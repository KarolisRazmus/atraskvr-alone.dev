<?php
/**
 * Created by PhpStorm.
 * User: karol
 * Date: 2017-06-09
 * Time: 00:21
 */

namespace App\Http\Traits;


trait ConfigurationForBladeTrait
{

    public function getFillableAndTableName ()
    {
        $configuration['fields'] = $this->getFillable();
        $configuration['tableName'] = $this->getTableName();

        return $configuration;
    }

}