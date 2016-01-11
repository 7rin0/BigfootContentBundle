<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TitleDescMediaSidebarType extends AbstractType
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
                'admin_content',
                array(
                    'data'      => $options['data'],
                    'template'  => $options['template'],
                    'templates' => $options['templates']
                )
            )
            ->add(
                'attributes',
                'entity',
                array(
                    'class'     => 'BigfootContentBundle:Attribute',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->findByType(Attribute::TYPE_PAGE);
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
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the page as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add(
                'slug',
                'text',
                array(
                    'required'  => false,
                    'attr'      => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This value is used to generate urls. Should contain only lower case letters and the \'-\' sign.',
                        'data-title'     => 'Slug',
                        'data-trigger'   => 'hover',
                    ),
                )
            )
            ->add('seoTitle', 'text', array('required' => false))
            ->add('seoDescription', 'textarea', array('required' => false))
            ->add('description', 'bigfoot_richtext')
            ->add('media', 'bigfoot_media')
            ->add(
                'sidebars',
                'collection',
                array(
                    'label'        => false,
                    'prototype'    => true,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'type'         => 'admin_page_sidebar',
                    'options'      => array(
                        'page' => $options['data'],
                    ),
                    'attr' => array(
                        'class' => 'widget-sidebars',
                    )
                )
            )
            ->add('translation', 'translatable_entity');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Template\TitleDescMediaSidebar',
                'template'   => '',
                'templates'  => ''
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_template_title_desc_media_sidebar';
    }
}
