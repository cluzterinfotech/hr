<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class Policy implements EntityInterface {
	
	private $id;
	private $title;
	private $content;
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	public function setTitle($title) {
	    $this->title = $title;
	}
	public function getTitle() {
	    return $this->title;
	}
	public function setContent($content) {
	    $this->content = $content;
	}
	public function getContent() {
	    return $this->content;
	}
	
}
