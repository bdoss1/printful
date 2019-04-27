<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Traits\CreatesViewPaths;
use Illuminate\Http\Request;
use App\Helpers\Multitenant;

class HomeController extends Controller
{
    use CreatesViewPaths;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function test(Request $request)
    {
        $response = [
            'test' => 'blah!',
            'blah' => 'test'
        ];
        return response()->json($response);
    }
}