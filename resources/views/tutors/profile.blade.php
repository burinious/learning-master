<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
?>

@extends('tutors.app')

@php($tutor_fullname = Query::getFullname('tutors',$the_tutor->id) )
                        
@section('title')
    E-learning |  Tutor | My Profile
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">My Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
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
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">

                        <div align="center">
                            <div class="align-self-center" align="center"> 
                                <br/>
                                @if($the_tutor->pix != "")
                                    <img src="/the_tutors/{{$the_tutor->pix}}" alt="user" class="img-responsive img-circle" style="max-width:300px;max-height: 300px"/>
                                @else 
                                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive img-circle" alt="user"/>
                                @endif <br/>
                                
                                <br/>
                                {{$tutor_fullname}}
                                <br/><br/>
                                tutor ID - {{$the_tutor->tutor_id}}
                                <p></p>
                                
                            </div><br/>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body"> 
                            <small class="text-muted">Email address </small>
                            <h6>{{$the_tutor->email}}</h6> 
                            <small class="text-muted p-t-30 db">Phone</small>
                            <h6>{{$the_tutor->phone}}</h6> 
                            <small class="text-muted p-t-30 db">Address</small>
                            <h6>{{$the_tutor->address}}</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">About me</a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="profile" role="tabpanel">
                                <div class="card-body">
                                    {{$the_tutor->about}}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- Column -->
            </div>
        </div>
    <br/><br/>
@endsection

