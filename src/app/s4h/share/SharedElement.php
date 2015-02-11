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

    }

    /**
     * Gets the Id of the Shared element
     * @return mixed
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * Sets the Id of the Shared element
     * @param mixed $elementId
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;
    }

    /**
     * Gets the message to display when sharing
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message to display when sharing
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Gets the class name of the shared object
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets the class name of the shared object
     * @param mixed $moduleId
     */
    public function setClassName($moduleId)
    {
        $this->className = $moduleId;
    }

    /**
     * Gets the Id of the person sharing the object (Sender)
     * @return mixed
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Sets the Id of the person sharing the object (Sender)
     * @param mixed $personId
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }

    /**
     * Gets the type of sharing
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type of sharing
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the URL of the shared element
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the URL of the shared element
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
     * Gets the SharedElement list of items.
     * @return mixed
     */
    public function getCustomElements()
    {
        return $this->customElements;
    }

    /**
     * Sets the SharedElement list of items.
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
     * Gets the list of persons whom the object is shared with
     * @return array
     */
    public function getSharedWith()
    {
        return $this->sharedWith;
    }

    /**
     * Sets the list of persons whom the object is shared with
     * @param array $sharedWith
     */
    public function setSharedWith($sharedWith)
    {
        $this->sharedWith = $sharedWith;
    }
}