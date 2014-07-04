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
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
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
            'Application\Controller\Index' => 'Application\Controller\IndexController'
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
        /* 'template_path_stack' => array(
          __DIR__ . '/../view',
          ), */
        'template_path_stack' => array(
            __DIR__ . '/../../../themes', // <------------------  Modificar aca
        ),
    ),
    // agregar este bloque al final
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
                __DIR__ . '/../../../themes/smeagol/css/images',
            ),
            // este mapeo puede ser dinamico desde base de datos o recorriendo el directorio
            'map' => array(
                'themes/enterprise/css/style.css' => __DIR__ . '/../../../themes/enterprise/css/style.css',
                'themes/enterprise/css/ie6.css' => __DIR__ . '/../../../themes/enterprise/css/ie6.css',
                'themes/enterprise/js/jquery-1.4.2.js' => __DIR__ . '/../../../themes/enterprise/js/jquery-1.4.2.js',
                'themes/enterprise/js/jquery.jcarousel.js' => __DIR__ . '/../../../themes/enterprise/js/jquery.jcarousel.js',
                'themes/enterprise/js/jquery.pngFix.js' => __DIR__ . '/../../../themes/enterprise/js/jquery.pngFix.js',
                'themes/enterprise/js/js-fnc.js' => __DIR__ . '/../../../themes/enterprise/js/js-fnc.js',
                //smeagol
                'themes/smeagol/css/style.css' => __DIR__ . '/../../../themes/smeagol/css/style.css',
                'themes/smeagol/js/jquery-1.3.2.min.js' => __DIR__ . '/../../../themes/smeagol/js/jquery-1.3.2.min.js',
                'themes/smeagol/js/jquery-func.js' => __DIR__ . '/../../../themes/smeagol/js/jquery-func.js',
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
