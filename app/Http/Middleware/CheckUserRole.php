<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Role\RoleChecker;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

/**
 * Class CheckUserRole
 * @package App\Http\Middleware
 */
class CheckUserRole
{
	/**
	 * @var RoleChecker
	 */
	protected $roleChecker;

	public function __construct(RoleChecker $roleChecker)
	{
		$this->roleChecker = $roleChecker;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param $role
	 * @return mixed
	 * @throws AuthorizationException
	 */
	public function handle($request, Closure $next, $role)
	{
		/** @var User $user */
		$user = Auth::guard()->user();

		if (isset($user)) {
			$link = route('admin');
			$len = mb_strlen($link);
			if ($len == 0) {
				$link = '/';
			} else {
				if (mb_substr($request->url(), -$len) === $link) {
					$link = '/';
				}
			}

			if (!$this->roleChecker->check($user, $role)) {
				return redirect($link);
			}
		} else {
			return redirect('/login');
		}

		return $next($request);
	}
}
