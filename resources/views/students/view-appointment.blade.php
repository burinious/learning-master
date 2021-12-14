<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use App\Tutors;
use App\Appointments;
use URL;
?>

@extends('students.app')
                        
@section('title')
    E-learning | {{ucfirst($appointment->title)}}
@endsection

@section('content')

    @php($tutor_pix = Query::getValue("tutors","id",$appointment->tutor_id,"pix"))
    @php($tutor_phone = Query::getValue("tutors","id",$appointment->tutor_id,"phone"))
    @php($tutor_fullname = Query::getFullname('tutors',$appointment->tutor_id) )
                            	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ucfirst($appointment->title)}}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Appointment</li>
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
 
                <div class="card-body ">
                    <div class="card row">
                        <div class="card-body">
                            
                            <div class="d-flex m-b-40">
                                <div>
                                    <a href="/students/tutors/profile/{{$appointment->tutor_id}}">
                                        @if($tutor_pix != "")
                                            <img src="/the_tutors/{{$tutor_pix}}" class="img-circle" style="max-width:70px"  alt="user"/>
                                        @else 
                                            <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:70px" alt="user"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="p-l-10">
                                    <h4 class="m-b-0"><a href="/students/tutors/profile/{{$appointment->tutor_id}}">{{$tutor_fullname}} </a></h4> <p></p>

                                    <small class="text-muted"><i class="fa fa-phone"></i> {{$tutor_phone}}</small>
                                </div>
                            </div>
                            <p>{!! html_entity_decode(nl2br($appointment->content)) !!}</p>
                            
                            @if($appointment->status == "0")
                                <small class='text-warning'> Pending </small>
                            @elseif($appointment->status == "1")
                                <small class='text-info'> Approved </small>
                            @else
                                <small class='text-danger'> Declined </small>
                            @endif 
                            
                            &nbsp; <small>{{\Carbon\Carbon::createFromTimeStamp(strtotime($appointment->created_at))->diffForHumans()}} </small>
                        </div>
                        <div>
                            <hr class="m-t-0">
                        </div>
                        <h4 class="container"><i class="fa fa-envelope"></i> Responses </h4> <br/><br/>
                            
                        <div class="card-body">
                            
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var appointment = "{{$appointment->id}}";
                                    setInterval(function() {
                                        ajaxNoLoadingRequest("/students/appointment-chats/"+appointment,"#message_student_div{{$appointment->id}}","","GET","no");
                                    },3000);
                                });
                            </script>

                            <div id="message_student_div{{$appointment->id}}"></div>
                            <div id="refresh_div" style="display:none"><small> Loading new chat...... </small></div>

                            <br/>
                            <form class="form-horizontal" id="respond_appointment_form" method="POST" onsubmit="return false">
                                {{csrf_field()}}
                                
                                <div class="form-group">
                                    <br/><p></p>
                                    <textarea class="form-control" rows="10" name="message" placeholder="Type your message here"></textarea>
                                </div>

                                <button type="button" id="respond_appointment_btn" onclick="return ajaxFormRequest('#respond_appointment_btn','#respond_appointment_form','/students/respond-appointment/{{$appointment->id}}','POST','#respond_appointment_status','Send Message','no')" class="btn btn-info"><i class="fa fa-location-arrow"></i> Send Message</button>
                                <br/> <p></p>
                                <div id="respond_appointment_status"></div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                
        </div>
    <br/><br/>
@endsection

