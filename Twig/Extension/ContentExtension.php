<?php

namespace Bigfoot\Bundle\ContentBundle\Twig\Extension;

use Bigfoot\Bundle\ContentBundle\Entity\Block;
use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * ContentExtension
 */
class ContentExtension extends Twig_Extension
{
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param Twig_Environment $twig
     * @param RouterInterface  $router
     * @param EntityManager    $entityManager
     */
    public function __construct(Twig_Environment $twig, RouterInterface $router, EntityManager $entityManager)
    {
        $this->twig          = $twig;
        $this->router        = $router;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new \Twig_SimpleFunction('display_page', array($this, 'displayPage', $options)),
            new \Twig_SimpleFunction('display_sidebar', array($this, 'displaySidebar', $options)),
            new \Twig_SimpleFunction('display_block', array($this, 'displayBlock', $options)),
        );
    }

    /**
     * @param       $page
     * @param array $data
     *
     * @return string
     */
    public function displayPage($page, array $data = null)
    {
        $template = (isset($data['template'])) ? $data['template'] : $page->getParentTemplate().'/'.$page->getSlugTemplate();

        return $this->twig->render(
            'BigfootContentBundle:templates:page/'.$template.'.html.twig',
            array(
                'page'       => $page,
                'parameters' => (isset($data['parameters'])) ? $data['parameters'] : null,
            )
        );
    }

    /**
     * @param       $sidebar
     * @param array $data
     *
     * @return string
     */
    public function displaySidebar($sidebar, array $data = null)
    {
        if (is_string($sidebar)) {
            $sidebar = $this->entityManager->getRepository('BigfootContentBundle:Sidebar')->findOneBySlug($sidebar);
        }

        if (!$sidebar) {
            return '';
        }

        $pageSidebar = (!$sidebar instanceof Sidebar) ? $sidebar : false;
        $template    = ($pageSidebar) ? $pageSidebar->getTemplate() : $sidebar->getParentTemplate().'/'.$sidebar->getSlugTemplate();
        $template    = (isset($data['template'])) ? $data['template'] : $template;
        $sidebar     = ($sidebar instanceof PageSidebar) ?  $sidebar->getSidebar() : $sidebar;

        return $this->twig->render(
            'BigfootContentBundle:templates:sidebar/'.$template.'.html.twig',
            array(
                'sidebar'    => $sidebar,
                'parameters' => (isset($data['parameters'])) ? $data['parameters'] : null,
            )
        );
    }

    /**
     * @param       $block
     * @param array $data
     *
     * @return string
     */
    public function displayBlock($block, array $data = null)
    {
        if (is_string($block)) {
            $block = $this->entityManager->getRepository('BigfootContentBundle:Block')->findOneBy(array('slug' => $block, 'active' => true));
        }

        if (!$block) {
            return '';
        }

        $entityBlock = (!$block instanceof Block) ? $block : false;
        $template    = ($entityBlock) ? $entityBlock->getTemplate() : $block->getParentTemplate().'/'.$block->getSlugTemplate();
        $template    = (isset($data['template'])) ? $data['template'] : $template;

        if (isset($data['parameters'])) {
            $action             = ($entityBlock) ? $entityBlock->getBlock()->getAction() : $block->getAction();
            $data['parameters'] = $this->handleParameters($action, $data['parameters']);
        }

        $block = (!$block instanceof Block) ? $entityBlock->getBlock() : $block;

        return $this->twig->render(
            'BigfootContentBundle:templates:block/'.$template.'.html.twig',
            array(
                'block'      => $block,
                'parameters' => (isset($data['parameters'])) ? $data['parameters'] : null,
            )
        );
    }

    /**
     * @param $action
     * @param $parameters
     *
     * @return array
     */
    public function handleParameters($action, $parameters)
    {
        if ($action) {
            $variables   = $this->router->getRouteCollection()->get($action)->compile()->getVariables();
            $nParameters = array();

            foreach ($variables as $variable) {
                $nParameters[$variable] = $parameters[$variable];
            }

            return $nParameters;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
