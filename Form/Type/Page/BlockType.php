<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlockType extends AbstractType
{
    protected $templates;

    /**
     * Construct Block Type
     *
     * @param string $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'block',
                'entity',
                array(
                    'class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
                )
            )
            ->add('position')
            ->add(
                'template',
                'choice',
                array(
                    'required' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choices'  => $this->toStringTemplates($this->templates)
                )
            );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $data->setPage($options['page']);
            }
        );
    }

    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key.'/'.$subTemplates] = $label;
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'page' => null,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_block';
    }
}
