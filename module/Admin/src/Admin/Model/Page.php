<?php

namespace Admin\Model;

use Smeagol\Model\NodeTable;
use Zend\Db\TableGateway\TableGateway;
// Class Select
use Zend\Db\Sql\Select;

class Page extends NodeTable {

    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);
    }

    public function fetchAllPages() {
        // Realizando un select para obetner los nodos de tipo página
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->where->equalTo('node_type_id', 1);
            $select->order('id DESC');
        });
        return $resultSet;
    }

    public function getPage($id) {
        return $this->getNode($id);
    }

    public function getPageByIdentifier($identifier) {
        $rowset = $this->tableGateway->select(array('url' => $identifier));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $identifier");
        }
        return $row;
    }

    public function savePage($page) {
        $data = array(
            'content' => $page->content,
            'title' => $page->title,
            'url' => $page->url,
            'node_type_id' => $page->node_type_id,
            'user_id' => $page->user_id,
            'created' => $page->created,
            'modified' => $page->modified,
        );

        $id = (int) $page->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPage($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Page does not exist');
            }
        }
    }

    public function deletePage($id) {
        $this->tableGateway->delete(array('id' => $id));
    }

}
