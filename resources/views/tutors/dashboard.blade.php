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

@section('title')
    E-learning | Tutors Dashboard
@endsection

@section('content')
    @php($tutor_fullname = Query::getFullname('tutors',$the_tutor->id) )

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>    

        <div class="container-fluid">
                <h2> Welcome back, {{$tutor_fullname}} </h2>
                <br/>
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
                
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div>
                            <div class="card-body bg-inverse" style="background-color:#4CAF50">
                                <h4 class="text-white card-title">Recently uploaded materials</h4>
                            </div>

                            @if($count_materials == 0)
                                <br/><p class="text-danger" style="width:100%;text-align: center;"> No material yet </p>
                            @else
                                <ul class="feeds">
                                
                                    @foreach($materials as $material)
                                        @php($student_fullname = Query::getFullname('students',$material->student_id))
                                        
                                        @php($subject = Query::getValue('subjects','id',$material->subject_id,'name'))

                                        <li>
                                            <div class="bg-info" style="color:#fff;padding:5px;font-size:18px">{{$loop->iteration}}</div> 
                                            
                                            {{ucfirst($material->title)}}

                                            <p style="margin-left:50px">
                                                <a href="/the_materials/{{$material->path}}">{{ucfirst($material->path)}}</a> 
                                                <br/>
                                                <small style='font-size:13px'>{{$subject}} &nbsp; &nbsp;  {{$student_fullname}} &nbsp; &nbsp; {{$material->size}}</small> <br/> 

                                                <span class="text-muted">{{\Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans()}}</span>
                                                <br/>
                                            </p><hr/>
                                        </li>
                                    @endforeach
                                    <div align="center">
                                        <a href="{{ route('tutorMaterials') }}" class="btn btn-sm btn-primary btn-rounded" type="button">All materials <i class="fa fa-arrow-circle-right"></i></a>
                                    </div> <br/>
                                @endif
                            </ul>
                        </div>
                    </div><br/><br/>
                </div>
                
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body bg-inverse" style="background-color:#4CAF50">
                            <h4 class="text-white card-title">Recently uploaded assignments</h4>
                        </div>
                        <div class="card m-b-0">
                            <div class="card-body">
                                
                                @if($count_assignments == 0)
                                    <p class="text-danger" style="width:100%;text-align: center;"> No assignment yet </p>
                                @else
                                    <ul class="feeds">

                                        @foreach($assignments as $assignment)
                                            @php($tutor_fullname = Query::getFullname('tutors',$assignment->tutor_id))
                                           
                                           @php($subject = Query::getValue('subjects','id',$assignment->subject_id,'name'))
                                            
                                            <li>
                                                <div class="bg-primary" style="color:#fff;padding:5px;font-size:18px">{{$loop->iteration}}</div> 
                                                 
                                                {{ucfirst($assignment->title)}}

                                                <p style="margin-left:50px">
                                                    <a href="/the_assignments/all/{{$assignment->path}}">{{ucfirst($assignment->path)}}</a> <br/>

                                                     <small style='font-size:13px'>{{$subject}} &nbsp; &nbsp;  {{$student_fullname}} &nbsp; &nbsp; {{$assignment->size}}</small> <br/>
                                                
                                                    <span class="text-muted">{{\Carbon\Carbon::createFromTimeStamp(strtotime($assignment->created_at))->diffForHumans()}}</span>
                                                    <br/>
                                                    <button class="btn btn-sm btn-info btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#SubmitSolutionModal{{$assignment->tutor_id}}">View solution</button>
                                                    <br/>
                                                </p><hr/>
                                            </li>
                                        @endforeach

                                        <div align="center">
                                            <a href="{{ route('tutorAssignments') }}" class="btn btn-sm btn-primary btn-rounded" type="button">All assignments <i class="fa fa-arrow-circle-right"></i></a>
                                        </div> <br/>
                                    </ul>
                                @endif
                            </div>
                        </div>
                        
                    </div>

                </div>

                <br/>

        </div>
    </section>
    <br/><br/>
@endsection

