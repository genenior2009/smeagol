<?php

namespace Noticias\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Noticias\Model\Noticias;

class IndexController extends AbstractActionController {

    /**
     * Noticias
     * @var Noticias\Model\Noticias
     */
    protected $_noticias;

    /**
     * Get Noticias object
     * @return Noticias\Model\Noticias
     */
    public function getNoticias() {
        if (!$this->_noticias) {
            $sm = $this->getServiceLocator();
            $this->_noticias = $sm->get('Noticias\Model\Noticias');
        }

        return $this->_noticias;
    }

    /**
     * We are overwriting the dispatch function so that all requests to this controller are catched here.
     * We use the action as the identifier, so that our calls will be http://www.domain.com/noticias/identifier
     * By the identifier we get the noticias.
     * 
     * @param \Zend\Stdlib\RequestInterface $request
     * @param \Zend\Stdlib\ResponseInterface $response
     * @return type
     * @throws \Noticias\Controller\Exception
     */
    public function dispatch(\Zend\Stdlib\RequestInterface $request, \Zend\Stdlib\ResponseInterface $response = null) {
        $identifier = (string) $this->getEvent()->getRouteMatch()->getParam('action');
        $identifier = "noticias/" . $identifier;
        $noticias = $this->getNoticias();

        try {
            $noticias = $noticias->getNoticiasByIdentifier($identifier);

            // get the renderer to manipulate the title
            $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

            // set the noticias title in the html head
            $renderer->headTitle($noticias->title);

            // write the models content to the websites content
            $this->layout()->content = '<h1>' . $noticias->title . '</h1>' . $noticias->content;
        } catch (\Exception $ex) {
            // if we are on development, show the exception,
            // if not (we are in production) show the 404 noticias
            if (isset($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] == 'development') {
                throw $ex;
            } else {
                // it is necessery to call the parent dispatch, otherwise the notFoundFunction doesn't work.
                parent::dispatch($request, $response);
                $this->notFoundAction();
                return;
            }
        }
    }

    public function indexAction() {
        
    }

}
