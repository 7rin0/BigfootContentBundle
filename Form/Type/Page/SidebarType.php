<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SidebarType
 *
 * @package Bigfoot\Bundle\ContentBundle\Form\Type\Page
 */
class SidebarType extends AbstractType
{
    /**
     * @var string
     */
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
                'sidebar',
                EntityType::class,
                array(
                    'class'         => 'Bigfoot\Bundle\ContentBundle\Entity\Sidebar',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')->orderBy('s.name', 'ASC');
                    }
                )
            )
            ->add('position')
            ->add(
                'template',
                ChoiceType::class,
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
                $data->setPage($options['page']);
            }
        );
    }

    /**
     * @param $templates
     *
     * @return array
     */
    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        if(isset($templates['sub_templates'])) {
            foreach ($templates as $key => $template) {
                foreach ($template['sub_templates'] as $subTemplates => $label) {
                    $nTemplates[$key . '/' . $subTemplates] = $label;
                }
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar',
                'page'    => ''
            )
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'sidebar';
    }
}
