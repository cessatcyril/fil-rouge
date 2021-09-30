<?php

namespace App\Tests\GestionCommandeController;

use App\Controller\GestionCommandesController;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class getDateButoirTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');


        $gestionCommandesController = self::$container->get(GestionCommandesController::class);

        $date = DateTime::createFromFormat('Y-m-d G:i:s', '2000-01-01 00:00:00');
        //$date->format("Y-m-d H:i:s");
        $reponse = $date->add(new \DateInterval(GestionCommandesController::INTERVALLE_DATE_BUTOIR));

        $result = $gestionCommandesController->getDateButoir($date);

        $this->assertEquals($reponse, $result);
    }
}
