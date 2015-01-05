<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 17/11/14
 * Time: 21:14
 */

namespace s4h\share;


/**
 * Custom Item to display in the sharing form.
 * Class SharedElementCustomItem
 * @package s4h\share
 */
class SharedElementCustomItem {

    /**
     * Name of the Custom option
     * @var $name
     */
    protected $name;
    /**
     * HTML Code to display the custom option, the id and name MUST match the name property
     * @var $html
     */
    protected $html;


    /**
     * Value of the custom element
     * @var $value
     */
    protected $value;

    /**
     * @param $name : Name of the custom item, this must match the HTML name
     * @param $html : HTML code to create the custom item
     */

    function __construct($name, $html, $value='')
    {
        $this->name = $name;
        $this->html = $html;
        $this->value = $value;
    }

    /**
     * Gets the name of the custom item, this must match the HTML name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the HTML code to create the custom item
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }


    /**
     * Gets the value of the custom control
     */
    public function getValue()
    {
        return $this->value;
    }
} 