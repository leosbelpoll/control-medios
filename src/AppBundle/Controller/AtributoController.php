<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Atributo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Atributo controller.
 *
 * @Route("atributo")
 */
class AtributoController extends Controller
{
    /**
     * Lists all atributo entities.
     *
     * @Route("/", name="atributo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $atributos = $em->getRepository('AppBundle:Atributo')->findAll();

        return $this->render('atributo/index.html.twig', array(
            'atributos' => $atributos,
        ));
    }

    /**
     * Creates a new atributo entity.
     *
     * @Route("/new", name="atributo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $atributo = new Atributo();
        $form = $this->createForm('AppBundle\Form\AtributoType', $atributo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atributo);
            $em->flush();

            return $this->redirectToRoute('atributo_index');
        }

        return $this->render('atributo/new.html.twig', array(
            'atributo' => $atributo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a atributo entity.
     *
     * @Route("/{id}", name="atributo_show")
     * @Method("GET")
     */
    public function showAction(Atributo $atributo)
    {
        $deleteForm = $this->createDeleteForm($atributo);

        return $this->render('atributo/show.html.twig', array(
            'atributo' => $atributo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing atributo entity.
     *
     * @Route("/{id}/edit", name="atributo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Atributo $atributo)
    {
        $deleteForm = $this->createDeleteForm($atributo);
        $editForm = $this->createForm('AppBundle\Form\AtributoType', $atributo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('atributo_index');
        }

        return $this->render('atributo/edit.html.twig', array(
            'atributo' => $atributo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a atributo entity.
     *
     * @Route("/{id}", name="atributo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Atributo $atributo)
    {
        $form = $this->createDeleteForm($atributo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($atributo);
            $em->flush();
        }

        return $this->redirectToRoute('atributo_index');
    }

    /**
     * Creates a form to delete a atributo entity.
     *
     * @param Atributo $atributo The atributo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Atributo $atributo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('atributo_delete', array('id' => $atributo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
