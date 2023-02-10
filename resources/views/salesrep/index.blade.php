@extends('layouts.app')

@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        
                        <table id="basic-btn" class="table table-condensed salesrep_datatable">
                            <thead>
                                <tr>
                                    <th>ID #</th>
                                    <th>Name</th>
                                    <th>Commission Percentage</th>
                                    <th>Tax Rate</th>
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
        
        $('.salesrep_datatable').DataTable({
            ajax: "{{ route('salesrep.datatable') }}",
            serverSide: true,
            columns: [
            {data: 'salesrep_num', sortable: true},
            {data: 'salesrep_name', sortable: true},
            
            { data: function (data, type, dataToSet) {
                return data.commission_percent+"%";
            }},
            { data: function (data, type, dataToSet) {
                return data.tax_rate+"%";
            }},
            {
                'className': "action",
                'data' : 'salesrep_id',
                'render' : function(salesrep_id) {
                    return '<a href="{{ url('salesrep/edit') }}/'+salesrep_id+'"><i class="fa fa-fw fa-edit"></i></a>&ensp;<a href="javascript:void(0)" onclick="delete_salesrep(\''+salesrep_id+'\');"><i style="color:red;" class="fa fa-fw fa-trash"></i></a>';
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
    </script>
    <script type="text/javascript">
        function delete_salesrep(salesrep_id){
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
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('salesrep/destroy') }}/"+ salesrep_id,
                        data: { _token: CSRF_TOKEN },
                        dataType: 'JSON',
                        cache: false,
                        error: function (xhr, status, errorThrown)
                        {
                            // Here the status code can be retrieved like;
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
                                $('.salesrep_datatable').DataTable().ajax.reload(null, false);
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
    