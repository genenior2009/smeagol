<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Page' => 'Admin\Controller\PageController',
            'Admin\Controller\Noticias' => 'Admin\Controller\NoticiasController',
        ),
    ),
    // Sección nueva donde definimos las reglas de ruteo y el ruteado principal
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin[/:controller[/:action][/:id]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'admin_menus' => 'Admin\Navigation\Service\AdminMenus'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
            'map' => array(
                'elfinder/css/elfinder.min.css' => __DIR__ . '/../library/elfinder/css/elfinder.min.css',
                'elfinder/css/theme.css' => __DIR__ . '/../library/elfinder/css/theme.css',
                'elfinder/js/elfinder.min.js' => __DIR__ . '/../library/elfinder/js/elfinder.min.js',
                'elfinder/js/i18n/elfinder.es.js' => __DIR__ . '/../library/elfinder/js/i18n/elfinder.es.js',
                'elfinder/img/arrows-active.png' => __DIR__ . '/../library/elfinder/img/arrows-active.png',
                'elfinder/img/arrows-normal.png' => __DIR__ . '/../library/elfinder/img/arrows-normal.png',
                'elfinder/img/crop.gif' => __DIR__ . '/../library/elfinder/img/crop.gif',
                'elfinder/img/dialogs.png' => __DIR__ . '/../library/elfinder/img/dialogs.png',
                'elfinder/img/icons-big.png' => __DIR__ . '/../library/elfinder/img/icons-big.png',
                'elfinder/img/icons-small.png' => __DIR__ . '/../library/elfinder/img/arrows-active.png',
                'elfinder/img/logo.png' => __DIR__ . '/../library/elfinder/img/logo.png',
                'elfinder/img/progress.gif' => __DIR__ . '/../library/elfinder/img/progress.gif',
                'elfinder/img/quicklook-bg.png' => __DIR__ . '/../library/elfinder/img/quicklook-bg.png',
                'elfinder/img/quicklook-icons.png' => __DIR__ . '/../library/elfinder/img/quicklook-icons.png',
                'elfinder/img/resize.png' => __DIR__ . '/../library/elfinder/img/resize.png',
                'elfinder/img/spinner-mini.gif' => __DIR__ . '/../library/elfinder/img/spinner-mini.gif',
                'elfinder/img/toolbar.png' => __DIR__ . '/../library/elfinder/img/toolbar.png',
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
);
