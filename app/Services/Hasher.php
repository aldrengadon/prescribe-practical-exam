<?php

namespace App\Services;

use Hashids\Hashids;

class Hasher 
{
	/**
     * Initiate Hashids instance
     *
     * @return array
     */
	public static function init()
	{
		return new Hashids(config('app.key'), 20);
	}
	
	/**
     * encode
     *
     * @return array
     */
	public static function encode($data)
	{
		$hashids = static::init();
		
		return $hashids->encodeHex($data); 
	}
	
	/**
     * decode
     *
     * @return array
     */
	public static function decode($data)
	{
		$hashids = static::init();
		
		return $hashids->decodeHex($data); 
	}
}