<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembersController extends Controller
{
    private array $members = [
          ['id' => 1,
          'firstname' => 'Aretha',
          'lastname'  => 'Franklin',
          'category'  => 'chanteuse',
          'photo'     => 'https://www.reforme.net/wp-content/uploads/2018/08/A-Franklin-web.jpg'],
          ['id' => 2,
          'firstname' => 'Bob',
          'lastname'  => 'Marley',
          'category'  => 'chanteur',
          'photo'     => 'https://images.ladepeche.fr/api/v1/images/view/609a111fd286c261e06fd706/large/image.jpg?v=1'],
          ['id' => 3,
          'firstname' => 'John',
          'lastname'  => 'Lennon',
          'category'  => 'chanteur',
          'photo'     => 'https://media.ouest-france.fr/v1/pictures/d2102b1ff038e5bcded1a997c736bf71-18736321.jpg?width=1000&client_id=eds&sign=030ce3a0b647d53af6a944a91a86de4d737d1277389346cfdc43e78b5d1aa5fd'],
        ];
  /**
   * Show all the members
   * @Route("/listMembers", name="members_list")
   */
  public function listMembersAction()
  {  
    return $this->render('@App/Members/membersList.html.twig', [
      'members' => $this->members
    ]);
  }
  
  /**
   * Show all the members
   * @Route("/showMember/{id}", name="member_show")
   */
  public function showMemberAction($id)
  {
    return $this->render('@App/Members/memberShow.html.twig', [
      'member' => $this->members[$id-1],
      'id'    =>  $id
    ]);
  }
}
