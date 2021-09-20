@extends('layoutsCustomer.app')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> @section('content') <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <h4> PETS </h4>
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-grey">
                                <h1 class="widget-user-username"></h1>
                            </div>
                             
                            
                @foreach ($petinfo as $info)
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link"> Name: <span class="float-right">{{$info->pet_name}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"> Birthday: <span class="float-right "></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"> Gender: <span class="float-right "></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"> Bloodtype: <span class="float-right "></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"> Date Registered: <span class="float-right"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"> Notes: <span class="float-right "></span>
                                        </a>
                                    </li>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    @endforeach
                    <!-- /.col -->
                </div>
                <div class="card-footer">
                    <nav aria-label="Contacts Page Navigation">
                        <ul class="pagination justify-content-center m-0">
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /.card-footer -->
                <!-- /.row --> @endsection
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