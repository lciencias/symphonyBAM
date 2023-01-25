<?php

namespace ZFriendly\Form;


use ZFriendly\Form\Decorator\TwitterErrors;

class Twitter extends \Zend_Form
{
    /**
     *
     * @var string
     */
    private $typeBootstrap;

    /**
     *
     * @static Types Styles
     */
    const TYPE_DEFAULT = 'default';
    const TYPE_STACKED = 'stacked';

    /**
     *
     */
    public function twitterDecorators($type = self::TYPE_DEFAULT)
    {
        $this->typeBootstrap = $type;
        $this->clearDecorators();

        $this->setElementDecorators(array(
                "ViewHelper",
                $this->getErrorDecorator(),
                array("Description", array("tag" => "div", "class" => "help-block")),
                array(array("innerwrapper" => "HtmlTag"), array("tag" => "span", "class" => "input")),
                array("Label", array("tag" => "div")),
                array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "clearfix"))
        ));

        $this->addDecorator("FormElements")
            ->addDecorator("HtmlTag", array("tag" => "fieldset"))
            ->addDecorator("Form", array("class" => $this->isStacked() ? 'form-stacked' : null));

        $this->loadTwitterDecoratorsForElements();
    }

    /**
     *
     */
    protected function loadTwitterDecoratorsForElements()
    {

        foreach ($this->getElements() as $element ){


            if($element instanceof \Zend_Form_Element_Submit
                    || $element instanceof \Zend_Form_Element_Reset
                    || $element instanceof \Zend_Form_Element_Button)
            {
                $class = "";

                if($element instanceof \Zend_Form_Element_Submit
                        && !($element instanceof \Zend_Form_Element_Reset)
                        && !($element instanceof \Zend_Form_Element_Button))
                {
                    $class = "primary";
                }

                $element->setAttrib("class", trim("btn $class " . $element->getAttrib("class")));
                $element->removeDecorator("Label");
                $element->removeDecorator("outerwrapper");
                $element->removeDecorator("innerwrapper");

                $this->_addActionsDisplayGroupElement($element);

            }

            if($element instanceof \Zend_Form_Element_Checkbox)
            {
               /* $element->setDecorators(array(
                        array(array("labelopening" => "HtmlTag"), array("tag" => "label", "id" => $element->getId()."-label", "for" => $element->getName(), "openOnly" => true)),
                        "ViewHelper",
                        array("Label"),
                        array(array("labelclosing" => "HtmlTag"), array("tag" => "label", "closeOnly" => true)),
                        array(array("liwrapper" => "HtmlTag"), array("tag" => "li")),
                        array(array("ulwrapper" => "HtmlTag"), array("tag" => "ul", "class" => "inputs-list")),
                        $this->getErrorDecorator(),
                        array("Description", array("tag" => "span", "class" => "help-block")),
                        array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "input")),
                        array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "clearfix"))
                ));
                */
            }

            if($element instanceof \Zend_Form_Element_Radio
                    || $element instanceof \Zend_Form_Element_MultiCheckbox)
            {
                $multiOptions = array();
                foreach($element->getMultiOptions() as $value => $label)
                {
                    $multiOptions[$value] = " ".$label;
                }

                $element->setMultiOptions($multiOptions);

                $element->setOptions(array("separator" => ""));
                $element->setDecorators(array(
                        "ViewHelper",
                        array(array("liwrapper" => "HtmlTag"), array("tag" => "li")),
                        array(array("ulwrapper" => "HtmlTag"), array("tag" => "ul", "class" => "inputs-list")),
                        $this->getErrorDecorator(),
                        array("Description", array("tag" => "span", "class" => "help-block")),
                        array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "input")),
                        array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "clearfix"))
                ));
            }

            if($element instanceof \Zend_Form_Element_Hidden)
            {
                $element->setDecorators(array("ViewHelper"));
            }
        }

        return $this;
    }

    /**
     *
     * @param unknown_type $element
     */
    private function _addActionsDisplayGroupElement($element)
    {
        $displayGroup = $this->getDisplayGroup("zfBootstrapFormActions");

        if( $displayGroup === null ){

            $displayGroup = $this->addDisplayGroup(array(
                $element->getName()),
                "zfBootstrapFormActions",
                array(
                    "decorators" => array(
                        "FormElements",
                        array("HtmlTag", array("tag" => "div", "class" => "actions"))
                    )
            ));

        }else{
            $displayGroup->addElement($element);
        }

        return $displayGroup;
    }

    /**
     * @return array
     */
    private function getErrorDecorator(){
        return array(new TwitterErrors(array(
               "placement" => $this->isStacked() ? "prepend" : "append",
               "error-class" => $this->isStacked() ? "help-block" : "help-inline",
            )));
        return array("TwitterErrors", array(
               "placement" => $this->isStacked() ? "prepend" : "append",
               "error-class" => $this->isStacked() ? "help-block" : "help-inline",
            )
        );
    }

    /**
     *
     * @return boolean
     */
    public function isStacked(){
        return self::TYPE_STACKED == $this->typeBootstrap;
    }

}