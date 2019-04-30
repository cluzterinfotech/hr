<?php
namespace Payment\Model;

use Payment\Model\AbstractCalculate;
use Payment\Model\AllowancePercentageInterface;

class AllowancePercentage extends AbstractCalculate implements AllowancePercentageInterface {
	public function getPercentage() {
		return .70;
	}
}
