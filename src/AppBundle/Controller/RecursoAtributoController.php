<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RecursoAtributo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Recursoatributo controller.
 *
 * @Route("recursoatributo")
 */
class RecursoAtributoController extends Controller
{
    /**
     * Lists all recursoAtributo entities.
     *
     * @Route("/", name="recursoatributo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recursoAtributos = $em->getRepository('AppBundle:RecursoAtributo')->findAll();

        return $this->render('recursoatributo/index.html.twig', array(
            'recursoAtributos' => $recursoAtributos,
        ));
    }

    /**
     * Creates a new recursoAtributo entity.
     *
     * @Route("/new", name="recursoatributo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $recursoAtributo = new Recursoatributo();
        $form = $this->createForm('AppBundle\Form\RecursoAtributoType', $recursoAtributo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recursoAtributo);
            $em->flush();

            return $this->redirectToRoute('recursoatributo_show', array('id' => $recursoAtributo->getId()));
        }

        return $this->render('recursoatributo/new.html.twig', array(
            'recursoAtributo' => $recursoAtributo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a recursoAtributo entity.
     *
     * @Route("/{id}", name="recursoatributo_show")
     * @Method("GET")
     */
    public function showAction(RecursoAtributo $recursoAtributo)
    {
        $deleteForm = $this->createDeleteForm($recursoAtributo);

        return $this->render('recursoatributo/show.html.twig', array(
            'recursoAtributo' => $recursoAtributo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing recursoAtributo entity.
     *
     * @Route("/{id}/edit", name="recursoatributo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RecursoAtributo $recursoAtributo)
    {
        $deleteForm = $this->createDeleteForm($recursoAtributo);
        $editForm = $this->createForm('AppBundle\Form\RecursoAtributoType', $recursoAtributo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recursoatributo_edit', array('id' => $recursoAtributo->getId()));
        }

        return $this->render('recursoatributo/edit.html.twig', array(
            'recursoAtributo' => $recursoAtributo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a recursoAtributo entity.
     *
     * @Route("/{id}", name="recursoatributo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RecursoAtributo $recursoAtributo)
    {
        $form = $this->createDeleteForm($recursoAtributo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recursoAtributo);
            $em->flush();
        }

        return $this->redirectToRoute('recursoatributo_index');
    }

    /**
     * Creates a form to delete a recursoAtributo entity.
     *
     * @param RecursoAtributo $recursoAtributo The recursoAtributo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RecursoAtributo $recursoAtributo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recursoatributo_delete', array('id' => $recursoAtributo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
