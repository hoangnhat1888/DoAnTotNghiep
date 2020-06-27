<?php

namespace App\Role;

use App\User;

/**
 * Class RoleChecker
 * @package App\Role
 */
class RoleChecker
{
	/**
	 * @param User $user
	 * @param $role
	 * @return bool
	 */
	public static function check(User $user, $role)
	{
		// Admin has everything
		if ($user->hasRole(UserRole::ADMIN)) {
			return true;
		} else if ($user->hasRole(UserRole::MANAGEMENT)) {
			$managementRoles = UserRole::getAllowedRoles(UserRole::MANAGEMENT);

			if (in_array($role, $managementRoles)) {
				return true;
			}
		}

		return $user->hasRole($role);
	}
}
