<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Block controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/block")
 */
class BlockController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_block';
    }

    /**
     * @return string
     */
    protected function getNewUrl()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Block';
    }

    /**
     * @return array
     */
    protected function getFields()
    {
        return array(
            'id'       => array(
                'label' => 'ID',
            ),
            'template' => array(
                'label' => 'Template',
            ),
            'name'     => array(
                'label' => 'Name',
            ),
        );
    }

    /**
     * @return string
     */
    public function getFormTemplate()
    {
        return $this->getEntity().':edit.html.twig';
    }

    /**
     * Return array of allowed global actions
     *
     * @return array
     */
    protected function getGlobalActions()
    {
        $globalActions = array();

        if (method_exists($this, 'newAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'block'),
                'icon'       => 'icon-plus-sign',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Block entities.
     *
     * @Route("/", name="admin_block")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Block entity.
     *
     * @Route("/new/{template}", name="admin_block_new")
     */
    public function newAction($template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates('block', $pTemplate);
        $block     = $templates['class'];
        $block     = new $block();
        $requestStack = $this->getRequestStack();
        $block->setTemplate($template);

        $action = $this->generateUrl('admin_block_new', array('template' => $template));
        $form   = $this->createForm(
            get_class($this->get('bigfoot_content.form.type.block_template_'.$pTemplate)),
            $block,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        if ('POST' === $requestStack->getMethod()) {
            $form->handleRequest($requestStack);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                if ($requestStack->isXmlHttpRequest()) {
                    $contentType = $requestStack->query->get('contentType');
                    $qTemplate   = $requestStack->query->get('template');

                    if (is_numeric($qTemplate)) {
                        $qTemplate = $this->getRepository('BigfootContentBundle:'.ucfirst($contentType))->find($qTemplate)->getSlugTemplate();
                    }

                    $pTemplate     = $this->getParentTemplate($qTemplate);
                    $templates     = $this->getTemplates($contentType, $pTemplate);
                    $contentEntity = $templates['class'];
                    $contentEntity = new $contentEntity();

                    $contentForm   = $this->createForm(
                        get_class($this->get('bigfoot_content.form.type.'.$contentType.'_template_'.$pTemplate)),
                        $contentEntity,
                        array(
                            'template'  => $qTemplate,
                            'templates' => $templates
                        )
                    );

                    $prototype = $this->renderView('BigfootContentBundle:'.ucfirst($contentType).':Block/prototype.html.twig', array('form' => $contentForm->createView()));

                    $content = array(
                        'prototype' => $prototype,
                        'option'    => array(
                            'label' => $block->getName().' - '.$block->getParentTemplate(),
                            'value' => $block->getId()
                        )
                    );

                    return $this->renderAjax('new_block', 'Block created!', $content);
                }

                $this->addSuccessFlash(
                    'Block successfully added!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                        'label' => 'Block successfully added!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            } else {
                if ($requestStack->isXmlHttpRequest()) {
                    return $this->renderAjax(false, 'Error during addition!', $this->renderForm($form, $action, $block)->getContent());
                }
            }
        }

        return $this->renderForm($form, $action, $block);
    }

    /**
     * Edit Block entity.
     *
     * @Route("/edit/{id}", name="admin_block_edit", options={"expose"=true})
     */
    public function editAction($id)
    {
        $block = $this->getRepository($this->getEntity())->find($id);
        $requestStack = $this->getRequestStack();

        if (!$block) {
            throw new NotFoundHttpException('Unable to find block entity.');
        }

        $templates = $this->getTemplates('block', $block->getParentTemplate());
        $action    = $this->generateUrl('admin_block_edit', array('id' => $block->getId()));

        $form = $this->createForm(
            get_class($this->get('bigfoot_content.form.type.block_'.$block->getParentTemplate())),
            $block,
            array(
                'template'  => $block->getSlugTemplate(),
                'templates' => $templates
            )
        );

        if ('POST' === $requestStack->getMethod()) {
            $form->handleRequest($requestStack);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                if ($requestStack->isXmlHttpRequest()) {
                    $contentType = $requestStack->query->get('contentType');
                    $qTemplate   = $requestStack->query->get('template');

                    if (is_numeric($qTemplate)) {
                        $qTemplate = $this->getRepository('BigfootContentBundle:'.ucfirst($contentType))->find($qTemplate)->getSlugTemplate();
                    }

                    $pTemplate     = $this->getParentTemplate($qTemplate);
                    $templates     = $this->getTemplates($contentType, $pTemplate);
                    $contentEntity = $templates['class'];
                    $contentEntity = new $contentEntity();

                    $contentForm   = $this->createForm(
                        get_class($this->get('bigfoot_content.form.type.'.$contentType.'_template_'.$pTemplate)),
                        $contentEntity,
                        array(
                            'template'  => $qTemplate,
                            'templates' => $templates
                        )
                    );

                    $prototype = $this->renderView('BigfootContentBundle:'.ucfirst($contentType).':Block/prototype.html.twig', array('form' => $contentForm->createView()));

                    $content = array(
                        'prototype' => $prototype,
                        'option'    => array(
                            'id'    => $block->getId(),
                            'label' => $block->getName().' - '.$block->getParentTemplate(),
                        )
                    );

                    return $this->renderAjax('edit_block', 'Block edited!', $content);
                }

                $this->addSuccessFlash(
                    'Block successfully updated!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                        'label' => 'Block successfully updated!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            }
        }

        return $this->renderForm($form, $action, $block);
    }

    /**
     * Delete Block entity.
     *
     * @Route("/delete/{id}", name="admin_block_delete")
     */
    public function deleteAction($id)
    {
        $entity = $this->getRepository($this->getEntity())->find($id);
        $requestStack = $this->getRequestStack();

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('Unable to find %s entity.', $this->getEntity()));
        }

        $this->removeAndFlush($entity);

        if (!$requestStack->isXmlHttpRequest()) {
            $this->addSuccessFlash(
                'Block successfully deleted!',
                array(
                    'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                    'label' => 'Block successfully deleted!'
                )
            );

            return $this->redirect($this->generateUrl($this->getRouteNameForAction('index')));
        }

        return $this->doDelete($id);
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    public function getParentTemplate($template)
    {
        $values = explode('_', $template);
        $end    = call_user_func('end', array_values($values));

        return str_replace('_'.$end, '', $template);
    }

    /**
     * @param $contentType
     * @param $parent
     *
     * @return mixed
     */
    public function getTemplates($contentType, $parent)
    {
        $templates = $this->getParameter('bigfoot_content.templates.'.$contentType);

        return $templates[$parent];
    }
}
