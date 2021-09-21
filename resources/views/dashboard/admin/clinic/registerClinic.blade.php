@extends('layoutsAdmin.app')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 

@section('content') 
@include('sweet::alert')

<link rel="stylesheet" href="/styles.css">

<script>
  $().ready(function() {
    // validate signup form on keyup and submit
    $("#addClinicForm").validate({
      rules: {
        clinic_name: { required: true, minlength: 2, maxlength: 35 },
        owner_name: { required: true, minlength: 2, maxlength: 35},
        clinic_mobile: { required: true, minlength: 9, maxlength: 13},
        clinic_tel: { required: true,  minlength: 9, maxlength: 13},
        clinic_email: { required: true, email: true},
        clinic_blk: { required: true, maxlength: 50},
        clinic_street: { required: true, maxlength: 50},
        clinic_barangay: { required: true, maxlength: 50},
        clinic_city: { required: true, maxlength: 20},
        clinic_zip: { required: true, minlength: 4, maxlength: 8}},
      messages: {
        clinic_name: { required: "Input Clinic Name", minlength: "Min Char: 2 characters", maxlength: "Max Char: 35 characters"},
        owner_name: { required: "Input Owner Name", minlength: "Min Char: 2 characters", maxlength: "Max Char: 35 characters"},
        clinic_mobile: { required: "Input Mobile No.", minlength: "Min Char: 9 digits", maxlength: "Max Char: 13 digits"},
        clinic_tel: { required: "Input Tel No.", minlength: "Min Char: 9 digits", maxlength: "Max Char: 13 digits"},
        clinic_blk: { required: "Input blk.", maxlength: "Max Char: 13"},
        clinic_street: { required: "Input Street", maxlength: "Max Char: 50"},
        clinic_barangay: { required: "Input brngy.", maxlength: "Max Char: 50"},
        clinic_city: { required: "Input City", maxlength: "Max Char: 20"},
        clinic_zip: { required: "Input ZIP", minlength: "Min Char: 4", maxlength: "Max Char: 5" },
        clinic_email: { email: "Input Email", required: "Email Needed"}
      }
    });
  });
  </script>

  <style>
    label.error{
      color: #dc3545;
      font-size: 14px;
    }
  </style>
<div class="content-wrapper">
  <br>

  <div class="card">
      <a class="btn btn-error btn-sm" href="/admin/CRUDclinic" style="text-align: left;">
        <i class="fas fa-arrow-left"></i> Return </a>

      <div style="width: auto; text-align: left;">
        <br>
        <h3 style="font-size: 300% ">Register Clinic</h3>
      </div>

      <form action="/admin/CRUDclinic/register/save" method="POST" id="addClinicForm"> 
        @csrf 
        <table class="table table-striped table-hover">
        <thead>
          <tr>
              <td>
                <label>Clinic Name: </label>
                <input type="text" class="form-control" name="clinic_name" id="clinic_name" placeholder="Enter Clinic Name">
              </td>
              <td>
                <label>Owner Name: </label>
                <input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter Owner Name" >
              </td>
              <td>
                <label>Mobile No: </label>
                <input type="number" class="form-control" name="clinic_mobile" id="clinic_mobile" placeholder="Enter Telephone" >
              </td>
            </tr>
            <td>
                <label>Telephone: </label>
                <input type="number" class="form-control" name="clinic_tel" id="clinic_tel" placeholder="Enter Telephone" >
              </div>
            </td>
            <td>
                <label>Email: </label>
                <input type="email" class="form-control" name="clinic_email" id="clinic_email" placeholder="Enter Email" >
            </td>
            <td>
                <label>House Block/Building/Floor No.: </label>
                <input type="text" class="form-control" name="clinic_blk" id="clinic_blk" placeholder="House Block/Building/Floor No." >
            </td>
          <tr>
            <td>
                <label>Street/Highway: </label>
                <input type="text" class="form-control" name="clinic_street" id="clinic_street" placeholder="House Block/Building/Floor No." >
            </td>
            <td>
                <label>Barangay: </label>
                <input type="text" class="form-control" name="clinic_barangay" id="clinic_barangay" placeholder="Barangay" >
            </td>
            <td>
                <label>City: </label>
                <input type="text" class="form-control" name="clinic_city" id="clinic_city" placeholder="City" >
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-group">
                <label>Zip Code: </label>
                <input type="number" class="form-control" name="clinic_zip" id="clinic_zip" placeholder="Zip Code" >
            </td>
            <td>
                <label>Clinic Active: </label>
                <select name="clinic_isActive" id="clinic_isActive" class="form-control" >
                  <option value=1 selected=""> Yes </option>
                  <option value=0> No </option>
                </select>
            </td>
            <br>
          </tr>
        </thead>
      </table>
      <div>
        <button type="submit" class="btn btn-success btn-lg" style="width: 250px"><i class="fas fa-save"></i> Save Changes</button>
      </div>
    </form>
  </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script>
  $("document").ready(function() {
    setTimeout(function() {
      $("#messageModal").remove();
    }, 3000);
  });
</script> @endsection