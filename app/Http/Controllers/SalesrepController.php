<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Salesrep;
use DB;
use Redirect;
use Response;
use PDF;
use Illuminate\Support\Facades\Storage;


class SalesrepController extends Controller
{
    public function index()
    {
        return view('salesrep.index');
    }

    public function datatable(Request $request)
    {
        $data = Salesrep::query()->orderBy('created_at', 'desc');
        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('salesrep.create');
    }

    public function store(Request $request)
    {
        $bonus = 0;
        $salesrep = Salesrep::create([
            'salesrep_name'         => $request->salesrep_name,
            'salesrep_num'          => rand(100000, 999999),
            'commission_percent'    => $request->commission_percent,
            'tax_rate'              => $request->tax_rate,
            'bonus'                 => $bonus,
            date_default_timezone_set('Asia/Manila')
        ]);

        if (!empty($salesrep)) {
            $status =  true;
            $message =  'Salesrep Added Successfully';
            return response()->json([
                'status'    => $status,
                'message'   => $message,
                'salesrep'  => $salesrep,
            ]);
        } else {
            $status = false;
            $message = 'Error Data';
            return response()->json([
                'status'        => $status,
                'message'       => $message
            ]);
        }
    }

    public function edit($salesrep_id, Request $request)
    {
        $salesrep_id = $request->salesrep_id;
        $salesrep = Salesrep::find($salesrep_id);
        return view('salesrep.edit', [
            'salesrep' => $salesrep
        ]);
    }

    public function update($salesrep_id, Request $request)
    {
        $salesrep_id = $request->salesrep_id;
        $salesrep_name = $request->salesrep_name;
        $commission_percent = $request->commission_percent;
        $tax_rate = $request->tax_rate;

        $update = DB::table('salesrep')->where('salesrep_id', $salesrep_id)->update(array(
            'salesrep_name'         => $salesrep_name,
            'commission_percent'    => $commission_percent,
            'tax_rate'              => $tax_rate,
        ));

        if (!empty($update)) {
            $status =  true;
            $message =  'Saved Successfully';
            return response()->json([
                'status'            => $status,
                'message'           => $message,
                'salesrep_name'     => $salesrep_name,
                'commission_percent' => $commission_percent,
                'tax_rate'          => $tax_rate
            ]);
        } else {
            $status = false;
            $message = 'Error Data';
            return response()->json([
                'status'        => $status,
                'message'       => $message
            ]);
        }
    }

    public function destroy($salesrep_id, Request $request)
    {
        $salesrep_id = $request->salesrep_id;
        $salesrep = DB::table('salesrep')->where('salesrep_id', $salesrep_id)->delete();

        if ($salesrep == 1) {
            $success = true;
            $message = "Deleted successfully";
        } else {
            $success = false;
            $message = "Data not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
