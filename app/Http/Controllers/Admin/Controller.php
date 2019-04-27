<?php

namespace App\Http\Controllers\Admin;

use Route;
use Illuminate\Support\Str;
use JavaScript;
use App\Helpers\Multitenant;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role:super-admin']);
        $data = [];

        foreach (Route::getRoutes() as $key => $value) {
            if (strpos(Str::lower($value->uri()), 'admin') !== false && !is_null($value->getName())) {
                $data[$value->getName()] = ['url' => $value->uri(), 'methods'=>$value->methods()];
            }
        }

        JavaScript::put(['home'       => url('/')]);
        JavaScript::put(['today'      => date('Y-m-d')]);
    }
}