<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends Controller
{
    /**
     * @Route("/add", name="addpage")
     */
    public function addAction()
    {
        return $this->render('Client/add.html.twig');
    }

}
