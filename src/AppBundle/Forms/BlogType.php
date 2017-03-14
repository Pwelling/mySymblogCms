<?php

namespace AppBundle\Forms;

use AppBundle\Forms\DataTransformer\SanitizeTransformer;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'blog.title'
                ],
                'label' => 'blog.title',
                'required' => true,
            ])
            ->add('blog', CKEditorType::class, [
                'attr' => [
                    'placeholder' => 'blog.blog',
                ],
                'label' => 'blog.blog',
                'required' => true,
                'config' => [
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => [
                        'instance' => 'default',
                        'homeFolder' => ''
                    ]
                ],
            ])
            ->add('tags', TextType::class, [
                'attr' => [
                    'placeholder' => 'blog.tags'
                ],
                'label' => 'blog.tags',
            ]);

        $builder->get('title')->addModelTransformer(new SanitizeTransformer());
        $builder->get('tags')->addModelTransformer(new SanitizeTransformer());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'AppBundle_BlogType';
    }
}
