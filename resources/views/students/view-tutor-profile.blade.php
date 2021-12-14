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
@php($tutor_fullname = Query::getFullname('tutors',$tutor->id) )
                        
@section('title')
    E-learning | {{$tutor_fullname}}'s Profile
@endsection

@section('content')
	@php($count_ratings = Query::countTheValues('ratings','tutor_id',$tutor->id))
    @php($tutor_rating = Query::tutorRating($tutor->id))

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{$tutor_fullname}}'s Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">{{$tutor_fullname}}'s Profile</li>
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
                                @if($tutor->pix != "")
                                    <img src="/the_tutors/{{$tutor->pix}}" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                @else 
                                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive img-circle" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                @endif <br/>
                                
                                <p></p>
                                @if($count_ratings == 0)
                                    <small class='text-danger'> No rating yet </small>
                                @else
                                    <i class="mdi mdi-star"></i> {{$tutor_rating}} 
                                @endif
                            </div><br/>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body"> <small class="text-muted">Email address </small>
                            <h6>{{$tutor->email}}</h6> <small class="text-muted p-t-30 db">Phone</small>
                            <h6>{{$tutor->phone}}</h6> <small class="text-muted p-t-30 db">Address</small>
                            <h6>{{$tutor->address}}</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#appointment" role="tab">Appointments</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#ratings" role="tab">Ratings</a> </li>                            
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="profile" role="tabpanel">
                                <div class="card-body">
                                    <h3> About {{$tutor_fullname}} </h3><hr/>
                                    <p class="m-t-30">{{$tutor->about}}</p>
                                </div>
                            </div>

                            <div class="tab-pane" id="appointment" role="tabpanel">
                                <div class="card-body">
                                    @if($count_appointments == 0)
                                        <p class="text-danger" style="width:100%;text-align: center;"> You haven't booked any appointment with {{$tutor_fullname}}</p>
                                    @else
                                        <h4 align="center"> Appointments with {{$tutor_fullname}} <span class="badge badge-success">{{$count_appointments}} </span></h4>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row card-body">
                                                    <div class="card b-all shadow-none">
                                                        <div class="table-responsive m-t-40">
                                                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>Title</th>
                                                                        <th>Description</th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    
                                                                @foreach($appointments as $key=>$appointment)
                                                                   
                                                                    <tr>
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <input type="checkbox" id="checkbox{{$key}}" value="check{{$appointment->id}}">
                                                                                <label for="checkbox0"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <a href="/students/appointment/view/{{$appointment->id}}">
                                                                            {{ucfirst(substr($appointment->title,0,50))}}
                                                                            </a>
                                                                        </td>
                                                                        <td>{!! html_entity_decode(nl2br(substr($appointment->content,0,100))) !!} ...</td>
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
                                                </div>

                                                {{$appointments->links()}}
                                            </div>
                                        @endif
                                        </div>
                                </div>
                            
                            <div class="tab-pane" id="ratings" role="tabpanel">
                                <div class="card-body">
                                    <h3> Ratings </h3>
                                    <div class="message-box contact-box">
                                        <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Rate Tutor" data-target="#RateTutorModal{{$tutor->id}}">+</button></h2>
                                        <div class="message-widget contact-widget">
                                            
                                            @if($count_ratings == 0)
                                                <p class='text-danger'> No rating yet </p>
                                            @else
                                                @foreach($ratings as $rating)
                                                    @php($student_fullname = Query::getFullname('students',$rating->student_id) )

                                                    <a href="#" style="color:#444">
                                                        <div class="user-img"> <span class="round">R</span> <span class="profile-status away pull-right"></span> </div>
                                                        <div class="mail-contnet">
                                                            <h5><b>{{$student_fullname}}</b> <small class="pull-right"><i class="mdi mdi-star"></i> {{$rating->rating}}</small></h5> 
                                                            <small class="container">{{ucfirst($rating->feedback)}}</small>
                                                            <br/><small class="pull-right">{{\Carbon\Carbon::createFromTimeStamp(strtotime($rating->created_at))->diffForHumans()}}</small></div>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="RateTutorModal{{$tutor->id}}" tabindex="-1" role="dialog" aria-labelledby="RateTutorModalLabel{{$tutor->id}}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="RateTutorModalLabel{{$tutor->id}}"><i class="mdi mdi-thumbs-up-down"></i> Rate {{$tutor_fullname}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal form-material" id="rating_form{{$tutor->id}}" method="POST" onsubmit="return false">
                                                {{csrf_field()}}
                                                <input type="hidden" name="page" value="profile"/>

                                                <div class="form-group">
                                                    <small for="recipient-name" class="control-label">Select rating</small>
                                                    <select name="rating" class="form-control">
                                                        <option value=""> -- Select -- </option>
                                                        @for($i=1;$i<=5;$i++)
                                                            <option value="{{$i}}"> {{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <small for="recipient-name" class="control-label">Feedback about the tutor (maximum of 255 characters)</small> <br/><p></p>
                                                    <textarea class="form-control form-material" maxlength="255" name="feedback" rows="5"> </textarea>
                                                </div>

                                                <div class="modal-footer" style="border:0px">
                                                    <div id="rating_status{{$tutor->id}}"></div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" id="rating_btn{{$tutor->id}}" onclick="return ajaxFormRequest('#rating_btn{{$tutor->id}}','#rating_form{{$tutor->id}}','/students/rate-tutor/{{$tutor->id}}','POST','#rating_status{{$tutor->id}}','Rate','no')" class="btn btn-info"><i class="fa fa-check"></i> Rate</button>

                                                </div>
                                            </form>
                                        </div>    
                                    </div>
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

