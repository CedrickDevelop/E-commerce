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
        // replace this example code with whatever you need
        return $this->render('@App/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/login", name="loginAdmin")
     */
    public function loginAdminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/default/login.html.twig');
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
