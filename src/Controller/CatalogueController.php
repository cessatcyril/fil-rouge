<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/", name="categorie")
     */
    public function categories(CategorieRepository $repo): Response
    {
        $categories = $repo->findAll();

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
    public function listeProduits(SousCategorie $sousCategorie, $page = 0, ProduitRepository $repo): Response
    {
        $n = 0;
        $nombreProduits = $repo->countProduits($sousCategorie);
        $nombrePages = intval($nombreProduits / 5);

        $listeProduits = $repo->findByPage($sousCategorie, $page);
        $previous = ($page > 0) ? $page - 1 : 0;
        $next = ($page >= $nombrePages) ? $nombrePages : $page + 1;


        return $this->render('catalogue/liste_produits.html.twig', [
            'controller_name' => 'CatalogueController',
            'listeProduits' => $listeProduits,
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
     * Affiche une image dans un dossier privé
     * @Route("/private_pic/{fichier}", name="private_pic")
     */
    public function private_pic($fichier): Response
    {
        return new BinaryFileResponse("../image/produit/" . $fichier);
    }
}
