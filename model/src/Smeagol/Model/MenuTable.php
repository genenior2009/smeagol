<?php

namespace Smeagol\Model;

use Zend\Db\TableGateway\TableGateway;
// Class Select
use Zend\Db\Sql\Select;

class MenuTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMenu($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getNavigationArray($parent_id = 0, $path = "", $menuTree = array(), $include_itself = false) {

        $parent_id = (int) $parent_id;
        if ($include_itself) {
            $resultSet = $this->tableGateway->select(function (Select $select, $parent_id) {
                $select->columns(array('id', 'name', 'label', 'parent_id', 'url', 'node_id'));
                $select->where->equalTo('id', $parent_id);
            });
            $menu = $resultSet->current();
            if (!empty($menu)) {
                $page = array('id' => $parent_id, 'label' => $menu->label);
                if (!empty($menu->route)) {
                    $page['route'] = $menu->route;
                }
                $menuTree[] = $page;
            }
        }

        $adapter = $this->tableGateway->getAdapter();

        $sql = new \Zend\Db\Sql\SQL($adapter);

        $select = $sql->select();
        $select->from(array('m' => 'menu'));
        $select->columns(array(
                    'id',
                    'name',
                    'label',
                    'parent_id',
                    'urlmenu' => 'url',
                    'node_id'
                ))
                ->join(array('n' => 'node'), 'node_id=n.id', array('urlnode' => 'url'), 'left')
        ->where->equalTo('m.parent_id', $parent_id);
        $select->order("order_id");
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = $statement->execute();

        foreach ($resultSet as $menu) {
            $route = "home";
            $module = "application";
            $controller = "";
            $action = "";
            $resource = "mvc:application.index.index";

            if (empty($menu['node_id'])) {
                if ($menu['urlmenu'] != '/') {
                    $m = explode("/", $menu['urlmenu']);
                    $route = $m[0];
                    $module = $m[0];
                    if (!empty($m[1])) {
                        $controller = $m[1];
                    } else {
                        $controller = "index";
                    }
                    if (!empty($m2)) {
                        $action = $m[2];
                    } else {
                        $action = "index";
                    }
                    $resource = "mvc:$module.$controller.$action";
                }
            } else {
                $route = "node";
                $module = "application";
            }

            $page = array('id' => $menu['id'],
                'label' => $menu['label'],
                'route' => $route,
                'module' => $module);
            
            if (!empty($controller)) {
                $page['controller'] = $controller;
                if (!empty($action)) {
                    $page['action'] = $action;
                }
            } else {
                if($route!="home"){
                    $resource = "mvc:application.index.node";
                }    
                $page['params'] = array('id' => $menu['id'], 'link' => "/" . $menu['urlnode']);
            }

            if (!empty($resource)) {
                $page['resource'] = $resource;
            }
            
            if (empty($path)) {
                $menuTree[] = $page;
                end($menuTree);
                $last_key = key($menuTree) . ":";
            } else {
                $pt = explode(":", $path);
                $temp = & $menuTree;
                foreach ($pt as $p) {
                    if (!empty($p)) {
                        $temp = &$temp[$p];
                    }
                }
                $temp["pages"]["menu" . $menu['id']] = $page;
                end($temp["pages"]);
                $last_key = "pages:" . key($temp["pages"]) . ":";
                unset($temp);
            }
            $menuTree = $this->getNavigationArray($menu['id'], $path . $last_key, $menuTree);
        }
        return $menuTree;
    }

}
