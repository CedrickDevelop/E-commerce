<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UsersController extends Controller
{
    /**
     * @Route("/inscription")
     */
    public function inscriptionAction()
    {
        return $this->render('AppBundle:Users:inscription.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/connexion")
     */
    public function connexionAction()
    {
        return $this->render('AppBundle:Users:connexion.html.twig', array(
            // ...
        ));
    }

}
