<?php

namespace Position\Model;

use Payment\Model\EntityInterface;

class PositionDescription implements EntityInterface {
		
	private $id;
	private $positionId;
	private $JobPurpose;
	private $JobAcct1;
	private $JobAcct2;
	private $JobAcct3;
	private $JobAcct4;
	private $JobAcct5;
	private $JobAcct6;
	private $JobAcct7;
	private $JobAcct8;
	private $JobAcct9;
	private $JobAcct10;
	private $JobAcct11;
	private $JobAcct12;
	private $JobAcct13;
	private $JobAcct14;
	private $JobAcct15;
	private $Kpi1;
	private $Kpi2;
	private $Kpi3;
	private $Kpi4;
	private $Kpi5;
	private $Kpi6;
	private $Kpi7;
	private $Kpi8;
	private $Kpi9;
	private $Kpi10;
	private $Kpi11;
	private $Kpi12;
	private $Kpi13;
	private $Kpi14;
	private $Kpi15;
	private $MajorChallenges;
	private $QualificationExperience;
	private $DevOthCoach;
	private $OpBusFocus;
	private $OpDriExec;
	private $OpNetLeading;
	private $BehOwnOrgnEnter;
	private $InsFolInsTrust;
	private $InsFolShapeStrategy;
	private $functionalCompetencies;
	private $OtherCompetencies;
	private $BehaviouralImplication;
	private $BdAnnualRevenue;
	private $BdCapex;
	private $BdOpex;
	private $BdManningLevel;
	private $BdOtherFeatures;
	
	public function setId($id) {
	     $this->id = $id;
    }
	public function getId() { return $this->id; }
	public function setPositionId($positionId) { $this->positionId = $positionId; }
	public function getPositionId() { return $this->positionId; }
	public function setJobPurpose($JobPurpose) { $this->JobPurpose = $JobPurpose; }
	public function getJobPurpose() { return $this->JobPurpose; }
	public function setJobAcct1($JobAcct1) { $this->JobAcct1 = $JobAcct1; }
	public function getJobAcct1() { return $this->JobAcct1; }
	public function setJobAcct2($JobAcct2) { $this->JobAcct2 = $JobAcct2; }
	public function getJobAcct2() { return $this->JobAcct2; }
	public function setJobAcct3($JobAcct3) { $this->JobAcct3 = $JobAcct3; }
	public function getJobAcct3() { return $this->JobAcct3; }
	public function setJobAcct4($JobAcct4) { $this->JobAcct4 = $JobAcct4; }
	public function getJobAcct4() { return $this->JobAcct4; }
	public function setJobAcct5($JobAcct5) { $this->JobAcct5 = $JobAcct5; }
	public function getJobAcct5() { return $this->JobAcct5; }
	public function setJobAcct6($JobAcct6) { $this->JobAcct6 = $JobAcct6; }
	public function getJobAcct6() { return $this->JobAcct6; }
	public function setJobAcct7($JobAcct7) { $this->JobAcct7 = $JobAcct7; }
	public function getJobAcct7() { return $this->JobAcct7; }
	public function setJobAcct8($JobAcct8) { $this->JobAcct8 = $JobAcct8; }
	public function getJobAcct8() { return $this->JobAcct8; }
	public function setJobAcct9($JobAcct9) { $this->JobAcct9 = $JobAcct9; }
	public function getJobAcct9() { return $this->JobAcct9; }
	public function setJobAcct10($JobAcct10) { $this->JobAcct10 = $JobAcct10; }
	public function getJobAcct10() { return $this->JobAcct10; }
	public function setJobAcct11($JobAcct11) { $this->JobAcct11 = $JobAcct11; }
	public function getJobAcct11() { return $this->JobAcct11; }
	public function setJobAcct12($JobAcct12) { $this->JobAcct12 = $JobAcct12; }
	public function getJobAcct12() { return $this->JobAcct12; }
	public function setJobAcct13($JobAcct13) { $this->JobAcct13 = $JobAcct13; }
	public function getJobAcct13() { return $this->JobAcct13; }
	public function setJobAcct14($JobAcct14) { $this->JobAcct14 = $JobAcct14; }
	public function getJobAcct14() { return $this->JobAcct14; }
	public function setJobAcct15($JobAcct15) { $this->JobAcct15 = $JobAcct15; }
	public function getJobAcct15() { return $this->JobAcct15; }
	public function setKpi1($Kpi1) { $this->Kpi1 = $Kpi1; }
	public function getKpi1() { return $this->Kpi1; }
	public function setKpi2($Kpi2) { $this->Kpi2 = $Kpi2; }
	public function getKpi2() { return $this->Kpi2; }
	public function setKpi3($Kpi3) { $this->Kpi3 = $Kpi3; }
	public function getKpi3() { return $this->Kpi3; }
	public function setKpi4($Kpi4) { $this->Kpi4 = $Kpi4; }
	public function getKpi4() { return $this->Kpi4; }
	public function setKpi5($Kpi5) { $this->Kpi5 = $Kpi5; }
	public function getKpi5() { return $this->Kpi5; }
	public function setKpi6($Kpi6) { $this->Kpi6 = $Kpi6; }
	public function getKpi6() { return $this->Kpi6; }
	public function setKpi7($Kpi7) { $this->Kpi7 = $Kpi7; }
	public function getKpi7() { return $this->Kpi7; }
	public function setKpi8($Kpi8) { $this->Kpi8 = $Kpi8; }
	public function getKpi8() { return $this->Kpi8; }
	public function setKpi9($Kpi9) { $this->Kpi9 = $Kpi9; }
	public function getKpi9() { return $this->Kpi9; }
	public function setKpi10($Kpi10) { $this->Kpi10 = $Kpi10; }
	public function getKpi10() { return $this->Kpi10; }
	public function setKpi11($Kpi11) { $this->Kpi11 = $Kpi11; }
	public function getKpi11() { return $this->Kpi11; }
	public function setKpi12($Kpi12) { $this->Kpi12 = $Kpi12; }
	public function getKpi12() { return $this->Kpi12; }
	public function setKpi13($Kpi13) { $this->Kpi13 = $Kpi13; }
	public function getKpi13() { return $this->Kpi13; }
	public function setKpi14($Kpi14) { $this->Kpi14 = $Kpi14; }
	public function getKpi14() { return $this->Kpi14; }
	public function setKpi15($Kpi15) { $this->Kpi15 = $Kpi15; }
	public function getKpi15() { return $this->Kpi15; }
	public function setMajorChallenges($MajorChallenges) { $this->MajorChallenges = $MajorChallenges; }
	public function getMajorChallenges() { return $this->MajorChallenges; }
	public function setQualificationExperience($QualificationExperience) { $this->QualificationExperience = $QualificationExperience; }
	public function getQualificationExperience() { return $this->QualificationExperience; }
	public function setDevOthCoach($DevOthCoach) { $this->DevOthCoach = $DevOthCoach; }
	public function getDevOthCoach() { return $this->DevOthCoach; }
	public function setOpBusFocus($OpBusFocus) { $this->OpBusFocus = $OpBusFocus; }
	public function getOpBusFocus() { return $this->OpBusFocus; }
	public function setOpDriExec($OpDriExec) { $this->OpDriExec = $OpDriExec; }
	public function getOpDriExec() { return $this->OpDriExec; }
	public function setOpNetLeading($OpNetLeading) { $this->OpNetLeading = $OpNetLeading; }
	public function getOpNetLeading() { return $this->OpNetLeading; }
	public function setBehOwnOrgnEnter($BehOwnOrgnEnter) { $this->BehOwnOrgnEnter = $BehOwnOrgnEnter; }
	public function getBehOwnOrgnEnter() { return $this->BehOwnOrgnEnter; }
	public function setInsFolInsTrust($InsFolInsTrust) { $this->InsFolInsTrust = $InsFolInsTrust; }
	public function getInsFolInsTrust() { return $this->InsFolInsTrust; }
	public function setInsFolShapeStrategy($InsFolShapeStrategy) { $this->InsFolShapeStrategy = $InsFolShapeStrategy; }
	public function getInsFolShapeStrategy() { return $this->InsFolShapeStrategy; }
	public function setfunctionalCompetencies($functionalCompetencies) { $this->functionalCompetencies = $functionalCompetencies; }
	public function getfunctionalCompetencies() { return $this->functionalCompetencies; }
	public function setOtherCompetencies($OtherCompetencies) { $this->OtherCompetencies = $OtherCompetencies; }
	public function getOtherCompetencies() { return $this->OtherCompetencies; }
	public function setBehaviouralImplication($BehaviouralImplication) { $this->BehaviouralImplication = $BehaviouralImplication; }
	public function getBehaviouralImplication() { return $this->BehaviouralImplication; }
	public function setBdAnnualRevenue($BdAnnualRevenue) { $this->BdAnnualRevenue = $BdAnnualRevenue; }
	public function getBdAnnualRevenue() { return $this->BdAnnualRevenue; }
	public function setBdCapex($BdCapex) { $this->BdCapex = $BdCapex; }
	public function getBdCapex() { return $this->BdCapex; }
	public function setBdOpex($BdOpex) { $this->BdOpex = $BdOpex; }
	public function getBdOpex() { return $this->BdOpex; }
	public function setBdManningLevel($BdManningLevel) { $this->BdManningLevel = $BdManningLevel; }
	public function getBdManningLevel() { return $this->BdManningLevel; }
	public function setBdOtherFeatures($BdOtherFeatures) { $this->BdOtherFeatures = $BdOtherFeatures; }
	public function getBdOtherFeatures() { return $this->BdOtherFeatures; }
	
	
	
}
?>