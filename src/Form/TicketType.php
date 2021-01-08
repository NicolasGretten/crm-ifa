<?php

namespace App\Form;

use App\Entity\Demand;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('demand', EntityType::class, [
                    'class' => Demand::class,
                    'choice_label' =>function ($demand) {
                        if (strlen($demand->getContent()) > 25)
                        {
                            $content =  substr($demand->getContent(), 0, 25)."...";
                        }
                        else
                        {
                            $content = $demand->getContent();
                        }
                        return 'Demand n°' . $demand->getId() . ',  preview content: ' . $content;
                        },
                    'required' => false
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
