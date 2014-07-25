<?php

namespace Admin\Navigation\Service;

use Zend\ServiceManager\ServiceLocator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class AdminMenus extends DefaultNavigationFactory {

    protected function getName() {
        return 'admin';
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator) {
        if (null === $this->pages) {

            $configuration['navigation'][$this->getName()] = array(
                array(
                    'label' => 'Dashboard',
                    'route' => 'admin',
                    'params' => array(
                        'link' => '/dashboard',
                    ),
                ),
                array(
                    'label' => 'Contenido',
                    'route' => 'admin',
                    'controller' => 'page',
                    'action' => 'index',
                    'params' => array(
                        'link' => '/admin/page',
                    ),
                ),
                array(
                    'label' => 'Noticias',
                    'route' => 'admin',
                    'controller' => 'noticias',
                    'action' => 'index',
                    'params' => array(
                        'link' => '/admin/noticias',
                    ),
                ),
                array(
                    'label' => 'Menus',
                    'route' => 'admin',
                    'controller' => 'menus',
                    'action' => 'index',
                    'params' => array(
                        'link' => '/admin/noticias',
                    ),
                ),
                array(
                    'label' => 'Temas',
                    'route' => 'admin',
                    'controller' => 'themes',
                    'action' => 'index',
                    'params' => array(
                        'link' => '/admin/themes',
                    ),
                ),
                array(
                    'label' => 'Usuarios',
                    'route' => 'admin',
                    'controller' => 'users',
                    'action' => 'index',
                    'params' => array(
                        'link' => '/admin/users',
                    ),
                    'pages' => array
                        (array(
                            'label' => 'Permisos',
                            'route' => 'admin',
                            'controller' => 'perms',
                            'action' => 'index',
                            'params' => array(
                                'link' => '/admin/perms',
                            ),
                        ),
                    ),
                ),
            );

            if (!isset($configuration['navigation'])) {
                throw new Exception\InvalidArgumentException('Could not find navigation configuration key');
            }
            if (!isset($configuration['navigation'][$this->getName()])) {
                throw new Exception\InvalidArgumentException(sprintf(
                        'Failed to find a navigation container by the name "%s"', $this->getName()
                ));
            }

            $application = $serviceLocator->get('Application');
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $router = $application->getMvcEvent()->getRouter();
            $pages = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
            // 
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
    }

}