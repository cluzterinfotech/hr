<?php

namespace Application\Contract;

interface SectionMapperInterface {
	public function findOne($sectionId);
	public function findAll();
	public function save($sectionEntity);
	public function remove($sectionId);
}