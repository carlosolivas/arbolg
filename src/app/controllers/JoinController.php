<?php

use s4h\core\PersonRepositoryInterface;
use s4h\share;

class JoinController extends BaseController
{
	protected $personRepository;

	/**
     * General constants
     */
 	const SHARE_ELEMENT_CLASS_NAME_FAMILY_TREE	= "familyTree";
 	const SHARE_ELEMENT_TYPE					= 1;

	public function __construct(PersonRepositoryInterface $personRepository) 
	{
        $this->personRepository = $personRepository;
	}		

	/**
	 * Sharing page
	 * @return View
	 */
	public function get_sharing($id)
	{		
		/*try {*/
			$input = Input::all();
		
			$user = Auth::user();
			$personLogged = $user->Person->id;
			$className = "familyTree";

			$className = self::SHARE_ELEMENT_CLASS_NAME_FAMILY_TREE;		
			// id received as parameter is the element id		
			$elementId = $id;
			$personId = $personLogged;
			$message = Lang::get('messages.shareElementMessage');
			$type = self::SHARE_ELEMENT_TYPE;

			$shareElement = new s4h\share\SharedElement;
			$shareElement->$className = $className;
	    	$shareElement->$elementId = $elementId;
		    $shareElement->$personId = $personId;
		    $shareElement->$message = $message;
		    $shareElement->$type = $type;

		    $fileRepository = new \s4h\core\DbS3FileRepository;
		    $groupRepository = new s4h\social\DbGroupRepository($fileRepository);
		    $shareRepository = new s4h\share\DbShareRepository;
		    $sharing = new s4h\share\Sharing($groupRepository, $shareRepository);

			return $sharing->displayShareForm($shareElement);			
		/*} catch (Exception $e) {
			return Lang::get('messages.error_loading_share_view');
		}	*/	
	}
}