<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TemplateType
 *
 * @package Bigfoot\Bundle\ContentBundle\Form\Type
 */
class TemplateType extends AbstractType
{
    /**
     * @var
     */
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
                ChoiceType::class,
                array(
                    'required'    => true,
                    'expanded'    => true,
                    'multiple'    => false,
                    'label'       => false,
                    'choices'     => $this->toStringTemplates($templates),
                    'choices_as_values' => true,
                    'constraints' => array(
                        new Assert\NotNull(),
                    )
                )
            );
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['contentType'] = $options['contentType'];
        $view->vars['templates']   = $this->templates;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'contentType' => '',
                'label' => false,
            )
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
        foreach ($templates as $key => $template) {
            if(isset($template['sub_templates'])) {
                foreach ($template['sub_templates'] as $label => $name) {
                    $nTemplates[$key][$name] = $label;
                }
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    /**
     * @param $templates
     *
     * @return array
     */
    public function toArrayTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            $nTemplates[$key] = array(
                "label" => isset($template['label']) ? $template['label'] : '',
                "subTemplates" => array()
            );
            if(isset($template['sub_templates'])) {
                foreach ($template['sub_templates'] as $subTemplates => $label) {
                    $nTemplates[$key]['subTemplates'][$subTemplates] = $label;
                }
            }
        }

        asort($nTemplates);
        $this->templates = $nTemplates;

        return $nTemplates;
    }
}
