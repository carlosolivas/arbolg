<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 20:36
 */

namespace s4h\share;


/**
 * Represents a Shared element within the application
 * Class SharedElement
 * @package s4h\share
 */
class SharedElement {

    protected $className;
    protected $elementId;
    protected $personId;
    protected $message;
    protected $type;
    protected $url;
    protected $customElements = [];
    protected $sharedWith = [];

    function __construct()
    {
        $customElements = array();
    }

    /**
     * @return mixed
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * @param mixed $elementId
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $moduleId
     */
    public function setClassName($moduleId)
    {
        $this->className = $moduleId;
    }

    /**
     * @return mixed
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * @param mixed $personId
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Type of sharing
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Adds a new Custom Item to the SharedElement list of items.
     * @param SharedElementCustomItem $customItem
     */
    public function addCustomItem(SharedElementCustomItem $customItem)
    {
        array_push($this->customElements, $customItem);
    }

    /**
     * @return mixed
     */
    public function getCustomElements()
    {
        return $this->customElements;
    }

    /**
     * @param mixed $customElements
     */
    public function setCustomElements(array $customElements)
    {
        $this->customElements = $customElements;
    }

    /**
     * Share the element with a Person or Group
     * @param SharedElementDetail $sharedElementDetail
     */
    public function addSharedWith(SharedElementDetail $sharedElementDetail)
    {
        array_push($this->sharedWith, $sharedElementDetail);
    }

    /**
     * @return array
     */
    public function getSharedWith()
    {
        return $this->sharedWith;
    }

    /**
     * @param array $sharedWith
     */
    public function setSharedWith($sharedWith)
    {
        $this->sharedWith = $sharedWith;
    }
}