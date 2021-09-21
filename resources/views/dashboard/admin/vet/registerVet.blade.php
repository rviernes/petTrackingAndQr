@extends('layoutsAdmin.app')

@section('content')

@include('sweet::alert')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="../lib/jquery.js"></script>
<script src="https://jqueryvalidation.org/files/lib/jquery-1.11.1.js"></script>
<script src="../dist/jquery.validate.js"></script>

<script>
  $().ready(function() {
    // validate signup form on keyup and submit
    $("#regVet").validate({
      rules: {
        user_name: { required: true, minlength: 2, maxlength: 15},
        user_mobile: { required: true, minlength: 9, maxlength: 13},
        user_password: { required: true, minlength: 5, maxlength: 35},
        user_email: { required: true, email: true },
        vet_fname: { required: true, minlength: 2, maxlength: 15},
        vet_lname: { required: true, minlength: 2, maxlength: 15},
        vet_mobile: { required: true, minlength: 9, maxlength: 13},
        vet_tel: { required: true, minlength: 9, maxlength: 13},
        vet_birthday: { required: true },
        vet_blk: { required: true, maxlength: 50},
        vet_street: { required: true, maxlength: 50},
        vet_subdivision: { required: true, maxlength: 50},
        vet_barangay: { required: true, maxlength: 50},
        vet_city: { required: true, maxlength: 50},
        vet_zip: { required: true, minlength: 4, maxlength: 8},
        vet_dateAdded: { required: true}
      },
      messages: {
        user_name: { required: "Please enter a username", minlength: "Your username must consist of at least 2 characters", maxlength: "Must not exceed 15 characters"},
        user_mobile: { required: "Please provide a mobile #", minlength: "Minimum of 9 characters", maxlength: "Must not exceed 13 characters"},
        user_password: { required: "Please provide a password", minlength: "Your password must be at least 5 characters long", maxlength: "Must not exceed 35 characters"},
        vet_fname: { required: "Please provide a First Name", minlength: "Name must be at least 2 characters long", maxlength: "Must not exceed 15 characters"},
        vet_lname: { required: "Please provide a Last Name", minlength: "Name must be at least 2 characters long", maxlength: "Must not exceed 15 characters"},
        vet_mobile: { required: "Please provide Mobile #", minlength: "Minimum of 9 characters", maxlength: "Must not exceed 13 characters"},
        vet_tel: { required: "Please provide Tel. #", minlength: "Minimum of 9 characters", maxlength: "Must not exceed 13 characters"},
        vet_birthday: { required: "Please provide Birthday"},
        vet_blk: { required: "Please provide Blk. Address", maxlength: "Must not exceed 50 characters"},
        vet_street: { required: "Please provide Address", maxlength: "Must not exceed 50 characters"},
        vet_subdivision: { required: "Please provide Address", maxlength: "Must not exceed 50 characters"},
        vet_barangay: { required: "Please provide Address", maxlength: "Must not exceed 50 characters"},
        vet_city: { required: "Please provide Address", maxlength: "Must not exceed 50 characters"},
        vet_zip: { required: "Please provide ZIP", minlength: "Minimum of 4 characters", maxlength: "Must not exceed 8 characters"},
        vet_dateAdded: { required: "Please pick a date"},
        user_email: "Please enter a valid email address"
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

<div class="card" style="width: auto; margin-left:20px; margin-right:20px; text-align: center; padding: 20px;">
        <a class="btn btn-error btn-sm" href="/admin/clinic/CRUDclinic/home" style="margin-right: 3000px; padding-top: 10px; margin-left:10px">
            <i class="fas fa-arrow-left">
            </i>
            Return
        </a>
      <h3 class="header" id="pet_name_id" style="font-size: 300%; text-align: left;">Register Veterinary</h3>
      <br>
     
    <!-- Main content -->
    <form action="{{ route('admin.addveterinarian') }}" method="POST" id="regVet">
        @csrf

        <table class="table table-striped table-hover">
    <div class="card-body table-responsive p-0">    
  <thead>
    <tr>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Username: </label>
                <input type="text"  class="form-control" id="user_name" name="user_name" value="{{ old('user_name')}}" placeholder="Enter username">
                <div >
                    <span class="text-danger error-text user_name_error" id="messageModal">@error('user_name'){{ $message }}@enderror</span>
                </div>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Password: </label>
                <input type="password"  class="form-control" id="user_password" name="user_password" value="{{ old('user_password')}}" placeholder="Enter password">
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Account Mobile: </label>
                <input type="text"  value="{{ old('user_mobile')}}" class="form-control" id="user_mobile" name="user_mobile" aria-describedby="emailHelp" placeholder="Enter mobile">
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Email: </label>
                <input type="email" class="form-control" value="{{ old('user_email')}}"  id="user_email" name="user_email" placeholder="Enter email">
                <span class="text-danger error-text user_email_error" id="messageModal">@error('user_email'){{ $message }}@enderror</span>
            </div>
        </td>
    </tr>
    <tr>
        <td >
            <div class="form-group" style="width: auto; text-align: left;">
                <label>First Name:</label>
                <input type="text" class="form-control" id="vet_fname" name="vet_fname"  placeholder="Enter First Name">
                <span class="text-danger error-text customer_fname_error">@error('vet_fname'){{ $message }}@enderror</span>
            </div>
        </td>

            <td >
                <div class="form-group" style="width: auto; text-align: left;">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" id="vet_lname" name="vet_lname"  placeholder="Enter Last Name">
                    <span class="text-danger error-text customer_lname_error">@error('vet_lname'){{ $message }}@enderror</span>
                </div>
            </td>

            <td>
                <div class="form-group" style="width: auto; text-align: left;">
                    <label>Middle Name:</label>
                    <input type="text" class="form-control" id="vet_mname" name="vet_mname" aria-describedby="emailHelp" placeholder="Enter Middle Name">
                    <span class="text-danger error-text customer_mname_error">@error('vet_mname'){{ $message }}@enderror</span>
                </div>
            </td>
            <td>
                <div class="form-group" style="width: auto; text-align: left;">
                    <label>Mobile:</label>
                    <input type="text" class="form-control" id="vet_mobile" name="vet_mobile" aria-describedby="emailHelp" placeholder="Enter Mobile No">
                    <span class="text-danger error-text customer_mobile_error">@error('vet_mobile'){{ $message }}@enderror</span>
                </div>
            </td>
        
    </tr>
    <tr>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Telephone:</label>
                <input type="number" class="form-control" id="vet_tel" name="vet_tel" placeholder="Enter Telephone">
                <span class="text-danger error-text customer_tel_error">@error('vet_tel'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label for="date" required class="form-label">Birthdate:</label>
                <br>
                <div class="" style="width: auto; text-align: left;">
                  <input type="date" class="form-control" id="vet_birthday" name="vet_birthday">
                  <span class="text-danger error-text customer_birthday_error">@error('vet_birthday'){{ $message }}@enderror</span>
                </div>
              </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>House No.:</label>
                <input type="text" class="form-control" name="vet_blk" id="vet_blActive" placeholder="Enter House No.">
                <span class="text-danger error-text customer_street_error">@error('vet_street'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Street/Highway:</label>
                <input type="text" class="form-control" name="vet_street" id="vet_street" placeholder="Enter Address">
                <span class="text-danger error-text customer_street_error">@error('vet_street'){{ $message }}@enderror</span>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Subdivision:</label>
                <input type="text" class="form-control" name="vet_subdivision" id="vet_subdivision"  placeholder="Enter Address">
                <span class="text-danger error-text customer_subdivision_error">@error('vet_subdivision'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Barangay:</label>
                <input type="text" class="form-control" name="vet_barangay" id="vet_barangay" placeholder="Enter Address">
                <span class="text-danger error-text customer_barangay_error">@error('vet_barangay'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>City:</label>
                <input type="text" class="form-control" name="vet_city" id="vet_city"  placeholder="Enter Address">
                <span class="text-danger error-text customer_city_error">@error('vet_city'){{ $message }}@enderror</span>
            </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label>Zip Code: </label>
                <input type="text" class="form-control" name="vet_zip" id="vet_zip" placeholder="Enter Addres">
                <span class="text-danger error-text customer_zip_error">@error('vet_zip'){{ $message }}@enderror</span>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label for="date" required class="form-label">Date Added:</label>
                <br>
                <div class="">
                  <input type="date" class="form-control" id="vet_dateAdded" name="vet_dateAdded">
                  <span class="text-danger error-text customer_birthday_error">@error('vet_dateAdded'){{ $message }}@enderror</span>
                </div>
              </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label for="inputStatus">Clinic:</label>
                @foreach($clinicInfo as $idGetter)
                    @if($idGetter->clinic_id == $vetInfo->clinic_id)
                    <input class="form-control" id="" name="" value="{{ $vetInfo->clinic_name}}" disabled>
                    @endif
                @endforeach
              </div>


                
                <select id="clinic_id" class="form-control custom-select" name="clinic_id" hidden="">
                    <option value="{{ $vetInfo->clinic_id }}">{{ $vetInfo->clinic_name}}</option>
                  </select>
                      


        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label for="inputStatus">Active:</label>
                <select id="vet_isActive" class="form-control custom-select" name="vet_isActive">
                  <option selected disabled>is this Veterinarian Active?</option>
                  <option value="1" default>Yes</option>
                  <option value="0">No</option>
                </select>
                <span class="text-danger error-text isActive_error">@error('isActive'){{ $message }}@enderror</span>
              </div>
        </td>
        <td>
            <div class="form-group" style="width: auto; text-align: left;">
                <label for="inputdp">Vet Profile:</label>
                <br>
                <form action="/action_page.php">
                  <input type="file" id="vet_DP" name="vet_DP">
              </div>
        </td>
    </tr>
  </thead>
</table>

<div style="padding-bottom: 20px">
    <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-save"></i> Register Veterinary</button>
</div>

</div>
</form>   

</div>
<script>
  $("document").ready(function() {
    setTimeout(function() {
      $("#messageModal").remove();
    }, 3000);
  });
</script>


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