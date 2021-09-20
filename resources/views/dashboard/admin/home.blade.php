@extends('layoutsAdmin.app')

@section('content')

@include('sweet::alert')



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    
<div class="card card-success">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-4">
        <div class="card mb-2 bg-gradient-dark">
          <img class="card-img-top" src="{{asset('vendors/dist/img/dogcat.jpg') }}" alt="Dist Photo 1">
          <div class="card-img-overlay d-flex flex-column justify-content-end">
            <p class="card-text text-grey pb-2 pt-1">Never believe that animals suffer less than humans. Pain is the same for them that it is for us. Even worse, because they cannot help themselves.</p>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-4">
        <div class="card mb-2">
          <img class="card-img-top" src="{{asset('vendors/dist/img/dogcat1.jpeg') }}" alt="Dist Photo 2">
          <div class="card-img-overlay d-flex flex-column justify-content-center">

      
          
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-4">
        <div class="card mb-2">
          <img class="card-img-top" src="{{asset('vendors/dist/img/dogcat2.jpeg') }}" alt="Dist Photo 3">
          <div class="card-img-overlay">
            <p class="card-text pb-1 pt-1 text-white">
              If having a soul means being able to <br>
              feel love and loyalty and gratitude, then <br>
              animals are better off than a lot of humans. </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- {{-- Main content  --}} -->
<div class= "content">
<div class= "containter-fluid">
    <div class="row">
        <div class="col-sm-12">
            <!-- Main content -->



            
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $countVeterinarians }}</h3>
  
                  <p>Veterinarians</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="/admin/CRUDvet" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $countPet }}<sup style="font-size: 20px"></sup></h3>
  
                  <p>Pets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="/admin/CRUDpet" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$countCustomers}}</h3>
  
                  <p>Customers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="/admin/CRUDcustomers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ $countClinic }}</h3>
  
                  <p>Clinic</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="/admin/CRUDclinic" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
          </div>
          <!-- /.row -->


        </div>
    </div>
</div>
</div>
</div>

<div class="card">
  <div class="card-header border-0">
    <h3 class="card-title">New Patients</h3>
    <div class="card-tools">
      <a href="#" class="btn btn-tool btn-sm">
        <i class="fas fa-download"></i>
      </a>
      <a href="#" class="btn btn-tool btn-sm">
        <i class="fas fa-bars"></i>
      </a>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-striped table-valign-middle">
      <thead>
      <tr>


        <th>Name</th>
        <th>Gender</th>
        <th>Pet Type</th>
        <th>Status</th>
        <th>More</th>
        
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>
          <img src="{{asset('vendors/dist/img/askal.jpg') }}" class="img-circle img-size-32 mr-2">
          Vincent
          <span class="badge bg-danger">NEW</span>
        </td>
        <td>Male</td>
        <td>
          <small class="text-success mr-1">
            
          </small>
          Askal
        </td>

        <td class="project-state">
          <span class="badge badge-success">Yes</span>
      </td> 
        
        <td>
          <a href="#" class="text-muted">
            <i class="fas fa-search"></i>
          </a>
        </td>
      </tr>

      <tr>
        <td>
          <img src="{{asset('vendors/dist/img/chiwawa.jpg') }}" class="img-circle img-size-32 mr-2">
          Shayna
          <span class="badge bg-danger">NEW</span>
        </td>
        <td>Male</td>
        <td>
          <small class="text-success mr-1">
          </small>
         Chiwawa
        </td>

        <td class="project-state">
          <span class="badge badge-success">Yes</span>
      </td> 
        
        <td>
          <a href="#" class="text-muted">
            <i class="fas fa-search"></i>
          </a>
        </td>
      </tr>
      <tr>
        <td>
          <img src="{{asset('vendors/dist/img/labrador.jpg') }}" class="img-circle img-size-32 mr-2">
          Russel
          <span class="badge bg-danger">NEW</span>
        </td>
        <td>Male</td>
        <td>
          <small class="text-success mr-1">
            
          </small>
          Labrador
        </td>

        <td class="project-state">
          <span class="badge badge-success">Yes</span>
      </td> 
        
     
        
        <td>
          <a href="#" class="text-muted">
            <i class="fas fa-search"></i>
          </a>
        </td>
      </tr>
      </tbody>
    
    </table>
    
  </div>
</div>
<!-- /.card -->

<div class="col-md-6">
  <!-- USERS LIST -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Latest Veterinarians</h3>

      <div class="card-tools">
        <span class="badge badge-danger">4 New Members</span>
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <ul class="users-list clearfix">
        <li>
          <img src="{{asset('vendors/dist/img/rus.jpg') }}" alt="User Image">
          <a class="users-list-name" href="#">Vincent Lagria</a>
          <span class="users-list-date">Today</span>
        </li>
        <li>
          <img src="{{asset('vendors/dist/img/soy.jpg') }}" alt="User Image">
          <a class="users-list-name" href="#">Russel Viernes</a>
          <span class="users-list-date">Yesterday</span>
        </li>
        <li>
          <img src="{{asset('vendors/dist/img/kang.jpg') }}" alt="User Image">
          <a class="users-list-name" href="#">Ericka Esleta</a>
          <span class="users-list-date">12 Jan</span>
        </li>
        <li>
          <img src="{{asset('vendors/dist/img/shayn.jpg') }}" alt="User Image">
          <a class="users-list-name" href="#">Shayna Goles</a>
          <span class="users-list-date">12 Jan</span>
        </li>
        
      </ul>
      <!-- /.users-list -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer text-center">
      <a href="/admin/vet/CRUDvet">View All Users</a>
    </div>
    <!-- /.card-footer -->
  </div>
  <!--/.card -->
</div>
<!-- /.col -->


</section>
<!-- /.content -->


</div>
<!-- /.col -->


</div><!-- /.container-fluid -->


</div> 

{{-- end whole --}}
@endsection