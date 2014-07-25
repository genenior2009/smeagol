<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
// Add these import statements:
use Smeagol\Model\Node;
use Smeagol\Model\NodeTable;
use Smeagol\Model\User;
use Smeagol\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

    public function onBootstrap(MvcEvent $e) {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $app = $e->getApplication();
        $sm = $app->getServiceManager();
        $nav = $sm->get('Navigation');

        $alias = $sm->get('Application\Router\Alias');
        $alias->setNavigation($nav);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('route', function($e) {
            // verificando si el usuario esta logueado
            $auth = new AuthenticationService();
            $is_login = false;
            if ($auth->hasIdentity()) {
                $is_login = true;
            }

            // validamos si entramos en el index del portal
            $is_front = false;
            // obtenemos la ruta del request
            $ruta = $e->getRouter()->getRequestUri()->getPath();

            if ($ruta == "/" || $ruta == "/application" || $ruta === "/application/index" || $ruta === "/application/index/index") {
                $is_front = true;
            }
            // decide which theme to use by get parameter
            $layout = 'enterprise/layout';
            $e->getViewModel()->setTemplate($layout);
            $e->getViewModel()->setVariable("is_login", $is_login);
            $e->getViewModel()->setVariable("is_front", $is_front);
        });
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    "Smeagol" => __DIR__ . '/../../model/src/Smeagol',
                ),
            ),
        );
    }

    // Add this method:
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Application\Router\Alias' => function($sm) {
            $alias = new \Application\Router\Alias('/node[/:id]');
            return $alias;
        },
                'Smeagol\Model\NodeTable' => function($sm) {
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
                'Smeagol\Model\UserTable' => function($sm) {
            $tableGateway = $sm->get('UserTableGateway');
            $table = new UserTable($tableGateway);
            return $table;
        },
                'UserTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new User());
            return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
        },
            ),
        );
    }

}
