<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Firstname', TextType::class, [
                "required" => true,
                "label" => "Type your name."
            ])
            ->add('Lastname', TextType::class,[
                "required" => true,
                "label" => "Type your last name."
            ])
            ->add('street', TextType::class,[
                "required" => true,
                "label" => "Your street address."
            ])
            ->add('number', NumberType::class, [
                "required" => true,
                "label" => "House number."
            ])
            ->add('zip', TextType::class, [
                "required" => true,
                "label" => "Zip code."
            ])
            ->add('city',TextType::class, [
                "required" => true,
                "label" => "City name."
            ])
            ->add('country', TextType::class, [
                "required" => true,
                "label" => "Country name."
            ])
            ->add('phonenumber', TextType::class, [
                "required" => true,
                "label" => "Your full number."
            ])
            ->add('birthday', BirthdayType::class,[
                "required" => true,
                "label" => "Your birth day."
            ])
            ->add('email', EmailType::class, [
                "required" => true,
                "label" => "Email."
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
