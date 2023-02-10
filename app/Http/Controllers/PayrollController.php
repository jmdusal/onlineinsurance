<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use App\Salesrep;
use App\Payroll;
use App\Client;
use DB;
use PDF;

class PayrollController extends Controller
{
    public function index()
    {
        return view('payroll.index');
    }

    public function datatable(Request $request)
    {
        $data = DB::table('payroll')
            ->join('salesrep', 'payroll.salesrep_id', '=', 'salesrep.salesrep_id')
            ->select('payroll.*', 'salesrep.*')
            ->get();

        return Datatables::of($data)->make(true);
    }

    public function create()
    {
        return view('payroll.create', [
            'salesrep' => Salesrep::all()
        ]);
    }

    public function store(Request $request)
    {
        $salesrep_id = $request->salesrep_id;
        $date_period = $request->date_period;
        $payroll_bonus = $request->payroll_bonus;
        date_default_timezone_set('Asia/Manila');
        $time = date('G:i:s');
        $date = date("Y-m-d");
        $date_time = $date . " " . $time;

        $payroll_id = DB::table('payroll')
            ->insertGetId(
                array(
                    'salesrep_id'   => $salesrep_id,
                    'date_period'   => $date_period,
                    'payroll_bonus' => $payroll_bonus,
                    'created_at'    => $date_time
                )
            );
        $client = $request->post('client');
        foreach ($client as $key => $value) {
            $client_array_data = array(
                'client_name'       => $value['client_name'],
                'client_email'      => $value['client_email'],
                'client_commission' => $value['client_commission'],
                'payroll_id'        => $payroll_id,
                'created_at'        => $date_time
            );
            $create_payroll = Client::create($client_array_data);
        }

        if ($payroll_id && $create_payroll) {
            $success = true;
            $message = "Payroll Created Successfully";
            return response()->json([
                'success' => $success,
                'message' => $message,
                'payroll' => $payroll_id
            ]);
        }
    }

    public function response_data(Request $request)
    {
        $payroll_id = $request->payroll_id;

        $payroll = DB::table('payroll')
            ->join('salesrep', 'payroll.salesrep_id', '=', 'salesrep.salesrep_id')
            ->select('payroll.*', 'payroll.created_at as payroll_date_created', 'salesrep.*', 'salesrep.created_at as salesrep_created_at')
            ->where('payroll_id', $payroll_id)
            ->first();

        $clients = DB::table('client')
            ->join('payroll', 'client.payroll_id', '=', 'payroll.payroll_id')
            ->select('client.*', 'payroll.payroll_id')
            ->where('client.payroll_id', '=', $payroll_id)
            ->get();
        $num_clients = count($clients);

        $json_data['payroll'] = $payroll;
        $json_data['clients'] = $clients;
        $json_data['num_clients'] = $num_clients;
        return response()->json($json_data);
    }

    public function edit($payroll_id, Request $request)
    {
        $payroll_id = $request->payroll_id;
        $payroll = DB::table('payroll')
            ->join('salesrep', 'payroll.salesrep_id', '=', 'salesrep.salesrep_id')
            ->select('payroll.*', 'payroll.created_at as payroll_date_created', 'salesrep.*', 'salesrep.created_at as salesrep_created_at')
            ->where('payroll_id', $payroll_id)
            ->first();

        $clients = DB::table('client')
            ->join('payroll', 'client.payroll_id', '=', 'payroll.payroll_id')
            ->select('client.*', 'payroll.payroll_id')
            ->where('client.payroll_id', '=', $payroll_id)
            ->get();

        $num_clients = count($clients);

        return view('payroll.edit', [
            'payroll' => $payroll,
            'clients' => $clients,
            'salesrep' => Salesrep::all(),
            'num_clients' => $num_clients
        ]);
    }

    public function update($payroll_id, Request $request)
    {
        $id = $request->payroll_id;
        $payroll = Payroll::find($id);
        $payroll->date_period = $request->input('date_period');
        $payroll->payroll_bonus = $request->input('payroll_bonus');
        $payroll->salesrep_id = $request->input('salesrep_id');
        $payroll->save();

        $client_id = $request->client_id;
        $delete_client = DB::table('client')->where('payroll_id', $id)->delete();

        $client = $request->post('client');
        foreach ($client as $key => $value) {
            $client_array_data = array(
                'client_name'       => $value['client_name'],
                'client_email'      => $value['client_email'],
                'client_commission' => $value['client_commission'],
                'payroll_id'        => $id,
            );
            $create_payroll = Client::create($client_array_data);
        }

        $success = true;
        $message = "Payroll Updated Successfully";
        return response()->json([
            'success' => $success,
            'message' => $message,
            'payroll' => $payroll
        ]);
    }

    public function show($payroll_id, Request $request)
    {
        $payroll_id = $request->payroll_id;
        $payroll = DB::table('payroll')
            ->join('salesrep', 'payroll.salesrep_id', '=', 'salesrep.salesrep_id')
            ->select('payroll.*', 'payroll.created_at as payroll_date_created', 'salesrep.*', 'salesrep.created_at as salesrep_created_at')
            ->where('payroll_id', $payroll_id)
            ->first();

        $clients = DB::table('client')
            ->join('payroll', 'client.payroll_id', '=', 'payroll.payroll_id')
            ->select('client.*', 'payroll.payroll_id')
            ->where('client.payroll_id', '=', $payroll_id)
            ->get();

        $payroll_bonus = $payroll->payroll_bonus;
        $salesrep_commission_percent = $payroll->commission_percent;
        $salesrep_tax_rate = $payroll->tax_rate;

        $total_commission = 0.00;
        $total_net = 0.00;
        $total_tax_amount = 0.00;
        $total_payment = 0.00;
        $table_clients = '';

        // GET CLIENT TOTAL COMMISSION
        foreach ($clients as $key => $value) {
            $percent_in_decimal = $salesrep_commission_percent / 100;
            $percent_amount = $percent_in_decimal * $value->client_commission;
            $total_commission += $percent_amount;

            $table_clients .= '<tr>
            <td class="total"><br><br>' . $value->client_name . ' </td>
            <td class="total"><br><br>' . $value->client_email . '</td>
            <td class="total"> <br><br>$' . (int) $value->client_commission . '</td>
            <td class="total"> <br><br>$' . $percent_amount . '</td>
            </tr>';
        }
        $total_net = $total_commission + $payroll_bonus;

        // GET SALESREP TOTAL PAYMENT
        $percent_in_decimal = $salesrep_tax_rate / 100;
        $total_tax_amount = $percent_in_decimal * $total_net;
        $total_payment = $total_net - $total_tax_amount;

        $pdf = PDF::loadView(
            'payroll.pdf.payroll-pdf',
            array(
                'payroll'       => $payroll,
                'clients'       => $clients,
                'table_clients' => $table_clients,
                'total_net'     => $total_net,
                'total_payment' => $total_payment,
                'total_commission' => $total_commission,
                'total_tax_amount' => $total_tax_amount,
                // 'percent_amount' => $percent_amount
            )
        );
        return $pdf->stream();
    }

    public function destroy($payroll_id, Request $request)
    {
        $payroll_id = $request->payroll_id;
        $payroll = DB::table('payroll')->where('payroll_id', $payroll_id)->delete();

        if ($payroll == 1) {
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
