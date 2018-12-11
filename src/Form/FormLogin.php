<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\User;

class FormLogin extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $loginBuilder, 
  array $option)
  {
    $loginBuilder
      ->add('email', TextType::class, array(
        'required' => true
      ))
      ->add('save', SubmitType::class, array('label' => 'Login'))
      ;
    }
    
  }