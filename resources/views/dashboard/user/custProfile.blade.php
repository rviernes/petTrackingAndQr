@extends('layoutscustomer.app')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> @section('content') <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Profile</h1>
                </div>
            
            <!-- Profile Image -->
          
            <!-- <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{$LoggedUserInfo->customer_DP }}"
                       alt="image">
                </div>
              <br>  -->
<!-- 
               <h5 style="text-align: center">{{ $LoggedUserInfo->customer_fname }} {{ $LoggedUserInfo->customer_mname }} {{ $LoggedUserInfo->customer_lname }} </h5> 

              <br>
              <a href="custAcc" class="btn btn-primary btn-block"><b>Edit Profile </b></a>
            </div>
        </div> -->
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- update -->
                    <div class="text-success alert-block text-center" id="update-success">
                        <strong></strong>
                    </div>
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ $LoggedUserInfo->customer_DP }}}" alt="Profile Pic">
                            </div>
                            <br>
                            <h5 style="text-align: center">{{ $LoggedUserInfo->customer_fname }} {{ $LoggedUserInfo->customer_mname }} {{ $LoggedUserInfo->customer_lname }} </h5>
                            <br>
                            <a href="custAcc" class="btn btn-primary btn-block">
                                <b>Edit Profile </b>
                            </a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#listofpets" data-toggle="tab">Customer Details</a>
                                </li>
                                <!-- <li class="nav-item"><a class="nav-link" href="#change_password" data-toggle="tab">Change Password </a></li> -->
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">First Name</label>
                                                    <h5>{{ $LoggedUserInfo->customer_fname }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Last Name</label>
                                                    <h5>{{ $LoggedUserInfo->customer_lname }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Middle Name</label>
                                                    <h5>{{ $LoggedUserInfo->customer_mname }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Gender </label>
                                                    <h5>{{ $LoggedUserInfo->customer_gender}}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Mobile </label>
                                                    <h5>{{ $LoggedUserInfo->customer_mobile }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Telephone </label>
                                                    <h5>{{ $LoggedUserInfo->customer_tel}}</h5>
                                                </div>
                                            </td>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Blk no. </label>
                                                    <h5>{{ $LoggedUserInfo->customer_blk }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Street. </label>
                                                    <h5>{{ $LoggedUserInfo->customer_street }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Subdivision </label>
                                                    <h5>{{ $LoggedUserInfo->customer_subdivision }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Barangay </label>
                                                    <h5>{{ $LoggedUserInfo->customer_barangay }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">City </label>
                                                    <h5>{{ $LoggedUserInfo->customer_city }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="">Zip </label>
                                                    <h5>{{ $LoggedUserInfo->customer_zip }}</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="col-md-4"></div>
                                <!-- /.col -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div> @endsection
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>