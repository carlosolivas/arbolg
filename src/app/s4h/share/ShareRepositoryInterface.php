<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 23:13
 */

namespace s4h\share;


/**
 * Interface ShareRepositoryInterface
 * @package s4h\share
 */
interface ShareRepositoryInterface {

    public function getById($id);

    /*public function give(SharedElement $sharedElement);

    public function receive($id);*/

    public function changeDetailStatus($sharedElementId, $status);

    public function getSharedElementDetailByPersonId($sharedElementDetailId, $personId);
} 