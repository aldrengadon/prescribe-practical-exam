<?php


namespace App\Services;

use App\Models\Module;

class Permissions
{
	/**
	* instance of core
	*/
	protected $core;

    /**
     * @param $name
     * @return string|null
     */
    public static function getByModuleName($name)
    {
        return Module::getModuleByName($name);
    }
}
