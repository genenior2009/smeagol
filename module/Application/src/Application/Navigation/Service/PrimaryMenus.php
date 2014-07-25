<?php

namespace Application\Navigation\Service;

use Zend\ServiceManager\ServiceLocator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class PrimaryMenus extends DefaultNavigationFactory {

    protected function getName() {
        return 'default';
    }

    protected function getPages(ServiceLocatorInterface $serviceLocator) {
        if (null === $this->pages) {

            // esto se generará despues desde la base de datos
            $configuration['navigation'][$this->getName()] = array(
                        array(
                            'label' => 'Inicio',
                            'route' => 'home'
                        ),
                        array(
                            'label' => 'Nosotros',
                            'route' => 'node',
                            'params' => array(
                                'id' => '1',
                                'link' => '/nosotros',
                                'node_type' => 'page',
                            ),
                        ),
                        array(
                            'label' => 'Servicios',
                            'route' => 'page',
                            'action' => 'servicios',
                            'pages' => array(
                                'programacion-web' => array(
                                    'label' => 'Programación Web',
                                    'route' => 'page',
                                    'action' => 'programacion-web'
                                ),
                                'desarrollo-portales' => array(
                                    'label' => 'Desarrollo de Portales',
                                    'route' => 'page',
                                    'action' => 'desarrollo-portales',
                                    'pages' => array(
                                        'drupal' => array(
                                            'label' => 'Drupal',
                                            'route' => 'page',
                                            'action' => 'drupal'
                                        ),
                                        'joomla' => array(
                                            'label' => 'Joomla',
                                            'route' => 'page',
                                            'action' => 'joomla'
                                        ),
                                        'wordpress' => array(
                                            'label' => 'Wordpress',
                                            'route' => 'page',
                                            'action' => 'wordpress'
                                        )
                                    )
                                )
                            ),
                        ),
                        array(
                            'label' => 'Soluciones',
                            'route' => 'page',
                            'action' => 'soluciones',
                            'pages' => array(
                                'smeagol' => array(
                                    'label' => 'Smeagol CMS',
                                    'route' => 'page',
                                    'action' => 'smeagol'
                                ),
                                'intranets' => array(
                                    'label' => 'Intranets',
                                    'route' => 'page',
                                    'action' => 'intranets'
                                )
                            )
                        ),
                        array(
                            'label' => 'Soporte',
                            'route' => 'page',
                            'action' => 'soporte',
                            'pages' => array(
                                'standar' => array(
                                    'label' => 'Standar',
                                    'route' => 'page',
                                    'action' => 'standar'
                                ),
                                'premium' => array(
                                    'label' => 'Intranets',
                                    'route' => 'page',
                                    'action' => 'premium'
                                )
                            )
                        ),
                        array(
                            'label' => 'Contactenos',
                            'route' => 'page',
                            'action' => 'contactenos',
                        )
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
