@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Payroll</div>

                <div class="card-body">

                    <form name="form_create_payroll" id="form_create_payroll" action="javascript:void(0)">
                        {{-- <form name="form_create_payroll" id="form_create_payroll" method="POST" action="{{ route('payroll.store') }}"> --}}
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Salesrep</label>
                                <div class="col-sm-6">
                                    {{-- <input type="text" name="salesrep_name" id="salesrep_name" class="form-control" placeholder="Enter fullname" required> --}}
                                    <select name="salesrep_id" id="salesrep_id" class="form-control" required>
                                        @foreach($salesrep as $data)
                                        <option hidden selected>Choose Salesrep</option>
                                        <option value="{{ $data->salesrep_id }}">{{ $data->salesrep_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Indicate the date period (weekly)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="date_period" id="date_period" class="form-control" placeholder="Select date period" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Bonus amount (if none, just skip)</label>
                                <div class="col-sm-6">
                                    <input type="number" name="payroll_bonus" id="payroll_bonus" class="form-control money" placeholder="$">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Number of clients</label>
                                <div class="col-sm-2">
                                    <input type="number" name="num_clients" id="num_clients" min="0" max="3" class="form-control num_clients" placeholder="0" required>
                                </div>
                            </div>
                            <hr>

                            <div id="show_message" class="form-group" hidden>
                                <span style="margin-top: 6px; color:red;">Input the client name and commission field:</span>
                                <br><br>
                                <div class="form-group row">
                                    <div class="field_wrapper">

                                    </div>
                                </div>
                            </div>


                            <br><br>
                            <button id="payroll_submit_btn" type="submit" class="btn btn-primary btn-round">Submit</button>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#payroll_submit_btn').on('click', function(){
                if($('#form_create_payroll').length > 0){
                    let salesrep_id = $('#salesrep_id').val();
                    let date_period = $('#date_period').val();
                    let payroll_bonus = $('#payroll_bonus').val();
                    let form = $('#form_create_payroll').serialize();
                    $.ajax({
                        url: "{{ route('payroll.store') }}",
                        // url: base_url+'payroll/store',
                        method: 'post',
                        dataType: 'JSON',
                        cache: false,
                        data: form,
                        salesrep_id: salesrep_id,
                        date_period: date_period,
                        payroll_bonus: payroll_bonus,
                        success : function(response){
                            console.log(response.payroll);
                            if(response.status == true){
                                Swal.fire({
                                    title: "Done!",
                                    text: response.message,
                                    type: "success",
                                    // showConfirmButton: true,
                                    // confirmButtonColor: "#007bff",
                                });
                                document.getElementById("form_create_payroll").reset();
                                // setTimeout(function(){
                                    //         window.location.href = '{{ url("/payroll/index")}}';
                                    //     }, 1000);

                                    setTimeout(function(){
                                        window.location.href = '{{ url("/payroll/pdf")}}/'+response.payroll;
                                    }, 1000);
                                }
                                else{
                                    Swal.fire({
                                        title: "Done!",
                                        text: response.message,
                                        type: "success",
                                    });
                                    document.getElementById("form_create_payroll").reset();
                                    // setTimeout(function(){
                                        //     window.location.href = '{{ url("/payroll/index")}}';
                                        // }, 1000);
                                        setTimeout(function(){
                                            window.location.href = '{{ url("/payroll/pdf")}}/'+response.payroll;
                                        }, 1000);
                                    }
                                }
                            });
                        }
                    });


                    let num_client = 0;
                    let wrapper = $('.field_wrapper');
                    let x = 0;
                    $('#num_clients').on('change keyup', function() {
                        if( $(this).val() <= 0 ){
                            $('#show_message').prop('hidden', true);
                        }else{
                            $('#show_message').prop('hidden', false);
                        }
                        num_client = $(this).val();
                        $(wrapper).html('');
                        x = 0;
                        for (let i = 1; i <= num_client; i++) {
                            x++;
                            let fieldHTML =  ''+
                            '   <div class="client_section row">  '  +
                                '     <div class="col-md-1 form-group" style="padding: 0px; margin: 0px" align="center">  '  +
                                    '     </div>   '  +
                                    '     '  +
                                    '     <div class="col-md-3 form-group" style="padding-left: 0px">  '  +
                                        '       <input type="text" class="form-control required" name="client['+x+'][client_name]" placeholder="Client Name" required/>  '  +
                                        '     </div>   '  +
                                        '     <div class="col-md-3 form-group">  '  +
                                            '       <input type="text" class="form-control money required" name="client['+x+'][client_commission]" placeholder="Commission" required/>  '  +
                                            '     </div>   '  +
                                            '     <div class="col-md-3 form-group">  '  +
                                                '       <input type="email" class="form-control required" name="client['+x+'][client_email]" placeholder="Email (optional)" />  '  +
                                                '     </div>   '  +
                                                '     <div class="col-md-2" style="padding: 0px;">  '  +
                                                    '       &ensp;<a href="javascript:void(0);" class="remove_button"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>  '  +
                                                    '     </div>  '  +
                                                    '  </div> <br> ' ;
                                                    $(wrapper).append(fieldHTML);
                                                }
                                                // $('.money').maskMoney({prefix:'$ ', precision: 0});
                                            });
                                            $(wrapper).on('click', '.remove_button', function(e){
                                                num_client = num_client - 1;
                                                if(num_client <= 0 ){
                                                    $('#show_message').prop('hidden', true);
                                                }else{
                                                    $('#show_message').prop('hidden', false);
                                                }
                                                $('#num_clients').val(num_client);
                                                e.preventDefault();
                                                $(this).parent().parent().remove();
                                                x--;
                                            });

                                            let startDate;
                                            let endDate;
                                            $('#date_period').datepicker({
                                                autoclose: true,
                                                format :'mm/dd/yyyy',
                                                forceParse :false
                                            }).on('changeDate', function(e){
                                                // console.log('yes');
                                                let date = e.date;
                                                startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
                                                endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
                                                $('#date_period').datepicker('update', startDate);
                                                $('#date_period').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' +  startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' +  endDate.getFullYear());

                                            });

                                            $('#prevWeek').click(function(e){
                                                let date = $('#date_period').datepicker('getDate');
                                                startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()- 7);
                                                endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() - 1);
                                                $('#date_period').datepicker("setDate", new Date(startDate));
                                                $('#date_period').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' +  startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' +  endDate.getFullYear());

                                                return false;
                                            });
                                            $('#nextWeek').click(function(){
                                                let date = $('#date_period').datepicker('getDate');

                                                startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+ 7);
                                                endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 13);
                                                $('#date_period').datepicker("setDate", new Date(startDate));
                                                $('#date_period').val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' +  startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' +  endDate.getFullYear());

                                                return false;
                                            });



                                        });
                                    </script>

                                    @endsection
