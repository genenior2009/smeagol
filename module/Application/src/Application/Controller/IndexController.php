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
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    // agregamos este atributo
    protected $nodeTable;

    public function indexAction() {
        return new ViewModel(array(
            'noticias' => $this->getNodeTable()->getNoticiasFront(),
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

}
