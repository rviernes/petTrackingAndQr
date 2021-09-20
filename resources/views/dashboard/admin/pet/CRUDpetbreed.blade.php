@extends('layoutsAdmin.app')
@section('content')
@include('sweet::alert')

<link rel="stylesheet" href="/styles.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <br>

<div class="card" style="width: auto; margin-left:20px; margin-right:20px; text-align: center; padding: 20px;">
    <div class="card-header">
      <h3 class="card-title" id="pet_name_id">Breed List</h3>
      <form action="{{ route('admin.breedsearch') }}" method="get">
        <div class="float-right">
          <input type="search" class="form-control rounded" placeholder="Search by Breed" name="breedSearch" id="breedSearch" style="width: 200px;"/> 
          <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
          
          <a class="btn btn-success" title="Add Pet Breed" style="margin-left: 10px" href="/admin/pets/CRUDaddbreed">
          <i class="fas fa-dna"></i> Add Pet Breed</a>
        </div>
    </form>
</div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle">
        <thead>
        <tr>
        <th scope="col" >Pet Breed</th>
        <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody> @foreach ($typeBreed as $petbreed) <tr>
          <td hidden> {{ $petbreed->breed_id}}</td>
          <td> {{ $petbreed->breed_name}} </td>

          <td>
              <a href="/admin/pets/CRUDeditbreed/{{$petbreed->breed_id}}" title="Edit Breed Name" class="btn btn-info">
                <i class="fas fa-pencil-alt"></i></a>
              <button class="btn btn-danger" title="Delete Breed Name" data-toggle="modal" data-target="#deleteModal{{ $petbreed->breed_id }}">
                <i class="fas fa-trash"></i></button>
              </td>
            </tr>

            <!-- DELETE MODAL -->
            <div class="modal fade" id="deleteModal{{ $petbreed->breed_id }}" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Breed </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="/admin/pets/delete-breed/{{ $petbreed->breed_id }}" method="GET">
                    {{ csrf_field() }}
                    <div class="modal-body">
                      <h3>Confirm deletion of Breed Name, {{ $petbreed->breed_name }}?</h3>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endforeach 
        </tbody>
      </table>
      <div style="margin-left: 10px;">{{ $typeBreed->links('pagination::bootstrap-4') }}</div>
    </div>  
  </div>
</div>
</section>
  


 <!-- /.content -->
 </div>
  <!-- /.content-wrapper -->
</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  <script src="../../plugins/jquery/jquery.min.js"></script>

  <script>
    $("document").ready(function(){
      setTimeout(function(){
        $("#messageModal").remove();
      }, 3000 );
    });
  </script>


@endsection