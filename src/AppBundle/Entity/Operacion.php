<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Operacion
 *
 * @ORM\Table(name="operacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperacionRepository")
 *
 */
class Operacion
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var boolean
     *
     * @ORM\Column(name="realizado", type="boolean")
     */
    private $realizado;

    /**
     * @var string
     *
     * @ORM\Column(name="operacion", type="text")
     * @Assert\NotBlank(message="Debe introducir la operación")
     */
    private $operacion;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recurso", inversedBy="operaciones")
    */
    private $recurso;



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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Operacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set operacion
     *
     * @param string $operacion
     *
     * @return Operacion
     */
    public function setOperacion($operacion)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion
     *
     * @return string
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     *
     * @return Operacion
     */
    public function setRecurso(\AppBundle\Entity\Recurso $recurso = null)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso
     *
     * @return \AppBundle\Entity\Recurso
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    public function __toString()
    {
        return $this->fecha;
    }

    /**
     * Set realizado
     *
     * @param boolean $realizado
     *
     * @return Operacion
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;

        return $this;
    }

    /**
     * Get realizado
     *
     * @return boolean
     */
    public function getRealizado()
    {
        return $this->realizado;
    }
}
