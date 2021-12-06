<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Articles;
use AppBundle\Entity\Carts;
use AppBundle\Entity\Utilisateurs;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cnx = $this->getDoctrine()->getManager();
        $session = new Session();


        if($request->isMethod('POST'))
        {
            $cart = new Carts();
            
            // Recuperer la session du user connecté
            $userID = $session->get('user')->getId();
            $user = $cnx->getRepository(Utilisateurs::class)->find($userID);

            // Recuperation du produit
            $idProduit = $request->get('idProduit');
            $produit = $cnx->getRepository(Articles::class)->find($idProduit);

            // Definir le prix de l'ensmeble des produits
            $prixProduit = $produit->getPrix();
            $total = $prixProduit * $request->get('quantity');

            // On edite les champs du panier
            $cart->setIdArticle($produit);
            $cart->setIdUser($user);
            $cart->setTotal($total);
            $cart->setDate(date('Y-m-d'));
            $cart->setQteCommande($request->get('quantity'));
            $cnx->persist($cart);
            $cnx->flush();

            return $this->redirectToRoute('homepage');
        
        }

        if(!empty($session->get('user'))){

            $cartUser = $cnx->getRepository(Carts::class)->findBy(['idUser'=> $session->get('user')->getId()]);

            
        }

        

        $articles = $cnx->getRepository(Articles::class)->findAll();

        // Calcul du prix total 
        // $total = 0;
        // foreach($cartUser as $key){
        //     $t = $key->getIdArticle->getPrix()* $key->getqtCommande();
        //     $total = $total + $t;
        // }

        // replace this example code with whatever you need
        return $this->render('@App/index.html.twig', [
            'articles'  => $articles,
            'cart'      => $cartUser
        ]);

    }
    
    /**
     * @Route("/login", name="loginAdmin")
     */
    public function loginAdminAction(Request $request)
    {
        // $message = '';
        
        if ($request->isMethod('POST')){
            
            $email = $request->get('email');
            $password = $request->get('password');

            if (($email == 'admin2021@gmail.com') && ($password == 'admin123')){
                
                return $this->redirectToRoute('homepage');

            } else {
                $message = "Vous avez effectué une erreur";
            }
        }
        

        // replace this example code with whatever you need
        return $this->render('default/login.html.twig',[
            'msg'   => @$message
        ]);
    }
    /**
     * @Route("/delete_cart/{id}", name="delete_cart")
     */
    public function deleteCartAction($id)
    {
        $cnx = $this->getDoctrine()->getManager();

        $delete = $cnx->getRepository(Carts::class)->find($id);
        $cnx->remove($delete);
        $cnx->flush();   

        // replace this example code with whatever you need
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/about", name="aboutpage")
     */
    public function aboutAction()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/products/{param}/{param2}", name="productspage")
     */
    public function productsAction($param, $param2)
    {
        return $this->render('default/products.html.twig', [
            "param" => $param,
            "param2" => $param2
        ]);
    }

    /**
     * @Route("/calculator/{calc}/{x}/{y}", name="calculatorpage")
     */
    public function calculatorAction($calc, $x, $y)
    {

        return $this->render('default/calculator.html.twig', [
            "x" => $x,
            "y" => $y,
            "calc" => $calc,

        ]);
    }

    /**
     * @Route("/response", name="response")
     */
    public function responseAction()
    {
        return new Response('Message sans twig !');
    }

    /**
     * @Route("/redirect", name="redirect")
     */
    public function redirectAction()
    {
        return $this->redirectToRoute('response');
    }

}
