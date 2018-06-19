<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Recurso
 *
 * @ORM\Table(name="recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecursoRepository")
 */
class Recurso
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
     * @ORM\Column(name="fechacreacion", type="date")
     */
    private $fechacreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechabaja", type="date", nullable=true)
     */
    private $fechabaja;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecursoAtributo", mappedBy="recurso", cascade={"persist"})
     */
    private $recursosatributos;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Operacion", mappedBy="recurso")
    */
    private $operaciones;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Componente", inversedBy="recursos")
    */
    private $componente;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona", inversedBy="recursos")
     */
    private $responsable;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recurso", mappedBy="padre", cascade={"persist"})
    **/
    private $subrecursos;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recurso", inversedBy="subrecursos")
    * @ORM\JoinColumn(name="subrecursos_id", referencedColumnName="id")
    **/
    private $padre;


    public function __toString()
    {
        $string = "";
        foreach ($this->componente->getAtributos() as $atributo){
            if($this->hasAtributo($atributo) and $atributo == 'Numero de Inventario'){
                return $this->componente." - Inventario:".$this->getValorByAtributo($atributo);
            }
            if($this->hasAtributo($atributo) and $atributo->getVisibleparatablas()){
                $string .= " ".$atributo->getNombre()." - ".$this->getValorByAtributo($atributo);
            }
        }
        if(!$string){
            return $this->componente." - ".$this->fechacreacion->format('d M, Y');
        }
        return $this->componente." - ".$string;
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

    public function getValorByAtributo($atributo)
    {
        foreach ($this->getRecursosatributos() as $ra){
            if($ra->getAtributo() == $atributo){
                return $ra->getValor();
            }
        }

        return null;
    }

    /**
     * Set fechacreacion
     *
     * @param \DateTime $fechacreacion
     *
     * @return Recurso
     */
    public function setFechacreacion($fechacreacion)
    {
        $this->fechacreacion = $fechacreacion;

        return $this;
    }

    /**
     * Get fechacreacion
     *
     * @return \DateTime
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * Set fechabaja
     *
     * @param \DateTime $fechabaja
     *
     * @return Recurso
     */
    public function setFechabaja($fechabaja)
    {
        $this->fechabaja = $fechabaja;

        return $this;
    }

    /**
     * Get fechabaja
     *
     * @return \DateTime
     */
    public function getFechabaja()
    {
        return $this->fechabaja;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Recurso
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
     * Add recursosatributo
     *
     * @param \AppBundle\Entity\RecursoAtributo $recursosatributo
     *
     * @return Recurso
     */
    public function addRecursosatributo(\AppBundle\Entity\RecursoAtributo $recursosatributo)
    {
        $this->recursosatributos[] = $recursosatributo;
        $recursosatributo->setRecurso($this);

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

    /**
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Recurso
     */
    public function addOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones[] = $operacione;

        return $this;
    }

    /**
     * Remove operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     */
    public function removeOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones->removeElement($operacione);
    }

    /**
     * Get operaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperaciones()
    {
        return $this->operaciones;
    }

    /**
     * Set componente
     *
     * @param \AppBundle\Entity\Componente $componente
     *
     * @return Recurso
     */
    public function setComponente(\AppBundle\Entity\Componente $componente = null)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return \AppBundle\Entity\Componente
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set responsable
     *
     * @param \AppBundle\Entity\Persona $responsable
     *
     * @return Recurso
     */
    public function setResponsable(\AppBundle\Entity\Persona $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    public function hasAtributo($atributo)
    {
        foreach ($this->recursosatributos as $rc){
            if($rc->getAtributo() == $atributo){
                return true;
            }
        }

        return false;
    }

    public function getValorAtributo($atributo)
    {
        foreach ($this->recursosatributos as $rc){
            if($rc->getAtributo() == $atributo){
                return $rc->getValor();
            }
        }

        return null;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recursosatributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subrecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subrecurso
     *
     * @param \AppBundle\Entity\Recurso $subrecurso
     *
     * @return Recurso
     */
    public function addSubrecurso(\AppBundle\Entity\Recurso $subrecurso)
    {
        $this->subrecursos[] = $subrecurso;
        $subrecurso->setPadre($this);

        return $this;
    }

    /**
     * Remove subrecurso
     *
     * @param \AppBundle\Entity\Recurso $subrecurso
     */
    public function removeSubrecurso(\AppBundle\Entity\Recurso $subrecurso)
    {
        $this->subrecursos->removeElement($subrecurso);
        $subrecurso->setPadre(null);
    }

    public function removeAllSubrecursos()
    {
        foreach ($this->subrecursos as $subrecurso){
            $subrecurso->setPadre(null);
        }
        $this->subrecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get subrecursos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubrecursos()
    {
        return $this->subrecursos;
    }

    /**
     * Set padre
     *
     * @param \AppBundle\Entity\Recurso $padre
     *
     * @return Recurso
     */
    public function setPadre(\AppBundle\Entity\Recurso $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \AppBundle\Entity\Recurso
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /*
     * @Assert\True(message = "El Recurso debe tener o Padre(con Responsable) o Responsable")
     */
    public function isAlgo()
    {
        return false;
        // return (!$this->responsable and $this->padre->getResponsable());
    }

    public function getOperacionesFuturas(){
        $operaciones = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->operaciones as $opr){
            if($opr->getFecha() > new \Datetime()){
                $operaciones->add($opr);
            }
        }

        return $operaciones;
    }

    public function getOperacionesPasadas(){
        $operaciones = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->operaciones as $opr){
            if($opr->getFecha() < new \Datetime() and $opr->getRealizado()){
                $operaciones->add($opr);
            }
        }

        return $operaciones;
    }

    public function getOperacionesIncumplidas(){
        $operaciones = new \Doctrine\Common\Collections\ArrayCollection();
        foreach($this->operaciones as $opr){
            if($opr->getFecha() < new \Datetime() and !$opr->getRealizado()){
                $operaciones->add($opr);
            }
        }

        return $operaciones;
    }
}
