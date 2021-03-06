<?php

namespace App\Controller;

use DateTime;
use \DateInterval;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Commande;
use App\Service\ToolBox;
use App\Entity\Livraison;
use App\Entity\CommandeDetail;
use App\Entity\LivraisonDetail;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use function PHPUnit\Framework\isNull;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionCommandesController extends AbstractController
{
    const INTERVALLE_DATE_BUTOIR = 'P15D';
    const INTERVALLE_DATE_LIVRAISON = 'P2D';
    const NB_HEURES_REMBOURSEMENT = 24;
    const MESSAGE_ANNULATION_DATE_IMPOSSIBLE = 'Cette commande n\'est pas annulable. Les annulations de commandes sont annulables pendant une durée de '. GestionCommandesController::NB_HEURES_REMBOURSEMENT*24 .' heures';
    const MESSAGE_ANNULATION_DEJA_EFFECTUEE = 'Cette commande n\'est pas annulable, cette commande a déja été annulée.';
    const MESSAGE_ANNULATION_COMMANDE_INCONNUE = 'Cette commande n\'existe pas et n\'est donc pas annulable';
    const MESSAGE_ANNULATION_PAS_EFFECTUEE = 'La commande n\'a encore pas été annulée. Pour effectuer un remboursement, la commande doit être à priori annulée.';
    const MESSAGE_ANNULATION_PAS_PAYE = 'La commande ne peut pas être remboursée, elle n\'a pas été payée.';
    const MESSAGE_PAIEMENT_COMMANDE_ANNULEE = 'Cette commande a été annulée. Une commande annulée ne peut pas être payée, passez une autre commande.';
    const MESSAGE_PAIEMENT_DEJA_FAIT = 'Cette commande a déja été payée.';

    /**
     * @Route("/particulier/commande/commander", name="commande_creer")
     */
    public function commandeCreer(EntityManagerInterface $eMI, ProduitRepository $produitRepo, ToolBox $toolBox): Response
    {
        //mise en base de donnees
        //pdf facture

        $panier = $toolBox->getPanier($this->getSession());
        if ($panier == null) {
            return $this->redirectToRoute("panier_vide");
        }

        $date = $this->getDate();
        $dateButoir = $this->getDateButoir($date);
        $dateLivraisonPrevue = $this->getDateLivraisonPrevue($date);

        $commande = new Commande();
        $commande->setClient($this->getUser()->getClient());
        $commande->setComStatut(Commande::EN_COURS);
        $commande->setComCommande($date);
        $commande->setComButoir($dateButoir);
        if ($eMI->persist($commande) || $eMI->flush()) {
            return $this->redirectToRoute("commande_erreur");
        }

        $commande_id = $commande->getId();
        $commande_client = $commande->getClient()->getId();
        $commande->setComFiche($this->getFiche($commande_id, $commande_client));
        $commande->setComFacture($this->getFacture($commande_id, $commande_client));
        if ($eMI->persist($commande) || $eMI->flush()) {
            return $this->redirectToRoute("commande_erreur");
        }

        foreach ($panier as $key => $article) {
            $produit = $produitRepo->findOneBy(['id' => $article["id"]]);
            $commande_detail = new CommandeDetail();
            $commande_detail->setCommande($commande);
            $commande_detail->setProduit($produit);
            $commande_detail->setDetQuantite($article["quantite"]);
            $commande_detail->setDetPrixVente($article["prix"]);
            $commande_detail->setDetRemise(0);//Ajouter variable "remise" dans panier
            if ($eMI->persist($commande_detail)) {
                return $this->redirectToRoute("commande_erreur");
            }

            $livraison = new Livraison();
            $livraison->setCommande($commande);
            $livraison->setLivDate($dateLivraisonPrevue);
            if ($eMI->persist($livraison)) {
                return $this->redirectToRoute("commande_erreur");
            }

            $livraisonDetail = new LivraisonDetail();
            $livraisonDetail->setProduit($produit);
            $livraisonDetail->setLivraison($livraison);
            $livraisonDetail->setDetQuantiteLivree(0);
            if ($eMI->persist($livraisonDetail)) {
                return $this->redirectToRoute("commande_erreur");
            }
            $eMI->flush();
        }

        $panier = null;
        $toolBox->panierRaz($this->getSession());
        //dd($panier);

        return $this->redirectToRoute('paiement_moyen', [
            'id' => $commande_id
        ]);

        return $this->render('gestion_commandes/creer.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }

    /**
     * @Route("erreur", name="erreur")
     */
    public function erreur(): Response
    {
        return $this->render('erreur/erreur.html.twig', []);
    }

    /**
     * @Route("commande/erreur", name="commande_erreur")
     */
    public function commandeErreur(): Response
    {
        return $this->render('gestion_commandes/erreur.html.twig', [
            'message' => 'Une erreur s\'est produite lors de la commande, veuillez ré-essayer.'
        ]);
    }

    /**
     * @Route("particulier/commande/passee/{id}", name="commande_succes")
     */
    public function commandeSucces(CommandeRepository $commandeRepo, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_PAIEMENT_COMMANDE_ANNULEE
            ]);    
        }

        if ($commande->getComPaiement()) {
            return $this->render('gestion_commandes/succes.html.twig', [
                'id' => $id
            ]);
        }

        return $this->render('gestion_commandes/commande_enregistree.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/commande/annulation/{id}", name="commande_annuler")
     */
    public function commandeAnnuler(EntityManagerInterface $eMI, CommandeRepository $commandeRepo, ToolBox $toolBox, $id): Response
    {
        $commande = $commandeRepo->findOneBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);

        if ($commande==null) {
            return $this->render('paiement/remboursement_echec.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_COMMANDE_INCONNUE
            ]);
        }

        if (!$toolBox->intervalCorrect($commande->getComCommande(), GestionCommandesController::NB_HEURES_REMBOURSEMENT)) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DATE_IMPOSSIBLE
            ]);
        }

        if ($commande->getComAnnulation()) {
            return $this->render('erreur/erreur.html.twig', [
                'message' => GestionCommandesController::MESSAGE_ANNULATION_DEJA_EFFECTUEE
            ]);
        }

        $commande->setComAnnulation(true);
        $eMI->persist($commande);
        $eMI->flush();
        return $this->render('gestion_commandes/annuler.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/particulier/commande/liste", name="commande_lister")
     */
    public function commandeLister(CommandeRepository $commandeRepo): Response
    {
        $commandes = $commandeRepo->findBy(['client'=>$this->getUser()->getCLient()->getId()]);
        $donnees = [];
        foreach ($commandes as $key => $commande) {
            $donnees[$key] = [
                'id' => $commande->getId(),
                'date_commande' => $commande->getComCommande()->format('d/m/Y'),
                'date_livraison' => (is_null($commande->getComLivraison())) ? "Pas encore livré." : $commande->getComLivraison()->format('d/m/Y'),
                'annulation' => $commande->getComAnnulation(),
                'paiement' => $commande->getComPaiement()
            ];

            
            $commande_details = $commande->getCommandeDetails();
            foreach ($commande_details as $key3 => $commande_detail) {
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()] = [
                    'id_produit' => $commande_detail->getProduit()->getId(),
                    'produit' => $commande_detail->getProduit()->getProProduit(),
                    'accroche' => $commande_detail->getProduit()->getProAccroche(),
                    'description' => $commande_detail->getProduit()->getProDescription(),
                    'remise' => $commande_detail->getDetRemise(),
                    'prix_unitaire' => $commande_detail->getDetPrixVente(),
                    'quantite_commandee' => $commande_detail->getDetQuantite(),
                    'sous_total' => $commande_detail->getDetPrixVente() * $commande_detail->getDetQuantite() - $commande_detail->getDetRemise(),
                    'quantite_livree' => 0,
                    'quantite_a_livrer' => $commande_detail->getDetQuantite(),
                    'image' => "/images/produit/".$commande_detail->getProduit()->getImagePrincipale(),
                ];
                
            }
            //dd($donnees);

            $livraisons = $commande->getLivraisons();
            foreach ($livraisons as $key2 => $livraison) {

                $livraisonDetails = $livraison->getLivraisonDetails();
                foreach ($livraisonDetails as $key3 => $livraisonDetail) {
                    if ($livraisonDetail->getLivraison() === $commande->getId()) {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = (is_Null($livraisonDetail->getDetQuantiteLivree() ? 0 : $livraisonDetail->getDetQuantiteLivree()));
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'];
                    } else {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = 0;
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'];
                        
                    }
                }
            }
        }

        return $this->render('gestion_commandes/liste.html.twig', [
            'controller_name' => 'GestionCompteController',
            'commandes' => $donnees
        ]);
    }


    /**
     * @Route("/particulier/commande/detail/{id}", name="commande_detail")
     */
    public function commandeDetail(CommandeRepository $commandeRepo, $id): Response
    {
        $commandes = $commandeRepo->findBy(['client'=>$this->getUser()->getCLient()->getId(), 'id'=>$id]);
        $donnees = [];
        foreach ($commandes as $key => $commande) {
            $donnees[$key] = [
                'id' => $commande->getId(),
                'date_commande'=> $commande->getComCommande()->format('d/m/Y'),
                'date_livraison' => (is_Null($commande->getComLivraison())) ? "Pas encore livré." : $commande->getComLivraison()->format('d/m/Y'),
                'annulation' => $commande->getComAnnulation(),
                'paiement' => $commande->getComPaiement()
            ];

            
            $commande_details = $commande->getCommandeDetails();
            foreach ($commande_details as $key3 => $commande_detail) {
                $donnees[$key]['produits'][$commande_detail->getProduit()->getId()] = [
                    'id_produit' => $commande_detail->getProduit()->getId(),
                    'produit' => $commande_detail->getProduit()->getProProduit(),
                    'accroche' => $commande_detail->getProduit()->getProAccroche(),
                    'description' => $commande_detail->getProduit()->getProDescription(),
                    'remise' => $commande_detail->getDetRemise(),
                    'prix_unitaire' => $commande_detail->getDetPrixVente(),
                    'quantite_commandee' => $commande_detail->getDetQuantite(),
                    'sous_total' => $commande_detail->getDetPrixVente() * $commande_detail->getDetQuantite() - $commande_detail->getDetRemise(),
                    'quantite_livree' => 0,
                    'quantite_a_livrer' => $commande_detail->getDetQuantite(),
                    'image' => "/images/produit/".$commande_detail->getProduit()->getImagePrincipale(),
                ];
            }

            $livraisons = $commande->getLivraisons();
            foreach ($livraisons as $key2 => $livraison) {

                $livraisonDetails = $livraison->getLivraisonDetails();
                foreach ($livraisonDetails as $key3 => $livraisonDetail) {
                    if ($livraisonDetail->getLivraison() === $commande->getId()) {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = (is_Null($livraisonDetail->getDetQuantiteLivree() ? 0 : $livraisonDetail->getDetQuantiteLivree()));
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_commandee'] - $donnees[$key]['livraison'][$key3]['quantite_livree'] = $livraisonDetail->getDetQuantiteLivree();
                    } else {
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_livree'] = 0;
                        $donnees[$key]['produits'][$livraisonDetail->getProduit()->getId()]['quantite_a_livrer'] = $donnees[$key]['produits'][$commande_detail->getProduit()->getId()]['quantite_commandee'];
                    }
                }
            }
        }
        //dd($donnees);

        return $this->render('gestion_commandes/detail.html.twig', [
            'controller_name' => 'GestionCompteController',
            'commandes' => $donnees
        ]);
    }

    /**
     * @Route("/particulier/commande/recapitulatif", name="commande_recapitulatif")
     */
    public function commandeRecapitulatif(AdresseTypeRepository $repo, ToolBox $toolBox): Response
    {
        if (is_null($toolBox->getPanier($this->getSession()))) {
            return $this->redirectToRoute('panier_vide');
        }
        return $this->render('gestion_commandes/recapitulatif.html.twig', [
            'controller_name' => 'GestionCompteController',
            'panier' => $toolBox->getPanier($this->getSession()),
            'adresses' => $toolBox->getAdresses($this->getUser())
        ]);
    }

    public function getDate()
    {
        $date = new DateTime();
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getDateButoir(Datetime $dateCommande)
    {
        $date = $dateCommande->add(new \DateInterval(GestionCommandesController::INTERVALLE_DATE_BUTOIR));
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getDateLivraisonPrevue($dateCommande)
    {
        $date = $dateCommande->add(new \DateInterval(GestionCommandesController::INTERVALLE_DATE_LIVRAISON));
        $date->format("Y-m-d H:i:s");
        return $date;
    }

    public function getFiche($commandeId, $clientId)
    {
        return "Commande_" . $clientId . "-" . $commandeId;
    }

    public function getFacture($commandeId, $clientId)
    {
        return "Facture_" . $clientId . "-" . $commandeId;
    }

    /**
     * Get the value of session
     */
    public function getSession()
    {
        return new Session();
    }

    /**
     * Set the value of session
     *
     * @return  self
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }



    /**
     * @Route("/commande/pdf", name="commande_pdf")
     */
    public function creerPdf(ToolBox $tb)
    {

        $n = $this->getUser()->getClient();
        $a = $tb->getAdresses($this->getUser());


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('gestion_commandes/detailCommandePdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'nom' => $n,
            'adresse' => $a

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return $this->render('gestion_commandes/detailCommandePdf.html.twig', [
            'controller_name' => 'GestionCompteController',
        ]);
    }
}
