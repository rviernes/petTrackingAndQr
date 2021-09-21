@extends('layoutsAdmin.app')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

@section('content')
<link rel="stylesheet" href="/styles.css">
<div class="content-wrapper">
  <br>

   
<!-- Default box -->
<div class="card">  
        <a class="btn btn-error btn-sm" href="/admin/CRUDpetbreed" id="returnName">
            <i class="fas fa-arrow-left">
            </i> Return
        </a>
      <h3 class="header" id="pet_name_id">Edit Pet Breed Name</h3>
    <!-- Main content -->
    <form action="/admin/pet/CRUDpetbreed/Edit/{{$getID->breed_id}}/Save" method="post">
    @csrf
    <table class="table table-striped table-hover">
      <thead>
        <tr>
              <td>
                <input type="hidden" class="form-control" name="breed_id" value="{{$getID->breed_id}}" placeholder="Pet Breed">
                <div class="form-group">
                    <label id="labelName2">Pet Breed: </label>
                    <input type="text" style="width: 300px" class="form-control" id="petbreed" name="breed_name" value="{{$getID->breed_name}}" placeholder="Pet Breed">
                </div>
            </td>
                <!-- <div class="form-group" style="width: 300px">
                    <input type="hidden" name="petbreed" value="3">
                  </div> -->
        </tr>
      </thead>
    </table> 

    <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-paw"></i> Save Changes </a></button>

   

</form>   

</div>

 

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
@endsection