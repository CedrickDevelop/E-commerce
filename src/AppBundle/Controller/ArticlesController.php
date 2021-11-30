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
     * Le formulaire est généré avec Article Type
     * @Route("/Ajout", name="AddArticles")
     */
    public function AjoutAction(Request $request)
    {
        //instance de l'entité
        $produit = new Articles();
        
        // On cree le formulaire
        $form = $this->createForm(ArticlesType::class,$produit);
        $form->handleRequest($request);

        if($form->isSubmitted()) // Deuxième possibilité pour récuperer les informations du formulaire
        {

            // Connexion avec Doctrine et persistance de la table
            $cnx = $this->getDoctrine()->getManager();
            $cnx->persist($produit);
            $cnx->flush();

            return $this->redirectToRoute('afficher');
        }


        return $this->render('@App/Articles/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }
    
    /**
     * Le formulaire est ajouté à la main
     * @Route("/Ajout2", name="AddArticles2")
     */
    public function AjoutAction2(Request $request)
    {


        //instance de l'entité
        $produit = new Articles();

        if($request->isMethod('POST')){

            $produit->setNom($request->get('nom'));
            $produit->setQte($request->get('qte'));
            $produit->setDescription($request->get('desc'));
    
            // Connexion avec Doctrine et persistance de la table
            $cnx = $this->getDoctrine()->getManager();
            $cnx->persist($produit);
            $cnx->flush();
    
    
            return $this->redirectToRoute('afficher');
        }

        return $this->render('@App/Articles/ajout2.html.twig');

    }

    /**
     * @Route("/Afficher", name="afficher")
     */
    public function AfficherAction(){
        // Connexion avec Doctrine
        $cnx=$this->getDoctrine()->getManager();
        $articles = $cnx->getRepository(Articles::class)->findAll();

        return $this->render('@App/Articles/afficherArticle.html.twig', [
            'articles'  => $articles
        ]);
    }
    
    /**
     * @Route("/delete/{id}", name="deleteArticle")
     */
    public function deleteAction($id){
        
        $cnx=$this->getDoctrine()->getManager();
        $delete = $cnx->getRepository(Articles::class)->find($id);
        $cnx->remove($delete);
        $cnx->flush();
        

        return $this->redirectToRoute('afficher');
    }
    
    /**
     * @Route("/showArticle/{id}", name="showArticle")
     */
    public function showArticleAction($id){
        
        $cnx=$this->getDoctrine()->getManager();
        $article = $cnx->getRepository(Articles::class)->find($id);

        

        return $this->render('@App/Articles/showArticle.html.twig', [
            'article'  => $article
        ]);
    }
    


}
