<?php
namespace Smeagol\Model;

class Menu
{
    public $id;
    public $name;
    public $label;
    public $url;
    public $parent_id;
    public $order_id;
    public $node_id;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name     = (isset($data['name'])) ? $data['name'] : null;
        $this->label     = (isset($data['label'])) ? $data['label'] : null;
        $this->url     = (isset($data['url'])) ? $data['url'] : null;
        $this->parent_id     = (isset($data['parent_id'])) ? $data['parent_id'] : null;
        $this->order_id     = (isset($data['order_id'])) ? $data['order_id'] : null;
        $this->node_id     = (isset($data['node_id'])) ? $data['node_id'] : null;    

    }
}