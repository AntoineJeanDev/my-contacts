<?php

namespace App\Controller;

// session
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// templates
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// routes
use Symfony\Component\Routing\Annotation\Route;

// forms
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\FormLogin;
use App\Form\FormRegister;
use App\Entity\User;

class HomeController extends AbstractController
{
    /**
    * @Route("/home", name="home")
    */
    public function index(SessionInterface $session, Request $request)
    {
        // $this->get('session')->set('activeSession', 'off');
        
        // create register/login form if no session
        // if ($this->get('session')->get('activeSession') == 'off') {
            
            $user_register = new User();
            $user_login = new User();

            $form_login = $this->createForm(FormLogin::class, $user_login);
            $form_register = $this->createForm(FormRegister::class, $user_register);
            
            // handle forms
            //// register
            $form_register->handleRequest($request);
            
            if ($form_register->isSubmitted() && $form_register->isValid()) {
                $user = $form_register->getData();
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                echo "<script>console.log('user created');</script>";
            }
            else {
                echo "<script>console.log('form not submited');</script>";
            }

            ///// Login
            $form_login->handleRequest($request);

            if ($form_login->isSubmitted() && $form_login->isValid()) {
                $user_login = $form_login->getData();

                $user_logged = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy(['email' => $user_login->getEmail()]);

                if ($user_logged) {
                    $session->set('activeSession', 'true');
                    $session->set('user', $user_logged);
                    echo "<script>console.log('user logged in');</script>";
                    return $this->redirectToRoute('user');
                }
                elseif (!$user_logged) {
                    echo "<script>console.log('wrong email');</script>";
                }

            }
            
            return $this->render('home/index.html.twig', array(
                'controller_name' => 'HomeController',
                'form_register' => $form_register->createView(),
                'form_login' => $form_login->createView(),
            ));
            
        // }
        // else {

        //     return $this->render('home/index.html.twig', array(
        //         'controller_name' => 'HomeController',
        //     ));

        // }  
        
    }
    
}
