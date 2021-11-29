<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\ArticlesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends Controller
{
    /**
     * @Route("/Ajout", name="AddArticles")
     */
    public function AjoutAction(Request $request)
    {
        //instance de l'entité
        $produit = new Articles();

        
        $form = $this->createForm(ArticlesType::class,$produit);

        if($form->isSubmitted()) // Deuxième possibilité pour récuperer les informations du formulaire
        {

        }

        return $this->render('@App/Articles/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }
    
    /**
     * @Route("/Ajout2", name="AddArticles2")
     */
    public function AjoutAction2(Request $request)
    {
        //instance de l'entité
        $produit = new Articles();
        $produit->setNom('PC');
        $produit->setQte(152);
        $produit->setDescription('PC DELL');

        // Connexion avec Doctrine et persistance de la table
        $cnx = $this->getDoctrine()->getManager();
        $cnx->persist($produit);
        $cnx->flush();


        return new Response('Ajout Ok');
    }

}
