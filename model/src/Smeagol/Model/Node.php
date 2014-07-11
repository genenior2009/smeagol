<?php
namespace Smeagol\Model;

class Node
{
    public $id;
    public $node_type_id;
    public $title;
    public $content;
    public $url;
    public $user_id;
    public $created;
    public $modified;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->node_type_id     = (isset($data['node_type_id'])) ? $data['node_type_id'] : null;
        $this->title     = (isset($data['title'])) ? $data['title'] : null;
        $this->content     = (isset($data['content'])) ? $data['content'] : null;
        $this->url     = (isset($data['url'])) ? $data['url'] : null;
        $this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->created     = (isset($data['created'])) ? $data['created'] : null;
        $this->modified     = (isset($data['modified'])) ? $data['modified'] : null;    

    }
}