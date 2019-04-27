<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait CreatesViewPaths
{
	public function getViewPath($method)
	{	
		//NOT IMPLEMENTED YET..
		//dd(static::class);
		//dd(array_search(static::class, debug_backtrace()));
		//dd(debug_backtrace());
		//dd(array_pluck(debug_backtrace(), 'developer.name', 'developer.id');)
		//dd(__NAMESPACE__);
		//dd(Str::lower(last(explode('\\', static::class))));
	}
}