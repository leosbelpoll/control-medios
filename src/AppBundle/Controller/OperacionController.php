<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Operacion;
use AppBundle\Entity\Recurso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Operacion controller.
 *
 * @Route("operacion")
 */
class OperacionController extends Controller
{
    /**
     * Lists all operacion entities.
     *
     * @Route("/", name="operacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $operacions = $em->getRepository('AppBundle:Operacion')->findAll();

        return $this->render('operacion/index.html.twig', array(
            'operacions' => $operacions,
        ));
    }

    /**
     * Creates a new operacion entity.
     *
     * @Route("recurso/{id}/operacion/new", name="recurso_operacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Recurso $recurso)
    {
        $operacion = new Operacion();
        $operacion->setRecurso($recurso);
        $form = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($operacion);
            $em->flush();

            return $this->redirectToRoute('recurso_show', array('id' => $recurso->getId()));
        }

        return $this->render('operacion/new.html.twig', array(
            'operacion' => $operacion,
            'recurso' => $recurso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a operacion entity.
     *
     * @Route("/{id}", name="operacion_show")
     * @Method("GET")
     */
    public function showAction(Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);

        return $this->render('operacion/show.html.twig', array(
            'operacion' => $operacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing operacion entity.
     *
     * @Route("recurso/{recurso}/operacion/{operacion}/edit", name="recurso_operacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recurso $recurso, Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);
        $editForm = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recurso_show', array('id' => $recurso->getId()));
        }

        return $this->render('operacion/edit.html.twig', array(
            'operacion' => $operacion,
            'recurso' => $recurso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a operacion entity.
     *
     * @Route("/{id}", name="operacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Operacion $operacion)
    {
        $form = $this->createDeleteForm($operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($operacion);
            $em->flush();
        }

        return $this->redirectToRoute('operacion_index');
    }

    /**
     * Creates a form to delete a operacion entity.
     *
     * @param Operacion $operacion The operacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Operacion $operacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operacion_delete', array('id' => $operacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
