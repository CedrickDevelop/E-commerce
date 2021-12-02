<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cnx = $this->getDoctrine()->getManager();
        $articles = $cnx->getRepository(Articles::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('@App/index.html.twig', [
            'articles'  => $articles
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
