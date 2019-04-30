<?php

namespace Application\Factory;

use Payment\Model\Company;

class CompanyFactory {
	
	public function __invoke($serviceLocator) {
		return new Company(); // StrategyTest($serviceLocator->get('testObject'));
	}
	
	
}