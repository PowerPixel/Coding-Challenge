<?php

namespace App\Form;

use DateTime;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;

class AdminRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez rentrer une adresse mail',
                        ]),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'L\'email ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        ),
                        new Email(
                            [
                                "message" => 'Veuillez choisir une adresse mail valide.'
                            ]
                        ),
                        
                    ],
                    'label' => "E-mail"
                ]
            )
            ->add(
                'first_name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez rentrer un prénom',
                        ]),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )
                    ],
                    'label' => 'Prénom'
                ]
            )
            ->add(
                'last_name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez rentrer un nom',
                        ]),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Le nom de famille ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )

                    ],
                    'label' => 'Nom'
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Veuillez rentrer un nom d\'utilisateur.'
                            ]
                        ),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Le nom d\'utilisateur ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )
                    ]
                ]
            )
            ->add('Register', SubmitType::class, [
                "label" => 'Inscrire'
            ])
            ->add(
                "join_date",
                TypeDateTimeType::class,
                [
                    'data' => new DateTime(date("Y-m-d H:i:s")),
                    'attr' => [
                        'hidden' => 'true'
                    ],
                    'label' => ' '
                ]

            );;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
