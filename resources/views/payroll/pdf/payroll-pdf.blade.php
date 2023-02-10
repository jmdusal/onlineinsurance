<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $payroll->salesrep_num }}</title>
    <style>
        #clients {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        #clients td, #clients th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        #clients tr:nth-child(even){background-color: #f2f2f2;}
        #clients tr:hover {background-color: #ddd;}
        #clients th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: grey;
            color: white;
        }
    </style>
</head>
<body>
    {{-- <center><img style="height: 100px; object-fit: cover; width: 60%;" src="{{ asset('onlineinsurance.png') }}" alt=""></center> --}}
    <img style="height: 50px; object-fit: cover; width: 20%;" src="{{ asset('onlineinsurance.png') }}" alt="">
    <center><h1>Sales Representative Payroll Invoice</h1></center>
    <hr>
    <br>
    <span><strong>Date Period:</strong> {{ $payroll->date_period }}</span>
    
    <br>
    <span><strong>Sales Representative #:</strong> {{ $payroll->salesrep_num }}</span>
    <br>
    <span><strong>Sales Representative Name:</strong> {{ $payroll->salesrep_name }}</span>
    <br><br>
    
    
    <span><strong>Produce on:</strong>
        <?php
        $orig_date =  explode('-', $payroll->payroll_date_created);
        $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
        echo date("M d, Y", strtotime($con_date));
        ?>
    </span>
    <br>
    <span><strong>Produce by:</strong> OnlineInsurance<br>
        Iligan City, Philippines
    </span>
    
    <br><br><br><br>
    <h3>Tax Invoice</h3>
    <hr>
    <div class="col-lg-12">
        <div class="row">
            <label style="margin-left: 20px;">Date</label>
            <label style="margin-left: 150px;">Description</label>
            <label style="margin-left: 335px;">Credit</label>
        </div>
        <hr>
        <div class="row">
            <label style="margin-left: 20px;">
                <?php
                $orig_date =  explode('-', $payroll->salesrep_created_at);
                $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
                echo date("M d, Y", strtotime($con_date));
                ?>
            </label>
            <label style="margin-left: 90px;">Commissions</label>
            <label style="margin-left: 327px;">${{ $total_commission }}</label>
        </div>
        
        <div class="row">
            <label style="margin-left: 20px;">
                <?php
                $orig_date =  explode('-', $payroll->salesrep_created_at);
                $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
                echo date("M d, Y", strtotime($con_date));
                ?>
            </label>
            <label style="margin-left: 90px;">Bonuses</label>
            <label style="margin-left: 360px;">${{ (int)$payroll->payroll_bonus }}</label>
        </div>
        
        
        <hr style="margin-left: 330px;">
        <div class="row">
            <label style="margin-left: 333px;">Net Amount:<span style="margin-left: 205px;">${{ (int)$total_net }}</span></label>
        </div>
        
        <div class="row">
            <label style="margin-left: 333px;">Tax:<span style="margin-left: 260px; color:red;">-${{ (int)$total_tax_amount }}</span></label>
        </div>
        
        <hr style="margin-left: 330px;">
        <div class="row">
            <label style="margin-left: 333px;">Total Amount Payment:<span style="margin-left: 135px;"">${{ (int)$total_payment }}</span></label>
        </div>
        
        
        {{-- <div class="row">
            <label>ss</label>
        </div> --}}
        
        
    </div>
    
    
    
    
    
    
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    {{-- <center><img style="height: 100px; object-fit: cover; width: 60%;" src="{{ asset('onlineinsurance.png') }}" alt=""></center> --}}
    <img style="height: 50px; object-fit: cover; width: 20%;" src="{{ asset('onlineinsurance.png') }}" alt="">
    <center><h1>Detail Commission Statement</h1></center>
    <hr>
    <br>
    
    <span><strong>Date Period:</strong> {{ $payroll->date_period }}</span>
    
    <br>
    <span><strong>Sales Representative #:</strong> {{ $payroll->salesrep_num }}</span>
    <br>
    <span><strong>Sales Representative Name:</strong> {{ $payroll->salesrep_name }}</span>
    <br><br>
    
    
    
    <span><strong>Produce on:</strong>
        <?php
        $orig_date =  explode('-', $payroll->payroll_date_created);
        $con_date = $orig_date[0].'-'.$orig_date[1].'-'.$orig_date[2];
        echo date("M d, Y", strtotime($con_date));
        ?>
    </span>
    <br>
    <span><strong>Produce by:</strong> OnlineInsurance<br>
        Iligan City, Philippines
    </span>
    
    
    <br><br><br><br>
    <h3>Production</h3>
    <hr>
    
    
    <table id="clients" class="table table-condensed">
        <tr>
            <th>Client Name</th>
            <th>Client Email</th>
            <th>Sales</th>
            <th>Commission</th>
        </tr>
        {!! $table_clients !!}
    </table>
    <br>
    <hr style="margin-left: 330px;">
    <span style="margin-left: 405px;">Total Commission: ${{ $total_commission }}</span>
    
</body>
</html>





