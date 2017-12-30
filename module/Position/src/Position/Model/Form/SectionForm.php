<?php
/**
 * @access public
 * @author dhayal
 * @package Form
 */
class SectionForm {
	/**
	 * 
	 * @ORM\Column(name="sectionId", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @myForm\Exclude()
	 */
	private $sectionId;
	/**
	 * 
	 * @ORM\Column(name="sectionNamee", type="string", length=100, nullable=false)
	 * @myForm\Type("Zend\Form\Element\Text")
	 * @myForm\Required({"required":"true" })
	 * @myForm\Filter({"name":"StripTags"})
	 * @myForm\Validator({"name":"StringLength", "options":{"min":"1"}})
	 * @myForm\Options({"label":"Name:"})
	 * @myForm\Attributes({"id":"sectionName","name":"sectionName"})
	 */
	private $sectionName;
	/**
	 * 
	 * @ORM\Column(name="sectionCode", type="integer", nullable=false)
	 * @myForm\Type("Zend\Form\Element\Text")
	 * @myForm\Required({"required":"true" })
	 * @myForm\Filter({"name":"StripTags"})
	 * @myForm\Attributes({"id":"sectionCode","name":"sectionCode"})
	 * @myForm\Options({"label":"Section Code"})
	 */
	private $sectionCode;
	/**
	 * 
	 * @ORM\Column(name="departmentId", type="integer", nullable=false)
	 * @ORM\OneToMany(targetEntity="Department")
	 * @ORM\JoinColumn(name="departmentId", referencedColumnName="departmentId")
	 * @myForm\Type("Zend\Form\Element\Select")
	 * @myForm\Required({"required":"true" })
	 * @myForm\Filter({"name":"StripTags"})
	 * @myForm\Options({"label":"Class:",
	 * "value_options" : {"":"","1":"A","2":"B","3":"Cfdfffffffffffff sddddddddddd"}})
	 * @myForm\Validator({"name":"InArray",
	 * "options":{"haystack":{"1","2","3"},
	 * "messages":{"notInArray":"Please Select a Class"}}})
	 * @myForm\Attributes({"id":"departmentId","name":"departmentId"})
	 */
	private $departmentId;
}
?>