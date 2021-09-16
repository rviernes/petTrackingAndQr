@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')

<center>
<form action="{{ route('add.name') }}" method="post">
        @csrf
        <input type="text" id="fname" name="fname" title="Enter First Name"/>
        <br><br>
        <input type="text" id="mname" name="mname" title="Enter Middle Name"/>
        <br><br>
        <input type="text" id="lname" name="lname" title="Enter Last Name"/>
        <br><br>

        <button type="submit">SUBMIIIIIIIIIIIIIIT</button>
    </form>

@endsection