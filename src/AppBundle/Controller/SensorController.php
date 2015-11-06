<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SensorController extends Controller
{
    /**
     * @Route("/sensor", name="sensor")
     */
    public function indexAction(Request $request)
    {
        $logger = $this->container->get('logger');
        $logger->info('request');

        print_r($request);
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
