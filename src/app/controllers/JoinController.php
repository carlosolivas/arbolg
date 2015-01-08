<?php
/**
* JoinCOntroller.php
*
* Handles the joining of tree's elements
*
*  @category Controllers
*  @author   Kiwing IT Solutions <info@kiwing.net>
*  @author   Federico Rossi <rossi.federico.e@gmail.com>
*
*/

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
  	const CUSTOM_ELEMENT_NAME_KEEP_THE_TREE		= "keepTheTree";
  	const CUSTOM_ELEMENT_KEEP_THE_TREE_HTML		= "<input type='checkbox' name='keepTheTree' value='1'/>";
  	const REQUEST_STATUS_SUCCESSFUL 			= 'successful';
  	const REQUEST_STATUS_FAILURE				= 'failure';

	public function __construct(PersonRepositoryInterface $personRepository)
	{
        $this->personRepository = $personRepository;
	}

	/**
	* Sharing page
	* @param $id The sharing element id
	* @return View
	*/
	public function get_sharing($id)
	{
		try {
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

		    $keepTheTreeCheckBox = new s4h\share\SharedElementCustomItem(
		    	self::CUSTOM_ELEMENT_NAME_KEEP_THE_TREE,
		    	self::CUSTOM_ELEMENT_KEEP_THE_TREE_HTML);

		    $shareElement->addCustomItem($keepTheTreeCheckBox);

		    $fileRepository = new \s4h\core\DbS3FileRepository;
		    $groupRepository = new s4h\social\DbGroupRepository($fileRepository);
		    $shareRepository = new s4h\share\DbShareRepository;
		    $sharing = new s4h\share\Sharing($groupRepository, $shareRepository, $this->personRepository);

		    $data = $sharing->displayShareForm($shareElement);

		    $response = array('status' => self::REQUEST_STATUS_SUCCESSFUL, 'data' => (string)$data);
			return Response::json($response);

		} catch (Exception $e) {

			$response = array('status' => self::REQUEST_STATUS_FAILURE, 'data' => Lang::get('messages.error_loading_share_view'));
			//return Response::json($response);
			return Response::json($e->getMessage());
		}
	}

	
}
