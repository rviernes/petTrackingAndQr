@extends('layoutsAdmin.app')
@section('content') 
@csrf 
<link rel="stylesheet" href="/styles.css">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <br>

    

  <div class="card" style="width: auto; margin-left:20px; margin-right:20px; text-align: center; padding: 20px;"> 
    @csrf 
    <div class="card-header">
    <h3 class="card-title" id="pet_name_id">Customer</h3>
    <form action="{{ route('admin.custsearch') }}" method="get">
      <div class="float-right">  
        <input type="search" class="form-control rounded" placeholder="Search by Name" name="custsearch" id="custsearch" style="width: 200px;"/>
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
      </div>
    </form>
  </div>
    <!-- Main content -->

    <div class="card-body table-responsive p-0" id="CRUDclinic">
    <table class="table table-striped table-valign-middle">
      <thead>
        <tr>
          <th style="width:15%"> Name</th>
          <th style="width:9%">Mobile</th>
          <th style="width:9%">Telephone</th>
          <th style="width:7%">Gender</th>
          <th style="width:7%">Birthday</th>
          <th style="width:25%">Address</th>
          <th style="width:8%">Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody> 
        @foreach ($customers as $customer) 
        <tr>
          <td>{{ $customer->customer_name}}</td>
          <td>{{ $customer->customer_mobile}}</td>
          <td>{{ $customer->customer_tel}}</td>
          <td>{{ $customer->customer_gender}}</td>
          <td>{{ $customer->customer_birthday}}</td>
          <td>{{ $customer->customer_address}}</td>
          @if ($customer->customer_isActive == 1) <td>
            <span class="badge badge-success">Yes</span>
          </td> @else <td>
            <span class="badge badge-danger">No</span>
          </td> @endif <td>
            <a href="/admin/customer/viewPatient/{{ $customer->customer_id}}" class="btn btn-primary btn-sm">
              <i class="fas fa-folder"></i>
            </a>
            <a href="/admin/customer/customerEdit/{{ $customer->customer_id }}" class="btn btn-info btn-sm">
              <i class="fas fa-pencil-alt"></i>
            </a>
            <button class="btn btn-danger btn-sm" id="delete" data-toggle="modal" data-target="#deleteModal{{ $customer->customer_id }}">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>

<!-- DELETE MODAL -->
        <div class="modal fade" id="deleteModal{{ $customer->customer_id }}" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action=" /admin/customer/delete/{{$customer->customer_id}} " method="GET">
                {{ csrf_field() }}
                <div class="modal-body">
                  <h3>Confirm deletion of user?</h3>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
                </div>
              </form>
            </div>
          </div>
        </div>
<!-- END DELETE MODAL -->
        @endforeach
      </tbody>
    </table>
      {{ $customers->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>
</div>


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="{{asset('vendors/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('vendors/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
      <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
  $("document").ready(function() {
    setTimeout(function() {
      $("#messageModal").remove();
    }, 2000);
  });
</script> 
</script>

@endsection