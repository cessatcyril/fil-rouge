<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/categorie", name="categorie")
     */
    public function categorie(): Response
    {
        return $this->render('catalogue/sous_categories.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    /**
     * @Route("/souscategorie", name="souscategorie")
     */
    public function sousCategorie(): Response
    {
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
