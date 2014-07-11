<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Noticias\Controller\Index' => 'Noticias\Controller\IndexController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'noticias' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/noticias[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Noticias\Controller',
                        'controller' => 'Noticias\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	'view_manager' => array(
			'template_path_stack' => array(
					'noticias' => __DIR__ . '/../view',
			),
	),
);

