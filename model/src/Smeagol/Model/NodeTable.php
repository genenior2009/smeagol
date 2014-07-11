<?php

namespace Smeagol\Model;

use Zend\Db\TableGateway\TableGateway;
// Class Select
use Zend\Db\Sql\Select;

class NodeTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getNoticiasFront() {
        // Realizando un select para obetner los nodos de tipo noticia
        // los tres últimos para la portada
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->where->equalTo('node_type_id', 2);
            $select->order('id DESC')->limit(3);
        });
        return $resultSet;
    }

    public function getNode($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

}
