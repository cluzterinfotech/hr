<?php
namespace Payment\Model;

class AllowanceSalaryGrade extends AbstractCalculate 
                           implements AllowanceSalaryGradeInterface 
{
	public function amount($salaryGrade) {
		if($salaryGrade == 20) {
			return 2500;
		} else {
			return 3500;
		}
	}
}