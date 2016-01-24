<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Sidebar\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Bigfoot\Bundle\ContentBundle\Form\Type\ContentType;
use Bigfoot\Bundle\CoreBundle\Form\Type\TranslatedEntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TitleBlockType
 *
 * @package Bigfoot\Bundle\ContentBundle\Form\Type\Sidebar\Template
 */
class TitleBlockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                ContentType::class,
                array(
                    'data'      => $options['data'],
                    'template'  => $options['template'],
                    'templates' => $options['templates']
                )
            )
            ->add(
                'attributes',
                EntityType::class,
                array(
                    'class'     => 'BigfootContentBundle:Attribute',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findByType(Attribute::TYPE_SIDEBAR);
                    },
                    'required'  => false,
                    'multiple'  => true,
                    'attr'      => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'Styles applied to this content element.',
                        'data-title'     => 'Style',
                        'data-trigger'   => 'hover',
                    ),
                    'label' => 'Style',
                )
            )
            ->add(
                'title',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the sidebar as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add(
                'blocks',
                CollectionType::class,
                array(
                    'label'        => false,
                    'prototype'    => true,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'entry_type'         => BlockType::class,
                    'entry_options'      => array(
                        'data'    => $options['data'],
                        'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block',
                    ),
                    'attr' => array(
                        'class' => 'widget-blocks',
                    )
                )
            )
            ->add('translation', TranslatedEntityType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Template\TitleBlock',
                'template'   => '',
                'templates'  => ''
            )
        );
    }
}
