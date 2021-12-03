<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\ArticlesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticlesController extends Controller
{

    /**
     * FORMULAIRE GENERE
     * @Route("/Ajout", name="AddArticles")
     */
    public function AjoutAction(Request $request)
    {

        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

        //instance de l'entité
        $produit = new Articles();
        
        // On cree le formulaire
        $form = $this->createForm(ArticlesType::class,$produit);
        $form->handleRequest($request);

        if($form->isSubmitted()) // formulaire généré
        {
            // PHOTO
                //Obtenir les informations de nom etc...du formulaire type File
                $file = $form->get('photo')->getData();
                //recuperation du nom de la photo et definition de son nom
                $photoName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->guessExtension();
                $photo = $photoName.'.'.$extension;
                // On definit le nom de la photo pour l'envoyer en bdd
                $produit->setPhoto($photo);

                // On deplace la photo vers le dossier dont le nom se trouve dans service.yml -- parameters
                $file->move($this->getParameter('articlesUpload'), $photo);

                // return new Response($photo);

            // PERSISTANCE
                // Connexion avec Doctrine et persistance de la table
                $cnx = $this->getDoctrine()->getManager();
                $cnx->persist($produit);
                $cnx->flush();

            // REORIENTATION
                // return $this->redirectToRoute('afficher');
        }


        return $this->render('@App/Articles/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }
    
    /**
     * FORMULAIRE FAIT MAIN
     * @Route("/Ajout2", name="AddArticles2")
     */
    public function AjoutAction2(Request $request)
    {
        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

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

        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

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
        
        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

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
        
        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

        $cnx=$this->getDoctrine()->getManager();
        $article = $cnx->getRepository(Articles::class)->find($id);
        

        return $this->render('@App/Articles/showArticle.html.twig', [
            'article'  => $article
        ]);
    }


    // --------------------------------------------
    // --------------------------------------------
    // --------------------------------------------

    /**
     * @Route("/AfficherArticleSelect", name="afficherArticleSelect")
     */
    public function AfficherArticleSelectAction(Request $request)
    {
        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

        $message ='';
        $oneArticle='';
        
        $cnx=$this->getDoctrine()->getManager();

        if ($request->isMethod('POST')){
            
            $id = $request->get('articleSelect');

            if ($request->get('submitDelete') === 'delete'){                

                $delete = $cnx->getRepository(Articles::class)->find($id);
                $cnx->remove($delete);
                $cnx->flush();

                $message='Votre element a été supprimé de la base de données';
                $this->get('session')->getFlashBag()->add('valid', "Votre element a été supprimé de la base de données");

            }

            if ($request->get('submitDetail') === 'detail'){

                $oneArticle = $cnx->getRepository(Articles::class)->find($id);
            }
        }

        $articles = $cnx->getRepository(Articles::class)->findAll();

        return $this->render('@App/Articles/AfficherArticleSelect.html.twig', [
            'articles'      => $articles,
            'oneArticle'    =>$oneArticle
        ]);
    }    

    // --------------------------------------------
    // --------------------------------------------
    // --------------------------------------------

    /**
     * @Route ("/search", name="search")
     */
    public function searchAction(Request $request)
    {

        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 

        $form = $this->createForm(ArticlesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $formArticle = $request->get('appbundle_articles');
            $nom = $formArticle['nom'];
            $cnx = $this->getDoctrine()->getManager();
            $data = $cnx->getRepository(Articles::class)->findBy(array('nom'=>$nom));
        }

        return $this->render('@App/Articles/search.html.twig', [
            'form'  => $form->createView(),
            'resultat'   =>  @$data,
            'btn'       => 'Rechercher'
        ]);
    }

    // --------------------------------------------
    // --------------------------------------------
    // --------------------------------------------

    /**
     * Le formulaire est généré avec Article Type
     * @Route("modifier/{id}", name="modifier")
     */
    public function modifierAction(Request $request, $id)
    {

        $session = new Session();
        $user = $session->get('user');
        if (!$user){
            return $this->redirectToRoute('connexion');
        } 
        
        $cnx = $this->getDoctrine()->getManager();
        $produit = $cnx->getRepository(Articles::class)->find($id);

        // On cree le formulaire
        $form = $this->createForm(ArticlesType::class,$produit);
        $form->handleRequest($request);

        if($form->isSubmitted()) 
        {

            // Connexion avec Doctrine et persistance de la table
            $cnx->persist($produit);
            $cnx->flush();

            return $this->redirectToRoute('afficher');
        }


        return $this->render('@App/Articles/ajout.html.twig', array(
            'form'  => $form->createView()
        ));
    }


}
