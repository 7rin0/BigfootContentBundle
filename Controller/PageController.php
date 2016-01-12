<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Event\FormEvent;
use Bigfoot\Bundle\CoreBundle\Util\StringManager;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Page controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/page")
 */
class PageController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_page';
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
        return 'BigfootContentBundle:Page';
    }

    protected function getFields()
    {
        return array(
            'id'   => array(
                'label' => 'ID',
            ),
            'template' => array(
                'label' => 'Template',
            ),
            'name' => array(
                'label' => 'Name',
            ),
        );
    }

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

        if (method_exists($this, 'chooseAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'page'),
                'icon'       => 'icon-plus-sign',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Page entities.
     *
     * @Route("/", name="admin_page")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Page entity.
     *
     * @Route("/new/{template}", name="admin_page_new")
     */
    public function chooseAction(RequestStack $requestStack, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $requestStack = $requestStack->getCurrentRequest();
        $templates = $this->getTemplates($pTemplate);
        $page      = $templates['class'];
        $page      = new $page();
        $page->setTemplate($template);
        $action = $this->generateUrl('admin_page_new', array('template' => $template));
        $form   = $this->createForm(
            $this->get('bigfoot_content.form.type.page_'.$pTemplate),
            $page,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        $this->getEventDispatcher()->dispatch(FormEvent::CREATE, new GenericEvent($form));

        if ('POST' === $requestStack->getMethod()) {
            $form->handleRequest($requestStack);

            if ($form->isValid()) {
                $this->persistAndFlush($page);

                $this->addSuccessFlash(
                    'Page successfully added!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                        'label' => 'Page successfully added!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($form, $action, $page);
    }

    /**
     * Edit Page entity.
     *
     * @Route("/edit/{id}", name="admin_page_edit")
     */
    public function editAction(RequestStack $requestStack, $id)
    {
        $page = $this->getRepository($this->getEntity())->find($id);

        if (!$page) {
            throw new NotFoundHttpException('Unable to find Page entity.');
        }

        $templates = $this->getTemplates($page->getParentTemplate());
        $action    = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
        $form      = $this->createForm(
            $this->get('bigfoot_content.form.type.page_'.$page->getParentTemplate()),
            $page,
            array(
                'template'  => $page->getSlugTemplate(),
                'templates' => $templates
            )
        );

        $dbBlocks    = new ArrayCollection();
        $dbBlocks2   = new ArrayCollection();
        $dbBlocks3   = new ArrayCollection();
        $dbBlocks4   = new ArrayCollection();
        $dbBlocks5   = new ArrayCollection();
        $dbSidebars  = new ArrayCollection();
        $dbSidebars2 = new ArrayCollection();
        $dbSidebars3 = new ArrayCollection();
        $dbSidebars4 = new ArrayCollection();
        $dbSidebars5 = new ArrayCollection();

        for ($i = 1; $i <= 5; $i++) {
            $j = ($i > 1) ? $i : '';

            foreach ($page->{'getBlocks'.$j}() as ${'block'.$j}) {
                ${'dbBlocks'.$j}->add(${'block'.$j});
            }
        }

        for ($i = 1; $i <= 5; $i++) {
            $j = ($i > 1) ? $i : '';

            foreach ($page->{'getSidebars'.$j}() as ${'sidebar'.$j}) {
                ${'dbSidebars'.$j}->add(${'sidebar'.$j});
            }
        }

        if ('POST' === $requestStack->getMethod()) {
            $form->handleRequest($requestStack);

            if ($form->isValid()) {
                for ($i = 1; $i <= 5; $i++) {
                    $j = ($i > 1) ? $i : '';

                    foreach (${'dbBlocks'.$j} as ${'block'.$j}) {
                        if ($page->{'getBlocks'.$j}()->contains(${'block'.$j}) === false) {
                            $page->{'getBlocks'.$j}()->removeElement(${'block'.$j});
                            $this->getEntityManager()->remove(${'block'.$j});
                        }
                    }
                }

                for ($i = 1; $i <= 5; $i++) {
                    $j = ($i > 1) ? $i : '';

                    foreach (${'dbSidebars'.$j} as ${'sidebar'.$j}) {
                        if ($page->{'getSidebars'.$j}()->contains(${'sidebar'.$j}) === false) {
                            $page->{'getSidebars'.$j}()->removeElement(${'sidebar'.$j});
                            $this->getEntityManager()->remove(${'sidebar'.$j});
                        }
                    }
                }

                $this->persistAndFlush($page);

                $this->addSuccessFlash(
                    'Page successfully updated!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                        'label' => 'Page successfully updated!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($form, $action, $page);
    }

    /**
     * Delete Page entity.
     *
     * @Route("/delete/{id}", name="admin_page_delete")
     */
    public function deleteAction(RequestStack $requestStack, $id)
    {
        $entity = $this->getRepository($this->getEntity())->find($id);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('Unable to find %s entity.', $this->getEntity()));
        }

        $this->removeAndFlush($entity);

        if (!$request->isXmlHttpRequest()) {
            $this->addSuccessFlash(
                'Page successfully deleted!',
                array(
                    'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                    'label' => 'Page successfully deleted!'
                )
            );

            return $this->redirect($this->generateUrl($this->getRouteNameForAction('index')));
        }

        return $this->doDelete($requestStack, $id);
    }

    public function getParentTemplate($template)
    {
        $values = explode('_', $template);
        $end    = call_user_func('end', array_values($values));

        return str_replace('_'.$end, '', $template);
    }

    public function getTemplates($parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.page');

        return $templates[$parent];
    }
}
