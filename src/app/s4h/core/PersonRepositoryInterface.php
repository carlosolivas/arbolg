<?php
namespace s4h\core;

interface PersonRepositoryInterface
{
    public function store($data);

    public function getById($id);

    public function getFamilyByPersonId($id);
}
