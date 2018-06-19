<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Atributo;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\Persona;
use AppBundle\Entity\User;
use AppBundle\Entity\Componente;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $dpto = null;

        // ******* ATRIBUTOS *******

        $sistemaoperativo = new Atributo();
        $sistemaoperativo->setNombre('Sistema Operativo');

        $sello = new Atributo();
        $sello->setNombre('Sello');

        $identificadorpc = new Atributo();
        $identificadorpc->setNombre('Identificador de la PC');

        $estado = new Atributo();
        $estado->setNombre('Estado');

        $numeroconsecutivo = new Atributo();
        $numeroconsecutivo->setNombre('Numero Consecutivo');
        $numeroconsecutivo->setVisibleparatablas(true);

        $direccionmac = new Atributo();
        $direccionmac->setNombre('Direccion MAC');

        $nombredominio = new Atributo();
        $nombredominio->setNombre('Nombre del Dominio');

        $direccionip = new Atributo();
        $direccionip->setNombre('Direccion IP');

        $grupored = new Atributo();
        $grupored->setNombre('Grupo de RED');

        $numeroinventario = new Atributo();
        $numeroinventario->setNombre('Numero de Inventario');
        $numeroinventario->setVisibleparatablas(true);

        $marca = new Atributo();
        $marca->setNombre('Marca');
        $marca->setVisibleparatablas(true);

        $modelo = new Atributo();
        $modelo->setNombre('Modelo');
        $modelo->setVisibleparatablas(true);

        $noserie = new Atributo();
        $noserie->setNombre('No. Serie');
        $noserie->setVisibleparatablas(true);

        $capacidad = new Atributo();
        $capacidad->setNombre('Capacidad');

        $velocidad = new Atributo();
        $velocidad->setNombre('Velocidad');

        $textoresponsabilidad = new Atributo();
        $textoresponsabilidad->setNombre('Texto de Responsabilidad');

        $elaboradopor = new Atributo();
        $elaboradopor->setNombre('Elaborado por');

        $cargo = new Atributo();
        $cargo->setNombre('Cargo');

        $directorentidad = new Atributo();
        $directorentidad->setNombre('Director de la Entidad');

        $nombre = new Atributo();
        $nombre->setNombre('Nombre');

        // ******* COMPONENTES  *******

        $unidadcentral = new Componente();
        $unidadcentral->setNombre('Unidad Central');
        $unidadcentral->addAtributo($identificadorpc);
        $unidadcentral->addAtributo($numeroconsecutivo);
        $unidadcentral->addAtributo($estado);
        $unidadcentral->addAtributo($direccionmac);
        $unidadcentral->addAtributo($nombredominio);
        $unidadcentral->addAtributo($sistemaoperativo);
        $unidadcentral->addAtributo($direccionip);
        $unidadcentral->addAtributo($grupored);
        $unidadcentral->addAtributo($numeroinventario);
        $unidadcentral->addAtributo($marca);
        $unidadcentral->addAtributo($sello);
        $unidadcentral->addAtributo($textoresponsabilidad);
        $manager->persist($unidadcentral);

        $motherboard = new Componente();
        $motherboard->setNombre('Motherboard');
        $motherboard->setPadre($unidadcentral);
        $motherboard->addAtributo($modelo);
        $motherboard->addAtributo($noserie);
        $motherboard->addAtributo($marca);
        $manager->persist($motherboard);

        $procesador = new Componente();
        $procesador->setNombre('Procesador');
        $procesador->setPadre($unidadcentral);
        $procesador->addAtributo($modelo);
        $procesador->addAtributo($noserie);
        $procesador->addAtributo($marca);
        $procesador->addAtributo($velocidad);
        $manager->persist($procesador);

        $hdd = new Componente();
        $hdd->setNombre('HDD');
        $hdd->setPadre($unidadcentral);
        $hdd->addAtributo($modelo);
        $hdd->addAtributo($noserie);
        $hdd->addAtributo($marca);
        $hdd->addAtributo($capacidad);
        $manager->persist($hdd);

        $memoriaram = new Componente();
        $memoriaram->setNombre('Memoria RAM');
        $memoriaram->setPadre($unidadcentral);
        $memoriaram->addAtributo($modelo);
        $memoriaram->addAtributo($noserie);
        $memoriaram->addAtributo($marca);
        $memoriaram->addAtributo($capacidad);
        $manager->persist($memoriaram);

        $dvdrw = new Componente();
        $dvdrw->setNombre('DVD RW');
        $dvdrw->setPadre($unidadcentral);
        $dvdrw->addAtributo($modelo);
        $dvdrw->addAtributo($noserie);
        $dvdrw->addAtributo($marca);
        $manager->persist($dvdrw);

        $dvdr = new Componente();
        $dvdr->setNombre('DVD R');
        $dvdr->setPadre($unidadcentral);
        $dvdr->addAtributo($modelo);
        $dvdr->addAtributo($noserie);
        $dvdr->addAtributo($marca);
        $manager->persist($dvdr);

        $cdr = new Componente();
        $cdr->setNombre('CD R');
        $cdr->setPadre($unidadcentral);
        $cdr->addAtributo($modelo);
        $cdr->addAtributo($noserie);
        $cdr->addAtributo($marca);
        $manager->persist($cdr);

        $cdrw = new Componente();
        $cdrw->setNombre('CD RW');
        $cdrw->setPadre($unidadcentral);
        $cdrw->addAtributo($modelo);
        $cdrw->addAtributo($noserie);
        $cdrw->addAtributo($marca);
        $manager->persist($cdrw);

        $fuenteinterna = new Componente();
        $fuenteinterna->setNombre('Fuente Interna');
        $fuenteinterna->setPadre($unidadcentral);
        $fuenteinterna->addAtributo($modelo);
        $fuenteinterna->addAtributo($noserie);
        $fuenteinterna->addAtributo($marca);
        $manager->persist($fuenteinterna);

        $programainstalado = new Componente();
        $programainstalado->setNombre('Programa Instalado');
        $programainstalado->setPadre($unidadcentral);
        $programainstalado->addAtributo($nombre);
        $manager->persist($programainstalado);


        $departamentos = array(
            'Auditoria',
            'Difusion',
            'Economia',
            'Sub-Direccion',
            'Proceso',
            'Direccion',
            'Poblacion y Desarrollo',
            'Nodo',
            'Informatica',
            'Cuadro',
            'Proteccion Fisica',
            'Servicios Generales',
            'Recursos Humanos',
            'Aguada de Pasajeros',
            'Rodas',
            'Palmira',
            'Lajas',
            'Cruces',
            'Cumanayagua',
            'Cienfuegos',
            'Abreus',
        );

        foreach ($departamentos as $departamento) {
            $tmp = $manager->getRepository('AppBundle:Departamento')->findOneBy(array('nombre' => $departamento));
            if (empty($tmp)) {
                $tmp = new Departamento();
                $tmp->setNombre($departamento);
                $manager->persist($tmp);
            }
            if($departamento == 'Informatica'){
                $dpto = $tmp;
            }
        }

        $user = new User();
        $password = $this->encoder->encodePassword($user, 'darien');
        $user->setEmail('darien@cf.onei.cu')
            ->setUsername('darien')
            ->setPassword($password)
            ->setSalt(0);

        $tmp = new Persona();
        $tmp->setNombre('Darien')
            ->setApellidos('Martinez Fernandez')
            ->setCi('89092825289')
            ->setUser($user)
            ->setDepartamento($dpto)
            ->setCargo('J\' Dpto de Informatica');
        $manager->persist($tmp);


        // salvar los cambios
        $manager->flush();
    }
}
