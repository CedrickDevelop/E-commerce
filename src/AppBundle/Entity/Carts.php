<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * carts
 *
 * @ORM\Table(name="carts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\cartsRepository")
 */
class Carts
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Utilisateurs")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Articles")
     */
    private $idArticle;

    /**
     * @var int
     *
     * @ORM\Column(name="qteCommande", type="integer")
     */
    private $qteCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qteCommande
     *
     * @param integer $qteCommande
     *
     * @return Carts
     */
    public function setQteCommande($qteCommande)
    {
        $this->qteCommande = $qteCommande;

        return $this;
    }

    /**
     * Get qteCommande
     *
     * @return integer
     */
    public function getQteCommande()
    {
        return $this->qteCommande;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Carts
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return Carts
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\Utilisateurs $idUser
     *
     * @return Carts
     */
    public function setIdUser(\AppBundle\Entity\Utilisateurs $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\Utilisateurs
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idArticle
     *
     * @param \AppBundle\Entity\Articles $idArticle
     *
     * @return Carts
     */
    public function setIdArticle(\AppBundle\Entity\Articles $idArticle = null)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return \AppBundle\Entity\Articles
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }
}
