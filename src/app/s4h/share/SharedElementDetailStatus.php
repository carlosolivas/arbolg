<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 22/11/14
 * Time: 12:30
 */

namespace s4h\share;


abstract class SharedElementDetailStatus {
    const Created = 0;
    const Sent = 1;
    const Accepted = 2;
    const Rejected = 3;
} 