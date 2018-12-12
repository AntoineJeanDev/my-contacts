<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use App\Entity\User;
use App\Entity\Contact;

class CsvManagerController extends AbstractController
{
    /**
     * @Route("/csv/writter/{id}", name="csv_manager")
     */
    public function index($id)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneById($id);

        $contacts = $user->getContacts();

        // $contacts = array();

        // foreach ($contacts_user as $c) {
        //     $con = new Contact();
        //     $con->setId($c->getId());
        //     $con->setFirstName($c->getFirstName());
        //     $con->setLastName($c->getLastName());
        //     $con->setAdress($c->getAdress());
        //     $con->setPhone($c->getPhone());
        //     $con->setEmail($c->getEmail());
        //     // $con->setUser($c->getUser());

        //     array_push($contacts, $con);
        // }

        // var_dump($contacts);

        // $encoders = array(new CsvEncoder());
        // $normalizers = array(new ObjectNormalizer());

        // $serializer = new Serializer($normalizers, $encoders);


        // $csvContent = $serializer->serialize($contacts, 'csv');

        // $serializer = JMS\Serializer\SerializerBuilder::create()->build();
        // $csvContent = $serializer->serialize($contacts, 'csv');
        // $csvContent = $this->get('jms_serializer')->serialize($contacts, 'csv');

        

        // var_dump ($csvContent);


        return $this->render('csv_manager/index.html.twig', [
            'controller_name' => 'CsvManagerController',
            'contacts' => $contacts,
            // 'csv' => $csvContent,
        ]);
    }
}
