<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{
    private $produits=[
        ['nom'       => 'Ordinateur',
        'prix'      => 170,
        'promotion' => 25,
        'icon'      => 'fas fa-laptop-code'],
        ['nom'       => 'Telephone',
        'prix'      => 370,
        'promotion' => 35,
        'icon'      => 'fas fa-phone-alt'],
        ['nom'       => 'Tablette',
        'prix'      => 120,
        'promotion' => 15,
        'icon'      => 'fas fa-tablet-alt'],
    ];

    /**
     * @route("/addProduct", name="add_product_page")
     */
    public function addProductAction(Request $request)
    {

        $affiche=false;$nom='';$prix=0;$promotion=0;$icon='';
        $message=null;

        
        // La recuperation des informations du formulaire
        if ($request->isMethod('POST')){
            $nom = $request->get('nom_produit');
            $prix = $request->get('prix_produit');
            $promotion = $request->get('promotion_produit');
            $icon = $request->get('icon_produit');

            $affiche=true;            
        }

        if ( $request->isMethod('POST') && 
        ($nom='' || $prix=0 || $promotion=0 || $icon='') ){
            $message = 'Vous avez oubliez un champ dans le formulaire';
        }

        return $this->render('@App/Product/addproduct.html.twig', [
            'nom' => $nom,
            'prix' => $prix,
            'promotion' => $promotion,
            'icon' => $icon,
            'affiche' => $affiche,
            'message'   =>$message
        ]);

        
    }
    
    /**
     * route d'affichage d'un element recupere dans l'url
     * @route("/getProduct/{productName}/{price}/{qty}", name="getProduct")
     */
    public function getProductAction($productName, $price, $qty)
    {
        if ($qty < 10){
            return new Response('Vous devez ajouter plus de 10 éléments');
        }

        $nombre_de_produits  = count($this->produits);

        return $this->render('@App/Product/getProduit.html.twig', [
            'prdname'   => $productName,
            'prix'      => $price,
            'qte'       => $qty, 
            'produits'  => $this->produits
        ]);
    }
}
