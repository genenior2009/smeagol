<?php
namespace Admin\Controller;

// Declaramos el uso de las clases principales de elFinder para que no haya excepción con el namespace
use elFinderConnector;
use elFinder;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {

    	$auth = new AuthenticationService();
    	if (!$auth->hasIdentity()) {
    		$this->redirect()->toRoute('auth');
    	}   
    	// Identity exists; get it
    	$identity = $auth->getIdentity();
    	
    	//pasando variable a la vista
    	return array("user"=>$identity);
    }
   
    public function elfinderAction() {
		// Definimos el layout-clean
    	$layout = 'enterprise/layout-clean';
    	$this->layout($layout);
    }
    
    public function elfinderfileAction() {
    	/**
    	 * Simple function to demonstrate how to control file access using "accessControl" callback.
    	 * This method will disable accessing files/folders starting from  '.' (dot)
    	 *
    	 * @param  string  $attr  attribute name (read|write|locked|hidden)
    	 * @param  string  $path  file path relative to volume root directory started with directory separator
    	 * @return bool|null
    	 **/
    	function access($attr, $path, $data, $volume) {
    		return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
    		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
    		:  null;                                    // else elFinder decide it itself
    	}
     
        $opts = array(
            // 'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files', // path to files (REQUIRED)
                    'URL' => '/files/', // URL to files (REQUIRED)
                    'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
                )
            )
        );	
    	
    	// run elFinder
    	$connector = new elFinderConnector(new elFinder($opts));
    	$connector->run();    	 
    	
    	// Deshabilitando el View
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	return $response;
    }
}