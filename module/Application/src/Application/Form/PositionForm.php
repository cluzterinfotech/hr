<?php
namespace Application\Form;
 
use Zend\Form\Annotation;
 
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("position")
 * @Annotation\Attributes({"class":"testForm"})
 */
class PositionForm
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringToUpper"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"5"}})
     * @Annotation\Options({"label":"Position Id:"})
     * @Annotation\Attributes({"id":"positionid","name":"positionid"})
     */
    public $positionid;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"5"}})
     * @Annotation\Options({"label":"Position Name:"})
     * @Annotation\Attributes({"id":"positionName","name":"positionName"})
     */
    public $positionName;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"id":"reportingPosition","name":"reportingPosition"})
     * @Annotation\Options({"label":"Reporting Position"})
     */
    public $reportingPosition;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Section:",
     *                      "value_options" : {"":"","1":"A","2":"B","3":"Cfdfffffffffffff sddddddddddd"}})
     * @Annotation\Validator({"name":"InArray",
     *                        "options":{"haystack":{"1","2","3"},
     *                              "messages":{"notInArray":"Please Select a Class"}}})
     * @Annotation\Attributes({"id":"section","name":"section"})
     */
    public $section;
         
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"submit","id":"submit"})
     */
    public $submit;
}