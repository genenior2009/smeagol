<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=smeagol;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Inicio',
                'route' => 'home'
            ),
            array(
                'label' => 'Nosotros',
                'route' => 'page',
                'action' => 'nosotros'
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
        )
    )
        )
;
