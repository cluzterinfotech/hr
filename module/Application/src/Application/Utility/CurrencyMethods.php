<?php
namespace Application\Utility;

class CurrencyMethods {
	
    public function twoDigit($number) {
		return number_format($number,2);
	}
	
	public function roundTwoDigit($number) {
		return number_format($number, 2, '.', '');
	}
	
}