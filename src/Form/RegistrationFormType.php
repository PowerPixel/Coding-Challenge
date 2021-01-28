<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType as TypeDateTimeType;

class RegistrationFormType extends AbstractType
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
                                'maxMessage' => 'Votre email ne doit pas dépasser {{ limit }} caractères.'
                            ]
                            ),
                            new Email(
                                [
                                    "message" => 'Veuillez choisir une adresse mail valide.'
                                ]
                            )
                    ],
                    'label'=> "E-mail"
                ]
            )
            ->add('first_name', TextType::class,
            [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un prénom',
                    ]),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Votre prénom ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )
                ],
                'label' => 'Prénom'
            ])
            ->add('last_name', TextType::class,
            [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un nom',
                    ]),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Votre nom de famille ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )

                ],
                'label' => 'Nom'
            ])
            ->add('username',TextType::class, [
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Veuillez rentrer un nom d\'utilisateur.'
                        ]
                        ),
                        new Length(
                            [
                                'max' => 60,
                                'maxMessage' => 'Votre nom d\'utilisateur ne doit pas dépasser {{ limit }} caractères.'
                            ]
                        )
                ]
            ]
            )
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rentrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être composé d\'au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => "Mot de passe"
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGU.',
                    ]),
                ],
                'label' => "En cochant cette case, vous acceptez les CGU"
            ])
            ->add('Register', SubmitType::class, [
                "label" => 'S\'inscrire'
            ])
            ->add("join_date",TypeDateTimeType::class,[
                'data' => new DateTime(date("Y-m-d H:i:s")),
                'attr' => [
                    'hidden' => 'true'
                ],
                'label'=>' '
            ]

        );
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
