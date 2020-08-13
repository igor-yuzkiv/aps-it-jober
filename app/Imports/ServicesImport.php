<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

/**
 * Class ServicesImport
 * @package App\Imports
 */
class ServicesImport implements  ToArray
{
    /**
     * @param array $array
     * @return array
     */
    public function array(array $array)
    {
       return $array;
    }
}
