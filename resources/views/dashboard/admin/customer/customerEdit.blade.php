@extends('layoutsAdmin.app')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

@section('content')
<link rel="stylesheet" href="/styles.css">
<br>


<div class="content-wrapper">
<!-- Default box -->
<div class="card">
    <a class="btn btn-error btn-sm" href="/admin/CRUDcustomers" style="text-align: left;">
    <i class="fas fa-arrow-left"></i>Return</a>
      <h3 class="header" id="pet_name_id">Update Customer</h3>
      <br>
     
    <!-- Main content -->
    <form action="/admin/CRUDcustomers/Edit/{{ $vetcust_id->customer_id }}/Save" method="post" id="editCustomerForm">
@csrf
    <table class="table table-striped table-hover">
  <thead>
      @if ($vetcust_id)
          
      <input type="hidden" value="{{ $vetcust_id->customer_id }}">
    <tr>
        <td >
            <div class="form-group" style="width: auto">
                <label>First Name</label>
                <input type="text"  class="form-control" value="{{ $vetcust_id->customer_fname }}" id="customer_fname" name="customer_fname"  placeholder="Enter First Name">
                <span class="text-danger error-text customer_fname_error">@error('customer_fname'){{ $message }}@enderror</span>
            </div>
        </td>

            <td >
                <div class="form-group" style="width: auto">
                    <label>Last Name</label>
                    <input type="text"  value="{{ $vetcust_id->customer_lname }}" class="form-control" id="customer_lname" name="customer_lname"  placeholder="Enter Last Name">
                    <span class="text-danger error-text customer_lname_error">@error('customer_lname'){{ $message }}@enderror</span>
                </div>
            </td>

            <td>
                <div class="form-group" style="width: auto">
                    <label>Middle Name</label>
                    <input type="text"  value="{{ $vetcust_id->customer_mname }}" class="form-control" id="customer_mname" name="customer_mname" aria-describedby="emailHelp" placeholder="Enter Middle Name">
                    <span class="text-danger error-text customer_mname_error">@error('customer_mname'){{ $message }}@enderror</span>
                </div>
            </td>
            <td>
                <div class="form-group" style="width: auto">
                    <label>Mobile</label>
                    <input type="number" class="form-control" value="{{ $vetcust_id->customer_mobile }}"  id="customer_mobile" name="customer_mobile" aria-describedby="emailHelp" placeholder="Enter Mobile No">
                    <span class="text-danger error-text customer_mobile_error">@error('customer_mobile'){{ $message }}@enderror</span>
                </div>
            </td>
        
    </tr>
    <tr>
        <td>
            <div class="form-group" style="width: auto">
                <label>Telephone</label>
                <input type="number" class="form-control" value="{{ $vetcust_id->customer_tel }}"  id="customer_tel" name="customer_tel" placeholder="Enter Telephone">
                <span class="text-danger error-text customer_tel_error">@error('customer_tel'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>Gender</label>
                <select id="customer_gender" class="form-control custom-select" name="customer_gender">
                  @if ($vetcust_id->customer_gender=="Male")
                  <option value="Male" selected>Male</option>
                  <option value="Female">Female</option>
                  @elseif ($vetcust_id->customer_gender=="Female")
                  <option value="Female" selected>Female</option>
                  <option value="Male">Male</option>
                  @endif
                </select>
                <span class="text-danger error-text customer_gender_error">@error('customer_gender'){{ $message }}@enderror</span>
              </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label required class="form-label">Birthdate</label>
                <br>
                <div class="">
                  <input type="date" class="form-control" value="{{ $vetcust_id->customer_birthday }}" id="customer_birthday" name="customer_birthday">
                  <span class="text-danger error-text customer_birthday_error">@error('customer_birthday'){{ $message }}@enderror</span>
                </div>
              </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>House Block/Building/Floor No.</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_blk }}" name="customer_blk" id="customer_blk"  placeholder="Enter Address">
                <span class="text-danger error-text customer_blk_error">@error('customer_blk'){{ $message }}@enderror</span>
            </div>
        </td>
    </tr>
    <tr>
        
        <td>
            <div class="form-group" style="width: auto">
                <label>Street/Highway</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_street }}" name="customer_street" id="customer_street" placeholder="Enter Address">
                <span class="text-danger error-text customer_street_error">@error('customer_street'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>Subdivision</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_subdivision }}" name="customer_subdivision" id="customer_subdivision"  placeholder="Enter Address">
                <span class="text-danger error-text customer_subdivision_error">@error('customer_subdivision'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>Barangay</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_barangay }}" name="customer_barangay" id="customer_barangay" placeholder="Enter Address">
                <span class="text-danger error-text customer_barangay_error">@error('customer_barangay'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>City</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_city }}" name="customer_city" id="customer_city"  placeholder="Enter Address">
                <span class="text-danger error-text customer_city_error">@error('customer_city'){{ $message }}@enderror</span>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="form-group" style="width: auto">
                <label>Zip Code</label>
                <input type="text" class="form-control" value="{{ $vetcust_id->customer_zip }}" name="customer_zip" id="customer_zip" placeholder="Enter Addres">
                <span class="text-danger error-text customer_zip_error">@error('customer_zip'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto">
                <label>Active</label>
                <select id="isActive" class="form-control custom-select" name="isActive">
                  @if ($vetcust_id->customer_isActive == 1)
                  <option value="1" selected>Yes</option>
                  <option value="0">No</option>
                  @elseif ($vetcust_id->customer_isActive == 0)
                  <option value="0" selected>No</option>
                  <option value="1">Yes</option>
                  @else
                  
                  @endif
                  
                  
                </select>
              </div>
        </td>
    </tr>
    @endif
  </thead>
</table>

<div style="">
    <button type="submit" class="btn btn-success btn-lg" style=" height: 50%;"> <i class="fas fa-save"></i> Save Changes </a></button>

   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

<script>
$("document").ready(function(){
  setTimeout(function(){
    $("#messageModal").remove();
  }, 3000 );
});
</script>


<script>
  $().ready(function() {
    // validate signup form on keyup and submit
    $("#editCustomerForm").validate({
      rules: {
        customer_fname: { required: true, minlength: 2 },
        customer_lname: { required: true, minlength: 2 },
        customer_mname: { required: true, minlength: 2 },
        customer_mobile: { required: true, minlength: 9, maxlength: 13 },
        customer_tel: { required: true, minlength: 9, maxlength: 13 },
        customer_birthday: { required: true},
        customer_barangay: { required: true, minlength: 2, maxlength: 20},
        customer_city: { required: true, minlength: 2, maxlength: 20},
        customer_zip: { required: true, minlength: 4, maxlength: 5}},
      messages: {
        customer_fname: { required: "Please provide first name", minlength: "Your clinic must consist of at least 2 characters"},
        customer_lname: { required: "Please provide last name"},
        customer_mname: { required: "Please provide middle name"},
        customer_mobile: { required: "Please provide Mobile No.", minlength: "Must be at least 9 characters long", maxlength: "Must not exceed 10 characters long"},
        customer_tel: { required: "Please provide Tel No."},
        customer_birthday: { required: "Please pick birthdate"},
        customer_barangay: { required: "Please provide barangay", minlength: "Must have 2 characters", maxlength: "Max of 20 characters" },
        customer_city: { required: "Please provide City", minlength: "Must have 2 characters", maxlength: "Max of 20 characters"},
        customer_zip: { required: "Please provide ZIP address", minlength: "Must have 4 characters", maxlength: "Max of 5 characters"}
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

<script>
$('.feet').on('click', function(e){
    e.preventDefault();
    $(#formSubmit).on('submit', function())
});
</script>

@endsection