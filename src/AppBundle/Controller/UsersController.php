<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateurs;
use AppBundle\Form\UtilisateursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class UsersController extends Controller
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionAction(Request $request )
    {
        $user = new Utilisateurs();

        $form = $this->createForm(UtilisateursType::class, $user);
        $form->handleRequest($request);

        $cnx = $this->getDoctrine()->getManager();

        if($form->isSubmitted()){

            $formulaire = $request->get('appbundle_utilisateurs');
            $email = $formulaire['email']; 

            $emailExist = $cnx->getRepository(Utilisateurs::class)->findBy(array('email'=>$email));

            if (!empty($emailExist)){
                $this->get('session')->getFlashBag()->add('error', "Un utilisateur existe déjà avec cet email");
                goto view;

            }

            // Envoi en base de donnée            
            $cnx->persist($user);
            $cnx->flush();

            $this->get('session')->getFlashBag()->add('valid', "l'utilisateur a ete cree");

            return $this->redirectToRoute('connexion');
        }

        view:

        return $this->render('@App/Login/inscription.html.twig', array(
            'form'  =>$form->createView()
        ));
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction(Request $request)
    {
        $user = new Utilisateurs();


        $form = $this->createForm(UtilisateursType::class, $user);
        $form->handleRequest($request);

        $cnx = $this->getDoctrine()->getManager();

        if($form->isSubmitted()){

            $formulaire = $request->get('appbundle_utilisateurs');
            $email = $formulaire['email']; 
            $password = $formulaire['password']; 

            $userExist = $cnx->getRepository(Utilisateurs::class)->findOneBy(array('email'=>$email));

            if (empty($userExist)){
                $this->get('session')->getFlashBag()->add('error', "Il n'y a pas de compte associé à cet email");
                goto view;
            }
            
            if (password_verify($password,$userExist->getPassword())){

                //demarrer une session
                $session = new Session();

                $session->set('user', $userExist);


                return $this->redirectToRoute('afficher');

                // return new Response('Vous êtes connecté '.$userExist->getNom().' '.$userExist->getPrenom());
            } else {
                $this->get('session')->getFlashBag()->add('error', "Votre mot de passe et password ne coincident pas");
            }         

        }

        view:
        return $this->render('@App/Login/connexion.html.twig', array(
            'form'  =>$form->createView()
        ));
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logoutAction()
    {

        $session = new Session();
        $session->clear();


        return $this->redirectToRoute('homepage');
    }

}
