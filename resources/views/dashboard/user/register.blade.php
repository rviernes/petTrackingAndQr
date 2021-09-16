


<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registration</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendors/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('vendors/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('vendors/dist/css/adminlte.min.css') }}">



    </head>
    <div class="card">
        <body class="hold-transition register-page">
            @if(Session::has('existing')) 
            <div class="alert alert-warning" role="alert" id="messageModal">
             {{ Session::get('existing') }}
           </div>
           @endif 
            <div class="register-box">
                <br>
                <h3 style="margin: 5%" class="header">Register new account for customer</h3>
                <br>
            </div>
            <!-- Main content -->
            <form class="cmxform" action="{{ route('user.validateregister') }}" method="POST" id="Register"> @csrf <table class="table table-striped table-hover">
                @csrf
                    <thead> <!-- This inserts into user_accounts table -->
                        <tr>
                            <input type="hidden" disabled style="width: 50px; border-color: white; background-color: white" class="form-control" name="userType_id" value="3">
                            <td>
                                <div class="form-group" style="">
                                    <label for="user_name">Username</label>
                                    <input type="text" style="width: 300px" class="form-control" id="user_name" name="user_name" placeholder="Enter username" value="{{ old('user_name') }}">
                    
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label style="red" for="user_password">Password</label>
                                    <input type="password" style="width: 300px;" class="form-control" id="user_password" name="user_password" value="{{ old('user_password')}}" placeholder="Enter password">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="user_mobile">Account Mobile</label>
                                    <input type="text" style="width: 300px" value="{{ old('user_mobile')}}" class="form-control" id="user_mobile" name="user_mobile" aria-describedby="emailHelp" placeholder="Enter mobile">
                                
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="user_email">Email</label>
                                    <input type="email" class="form-control" value="{{ old('user_email')}}" style="width: 300px" id="user_email" name="user_email" placeholder="Enter email">
                               
                                </div>
                            </td>
                          
                        </tr>
                        <tr>  <!-- This inserts into customers table -->
                            <td >
                                <div class="form-group">
                                    <label for="customer_fname">First Name</label>
                                    <input type="text" style="width: 300px" class="form-control" id="customer_fname" name="customer_fname"  placeholder="Enter First Name">
                                   
                                </div>
                            </td>
                    
                                <td >
                                    <div class="form-group">
                                        <label for="customer_lname">Last Name</label>
                                        <input type="text" style="width: 300px" class="form-control" id="customer_lname" name="customer_lname"  placeholder="Enter Last Name">
                                     
                                    </div>
                                </td>
                    
                                <td>
                                    <div class="form-group">
                                        <label for="customer_mname">Middle Name</label>
                                        <input type="text" style="width: 300px" class="form-control" id="customer_mname" name="customer_mname" aria-describedby="emailHelp" placeholder="Enter Middle Name">
                                     
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="customer_mobile">Mobile</label>
                                        <input type="number" class="form-control" style="width: 300px" id="customer_mobile" name="customer_mobile" aria-describedby="emailHelp" placeholder="Enter Mobile No">
                                 
                                    </div>
                                </td>
                            
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="customer_tel">Telephone</label>
                                    <input type="number" class="form-control" style="width: 300px" id="customer_tel" name="customer_tel" placeholder="Enter Telephone">
                                
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_gender">Gender</label>
                                    <select id="customer_gender" class="form-control custom-select" id="customer_gender" name="customer_gender">
                                      <option selected disabled>Choose Gender:</option>
                                      <option value="Female">Female</option>
                                      <option value="Male">Male</option>
                                    </select>
                             
                                  </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_birthday" class="form-label">Birthdate</label>
                                    <br>
                                    <div class="">
                                      <input type="date" class="form-control" id="customer_birthday" name="customer_birthday">
                                      
                                    </div>
                    
                                    
                                  </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_blk">House Block/Building/Floor No.</label>
                                    <input type="text" class="form-control" name="customer_blk" id="customer_blk"  placeholder="Enter Address">
                             
                                </div>
                            </td>
                        </tr>
                        <tr>
                            
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_street">Street/Highway</label>
                                    <input type="text" class="form-control" name="customer_street" id="customer_street" placeholder="Enter Address">
                             
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_subdivision">Subdivision</label>
                                    <input type="text" class="form-control" name="customer_subdivision" id="customer_subdivision"  placeholder="Enter Address">
                             
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="">Barangay</label>
                                    <input type="text" class="form-control" name="customer_barangay" id="customer_barangay" placeholder="Enter Address">
                           
                                </div>
                            </td>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_city">City</label>
                                    <input type="text" class="form-control" name="customer_city" id="customer_city"  placeholder="Enter Address">
                    
                                </div>
                            </td>
                        </tr>
                    
                        <tr>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <label for="customer_zip">Zip Code</label>
                                    <input type="text" class="form-control" name="customer_zip" id="customer_zip" placeholder="Enter Addres">
                        
                                </div>
                            </td>
                    
                        </tr>
                    </thead>
                </table>
              
                <div class="form-group">
                    <button type="submit" style="width: 200px; margin-left: 500px" class="btn btn-primary btn-block">Register</button>
                    <br>
                </div>
            </form>
      
    </div>
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms"> I agree to the <a href="#">terms</a>
                </label>
            </div>       
        </div>

        <!-- /.col -->
       
        <!-- /.col -->
    </div>
    <a href="{{ route('user.login') }}" class="text-center">I already have an account</a>
    <!-- /.register-box -->
    <script src="{{ asset('vendors/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendors/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendors/dist/js/adminlte.min.js') }}"></script>
 
    <script src="https://jqueryvalidation.org/files/lib/jquery-1.11.1.js"></script>
    <script src="https://jqueryvalidation.org/files/dist/jquery.validate.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script >
    
    $().ready(function() {
    
        $("#Register").validate({
            rules: {
                user_name: {
                    required: true,
                    maxlength: 20
                },
                user_password:{
                    required: true
                },
                user_mobile:{
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 11
                },
                user_email: {
                    required: true,
                    email: true
                },
                customer_fname: {
                    required: true
                },
                customer_lname: {
                    required: true
                },
                customer_mname: {
                    required: true
                },
                customer_mobile: {
                    required: true,
                    number: true,
                    minlength: 11,
                    maxlength: 11
                },
                customer_tel: {
                    required: true
                },
                customer_birthday: {
                    required: true
                },
                customer_gender: {
                    required: true
                },
                customer_blk: {
                    required: true
                },
                customer_street: {
                    required: true
                },
                customer_subdivision: {
                    required: true
    
                },
                customer_barangay: {
                    required: true
    
                },
                customer_city: {
                    required: true
    
                },
                customer_zip: {
                    required: true,
                    number: true
    
                }
            },
            messages: {
                user_name: {
                    required: "First name is required",
                    maxlength: "Max"
         
                },
                user_password: {
                    required: "Password is required"
                },
                user_mobile: {
                    required: "Phone number is required",
                    minlength: "Phone number must be of 11 digits"
                },
                user_email: {
                    required: "Email is required",
                    email: "Email must be a valid email address"
                },
                customer_fname: {
                    required: "first name is required"
                },
                customer_lname: {
                    required:  "Last name is required"
                },
                customer_mname: {
                    required:  "Middle name is required"
                },
                customer_mobile: {
                    required: "Phone number is required",
                    minlength: "Phone number must be of 11 digits"
                },
                customer_tel: {
                    required: "Address is required",
                    maxlength: "Telephone number must be of 11 digits"
                },
                customer_gender: {
                    required: "Gender is required"
                },
                customer_birthday: {
                    required: "Birthday is required"
                },
                customer_blk: {
                    required: "Blk is required"
                },
                customer_street: {
                    required: "Street is required"
                },
                customer_subdivision: {
                    required: "Subdivision is required"
                },
                customer_barangay: {
                    required: "Barangay is required"
                },
                customer_city: {
                    required: "City is required"
                },
                customer_zip: {
                    required: "Zip Code is required"
                }
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
    
    </body>

    @include('sweet::alert')
</html>