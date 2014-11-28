<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 23:14
 */

namespace s4h\share;


class DbShareRepository implements ShareRepositoryInterface {


    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    /**
     * Stores a shared element in the DB
     *
     * @param SharedElement $sharedElement
     *
     * @return mixed
     */
    public function give(SharedElement $sharedElement)
    {
        $share = new Share();
        $share->person_id = $sharedElement->getPersonId();
        $share->sharetype_id = $sharedElement->getType();
        $share->class_name = $sharedElement->getClassName();
        $share->element_id = $sharedElement->getElementId();
        $share->message = $sharedElement->getMessage();
        $share->url = $sharedElement->getUrl();
        $share->save();

        foreach($sharedElement->getCustomElements() as $customItem)
        {
            $shareOpt = new ShareOption();
            $shareOpt->name = $customItem->getName();
            $shareOpt->option = $customItem->getHTML();
            $share->ShareOptions()->save($shareOpt);
        }

        foreach($sharedElement->getSharedWith() as $sharedWith)
        {
            $shareDetail = new ShareDetail();
            $shareDetail->person_id = $sharedWith->getPersonId();
            $shareDetail->group_id = $sharedWith->getGroupId();
            $shareDetail->status = $sharedWith->getStatus();
            $shareDetail = $share->SharedWith()->save($shareDetail);
            $sharedWith->setId($shareDetail->id);
        }

        return $share->id;
    }
/*
    public function receive($id)
    {
        return $this->changeDetailStatus($id, SharedElementDetailStatus::Accepted);
    }

    public function reject($id)
    {
        return $this->changeDetailStatus($id, SharedElementDetailStatus::Rejected);
    }
*/
    public function changeDetailStatus($sharedElementId, $status)
    {
        $shareDetail = ShareDetail::findOrFail($sharedElementId);
        $shareDetail->status = $status;
        $shareDetail->save();
        return $shareDetail;
    }

    public function getSharedElementDetailByPersonId($sharedElementDetailId, $personId)
    {
        $groupIds = \DB::table('group_person')
            ->where('person_id', '=', \Auth::user()->Person->id)
            ->lists('group_id');

        $shareDetail = ShareDetail::where('id', '=', $sharedElementDetailId)
            ->where('person_id', '=', $personId)
            ->orwhereIn('group_id', $groupIds)
            ->first();

        return $shareDetail;
    }
}