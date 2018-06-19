<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Componente
 *
 * @ORM\Table(name="componente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComponenteRepository")
 * @UniqueEntity(
 *     value="nombre",
 *     message="Este componente ya existe."
 * )
 */
class Componente
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Componente", mappedBy="padre")
     **/
    private $hijos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Componente", inversedBy="hijos")
     * @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     **/
    private $padre;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Atributo", inversedBy="componentes", cascade={"persist"})
     */
    private $atributos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recurso", mappedBy="componente")
     */
    private $recursos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icono;

    /**
    * @Assert\File(maxSize="6000000")
    */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsoluteIcono()
    {
        return null === $this->icono
            ? null
            : $this->getUploadRootDir() . '/' . $this->icono;
    }

    public function getWebIcono()
    {
        return null === $this->icono
            ? null
            : $this->getUploadDir() . '/' . $this->icono;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/iconos';
    }


    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hijos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->atributos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Componente
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
     * @return Componente
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
     * Add hijo
     *
     * @param \AppBundle\Entity\Componente $hijo
     *
     * @return Componente
     */
    public function addHijo(\AppBundle\Entity\Componente $hijo)
    {
        $this->hijos[] = $hijo;

        return $this;
    }

    /**
     * Remove hijo
     *
     * @param \AppBundle\Entity\Componente $hijo
     */
    public function removeHijo(\AppBundle\Entity\Componente $hijo)
    {
        $this->hijos->removeElement($hijo);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHijos()
    {
        return $this->hijos;
    }

    /**
     * Set padre
     *
     * @param \AppBundle\Entity\Componente $padre
     *
     * @return Componente
     */
    public function setPadre(\AppBundle\Entity\Componente $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \AppBundle\Entity\Componente
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add atributo
     *
     * @param \AppBundle\Entity\Atributo $atributo
     *
     * @return Componente
     */
    public function addAtributo(\AppBundle\Entity\Atributo $atributo)
    {
        $this->atributos[] = $atributo;

        return $this;
    }

    /**
     * Remove atributo
     *
     * @param \AppBundle\Entity\Atributo $atributo
     */
    public function removeAtributo(\AppBundle\Entity\Atributo $atributo)
    {
        $this->atributos->removeElement($atributo);
    }

    /**
     * Get atributos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAtributos()
    {
        return $this->atributos;
    }

    /**
     * Add recurso
     *
     * @param \AppBundle\Entity\Recurso $recurso
     *
     * @return Componente
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

    /*
     * @Assert\True(message = "Un componente contenedor no puede tener atributos")
     */
    public function isContenedor()
    {

    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $nuevoTitulo = $this->getFile()->getClientOriginalName();
        $this->getFile()->move($this->getUploadRootDir(), $nuevoTitulo);
        // FIXME: poner la imagen
        $this->icono = $nuevoTitulo;
        $this->file = null;
    }

    public function getIcono(){
        if($this->icono){
            return $this->getUploadDir().'/'. $this->icono;
        }

        return;
    }
}
