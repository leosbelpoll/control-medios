<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Componente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Componente controller.
 *
 * @Route("componente")
 */
class ComponenteController extends Controller
{
    /**
     * Lists all componente entities.
     *
     * @Route("/", name="componente_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $componentes = $em->getRepository('AppBundle:Componente')->findAll();

        return $this->render('componente/index.html.twig', array(
            'componentes' => $componentes,
        ));
    }

    /**
     * Creates a new componente entity.
     *
     * @Route("/new", name="componente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $componente = new Componente();
        $form = $this->createForm('AppBundle\Form\ComponenteType', $componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $componente->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($componente);
            $em->flush();

            return $this->redirectToRoute('componente_index');
        }

        return $this->render('componente/new.html.twig', array(
            'componente' => $componente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a componente entity.
     *
     * @Route("/{id}", name="componente_show")
     * @Method("GET")
     */
    public function showAction(Componente $componente)
    {
        $deleteForm = $this->createDeleteForm($componente);

        return $this->render('componente/show.html.twig', array(
            'componente' => $componente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing componente entity.
     *
     * @Route("/{id}/edit", name="componente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Componente $componente)
    {
        $deleteForm = $this->createDeleteForm($componente);
        $editForm = $this->createForm('AppBundle\Form\ComponenteType', $componente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $componente->upload();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('componente_index');
        }

        return $this->render('componente/edit.html.twig', array(
            'componente' => $componente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a componente entity.
     *
     * @Route("/{id}", name="componente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Componente $componente)
    {
        $form = $this->createDeleteForm($componente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($componente);
            $em->flush();
        }

        return $this->redirectToRoute('componente_index');
    }

    /**
     * Creates a form to delete a componente entity.
     *
     * @param Componente $componente The componente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Componente $componente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('componente_delete', array('id' => $componente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
