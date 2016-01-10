<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Sidebar;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                    'class'         => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('b')->orderBy('b.name', 'ASC');
                    }
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
            function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $data->setSidebar($options['sidebar']);
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
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'sidebar' => null
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'admin_sidebar_block';
    }
}
