<?php

namespace Application\Router;

use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Mvc\Router\Http;

class Alias extends Http\Segment {

    private static $_aliasUrl = null;
    private static $_nodeTable = null;

    public function match(Request $request, $pathOffset = null) {
        //get Navigation
        $aliasUrl = self::$_aliasUrl;
        $nodeTable = self::$_nodeTable;

        $uri = $request->getUri();
        $path = $uri->getPath();


        if ($path !== "/") {
            $path = substr($path, 1);
            $node = $nodeTable->getNodeByUrl($path);

            // verificando si se hallo el url en la tabla node y asignandole un ro
            if (!empty($node)) {
                if ($path == $node->url) {
                    $uri->setPath('/node/' . $node->id);
                    $request->setUri($uri);
                }
            }
        }
        return parent::match($request, $pathOffset);
    }

    public function setAliasUrl($aliasUrl) {
        self::$_aliasUrl = $aliasUrl;
    }

    public function setNodeTable($nodeTable) {
        self::$_nodeTable = $nodeTable;
    }

    protected function buildPath(array $parts, array $mergedParams, $isOptional, $hasChild, array $options) {
        if (isset($mergedParams['link'])) {
            return $mergedParams['link'];
        }
        return parent::buildPath($parts, $mergedParams, $isOptional, $hasChild, $options);
    }

}