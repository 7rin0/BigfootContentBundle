<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class TemplateType extends AbstractType
{
    private $templates;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $templates = $options['data'];

        $this->toArrayTemplates($templates);

        $builder
            ->add(
                'template',
                'choice',
                array(
                    'required'    => true,
                    'expanded'    => true,
                    'multiple'    => false,
                    'label'       => false,
                    'choices'     => $this->toStringTemplates($templates),
                    'constraints' => array(
                        new Assert\NotNull(),
                    )
                )
            );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['contentType'] = $options['contentType'];
        $view->vars['templates']   = $this->templates;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'contentType' => '',
                'label' => false,
            )
        );
    }

    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key][$subTemplates] = $label;
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    public function toArrayTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            $nTemplates[$key] = array(
                "label" => isset($template['label']) ? $template['label'] : '',
                "subTemplates" => array()
            );
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key]['subTemplates'][$subTemplates] = $label;
            }
        }

        asort($nTemplates);

        $this->templates = $nTemplates;

        return $nTemplates;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_template';
    }
}
