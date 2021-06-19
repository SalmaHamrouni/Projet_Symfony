<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Offre;
use App\Form\EditType;
use App\Form\UserType;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
* @Route("/candidat")
*/

class NewCondidatureController extends AbstractController
{
   /**
     * @Route("/new_Candidature_user", name="candidature", methods={"GET","POST"})
     */
    public function newCandidatureUser(Request $request): Response
    {
        
        if($request->query->get('id'))
        {
            $offre= $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($request->query->get('id'));
            $candidature = new Candidature();
            $candidature->setUser($this->getUser());
            $candidature->setIdOffre($offre);
            $candidature->setValider("En Attente");
            
           /* $form = $this->createForm(CandidatureType::class, $candidature);
            $form->handleRequest($request);*/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();
             //dd("succes");
            return $this->redirectToRoute('indexCandidature');
           

           
        }     
    }
    
    /**
     * @Route("/index", name="indexCandidature", methods={"GET"})
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }

     /**
     * @Route("/candidat_show", methods={"GET"}, name="CandidatShow")
     */
    public function show()
    {
        return $this->render('Edit_Profile/show.html.twig');
    }

    /**
     * @Route("/{id}/editProfile", name="candidat_profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
       # dd($user);
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();


        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
                );
            $entityManager->persist($user);
            $entityManager->flush();

           
            
           // dd("updated");

            return $this->redirectToRoute('CandidatShow');
        }

        return $this->render('Edit_Profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
