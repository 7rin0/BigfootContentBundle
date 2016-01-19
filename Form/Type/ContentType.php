<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'template',
                ChoiceType::class,
                array(
                    'required' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'data'     => $options['template'],
                    'choices'  => $options['data']->toStringTemplates($options['templates'])
                )
            )
            ->add(
                'name',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the name of the content in the back office. It will not be displayed to the web user.',
                        'data-title'     => 'Name',
                        'data-trigger'   => 'hover',
                    )
                )
            )
            ->add('active', CheckboxType::class, array('required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'inherit_data'  => true,
                'template'      => '',
                'templates'     => '',
                'label'         => false,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
