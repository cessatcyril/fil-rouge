<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\Image;
use App\Entity\Produit;
use App\Service\ToolBox;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/", name="categorie")
     */
    public function categories(CategorieRepository $CategorieRepo, Request $request): Response
    {    
        $categories = $CategorieRepo->findAll();

        return $this->render('catalogue/categories.html.twig', [
            'menu_actuel' => 'accueil',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/sous_categories/{categorie}", name="sous_categories")
     */
    public function sousCategories(Categorie $categorie): Response
    {
        $sousCategories = $categorie->getSousCategories();

        return $this->render('catalogue/sous_categories.html.twig', [
            'controller_name' => 'CatalogueController',
            'sousCategories' => $sousCategories
        ]);
    }

    /**
     * @Route("/liste_produits/{sousCategorie}/{page}", name="liste_produits")
     */
    public function listeProduits(SousCategorie $sousCategorie, $page = 0, ProduitRepository $repo, ToolBox $toolBox, ParameterBagInterface $parameterBagInterface): Response
    {
        $n = 0;
        $nombreProduits = $repo->countProduits($sousCategorie);
        $nombrePages = intval($nombreProduits / 5);

        $listeProduits = $repo->findByPage($sousCategorie, $page);
        $liste = [];
        foreach ($listeProduits as $key => $produit) {
            $liste[] = [
                'id' => $produit->getId(),
                'proProduit' => $produit->getProProduit(),
                'proDescription' => $produit->getProDescription(),
                'proAccroche' => $produit->getProAccroche(),
                'sousCategorie' => $produit->getSousCategorie(),
                'image' => "/images/produit/".$produit->getImagePrincipale(),
                'prix' => $produit->getProPrixV()
            ]; 
        }
        

        $previous = ($page > 0) ? $page - 1 : 0;
        $next = ($page >= $nombrePages) ? $nombrePages : $page + 1;


        return $this->render('catalogue/liste_produits.html.twig', [
            'controller_name' => 'CatalogueController',
            'listeProduits' => $liste,
            "nombrePages" => $nombrePages,
            "page" => $page,
            "previous" => $previous,
            "next" => $next,
            "n" => $n,
        ]);
    }

    /**
     * @Route("/produit/{produit}", name="produit")
     */
    public function produit(Produit $produit): Response
    {
        return $this->render('catalogue/detail_produit.html.twig', [
            'controller_name' => 'CatalogueController',
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/produit/carousel/{produit}", name="produit_carousel")
     */
    public function produitCarousel(Produit $produit): Response
    {
        return $this->render('catalogue/produit_carousel.html.twig', [
            'controller_name' => 'CatalogueController',
            'produit' => $produit
        ]);
    }

    /**
     * Affiche une image dans un dossier priv??
     * @Route("/private_pic/{fichier}", name="private_pic")
     */
    public function private_pic($fichier): Response
    {
        return new BinaryFileResponse("../image/produit/" . $fichier);
    }

    /**
     * @Route("/recherche/{rech}/{page}", name="categorie_recherche")
     */
    public function recherche(Request $request, ProduitRepository $repoP, $rech = "", $page = 0, $nombreProduits = 0, $nombrePages = 0, $previous = 0, $next = 0): Response
    {

        if ($rech != "") {
            $recherche = '%' . $rech . '%';
            $nombreProduits = $repoP->countProduitsRecherche($recherche);
            $nombrePages = intval($nombreProduits / 10);

            $listeProduits = $repoP->rechercheByPage($recherche, $page);
            $previous = ($page > 0) ? $page - 1 : 0;
            $next = ($page >= $nombrePages) ? $nombrePages : $page + 1;
        } else if ($request->getMethod() == "POST") {
            $recherche = $request->request->get("recherche");
            if ($recherche != '') {
                $rech = $recherche;
                $recherche = '%' . $recherche . '%';
                $nombreProduits = $repoP->countProduitsRecherche($recherche);
                $nombrePages = intval($nombreProduits / 10);

                $listeProduits = $repoP->rechercheByPage($recherche, $page);
                $previous = ($page > 0) ? $page - 1 : 0;
                $next = ($page >= $nombrePages) ? $nombrePages : $page + 1;
            } else {
                $listeProduits = false;
            }
        } else {
            $listeProduits = False;
        }


        //dd($recherche);
        return $this->render('catalogue/recherche.html.twig', [
            'menu_actuel' => 'accueil',
            //'recherche' => $produit,
            'recherche' => $listeProduits,
            "nombrePages" => $nombrePages,
            "page" => $page,
            "previous" => $previous,
            "next" => $next,
            'rech' => $rech,
        ]);
    }
}
