<?php

namespace App\Controller;

// session
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User;
use App\Entity\Contacts;

use App\Form\FormEditUser;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(SessionInterface $session)
    {
        
        if ($session->get('activeSession') == 'true') {

            $user_loggedIn = $session->get('user');

            $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user_loggedIn->getId());

            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'user' => $user,
            ]);
        } else {
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
            ]);
        }
    }

    /**
     * @Route("/user/disconnect", name="user_disconnect")
     */
    public function disconnect(SessionInterface $session)
    {
        $session->set('activeSession', 'false');
        $session->set('user', null);

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/user/edit", name="user_edit")
     */
    public function userEdit(SessionInterface $session, Request $request)
    {
        if ($session->get('activeSession') == 'true') {

            $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($session->get('user')->getId()); 
            
            $user_temp = new User();

            $form_edit = $this->createForm(FormEditUser::class, $user_temp);
            $form_edit->handleRequest($request);

            if ($form_edit->isSubmitted() && $form_edit->isValid()) {
                $user_temp = $form_edit->getData();

                $user->setFirstName($user_temp->getFirstName());
                $user->setLastName($user_temp->getLastName());
                $user->setAdress($user_temp->getAdress());
                $user->setPhone($user_temp->getPhone());
                $user->setEmail($user_temp->getEmail());
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('user');

            } else {
                $form_edit->get('first_name')->setData($user->getFirstName());
                $form_edit->get('last_name')->setData($user->getLastName());
                $form_edit->get('adress')->setData($user->getAdress());
                $form_edit->get('phone')->setData($user->getPhone());
                $form_edit->get('email')->setData($user->getEmail());
            }

            return $this->render('user/edit.html.twig', [
                'controller_name' => 'UserController',
                'form_edit' => $form_edit->createView(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
