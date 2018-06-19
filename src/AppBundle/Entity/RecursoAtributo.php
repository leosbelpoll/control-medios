<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecursoAtributo
 *
 * @ORM\Table(name="recurso_atributo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecursoAtributoRepository")
 */
class RecursoAtributo
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
     * @ORM\Column(name="valor", type="string", length=255, nullable=true)
     */
    private $valor;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recurso", inversedBy="recursosatributos")
    */
    private $recurso;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Atributo", inversedBy="recursosatributos")
     */
    private $atributo;



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
     * Set valor
     *
     * @param string $valor
     *
     * @return RecursoAtributo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     *
     * @return RecursoAtributo
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

    /**
     * Set atributo
     *
     * @param \AppBundle\Entity\Atributo $atributo
     *
     * @return RecursoAtributo
     */
    public function setAtributo(\AppBundle\Entity\Atributo $atributo = null)
    {
        $this->atributo = $atributo;

        return $this;
    }

    /**
     * Get atributo
     *
     * @return \AppBundle\Entity\Atributo
     */
    public function getAtributo()
    {
        return $this->atributo;
    }

    public function __toString()
    {
        return $this->atributo.' '.$this->valor.' ';
    }
}
