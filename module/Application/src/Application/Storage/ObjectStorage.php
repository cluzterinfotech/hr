<?php

namespace Application\Storage;

use Application\Storage\ObjectStorageInterface;

class ObjectStorage extends \SplObjectStorage implements ObjectStorageInterface {
	public function clear() {
		$tempStorage = clone $this;
		$this->addAll ( $tempStorage );
		$this->removeAll ( $tempStorage );
		$tempStorage = null;
	}
}