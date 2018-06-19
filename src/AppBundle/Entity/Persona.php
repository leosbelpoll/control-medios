<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 *
 * @ORM\Table(name="persona")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 * @UniqueEntity(
 *     value="ci",
 *     message="Este carnet de identidad ya existe."
 * )
 */
class Persona
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
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank(message="Debe introducir el nombre")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     * @Assert\NotBlank(message="Debe introducir los apellidos")
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=255)
     * @Assert\NotBlank(message="Debe introducir el cargo")
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=255)
     * @Assert\NotBlank(message="Debe introducir el carnet de identidad")
     */
    private $ci;

    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="persona", cascade={"persist"})
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="personas", cascade={"persist"})
     * @Assert\NotNull(message="Debe seleccionar un departamento.")
    */
    private $departamento;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recurso", mappedBy="responsable")
    */
    private $recursos;


    function __toString()
    {
        return $this->nombre.' '.$this->apellidos;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recursos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Persona
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
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Persona
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set ci
     *
     * @param string $ci
     *
     * @return Persona
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Persona
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set departamento
     *
     * @param \AppBundle\Entity\Departamento $departamento
     *
     * @return Persona
     */
    public function setDepartamento(\AppBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Add recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     *
     * @return Persona
     */
    public function addRecurso(\AppBundle\Entity\Recurso $recurso)
    {
        $this->recursos[] = $recurso;

        return $this;
    }

    /**
     * Remove recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     */
    public function removeRecurso(\AppBundle\Entity\Recurso $recurso)
    {
        $this->recursos->removeElement($recurso);
    }

    /**
     * Get recursos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecursos()
    {
        return $this->recursos;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Persona
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }
}
