<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 22/11/14
 * Time: 12:08
 */

namespace s4h\share;


/**
 * This class represents Persons or Groups with whom an item is shared
 * Class SharedElementDetail
 * @package s4h\share
 */
class SharedElementDetail {

    protected $id;
    protected $status;
    protected $person_id;
    protected $group_id;

    /**
     * @param $group_id
     * @param $person_id
     * @param $status
     */
    function __construct($group_id, $person_id, $status)
    {
        $this->group_id = $group_id;
        $this->person_id = $person_id;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param mixed $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @return mixed
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * @param mixed $person_id
     */
    public function setPersonId($person_id)
    {
        $this->person_id = $person_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



} 