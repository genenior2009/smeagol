<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Page\Model\Page;

class IndexController extends AbstractActionController {

    /**
     * Page
     * @var Page\Model\Page
     */
    protected $_page;

    /**
     * Get Page object
     * @return Page\Model\Page
     */
    public function getPage() {
        if (!$this->_page) {
            $sm = $this->getServiceLocator();
            $this->_page = $sm->get('Page\Model\Page');
        }

        return $this->_page;
    }

    /**
     * We are overwriting the dispatch function so that all requests to this controller are catched here.
     * We use the action as the identifier, so that our calls will be http://www.domain.com/page/identifier
     * By the identifier we get the page.
     * 
     * @param \Zend\Stdlib\RequestInterface $request
     * @param \Zend\Stdlib\ResponseInterface $response
     * @return type
     * @throws \Page\Controller\Exception
     */
    public function dispatch(\Zend\Stdlib\RequestInterface $request, \Zend\Stdlib\ResponseInterface $response = null) {
        $identifier = (string) $this->getEvent()->getRouteMatch()->getParam('action');
        $identifier = "page/" . $identifier;
        $page = $this->getPage();

        try {
            $page = $page->getPageByIdentifier($identifier);

            // get the renderer to manipulate the title
            $renderer = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

            // set the page title in the html head
            $renderer->headTitle($page->title);

            // write the models content to the websites content
            $this->layout()->content = '<h1>' . $page->title . '</h1>' . $page->content;
        } catch (\Exception $ex) {
            // if we are on development, show the exception,
            // if not (we are in production) show the 404 page
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
