<?php

use s4h\social\GroupRepositoryInterface;

class GroupsController extends \BaseController {

	protected $group;

	public function __construct(GroupRepositoryInterface $group) {
		$this->group = $group;
	}

	/**
	 * Display a listing of the resource.
	 * GET /groups
	 *
	 * @return Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /groups/create
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /groups
	 *
	 * @return Response
	 */
	public function store() {
		//
	}

	/**
	 * Display the specified resource.
	 * GET /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /groups/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /groups/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

	/**
	 * Busca los grupos del tipo especificado que contengan las palabas clave dadas
	 * Los resultados excluyen aquellos grupos que ya tengan una solicitud de amistad aprobada
	 * Tambien se excluye al grupo del usuario que hace la búsqueda.
	 *
	 * @param int $GroupTypeId
	 * @param string $Keywords
	 * @return Response
	 */
	public function findNewFriends() {

        $groupTypeId = Input::get('GroupTypeId');
        $keyword = Input::get('Name');

		$groups = $this->group->findNewFriends($groupTypeId, $keyword);

		return View::make('Groups.searchresults', array('groups' => $groups));
	}

	/**
	 * Muestra los miembros de los grupos de amigos del usuario
	 *
	 * @return Response
	 */
	public function myFriends() {

        $friends = $this->group->myFriends();

		return View::make('Groups.myfriends', array('friends' => $friends['myFriends'], 'familyFriends' => $friends['myFamilyFriends']));
	}

}