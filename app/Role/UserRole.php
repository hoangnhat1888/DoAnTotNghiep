<?php

namespace App\Role;

/***
 * Class UserRole
 * @package App\Role
 */
class UserRole
{
	const ADMIN = 'ADMIN';
	const MANAGEMENT = 'MANAGEMENT';
	const SUPPORT = 'SUPPORT';

	/**
	 * @var array
	 */
	protected static $roleHierarchy = [
		self::ADMIN => ['*'],
		self::MANAGEMENT => [
			self::SUPPORT
		],
		self::SUPPORT => []
	];

	/**
	 * @param $role
	 * @return array
	 */
	public static function getAllowedRoles($role)
	{
		if (isset(self::$roleHierarchy[$role])) {
			return self::$roleHierarchy[$role];
		}

		return [];
	}

	/***
	 * @return array
	 */
	public static function getRoleList()
	{
		return [
			static::ADMIN => 'Admin',
			static::MANAGEMENT => 'Management',
			static::SUPPORT => 'Support'
		];
	}
}
