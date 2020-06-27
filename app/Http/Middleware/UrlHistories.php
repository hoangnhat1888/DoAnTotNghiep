<?php

namespace App\Http\Middleware;

use Closure;

class UrlHistories
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 * @throws UrlHistories
	 */
	public function handle($request, Closure $next)
	{
		$urlHistories = json_decode(request()->session()->get('URL_HISTORIES', '[]'));

		if (!$urlHistories) {
			$urlHistories = [];
		} else {
			if (count($urlHistories) > 10) {
				array_pop($urlHistories);
			}
		}

		if (isset($_SERVER['HTTP_REFERER'])) {
			if (count($urlHistories)) {
				if ($_SERVER['HTTP_REFERER'] !== $urlHistories[0]) {
					array_unshift($urlHistories, $_SERVER['HTTP_REFERER']);
				}
			} else {
				array_unshift($urlHistories, $_SERVER['HTTP_REFERER']);
			}
		}

		request()->session()->put('URL_HISTORIES', json_encode($urlHistories));

		return $next($request);
	}
}
