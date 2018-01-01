<?php

namespace Application\Mapper;

use Application\Contract\SectionMapperInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use Application\Entity\SectionEntity;

class SectionInMemoryMapper extends AbstractDbMapper implements SectionMapperInterface {
	private $section = array ();
	public function findAll() {
		return $this->section;
	}
	public function findOne($sectionId) {
	}
	public function remove($sectionId) {
	}
	public function save(SectionEntity $sectionEntity) {
		$this->section = array (
				'departmentId' => $sectionEntity->departmentId,
				'sectionCode' => $sectionEntity->sectionCode,
				'sectionId' => $sectionEntity->sectionId,
				'sectionName' => $sectionEntity->sectionName 
		);
	}
}