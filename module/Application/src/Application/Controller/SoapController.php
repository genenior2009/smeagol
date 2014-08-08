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
        $options = array('location' => 'http://www.smeagol.com/soap/nowsdl',
            'uri' => 'http://www.smeagol.com/soap/nowsdl');

        // Instancia del Soap Server; null establece que no se usa un descriptor wsdl
        $server = new Server(null, $options);

        // Los métodos del servicio se depliegan a partir del objeto $hello
        $server->setObject($hello);
        $server->handle();

        // se dshabilita la vista
        return $this->getResponse();
    }

    public function test1Action() {
        $options = array('location' => 'http://www.smeagol.com/soap/nowsdl',
            'uri' => 'http://www.smeagol.com/soap/nowsdl');
        
        // Instancia de Soap Client, null establece que no se usa un descriptor wsdl
        $client = new Client(null, $options);
        
        // Invocando al método remoto sayHello
        echo $client->sayHello("Mundo!");
        return $this->getResponse();
    }
}