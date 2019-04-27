<?php

namespace App\Http\Controllers\Admin;
use DB;

use App\Http\Requests\PageRequest;
use Illuminate\Http\Request;
use App\Helpers\Multitenant;
use App\Traits\CreatesViewPaths;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Input;
use App\Events\RoutesUpdated;
use App\Helpers\Helper;
use File;
use Excel;

class InvoiceController extends Controller
{
    use CreatesViewPaths;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('pages.admin.dashboard');
    }

    public function show(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Store method goes here

        return response()->json([
            "message" => "Invoice has created successfully!",
            "status"  => "success",
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        return view('pages.admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // Update method goes here
        $item       = Multitenant::getModel('Invoice')::where('id', $id)->first();
        $item->id   = $request->id;

        $item->save();

        return response()->json([
            "message" => "Invoice has successfully redirected!",
            "status" => "success",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Multitenant::getModel('Invoice')::where('id', $id)->delete();

        return response()->json([
            "message" => "Invoice has been successfully deleted!",
            "status" => "success",
        ], 200);
    }

    /*
     * Invoices browser method
     */
    public function browseInvoices(Request $request) {
        if ($request->expectsJson()) {
            $params = $request->params;
            $params['page'] = intval($params['page']);
            $params['service_period'] = date('Y-m-d', strtotime($params['service_period']));

            $id = !is_null($request->id) ? $request->id : null; 
            /*
             *  I have created a helper to receive API data 
             *  @params will contain 'page_id' to define on which page we are
             *  'start_date' and 'end_date' to get data for certain period.
             *  ID - to view one specific invoice.
             */
            $invoices = Helper::apiData($id, $params);

            return response()->json(json_decode($invoices));
        }
    }
    /*
     *  Exporting the data in excel
     *  @type can be xls, xlsx.
     *  NOTE: The data must be an array where the keys are Excel columns and values are appropriate rows. 
     *  WARNING: STILL COULD NOT MANAGE TO CORRECT THE PACKAGE ERROR!
     */
    public function export(Request $request) {
        $type = isset($request->type) ? $request->type : 'xlsx';
        $data = isset($request->data) ? $request->data : [];
        return Excel::download(function($excel) use ($data) {
            $excel->sheet('Invoices', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        }, 'invoice.'.$type);
    }

    public function editInvoice(Request $request, $id) {
        if ($request->expectsJson()) {
            $params = [];
            $invoices = Helper::apiData($id, $params);

            return response()->json(json_decode($invoices));
        }        
    }

    public function createInvoice(Request $request) {
        if ($request->expectsJson()) {

            return response()->json([

            ], 200);
        }
    }
}