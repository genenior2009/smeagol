<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

class NoticiasController extends AbstractActionController {

    
    //Hay que hacerlo trabajar en conjunto
    /**
     * Page
     * @var Admin\Model\Page
     */
    protected $_page;

    /**
     * Get Page object
     * @return Admin\Model\Page
     */
    public function getPage() {
        if (!$this->_page) {
            $sm = $this->getServiceLocator();
            $this->_page = $sm->get('Admin\Model\Page');
        }

        return $this->_page;
    }

    public function indexAction() {
        return new ViewModel(array(
            'pages' => $this->getpage()->fetchAllPages(),
        ));
    }

    // Agregamos este método
    public function getNodeTable() {
        if (!$this->nodeTable) {
            $sm = $this->getServiceLocator();
            $this->nodeTable = $sm->get('Smeagol\Model\NodeTable');
        }

        return $this->nodeTable;
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin', array(
                        'controller' => 'page', 'action' => 'index'
            ));
        }
        $pageTable = $this->getPage();
        $page = $pageTable->getPage($id);

        if ($page) {

            // Obtenemos el ViewHelper HeadScript para agregar un javacript en la sección head
            // del html; este script controlará la petición en Ajax
            $HeadScript = $this->getServiceLocator()->get('viewhelpermanager')->get('HeadScript');
            $HeadLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
            $HeadScript->appendFile("/ckeditor/ckeditor.js");
            $HeadLink->appendStylesheet("/ckeditor/content.css");

            // verificamos el post
            $request = $this->getRequest();

            if ($request->isPost()) {
                // Obtenemos el título, contenido y url del POST
                $page->title = $request->getPost("titulo");
                $page->content = $request->getPost("contenido");
                $page->url = $request->getPost("url");
                $page->modified = date("Y-m-d H:i:s");

                // Guardamos los datos
                $pageTable->savePage($page);


                // Redireccionamos la petición
                return $this->redirect()->toRoute('admin', array(
                            'controller' => 'page', 'action' => 'index'
                ));

                // Deshabilitando el View
                $response = $this->getResponse();
                $response->setStatusCode(200);
                return $response;
            }

            return new ViewModel(array(
                'page' => $page
            ));
        } else {
            return $this->redirect()->toRoute('admin', array(
                        'controller' => 'page', 'action' => 'index'
            ));
        }
    }

    public function addAction() {
        $page = $this->getPage();
        // Obtenemos el ViewHelper HeadScript para agregar un javacript en la
        // sección head
        // del html; este script controlará la petición en Ajax
        $HeadScript = $this->getServiceLocator()->get('viewhelpermanager')->get('HeadScript');
        $HeadLink = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $HeadScript->appendFile("/ckeditor/ckeditor.js");
        $HeadLink->appendStylesheet("/ckeditor/content.css");

        // verificamos el post
        $request = $this->getRequest();

        $mensaje = "";
        if ($request->isPost()) {
            // Obtenemos el título, contenido y url del POST
            $page->title = $request->getPost("titulo");
            $page->content = $request->getPost("contenido");
            $page->url = $request->getPost("url");

            // seteamos el ID a  0
            $page->id = 0;

            if (!empty($page->title) && !empty($page->content) && !empty($page->url)) {
                $page->user_id = 1;
                $page->created = date("Y-m-d H:i:s");
                $page->modified = date("Y-m-d H:i:s");
                $page->node_type_id = 1;
                // Guardamos los datos
                $page->savePage($page);

                // Redireccionamos la petición
                return $this->redirect()->toRoute('admin', array(
                            'controller' => 'page',
                            'action' => 'index'
                ));
            } else {
                $mensaje = "Debe llenar todos los datos";
            }
        } else {
            // Valores predeterminados de las propiedades de page
            $page->title = "";
            $page->content = "";
            $page->url = "";
        }

        return new ViewModel(array(
            'page' => $page,
            'mensaje' => $mensaje
        ));
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            // Redirect to list of pages
            return $this->redirect()->toRoute('admin', array(
                        'controller' => 'page',
                        'action' => 'index'
                    ));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del');

            if ($del == 'SI') {
                $id = (int) $request->getPost('id');
                $this->getPage()->deletePage($id);
            }

            // Redirect to list of pages
            return $this->redirect()->toRoute('admin', array(
                        'controller' => 'page',
                        'action' => 'index'
                    ));
        }

        return array(
            'id' => $id,
            'page' => $this->getPage()->getPage($id)
        );
    }

}
