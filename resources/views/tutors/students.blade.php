<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use App\Appointments;
use URL;
?>

@extends('tutors.app')

@section('title')
    E-learning |  Tutor | Students
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Students</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </div>
        </div>    

        <div class="container-fluid">
                
                @if(session('error'))
                    <div class='alert alert-danger'>
                        <i class="fa fa-remove"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class='alert alert-success'>
                        <i class="fa fa-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if(Session::has('operation')) 
                    <div class='alert alert-success'>
                        <i class="fa fa-check"></i> {{ session('operation') }}
                    </div>
                @endif

                @php(Session::forget('operation'))

                <div class="row">
                    
                    @if($count_students == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No student yet </p>
                    @else
                        @foreach($students as $student)
                            @php($student_fullname = Query::getFullname('students',$student->id) )
                            
                            <div class="col-md-6 col-xlg-4">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xlg-4 text-center">
                                            <a href="students/profile/{{$student->id}}">
                                                @if($student->pix != "")
                                                    <img src="/the_students/{{$student->pix}}" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                @else 
                                                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xlg-4">
                                            <p></p><a href="students/profile/{{$student->id}}" class="text-primary" style="font-size:20px">{{$student_fullname}}</a>
                                            <p></p>  
                                            <p><i class="mdi mdi-cellphone"></i> {{$student->phone}}</p>
                                            <p><i class="mdi mdi-email-outline"></i> {{$student->email}}</p>
                                            <small> {{strtoupper($student->class)}} </small>
                                        </div> <br/><p></p>


                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>
    <br/><br/>
@endsection



