<?php
/**
 * Created by PhpStorm.
 * User: hermann
 * Date: 18/03/15
 * Time: 23:08
 */

namespace Utility;


class LinkedCollection extends Collection
{
    /**
     * Takes the reference of an array
     *
     * @param array $info
     */
    public function __construct(array &$info = array())
    {
        $this->_data =& $info;
    }
}