<?php

namespace Noticias\Model;

use Smeagol\Model\NodeTable;
use Zend\Db\TableGateway\TableGateway;
// Class Select
use Zend\Db\Sql\Select;

class Noticias extends NodeTable {

    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);
    }

    public function fetchAllNoticiass() {
        // Realizando un select para obtener los nodos de tipo página
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->where->equalTo('node_type_id', 2);
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function getNoticias($id) {
        return $this->getNode($id);
    }

    // esto permiter la página de acuerdo al url
    public function getNoticiasByIdentifier($identifier) {
        $rowset = $this->tableGateway->select(array('url' => $identifier));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $identifier");
        }
        return $row;
    }

}
