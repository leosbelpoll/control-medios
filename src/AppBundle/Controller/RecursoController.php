<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Componente;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\RecursoAtributo;
use AppBundle\Form\RecursoAtributoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Recurso controller.
 *
 */
class RecursoController extends Controller
{

    /**
     *
     * @Route("recurso/{id}/imprimir_ficha_tecnica", name="imprimir_ficha_tecnica")
     * @Method("GET")
     */
    public function imprimirFichaTecnicaAction()
    {
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject(__DIR__. '/../../../web/files/'.'ficha_tecnica.xlsx');

       $phpExcelObject->getProperties()->setCreator("liuggio")
           ->setLastModifiedBy("Giulio De Donato")
           ->setTitle("Office 2005 XLSX Test Document")
           ->setSubject("Office 2005 XLSX Test Document")
           ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
           ->setKeywords("office 2005 openxml php")
           ->setCategory("Test result file");
       $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Hello')
           ->setCellValue('B2', 'world!');
       $phpExcelObject->getActiveSheet()->setTitle('Simple');
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }



    // public function imprimirFichaTecnicaAction(Recurso $recurso)
    // {
    //     $this->get('knp_snappy.pdf')->generateFromHtml(
    //         $this->renderView(
    //             'recurso/ficha_tecnica.html.twig',
    //             array(
    //                 'recurso'  => $recurso
    //             )
    //         ),
    //         '/path/to/the/file.pdf'
    //     );
    // }

    /**
     * Lists all recurso entities.
     *
     * @Route("/recursos", name="recurso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recursos = $em->getRepository('AppBundle:Recurso')->findAll();
        $componentes = $em->getRepository('AppBundle:Componente')->findAll();

        return $this->render('recurso/index.html.twig', array(
            'recursos' => $recursos,
            'componentes' => $componentes,
        ));
    }

    /**
     * @Route("/componente/{id}/recursos", name="recurso_index_by_componente")
     * @Method("GET")
     */
    public function indexByComponenteAction(Componente $componente)
    {
        $recursos = $componente->getRecursos();
        return $this->render('recurso/index-by-componente.html.twig', array(
            'recursos'      => $recursos,
            'componente'    => $componente,
        ));
    }

    /**
     * Creates a new recurso entity.
     *
     * @Route("/componente/{id}/recurso/new", name="recurso_new")
     * @Method({"GET", "POST"})
     */
     public function newAction(Request $request, Componente $componente)
    {
        $recurso = new Recurso();
        $recurso->setComponente($componente);

        foreach ($componente->getAtributos() as $atributo){
            $recursoatributo = new RecursoAtributo();
            $recursoatributo->setAtributo($atributo);
            $recurso->addRecursosatributo($recursoatributo);
        }

        $form = $this->createForm('AppBundle\Form\RecursoType', $recurso);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recurso);
            $em->flush();

            return $this->redirectToRoute('recurso_index_by_componente', array('id' => $componente->getId()));
        }

        return $this->render('recurso/new.html.twig', array(
            'recurso' => $recurso,
            'componente' => $componente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a recurso entity.
     *
     * @Route("recurso/{id}", name="recurso_show")
     * @Method("GET")
     */
    public function showAction(Recurso $recurso)
    {
        return $this->render('recurso/show.html.twig', array(
            'recurso' => $recurso,
        ));
    }

    /**
     *
     * @Route("recurso/{id}/ficha_tecnica", name="recurso_ficha_tecnica")
     * @Method("GET")
     */
    public function fichaTecnicaAction(Recurso $recurso)
    {
        return $this->render('recurso/ficha_tecnica.html.twig', array(
            'recurso' => $recurso,
        ));
    }

    /**
     * Displays a form to edit an existing recurso entity.
     *
     * @Route("/recurso/{id}/edit", name="recurso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recurso $recurso)
    {
        foreach ($recurso->getComponente()->getAtributos() as $atributo){
            if(!$recurso->hasAtributo($atributo)) {
                $recursoatributo = new RecursoAtributo();
                $recursoatributo->setAtributo($atributo);
                $recurso->addRecursosatributo($recursoatributo);
            }
        }
        $editForm = $this->createForm('AppBundle\Form\RecursoType', $recurso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
//            return $this->re  directToRoute('recurso_index_by_componente', array('id' => $recurso->getComponente()->getId()));
            return $this->redirectToRoute('recurso_edit', array('id' => $recurso->getId()));
        }



        return $this->render('recurso/edit.html.twig', array(
            'recurso' => $recurso,
            'componente' => $recurso->getComponente(),
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a recurso entity.
     *
     * @Route("recurso/{id}/delete/componente/{idComponente}", name="recurso_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id, $idComponente)
    {
        $em = $this->getDoctrine()->getManager();

        $recurso = $em->getRepository('AppBundle:Recurso')->find($id);

        $em->remove($recurso);
        $em->flush();

        if($idComponente == -1){
            return $this->redirectToRoute('recurso_index');
        }

        return $this->redirectToRoute('recurso_index_by_componente', ['id'=> $idComponente]);
    }

    /**
     * Creates a form to delete a recurso entity.
     *
     * @param Recurso $recurso The recurso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recurso $recurso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recurso_delete', array('id' => $recurso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
