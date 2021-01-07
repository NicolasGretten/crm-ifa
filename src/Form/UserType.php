<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder
//            ->add('email')
//            ->add('roles')
//            ->add('password')
//            ->add('created_at')
//            ->add('updated_at')
//            ->add('customer', EntityType::class, [
//                'class' => Customer::class,
//                'choice_label' => 'email_address']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
