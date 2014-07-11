<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
// usaremos el AuthAdapter
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;

class AuthController extends AbstractActionController {

    protected $_userTable;

    public function indexAction() {
        $message = "";
        //Obtenemos el dbAdapter (Objeto de Conexión)    
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        // verificamos el post 
        $request = $this->getRequest();

        //si se hizo el envio POST
        if ($request->isPost()) {

            // Obtenemos el usuario y password del POST
            $username = $request->getPost("username");
            $password = $request->getPost("password");

            if (empty($username) || empty($password)) {
                $message = "llene todos los datos";
            } else {

                // Creando la instancia del objeto authAdapter
                $authAdapter = new AuthAdapter($dbAdapter);

                // Definiendo la tabla de usuario, la columna de username y password
                $authAdapter->setTableName('user')
                        ->setIdentityColumn('username')
                        ->setCredentialColumn('password');

                //Seteando los valores de usuario y password
                $password = md5($password);
                $authAdapter->setIdentity($username)
                        ->setCredential($password);

                //Autenticamos
                $result = $authAdapter->authenticate();

                // verificamos si autentico
                if (!$result->isValid()) {
                    $message = "Usuario o Clave incorrecta";
                } else {

                    //Iniciando la sesión
                    $session = new Storage\Session();

                    //Obteniendo los datos del usuario
                    $sm = $this->getServiceLocator();
                    $userTable = $sm->get('Smeagol\Model\UserTable');
                    $user = $userTable->getUserByUsername($username);
                    unset($user->password);
                    $session->write($user);

                    // Redireccionamos al módulo admin
                    $this->redirect()->toRoute('admin');
                }
            }
        }

        return array("message" => $message);
    }

    public function logoutAction() {
        $auth = new AuthenticationService();
        if (!$auth->hasIdentity()) {
            $this->redirect()->toRoute('auth');
        }

        // Destruyendo la sesión
        $auth->clearIdentity();

        // Direccionando al index
        $this->redirect()->toRoute('home');

        // Deshabilitando el View
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $response->setContent("Hasta Pronto");
        return $response;
    }

}
