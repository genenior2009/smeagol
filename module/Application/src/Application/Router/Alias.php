<?php

namespace Application\Router;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Mvc\Router\Http;

class Alias extends Http\Segment {

    private static $_navigation = null;

    public function match(Request $request, $pathOffset = null) {
        //get Navigation
        $nav = self::$_navigation;
        $uri = $request->getUri();
        $path = $uri->getPath();

        //la traducción del alias al Url se cargará desde la base de datos
        if ($path == '/nosotros') {
            $uri->setPath('/node/1');
            $request->setUri($uri);           
        }

        return parent::match($request, $pathOffset);
    }

    public function setNavigation($navigation) {
        self::$_navigation = $navigation;
    }

    protected function buildPath(array $parts, array $mergedParams, $isOptional, $hasChild, array $options) {

        if (isset($mergedParams['link'])) {
            return $mergedParams['link'];
        }
        return parent::buildPath($parts, $mergedParams, $isOptional, $hasChild, $options);
    }
}
