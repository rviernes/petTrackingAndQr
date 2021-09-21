
@extends('layoutsAdmin.app')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

@section('content')
<link rel="stylesheet" href="/styles.css">
<div class="content-wrapper">
  <br>

   
<!-- Default box -->
<div class="card" style="width: auto; margin-left:20px; margin-right:20px; text-align: center; padding: 10px">
      <a class="btn btn-error btn-sm" href="/admin/CRUDpettype" style="text-align: left;">
      <i class="fas fa-arrow-left"></i> Return </a>
      <h3 class="header" style="font-size: 300%">Edit Pet Type</h3><br>

    <!-- Main content -->
    <form action="/admin/pet/CRUDpettype/Edit/{{ $getID->id }}/Save" method="post">
@csrf
    <table class="table table-striped table-hover">
  <thead>
    <tr>
          <td>
            <input type="hidden" style="width: 300px" class="form-control" name="type_id" value="{{$getID->id}}" placeholder="Pet Type">
            <div class="form-group" style="width: 300px; text-align: center; margin: auto;">
                <label style=" margin-right: 220px;">Pet Type</label>
                <input type="text" style="width: 300px; text-align: center; margin: auto;" class="form-control" id="pettype" name="type_name" value="{{$getID->type_name}}" placeholder="Pet Type">
                <span class="text-danger error-text pet_type_error">@error('pettype'){{ $message }}@enderror</span>
            </div>
        </td>
            <div class="form-group" style="width: 300px; text-align: center; margin: auto;">
                <input type="hidden" name="pettype" value="3">
            </div>
    </tr>
   
  </thead>
</table>

<div style="">
    <button type="submit" class="btn btn-success btn-lg"> <i class="fas fa-save"></i> Save Changes </a></button>

   
</div>

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