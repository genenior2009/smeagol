<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Soap\Server;
use Zend\Soap\Client;
use Zend\Soap\AutoDiscover;
use Smeagol\Service\Hello;

class SoapController extends AbstractActionController {
    
    public function nowsdlAction() {
        $hello = new Hello();
        $options = array('location' => 'http://vm-0.genenior2009.koding.kd.io/soap/nowsdl',
            'uri' => 'http://vm-0.genenior2009.koding.kd.io/soap/nowsdl');

        // Instancia del Soap Server; null establece que no se usa un descriptor wsdl
        $server = new Server(null, $options);

        // Los métodos del servicio se depliegan a partir del objeto $hello
        $server->setObject($hello);
        $server->handle();

        // se dshabilita la vista
        return $this->getResponse();
    }

    public function test1Action() {
        $options = array('location' => 'http://vm-0.genenior2009.koding.kd.io/soap/nowsdl',
            'uri' => 'http://vm-0.genenior2009.koding.kd.io/soap/nowsdl');
        
        // Instancia de Soap Client, null establece que no se usa un descriptor wsdl
        $client = new Client(null, $options);
        
        // Invocando al método remoto sayHello
        echo $client->sayHello("Mundo!");
        return $this->getResponse();
    }

    // método que genera el archivo wsdl
    public function autodiscoverWsdlAction() {
        $autodiscover = new AutoDiscover();
        // definiendo la clase para generar su wsdl y el 
        // enlace del soap server
        $autodiscover->setClass("\Smeagol\Service\Hello")
                ->setUri('http://vm-0.genenior2009.koding.kd.io/soap/withwsdl');
        // Se imprime el XML del descriptor WSDL
        $autodiscover->handle();
        // se deshabilita la vista
        return $this->getResponse();
    }
    
    public function withWsdlAction() {
        // La instancia del soap server tiene que hacerse con el url del archivo wsdl
        $server = new Server("http://vm-0.genenior2009.koding.kd.io/soap/autodiscoverwsdl");
        // Se define la clase desplegada en el web service
        $server->setClass("\Smeagol\Service\Hello");
        // Se despliega el web service
        $server->handle();
        return $this->getResponse();
    }


    public function test2Action() {
        $options = array('location' => 'http://vm-0.genenior2009.koding.kd.io/soap/withwsdl',
            'uri' => 'http://vm-0.genenior2009.koding.kd.io/soap/withwsdl');
        // Se instancia el cliente con el enlace del descriptor wsdl
        $client = new Client('http://vm-0.genenior2009.koding.kd.io/soap/autodiscoverwsdl', $options);
        // se invoca al método remoto
        echo $client->sayHello("Mundo!");
        return $this->getResponse();
    }
}