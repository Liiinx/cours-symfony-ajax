<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label'  => 'Votre commentaire',
                'attr'   =>  ['class'   => 'form-control',
                    'rows' => '2',
                    ]
            ])
            ->add('user', HiddenType::class)
            ->add('post', HiddenType::class)
            ->add('save', SubmitType::class, [
                'label'  => 'Enregistrer',
                'attr'   =>  ['class'   => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
