<?php

namespace App\Controller;

// session
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Form\FormCreateContact;

use App\Entity\User;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/create", name="contact_create")
     */
    public function createUser(SessionInterface $session, Request $request)
    {
        if ($session->get('activeSession') == 'true') {
            $new_contact = new Contact();
            $form_create = $this->createForm(FormCreateContact::class, $new_contact);

            $form_create->handleRequest($request);

            if ($form_create->isSubmitted() && $form_create->isValid()) {
                $user_loggedIn = $session->get('user');
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($user_loggedIn->getId());


                $contact = $form_create->getData();

                $contact->setUser($user);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();

                return $this->redirectToRoute('user');

            }

            return $this->render('contact/create.html.twig', [
                'controller_name' => 'ContactController',
                'form_create' => $form_create->createView(),
            ]);
        } else {
            return $this->render('contact/create.html.twig', [
                'controller_name' => 'ContactController',
            ]);
        }
            
    }
    
    /**
     * @Route("/contact/{id}", name="contact_show")
     */
    public function index(SessionInterface $session, $id)
    {
        if ($session->get('activeSession') == 'true') {
            $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($id);

            return $this->render('contact/index.html.twig', [
                'controller_name' => 'ContactController',
                'contact' => $contact,
            ]);
        } else {
            return $this->render('contact/index.html.twig', [
                'controller_name' => 'ContactController',
            ]);

        }
    }


    /**
     * @Route("/contact/delete/{id}", name="contact_delete")
     */
    public function deleteContact(SessionInterface $session, $id)
    {
        if ($session->get('activeSession') == 'true') {
            $entityManager = $this->getDoctrine()->getManager();
            $contact = $entityManager
                ->getRepository(Contact::class)
                ->find($id);
            $entityManager->remove($contact);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }
    }

}
