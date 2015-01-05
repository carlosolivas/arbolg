<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 0:07
 */

namespace s4h\share;


use Illuminate\Support\Facades\View;
use \s4h\social\GroupRepositoryInterface;
use \s4h\core\PersonRepositoryInterface;

class Sharing {

    protected $groupRepo;
    protected $shareRepo;
    protected $personRepo;

    function __construct(
        GroupRepositoryInterface $group,
        ShareRepositoryInterface $share,
        PersonRepositoryInterface $person
    )
    {
        $this->groupRepo = $group;
        $this->shareRepo = $share;
        $this->personRepo = $person;
    }


    /**
     * @param SharedElement $sharedElement
     *
     * @return mixed
     */
    public function displayShareForm(SharedElement $sharedElement)
    {
        $myFriends = $this->groupRepo->friendsByFamilyId(\Auth::user()->Person->family_id);
        return View::make('share.share')
            ->with('shareTypeId', $sharedElement->getType())
            ->with('elementId', $sharedElement->getElementId())
            ->with('className', $sharedElement->getClassName())
            ->with('personId', $sharedElement->getPersonId())
            ->with('message', $sharedElement->getMessage())
            ->with('customControls', $sharedElement->getCustomElements())
            ->with('myFriends', $myFriends);
    }

    /**
     * Display the form to accept a shared element
     * @param $shareElementDetailId
     * @param $personId
     *
     * @return mixed
     */
    public function displayAcceptShareForm($shareElementDetailId, $personId)
    {
        $shareDetail = $this->shareRepo->getSharedElementDetailByPersonId($shareElementDetailId, $personId);
        return View::make('share.accept')
            ->with('shareDetail', $shareDetail);
    }

    public function give(SharedElement $sharedElement)
    {
        $id = $this->shareRepo->give($sharedElement);
        \Event::fire("sharing.{$sharedElement->getClassName()}.wasCreated", $sharedElement);
        return $id;
    }

    public function accept($shareElementDetailId, $personId)
    {
        $shareDetail = $this->shareRepo->getSharedElementDetailByPersonId($shareElementDetailId, $personId);
        if ($shareDetail)
            $this->changeShareDetailStatus($shareDetail->id, SharedElementDetailStatus::Accepted);
    }

    public function reject($shareElementDetailId, $personId)
    {
        $shareDetail = $this->shareRepo->getSharedElementDetailByPersonId($shareElementDetailId, $personId);
        if ($shareDetail)
            $this->changeShareDetailStatus($shareDetail->id, SharedElementDetailStatus::Rejected);

    }

    public function respond()
    {
        //TODO: create logic for this method
    }

    public function request()
    {
        //TODO: create logic for this method
    }

    /**
     * Changes the Status of the share request of a specific user or group
     * @param $sharedElementDetailId
     * @param $status
     */
    public function changeShareDetailStatus($sharedElementDetailId, $status)
    {
        $sharedWith = $this->shareRepo->changeDetailStatus($sharedElementDetailId, $status);
        $sharedElement = $sharedWith->Share()->first();

        $eventName = "unknown";
        switch($status) {
            case SharedElementDetailStatus::Sent:
                $eventName = "wasSent";
                break;
            case SharedElementDetailStatus::Accepted:
                $eventName = "wasAccepted";
                break;
            case SharedElementDetailStatus::Rejected:
                $eventName = "wasRejected";
                break;
        }

        if ($sharedWith->person_id) {
            $person = $this->personRepo->getById($sharedWith->person_id);
            $acceptedBy = $person->name;
        } else {
            $family = $this->groupRepo->getFamilyByGroupId($sharedWith->group_id);
            $acceptedBy = $family->name;
        }

        $sharedWith->acceptedBy = $acceptedBy;
        \Event::fire("sharing.{$sharedElement->class_name}.{$eventName}", $sharedWith);
    }
} 