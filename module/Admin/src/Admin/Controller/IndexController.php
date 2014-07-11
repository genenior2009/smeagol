<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {

        $auth = new AuthenticationService();
        if (!$auth->hasIdentity()) {
            $this->redirect()->toRoute('auth');
        }
        // Identity exists; get it
        $identity = $auth->getIdentity();

        //pasando variable a la vista
        return array("user" => $identity);
    }

}
