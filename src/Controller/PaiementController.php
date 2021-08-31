<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementController extends AbstractController
{
    /**
     * @Route("/paiement", name="paiement")
     */
    public function paiement(): Response
    {
        return $this->render('paiement/paiement.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }

    /**
     * @Route("/validation-paiement", name="validation_paiement")
     */
    public function validationPaiement(): Response
    {
        return $this->render('paiement/validation.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }
}
