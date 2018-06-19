<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Atributo
 *
 * @ORM\Table(name="atributo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AtributoRepository")
 * @UniqueEntity(
 *     value="nombre",
 *     message="Este atributo ya existe."
 * )
 */
class Atributo
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Debe introducir el nombre")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visibleparatablas", type="boolean", nullable=true)
     */
    private $visibleparatablas;

    /**
    *@ORM\ManyToMany(targetEntity="AppBundle\Entity\Componente", mappedBy="atributos")
    */
    private $componentes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecursoAtributo", mappedBy="atributo")
     */
    private $recursosatributos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recursosatributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Atributo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Atributo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add componente
     *
     * @param \AppBundle\Entity\Componente $componente
     *
     * @return Atributo
     */
    public function addComponente(\AppBundle\Entity\Componente $componente)
    {
        $this->componentes[] = $componente;

        return $this;
    }

    /**
     * Remove componente
     *
     * @param \AppBundle\Entity\Componente $componente
     */
    public function removeComponente(\AppBundle\Entity\Componente $componente)
    {
        $this->componentes->removeElement($componente);
    }

    /**
     * Get componentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentes()
    {
        return $this->componentes;
    }

    /**
     * Add recursosatributo
     *
     * @param \AppBundle\Entity\RecursoAtributo $recursosatributo
     *
     * @return Atributo
     */
    public function addRecursosatributo(\AppBundle\Entity\RecursoAtributo $recursosatributo)
    {
        $this->recursosatributos[] = $recursosatributo;

        return $this;
    }

    /**
     * Remove recursosatributo
     *
     * @param \AppBundle\Entity\RecursoAtributo $recursosatributo
     */
    public function removeRecursosatributo(\AppBundle\Entity\RecursoAtributo $recursosatributo)
    {
        $this->recursosatributos->removeElement($recursosatributo);
    }

    /**
     * Get recursosatributos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecursosatributos()
    {
        return $this->recursosatributos;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Set visibleparatablas
     *
     * @param boolean $visibleparatablas
     *
     * @return Atributo
     */
    public function setVisibleparatablas($visibleparatablas)
    {
        $this->visibleparatablas = $visibleparatablas;

        return $this;
    }

    /**
     * Get visibleparatablas
     *
     * @return boolean
     */
    public function getVisibleparatablas()
    {
        return $this->visibleparatablas;
    }
}
