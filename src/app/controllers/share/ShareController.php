<?php

use s4h\share\ShareRepositoryInterface;
use s4h\share\SharedElement;
use \s4h\share\SharedElementCustomItem;
use \s4h\share\SharedElementType;
use \s4h\Facades\Sharing;
/**
 * Class ShareController
 */
class ShareController extends \BaseController {

    protected $share;

    public function __construct(ShareRepositoryInterface $share)
    {
        $this->share = $share;
    }

    /**
     * @returns int $requestId: ID of the request.
     */
    public function testRequestShare($moduleId='post', $elementId=2, $personId=3, $message='', $customElements=array())
    {
        //$customElements = array(array("ConMontos", '<input type="text" id="ConMontos" name="ConMontos" />'));
        $element = new SharedElement();
        $element->setClassName($moduleId);
        $element->setElementId($elementId);
        $element->setPersonId($personId);
        $element->setMessage($message);
        $element->setType(SharedElementType::Give);

        $customItem = new SharedElementCustomItem("ConMontos", '<input type="text" id="ConMontos" name="ConMontos" />');
        $element->addCustomItem($customItem);
        return s4h\Facades\Sharing::displayShareForm($element);
    }

    public function SaveRequestShare()
    {
        $sharedElement = $this->createSharedElementObject(Input::all());

        return s4h\Facades\Sharing::give($sharedElement);
    }

    /**
     * @return SharedElement
     */
    private function createSharedElementObject($data)
    {
        $sharedElement = new SharedElement();
        $sharedElement->setPersonId($data['person_id']);
        $sharedElement->setType(SharedElementType::Give);
        $sharedElement->setClassName($data['className']);
        $sharedElement->setElementId($data['element_id']);
        $sharedElement->setMessage($data['message']);
        $sharedElement->setUrl($data['url']);

        $otherElements = array_diff_assoc($data, (array)$sharedElement);
        unset($otherElements['_token']);

        $this->addCustomItems(
            $sharedElement,
            array_filter($otherElements, function($key) {
                return substr($key, 0, 9) != 'shareWith';
            }, ARRAY_FILTER_USE_KEY)
        );

        $this->addSharedWithItems(
            $sharedElement,
            array_filter($otherElements, function($key) {
                return substr($key, 0, 9) == 'shareWith';
            }, ARRAY_FILTER_USE_KEY)
        );

        return $sharedElement;
    }

    /**
     * @param $customItems
     * @param $sharedElement
     */
    private function addCustomItems(SharedElement $sharedElement, array $customItems)
    {
        foreach ($customItems as $key => $value) {
            $sharedElement->addCustomItem(new SharedElementCustomItem($key, $value));
        }
    }

    private function addSharedWithItems(SharedElement $sharedElement, array $shareWith)
    {
        foreach ($shareWith as $key => $value) {
            $group_id = $key != "shareWithFriends" ? $value : NULL;
            $person_id = $key == "shareWithFriends" ? $value : NULL;
            $sharedElement->addSharedWith(new \s4h\share\SharedElementDetail($group_id, $person_id, \s4h\share\SharedElementDetailStatus::Created));
        }
    }

    public function AcceptShareRequest($sharedDetailId)
    {
        return Sharing::accept($sharedDetailId, Auth::user()->Person->id);
    }
}