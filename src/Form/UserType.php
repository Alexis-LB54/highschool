<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Pupil" => "ROLE_USER",
                    "Admin" => "ROLE_ADMIN",
                    "Mentor" => "ROLE_MENTOR"
                ]
            ]);
        if ($options['mode'] !== "edit") {
            $builder->add('password');
        }
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('mentor', EntityType::class, [
                "class" => User::class,
                "choices" => $options["mentor"] ?? ""
            ])
            // ->add('promotion')
        ;
        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
        $builder->add('attachment', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'mentor' =>  [],
            'mode' =>  "",
        ]);
    }
}
