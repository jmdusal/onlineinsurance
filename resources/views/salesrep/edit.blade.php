@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Salesrep</div>
                
                <div class="card-body">
                    
                    <form id="form_edit_salesrep" action="javascript:void(0)">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fullname</label>
                            <div class="col-sm-6">
                                <input type="text" name="salesrep_name" id="salesrep_name" class="form-control" value="{{ $salesrep->salesrep_name }}" placeholder="Enter fullname" required>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Commission Percentage (0-100%)</label>
                            <div class="col-sm-6">
                                <input type="number" name="commission_percent" id="commission_percent"  class="form-control" value="{{ $salesrep->commission_percent }}" placeholder="0%" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Tax Rate (0-100%)</label>
                            <div class="col-sm-6">
                                <input type="number" name="tax_rate" id="tax_rate" class="form-control" value="{{ $salesrep->tax_rate }}" placeholder="0%" required>
                            </div>
                        </div>
                        <br>
                        <button id="salesrep_submit_btn" type="submit" class="btn btn-primary btn-round">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#salesrep_submit_btn').on('click', function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form_edit_salesrep = $("#form_edit_salesrep").serialize();
            $.ajax({
                url: "{{url('salesrep/update')}}/" + {{ $salesrep->salesrep_id }},
                method: 'PATCH',
                dataType: "JSON",
                data: form_edit_salesrep,
                success : function(response)
                {
                    if(response.status == true)
                    {
                        $('#salesrep_name').val(response.salesrep_name);
                        $('#commission_percent').val(response.commission_percent);
                        $('#tax_rate').val(response.tax_rate);
                        Swal.fire({
                            title: "Done!",
                            text: response.message,
                            type: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#007bff",
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
