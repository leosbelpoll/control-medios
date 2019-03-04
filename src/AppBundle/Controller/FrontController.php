<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function redirigePortadaAction(Request $request)
    {
        return $this->render('front/inicio.html.twig');
    }

    /**
     * @Route("/render-submenu-recursos", name="render-submenu-recursos")
     */
    public function renderSubMenuRecursosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $menu = array(
            'titulo'        => 'Recursos',
            'tipoIcono' => 'icon',
            'icono'         => 'monitor',
        );

        $componentes = $em->getRepository('AppBundle\Entity\Componente')->findAll();

        foreach ($componentes as $componente){
            $subMenu = array(
                'ruta'      => $this->generateUrl('recurso_index_by_componente', array('id'=>$componente->getId())),
                'icono'     => $componente->getIcono(),
                'posiblesRutas' => [],
                'titulo'    => $componente->getNombre()
            );
            $menu['subMenus'][] = $subMenu;
        }

        $subMenu = array(
            'ruta'      => $this->generateUrl('recurso_index'),
            'icono'     => 'uploads/iconos/all.png',
            'posiblesRutas' => ['recurso_index'],
            'titulo'    => 'Todos'
        );
        $menu['subMenus'][] = $subMenu;

        return $this->render('inc/menu/menu.html.twig', $menu);
    }

}
