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
use Smeagol\Model\Menu;
use Smeagol\Model\MenuTable;
use Smeagol\Model\Role;
use Smeagol\Model\RoleTable;
use Smeagol\Model\RolePermission;
use Smeagol\Model\RolePermissionTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use Smeagol\Rules\NodeRule;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

//.. Ahora modificamos el método onBootStrap
    public function onBootstrap(MvcEvent $e) {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $app = $e->getApplication();
        $sm = $app->getServiceManager();

        $alias = $sm->get('Application\Router\Alias');
        $nodeTable = $sm->get('Smeagol\Model\NodeTable');
        $alias->setNodeTable($nodeTable);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('route', function($e) {
// rol por defecto
            $userRole = 'guest';

// verificando si el usuario esta logueado
            $auth = new AuthenticationService();
            $is_login = false;
            if ($auth->hasIdentity()) {
                $is_login = true;
                $identity = $auth->getIdentity();
                $userRole = $identity->role_type;
            }

            $roleTable = $e->getApplication()->getServiceManager()->get('Smeagol\Model\RoleTable');
            $roles = $roleTable->fetchAll();

// Datos se obtendrán de la base de datos
// $roles = array('guest', 'member', 'editor', 'admin');

            $rolePermissionTable = $e->getApplication()->getServiceManager()->get('Smeagol\Model\RolePermissionTable');
            $roles_permissions = $rolePermissionTable->fetchAll();

            $permissions = array();
            foreach ($roles_permissions as $role_permission) {
                $permissions[$role_permission->role_type][] = $role_permission->permission_resource;
            }
            /*
              $permissions = array(
              'admin' => array('mvc:admin.*', 'mvc:application.*'),
              'guest' => array('mvc:application.*'),
              'editor' => array('mvc:application.*', 'mvc:admin.index.index',
              'mvc:admin.page.*'),
              'member' => array(
              'mvc:application.*',
              'mvc:admin.index.index',
              'mvc:admin.page.index',
              'mvc:admin.page.add',
              'mvc:admin.page.edit:owner',
              'mvc:admin.page.delete:owner',
              )
              );
             */
// Instanciando la clase Acl
            $acl = new Acl();

// Agregando los roles
            foreach ($roles as $role) {
                $acl->addRole(new GenericRole($role->type));
            }

// Obteniendo los módulos del sistema
            $manager = $e->getApplication()->getServiceManager()->get('ModuleManager');
            $modules = $manager->getLoadedModules();
            $loadedModules = array_keys($modules);
            $skipActionsList = array('notFoundAction', 'getMethodFromAction');

            foreach ($loadedModules as $loadedModule) {
                $moduleClass = '\\' . $loadedModule . '\Module';
                $moduleObject = new $moduleClass;
                $config = $moduleObject->getConfig();

                if (isset($config['controllers']['invokables'])) {
                    $controllers = $config['controllers']['invokables'];
                    foreach ($controllers as $key => $moduleClass) {
                        $tmpArray = get_class_methods($moduleClass);
                        $controllerActions = array();

                        $rs = explode("\\", $moduleClass);
                        $module = strtolower($rs[0]);
                        $controller = strtolower($rs[2]);
                        $controller = substr($controller, 0, -10);

                        foreach ($tmpArray as $action) {
                            if (substr($action, strlen($action) - 6) === 'Action' && !in_array($action, $skipActionsList)) {
                                $action = strtolower(substr($action, 0, -6));
                                $resource = "mvc:$module.$controller.$action";
// agregando todos los actions como recursos de la aplicación
                                $acl->addResource(new GenericResource($resource));

// recorriendo el array de permisos para asignar acceso a los recursos
                                foreach ($permissions as $role => $permission) {

                                    $is_allowed = false;
                                    if (in_array("mvc:$module.*", $permission)) {
                                        $is_allowed = true;
                                    }

                                    if (in_array("mvc:$module.$controller.*", $permission)) {
                                        $is_allowed = true;
                                    }

                                    if (in_array($resource, $permission)) {
                                        $is_allowed = true;
                                    }

                                    if (in_array("$resource:owner", $permission)) {

                                        if ($is_login) {
                                            $routeParams = $e->getRouteMatch()->getParams();
                                            $scontroller = trim($routeParams['controller']);
                                            $rs = explode("\\", $scontroller);
                                            $moduleR = strtolower($rs[0]);
                                            $controllerR = strtolower($rs[2]);
                                            $actionR = strtolower($routeParams['action']);

                                            if ($resource == "mvc:$moduleR.$controllerR.$actionR") {

                                                if (isset($routeParams['id'])) {
                                                    $nodeid = (int) $routeParams['id'];
                                                    $nodeRule = $e->getApplication()->getServiceManager()->get('Smeagol\Rules\NodeRule');

                                                    if ($nodeRule->userIsOwner($nodeid, $identity->id)) {
                                                        $is_allowed = true;
                                                    }
                                                }
                                            }
                                        }
                                    }

// asignado permiso de acceso al recurso
                                    if ($is_allowed) {
                                        $acl->allow($role, $resource);
                                    }
                                }
                            }
                        }
                    }
                }
            }

// validamos si el rol tiene acceso a este recurso
            $routeParams = $e->getRouteMatch()->getParams();
            $scontroller = trim($routeParams['controller']);
            $rs = explode("\\", $scontroller);
            $module = strtolower($rs[0]);
            $controller = strtolower($rs[2]);
            $action = strtolower($routeParams['action']);
            if (isset($routeParams['id'])) {
                $id = (int) $routeParams['action'];
            }

            $acceso = false;

// verificación de acceso al recurso
            $resource = "mvc:$module.$controller.$action";
            if ($acl->isAllowed($userRole, $resource)) {
                $acceso = true;
            }

// Bloqueo de acceso
            if (!$acceso) {
                die("acceso denegado");
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
            $e->getViewModel()->setVariable("acl", $acl);
            $e->getViewModel()->setVariable("role", $userRole);
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
                'Smeagol\Model\RoleTable' => function($sm) {
            $tableGateway = $sm->get('RoleTableGateway');
            $table = new RoleTable($tableGateway);
            return $table;
        },
                'RoleTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Role());
            return new TableGateway('role', $dbAdapter, null, $resultSetPrototype);
        },
                'Smeagol\Model\RolePermissionTable' => function($sm) {
            $tableGateway = $sm->get('RolePermissionTableGateway');
            $table = new RolePermissionTable($tableGateway);
            return $table;
        },
                'RolePermissionTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new RolePermission());
            return new TableGateway('role_permission', $dbAdapter, null, $resultSetPrototype);
        },
                'Smeagol\Model\MenuTable' => function($sm) {
            $tableGateway = $sm->get('MenuTableGateway');
            $table = new MenuTable($tableGateway);
            return $table;
        },
                'MenuTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Menu());
            return new TableGateway('menu', $dbAdapter, null, $resultSetPrototype);
        },
                'Smeagol\Rules\NodeRule' => function($sm) {

            $tableGateway = $sm->get('NodeTableGateway');

            $table = new NodeRule($tableGateway);

            return $table;
        },
            ),
        );
    }

}