<?php

namespace App\Controller;

// session
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User;
use App\Entity\Contacts;

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
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
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
}
