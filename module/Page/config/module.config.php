<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Page\Controller\Index' => 'Page\Controller\IndexController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'page' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/page[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                    	'__NAMESPACE__' => 'Page\Controller',
                        'controller' => 'Page\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	'view_manager' => array(
			'template_path_stack' => array(
					'page' => __DIR__ . '/../view',
			),
	),
);

