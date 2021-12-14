<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
?>

@extends('students.app')

@section('title')
    E-learning | Student | My Appointments
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">My Appointments</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">My Appointments</li>
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

            @if($count_appointments == 0)
                <p class="alert alert-danger" style="width:100%;text-align: center;"> You haven't booked any appointment </p>
            @else

                <div class="row">
                    <div style="margin:10px">
                        <div class="card-body">
                            <div class="card b-all shadow-none">
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Tutor</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                        @foreach($appointments as $key=>$appointment)
                                            @php($tutor_fullname = Query::getFullname("tutors",$appointment->tutor_id))

                                            <tr>
                                                <!-- <td>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="checkbox{{$key}}" value="check{{$appointment->id}}">
                                                        <label for="checkbox0"></label>
                                                    </div>
                                                </td> -->
                                                
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$tutor_fullname}}</td>
                                                <td>
                                                    <a href="/students/appointment/view/{{$appointment->id}}">
                                                    {{ucfirst(substr($appointment->title,0,50))}}
                                                    </a>
                                                </td>
                                                <td>{!! html_entity_decode(nl2br(substr($appointment->content,0,50))) !!} ...</td>
                                                <td>
                                                    @if($appointment->status == "0")
                                                        <small class='text-warning'> pending </small>
                                                    @elseif($appointment->status == "1")
                                                        <small class='text-info'> approved </small>
                                                    @else
                                                        <small class='text-danger'> declined </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{\Carbon\Carbon::createFromTimeStamp(strtotime($appointment->created_at))->diffForHumans()}} </small>
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                        {{$appointments->links()}}

                    </div>
                </div>
            @endif
        </div>
    <br/><br/>
@endsection

