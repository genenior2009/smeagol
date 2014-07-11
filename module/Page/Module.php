<?php
namespace Page;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

// Add these import statements:
use Smeagol\Model\Node;
use Smeagol\Model\NodeTable;
use Page\Model\Page;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                   "Smeagol" => __DIR__ . '/../../model/src/Smeagol',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return array(
		'factories' => array(
			'Smeagol\Model\NodeTable' =>  function($sm) {
				$tableGateway = $sm->get('NodeTableGateway');
				$table = new NodeTable($tableGateway);
				return $table;
			},
			'NodeTableGateway' => function ($sm) {
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new Node());
				return new TableGateway('node', $dbAdapter, null, $resultSetPrototype);
			},
			'Page\Model\Page' =>  function($sm) {
				$tableGateway = $sm->get('NodeTableGateway');
				$table = new Page($tableGateway);
				return $table;
			},
		),
    	);
    }
}
