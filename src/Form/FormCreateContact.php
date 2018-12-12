<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use App\Entity\Contact;

class FormCreateContact extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $registerBuilder, 
  array $option)
  {
    $registerBuilder
    ->add('first_name', TextType::class, array(
      'required' => true
  ))
  ->add('last_name', TextType::class, array(
      'required' => true
  ))
  ->add('adress', TextType::class, array(
      'required' => true
  ))
  ->add('phone', IntegerType::class, array(
      'required' => true
  ))
  ->add('email', TextType::class, array(
      'required' => true
  ))
  ->add('save', SubmitType::class, array('label' => 'Create Contact'))
      ;
    }
    
  }