<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/candidature")
*/
class CandidatureController extends AbstractController
{
    /**
     * @Route("/index", name="index", methods={"GET"})
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }
    

    /**
     * @Route("/index_candidature", name="candidature_index", methods={"GET"})
     */
    public function index_Candidature(CandidatureRepository $candidatureRepository,Request $request): Response
    {
        $user= $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->query->get('id'));
            
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findBy(['user' => $user ,]),
        ]);
    }
    

    /**
     * @Route("/new", name="candidature_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('candidature_index');
        }

        return $this->render('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="candidature_show", methods={"GET"})
     */
    public function show(Candidature $candidature): Response
    {
        return $this->render('candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="candidature_edit_Valide", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidature $candidature): Response
    {
        

        $candidature->setValider("Valider");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();
            return $this->redirectToRoute('rendez_vous_new',array('candidature' => $candidature));
           
        }
    
    /**
     * @Route("/{id}/editNV", name="candidature_edit_nv", methods={"GET","POST"})
     */
    public function editnv(Request $request, Candidature $candidature): Response
    {

       $candidature->setValider("Refuser");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();
            return $this->redirectToRoute('index');
           
        }

    /**
     * @Route("/{id}", name="candidature_delete", methods={"POST"})
     */
    public function delete(Request $request, Candidature $candidature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        
        return $this->render('candidature/success_delete.html.twig');

    
}
}