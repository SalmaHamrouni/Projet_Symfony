<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Form\UserType;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;


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
        $candidature = new Candidature();
        $candidature->setUser($this->getUser());
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidature);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('/new_condidature/index.html.twig', [
            'candidature' => $candidature,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/candidat_show", methods={"GET"})
     */
    public function show()
    {
        return $this->render('new_condidature/show.html.twig');
    }

    /**
     * @Route("/{id}/editProfile", name="candidat_profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
                );
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidature');
        }

        return $this->render('new_condidature/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
