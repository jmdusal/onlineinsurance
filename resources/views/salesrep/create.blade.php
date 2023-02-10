@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Add Salesrep Profile</div>
                
                <div class="card-body">
                    
                    <form name="form_create_salesrep" id="form_create_salesrep" action="javascript:void(0)">
                        @csrf
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Fullname</label>
                            <div class="col-sm-6">
                                <input type="text" name="salesrep_name" id="salesrep_name" class="form-control" placeholder="Enter fullname" required>
                            </div>
                        </div>
                        <hr>
                        
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Commission Percentage (0-100%)</label>
                            <div class="col-sm-6">
                                <input type="number" min="0" max="100" name="commission_percent" id="commission_percent" class="form-control" placeholder="0%" onkeyup="if(parseInt(this.value)>100){ this.value =100; return false; }" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-5 col-form-label">Tax Rate (0-100%)</label>
                            <div class="col-sm-6">
                                <input type="number" min="0" max="100" name="tax_rate" id="tax_rate" class="form-control" placeholder="0%" onkeyup="if(parseInt(this.value)>100){ this.value =100; return false; }" required>
                            </div>
                        </div>
                        <br>
                        <br>
                        <button id="salesrep_submit_btn" type="submit" class="btn btn-primary btn-round">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#salesrep_submit_btn').on('click', function(){
            
            if($('#form_create_salesrep').length > 0){
                
                let salesrep_name = $('#salesrep_name').val();
                let commisssion_percent = $('#commisssion_percent').val();
                let tax_rate = $('#tax_rate').val();
                let form = $('#form_create_salesrep').serialize();
                let create_url = base_url + 'salesrep/store';
                $.ajax({
                    url: "{{ route('salesrep.store') }}",
                    method: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    data: form,
                    salesrep_name: salesrep_name,
                    commisssion_percent: commisssion_percent,
                    tax_rate: tax_rate,
                    success : function(response){
                        // response = JSON.parse(response);
                        if(response.status == true){
                            Swal.fire({
                                title: "Done!",
                                text: response.message,
                                type: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#007bff",
                            });
                            document.getElementById("form_create_salesrep").reset();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
