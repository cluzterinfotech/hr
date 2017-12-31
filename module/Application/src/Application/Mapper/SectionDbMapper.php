<?php

namespace Application\Mapper;

use Application\Contract\SectionMapperInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Adapter\AdapterInterface;
use Application\Entity\SectionEntity;

class SectionDbMapper extends AbstractDbMapper implements SectionMapperInterface {
	public function __construct(AdapterInterface $dbAdapter) {
		$this->setDbAdapter ( $dbAdapter );
	}
	public function findAll() {
	}
	public function findOne() {
	}
	public function remove() {
	}
	public function save(SectionEntity $sectionEntity) {
	}
}