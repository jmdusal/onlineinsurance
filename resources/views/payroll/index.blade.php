@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Payroll PDF</div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        
                        <table id="basic-btn" class="table table-condensed payroll_datatable">
                            <thead>
                                <tr>
                                    <th>Salesrep Name</th>
                                    <th>Date Period</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    
    $(document).ready(function(){
        
        
        $('.payroll_datatable').DataTable({
            ajax: "{{ route('payroll.datatable') }}",
            serverSide: true,
            columns: [
            {data: 'salesrep_name', sortable: true},
            {data: 'date_period', sortable: true},
            {
                'className': "action",
                'data' : 'payroll_id',
                'render' : function(payroll_id){
                    
                    return '<a href="{{ url('payroll/pdf') }}/'+payroll_id+'"><i style="color:green;" class="fa fa-fw fa-file-pdf-o"></i></a>&ensp;<a href="{{ url('payroll/edit') }}/'+payroll_id+'"><i class="fa fa-fw fa-edit"></i></a>&ensp;<a href="javascript:void(0)" onclick="delete_payroll(\''+payroll_id+'\');"><i style="color:red;" class="fa fa-fw fa-trash"></i></a>';
                },
                'sortable': false}
                ],
                searching   : true,
                ordering    : true,
                info        : true,
                autoWidth   : false,
                cache 		: false,
                lengthChange: true
            });
        });
        
        
        
        function delete_payroll(payroll_id){
            
            Swal.fire({
                title: "Are you sure to remove this?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancel",
                confirmButtonText: "Yes, remove it!",
            }).then(function (e)
            {
                if (e.value === true)
                {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    // var delete_user_url = base_url + 'user/destroy/' + id;
                    
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('payroll/destroy') }}/"+ payroll_id,
                        data: { _token: CSRF_TOKEN },
                        dataType: 'JSON',
                        cache: false,
                        error: function (xhr, status, errorThrown)
                        {
                            xhr.status;
                            console.log(xhr.responseText);
                        },
                        success: function (results)
                        {
                            if (results.success === true)
                            {
                                Swal.fire({
                                    title: "Done!",
                                    text: results.message,
                                    type: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#007bff",
                                    
                                });
                                
                                $('.payroll_datatable').DataTable().ajax.reload(null, false);
                                
                            }
                            else
                            {
                                Swal.fire({
                                    title: "Error!",
                                    text: results.message,
                                    type: "error",
                                    showConfirmButton: true
                                });
                                
                                setTimeout(function(){
                                    location.reload(true);
                                }, 1000);
                            }
                        }
                    });
                    
                }
                else
                {
                    e.dismiss;
                }
            }, function (dismiss)
            {
                return false;
            })
        }
        
        
        
        
        
    </script>
    @endsection
    