<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Image;
use App\Entity\Produit;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
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
     * @Route("/liste_produits/{sousCategorie}", name="liste_produits")
     */
    public function listeProduits(SousCategorie $sousCategorie): Response
    {
        $listeProduits = $sousCategorie->getProduits();

        return $this->render('catalogue/liste_produits.html.twig', [
            'controller_name' => 'CatalogueController',
            'listeProduits' => $listeProduits
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
     * Affiche une image dans un dossier privé
     * @Route("/private_pic/{fichier}", name="private_pic")
     */
    public function private_pic($fichier): Response
    {
        return new BinaryFileResponse("../image/produit/" . $fichier);
    }
}
