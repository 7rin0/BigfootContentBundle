<?php

namespace Bigfoot\Bundle\ContentBundle\Subscriber;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\ExpressionLanguage\Token;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Security;

/**
 * Menu Subscriber
 */
class MenuSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private $security;

    /**
     * @param Security $security
     */
    public function __construct(TokenStorage $security)
    {
        $this->security = $security;
    }

    /**
     * Get subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            MenuEvent::GENERATE_MAIN => array('onGenerateMain', 8),
        );
    }

    /**
     * @param GenericEvent $event
     */
    public function onGenerateMain(GenericEvent $event)
    {
        $builder = $event->getSubject();

        $builder
            ->addChild(
                'content',
                array(
                    'label'          => 'Content',
                    'url'            => '#',
                    'linkAttributes' => array(
                        'class' => 'dropdown-toggle',
                        'icon'  => 'list-alt',
                    ),
                    'attributes' => array(
                        'class' => 'parent'
                    ),
                    'extras' => array(
                        'routes' => array(
                            'admin_content_template_choose',
                        )
                    )
                ),
                array(
                    'children-attributes' => array(
                        'class' => 'submenu'
                    )
                )
            )
            ->addChildFor(
                'content',
                'content_page',
                array(
                    'label'  => 'Page',
                    'route'  => 'admin_page',
                    'extras' => array(
                        'routes' => array(
                            'admin_page_new',
                            'admin_page_edit',
                        )
                    ),
                    'linkAttributes' => array(
                        'icon' => 'list-alt',
                    )
                )
            )
            ->addChildFor(
                'content',
                'content_sidebar',
                array(
                    'label'  => 'Sidebar',
                    'route'  => 'admin_sidebar',
                    'extras' => array(
                        'routes' => array(
                            'admin_sidebar_new',
                            'admin_sidebar_edit',
                        )
                    ),
                    'linkAttributes' => array(
                        'icon' => 'list-alt',
                    )
                )
            )
            ->addChildFor(
                'content',
                'content_block',
                array(
                    'label'  => 'Block',
                    'route'  => 'admin_block',
                    'extras' => array(
                        'routes' => array(
                            'admin_block_new',
                            'admin_block_edit',
                        )
                    ),
                    'linkAttributes' => array(
                        'icon' => 'list-alt',
                    )
                )
            );
    }
}
