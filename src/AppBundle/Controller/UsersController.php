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
            

            if (isset($formulaire['photo'])){
                $file = $formulaire['photo'];
                $photoName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->guessExtension();
                $photo = $photoName.'.'.$extension;

                //ajout de la photo dans le dossier
                $file->move($this->getParameter('photosUtilisateurs'), $photo);
            }

            

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


                return $this->redirectToRoute('account');

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
     * @Route("/account", name="account")
     */
    public function accountAction(Request $request)
    {
        //connexion bdd
        $cnx = $this->getDoctrine()->getManager();
        
        // Recuperation user information session
        $session = new Session();
                
        // Recuperatiion user
        $userId = $session->get('user')->getId();
        $user = $cnx->getRepository(Utilisateurs::class)->find($userId);
        

        // Creation du formulaire pour la page
        $form = $this->createForm(UtilisateursType::class);
        $form->handleRequest($request);

        
        if ($form->isSubmitted()){
            // infos de la photo
            $file =$form->get('photo')->getData();
            $photoName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->guessExtension();
            $photo = $photoName.'.'.$extension;

            //ajout de la photo dans le dossier
            $file->move($this->getParameter('photosUtilisateurs'), $photo);

            // On met a jour les données en bdd
            $user->setPhoto($photo);
            $cnx->persist($user);
            $cnx->flush();


            return $this->redirectToRoute('account');
        }

        
        
        return $this->render('@App/Login/account.html.twig', [
            'form'  => $form->createView(),
            'user'  => $user
        ]);
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
