<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action' => 'logout',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action' => 'login',
                    ),
                ),
            ),
            'auth' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/auth[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Auth',
                        'action' => 'index',
                    ),
                ),
            ),
            //Alias de Urls
            'node' => array(
                'type' => 'Application\Router\Alias',
                'options' => array(
                    'route' => '/node[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'node',
                        'id' => '0'
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'primary_menus' => 'Application\Navigation\Service\PrimaryMenus',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Router\Alias' => 'Application\Router\Alias',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../../../themes',
            'application' => __DIR__ . '/../view',
        ),
    ),
    // agregar este bloque
    // agregar este bloque al final
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public', // public del module Application
                __DIR__ . '/../../../themes/enterprise/css/images',
            ),
            // este mapeo puede ser dinamico desde base de datos o recorriendo el directorio
            'map' => array(
                'themes/enterprise/css/style.css' => __DIR__ . '/../../../themes/enterprise/css/style.css',
                'themes/enterprise/css/ie6.css' => __DIR__ . '/../../../themes/enterprise/css/ie6.css',
                'themes/enterprise/js/jquery-1.4.2.js' => __DIR__ . '/../../../themes/enterprise/js/jquery-1.4.2.js',
                'themes/enterprise/js/jquery.jcarousel.js' => __DIR__ . '/../../../themes/enterprise/js/jquery.jcarousel.js',
                'themes/enterprise/js/jquery.pngFix.js' => __DIR__ . '/../../../themes/enterprise/js/jquery.pngFix.js',
                'themes/enterprise/js/js-fnc.js' => __DIR__ . '/../../../themes/enterprise/js/js-fnc.js',
                'js/login.js' => __DIR__ . '/../public/login.js',
            ),
        ),
        'caching' => array(
            'default' => array(
                'cache' => 'Filesystem',
                'options' => array(
                    'dir' => __DIR__ . '/../../../public/cache', // path/to/cache
                ),
            ),
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
