<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(CategorieRepository $repo): Response
    {
        $categories = $repo->findAll();

        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie/{categorie}", name="categorie")
     */
    public function categorie(Categorie $categorie): Response
    {
        $sousCategories = $categorie->getSousCategories();

        return $this->render('catalogue/sous_categories.html.twig', [
            'controller_name' => 'CatalogueController',
            'sousCategories' => $sousCategories
        ]);
    }

    /**
     * @Route("/souscategorie", name="souscategorie")
     */
    public function sousCategorie(SousCategorie $sousCategorie): Response
    {
        $produits = $sousCategorie->getProduits();

        return $this->render('catalogue/liste_produits.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    /**
     * @Route("/produit", name="produit")
     */
    public function produit(): Response
    {
        return $this->render('catalogue/detail_produit.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    /**
     * @Route("/private_pic/{fichier}", name="private_pic")
     */
    public function private_pic($fichier): Response
    {
        return new BinaryFileResponse("../image/produit/" . $fichier);
    }
}
