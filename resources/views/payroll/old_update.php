@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Payroll</div>

                <div class="card-body">

                    <form name="form_create_payroll" id="form_create_payroll" action="javascript:void(0)">
                        {{-- <form name="form_create_payroll" id="form_create_payroll" method="POST" action="{{ route('payroll.store') }}"> --}}
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Salesrep</label>
                            <div class="col-sm-6">
                                <select name="salesrep_id" id="salesrep_id" class="form-control" required>
                                    @foreach($salesrep as $data)
                                    <option hidden selected>{{ $payroll->salesrep_name }}</option>
                                    <option value="{{ $data->salesrep_id }}">{{ $data->salesrep_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Indicate the date period (weekly)</label>
                            <div class="col-sm-6">
                                <input type="text" name="date_period" id="date_period" class="form-control" value="{{ $payroll->date_period }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Bonus amount (if none, just skip)</label>
                            <div class="col-sm-6">
                                <input type="number" name="payroll_bonus" id="payroll_bonus" class="form-control money" value="{{ (int)$payroll->payroll_bonus }}" placeholder="$">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Number of clients</label>
                            <div class="col-sm-2">
                                <input type="number" id="num_clients" min="0" max="3" value="{{ $num_clients }}" class="form-control num_clients" placeholder="0" required>
                            </div>
                        </div>


                        <hr>

                        <div id="show_message" class="form-group">
                            <span style="margin-top: 6px; color:red;">Please input the client name and commission field:</span>
                            <br><br>
                            <div class="form-group row">
                                <div class="field_wrapper">
                                    <div class="">

                                    </div>

                                </div>
                            </div>
                        </div>



                        {{-- <div id="show_message" class="form-group">
                                <span style="margin-top: 6px; color:red;">Input the client name and commission field:</span>
                                <br><br>
                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div class="client_section row">
                                            @foreach($clients as $client)
                                            <div class="col-md-3 form-group" style="padding-left: 0px">
                                                <input type="text" class="form-control required" name="client_name[]" value="{{ $client->client_name }}" placeholder="Client's Name" value="test1" required/>
                </div>

                <div class="col-md-3 form-group">
                    <input type="text" class="form-control required" name="client_commission[]" value="{{ $client->client_commission }}" placeholder="Client Commission" required />
                </div>

                <div class="col-md-3 form-group">
                    <input type="text" class="form-control required" name="client_email[]" value="{{ $client->client_email }}" placeholder="Email" required />
                </div>
                <div class="col-md-2" style="padding: 0px;">
                    <a href="javascript:void(0);" class="remove_button"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div> --}}





<br><br>
<button id="payroll_submit_btn" type="submit" class="btn btn-primary btn-round">Save</button>


</form>
</div>

</div>
</div>
</div>
</div>

<script type="text/javascript">
    $(function() {



        $('#payroll_submit_btn').on('click', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            let form_create_payroll = $("#form_create_payroll").serialize();

            let id = "{{ $payroll->payroll_id }}";

            $.ajax({
                url: "{{url('payroll/update')}}/" + id,
                method: 'PATCH',
                dataType: "JSON",
                data: form_create_payroll,
                success: function(response) {
                    console.log(response);

                }


            });



        });














        var num_client = $('#num_clients').val();
        let wrapper = $('.field_wrapper');
        let x = 0;
        $(wrapper).html('');


        let payroll_id = "{{ $payroll->payroll_id }}";
        $.ajax({
            url: "{{ url('payroll/response_data') }}/" + payroll_id,
            method: 'get',
            dataType: 'json',
            cache: false,
            data: payroll_id,
            success: function(response) {

                let client = response['clients'];

                // console.log(client);
                for (let i = 0; i < client.length; i++) {
                    // console.log(client[i]);
                    x++;
                    let fieldHTML = '' +
                        '   <div class="client_section row">  ' +
                        '     <div class="col-md-1 form-group" style="padding: 0px; margin: 0px" align="center">  ' +
                        '     </div>   ' +
                        '     ' +
                        '     <div class="col-md-3 form-group" style="padding-left: 0px">  ' +
                        '       <input type="text" class="form-control required" name="client[' + x + '][client_name]" value="' + client[i].client_name + '" required/>  ' +
                        '     </div>   ' +
                        '     <div class="col-md-3 form-group">  ' +
                        '       <input type="text" class="form-control money required" name="client[' + x + '][client_commission]" value="' + client[i].client_commission + '" placeholder="Commission" required/>  ' +
                        '     </div>   ' +
                        '     <div class="col-md-3 form-group">  ' +
                        '       <input type="email" class="form-control required" name="client[' + x + '][client_email]" value="' + client[i].client_email + '" placeholder="Email (optional)" />  ' +
                        '     </div>   ' +
                        '     <div class="col-md-2" style="padding: 0px;">  ' +
                        '       &ensp;<a href="javascript:void(0);" class="remove_button"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>  ' +
                        '     </div>  ' +
                        '  </div> <br> ';
                    $(wrapper).append(fieldHTML);
                }





            }


        });














        // for (var i = 1; i <= num_client; i++) {
        //     console.log(num_client);
        //     x++;
        //     let fieldHTML =  ''+
        //     '   <div class="client_section row">  '  +
        //         '     <div class="col-md-1 form-group" style="padding: 0px; margin: 0px" align="center">  '  +
        //             '     </div>   '  +
        //             '     '  +
        //             '     <div class="col-md-3 form-group" style="padding-left: 0px">  '  +
        //                 '       <input type="text" class="form-control required" name="client['+x+'][client_name]" placeholder="Client Name" required/>  '  +
        //                 '     </div>   '  +
        //                 '     <div class="col-md-3 form-group">  '  +
        //                     '       <input type="text" class="form-control money required" name="client['+x+'][client_commission]" placeholder="Commission" required/>  '  +
        //                     '     </div>   '  +
        //                     '     <div class="col-md-3 form-group">  '  +
        //                         '       <input type="email" class="form-control required" name="client['+x+'][client_email]" placeholder="Email (optional)" />  '  +
        //                         '     </div>   '  +
        //                         '     <div class="col-md-2" style="padding: 0px;">  '  +
        //                             '       &ensp;<a href="javascript:void(0);" class="remove_button"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>  '  +
        //                             '     </div>  '  +
        //                             '  </div> <br> ' ;
        //                             $(wrapper).append(fieldHTML);
        //                         }































        $(wrapper).on('click', '.remove_button', function(e) {
            num_client = num_client - 1;
            if (num_client <= 0) {
                $('#show_message').prop('hidden', true);
            } else {
                $('#show_message').prop('hidden', false);
            }
            $('#num_clients').val(num_client);
            e.preventDefault();
            $(this).parent().parent().remove();
            x--;
        });













        $('#num_clients').on('change keyup', function() {

            if ($(this).val() <= 0) {
                $('.show_message').prop('hidden', true);
            } else {
                $('.show_message').prop('hidden', false);
            }
            num_client = $(this).val();
            $(wrapper).html('');
            x = 0;

        });
















    });
</script>

@endsection
