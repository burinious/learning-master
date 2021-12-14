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
@php($subject_name = Query::getValue('subjects','id',$subject_id,'name') )
                        
@section('title')
    E-learning | {{$subject_name}} Tutors
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{$subject_name}} Tutors</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">{{$subject_name}} Tutors</li>
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
                    
                    @if($count_tutors == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No tutor yet for {{$subject_name}} </p>
                    @else
                        @foreach($tutors as $tutor)
                            @php($tutor_fullname = Query::getFullname('tutors',$tutor->id) )
                            @php($count_ratings = Query::countTheValues('ratings','tutor_id',$tutor->id))
                            @php($tutor_rating = Query::tutorRating($tutor->id))

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
                                                    <button type="button" id="rating_btn{{$tutor->id}}" onclick="return ajaxFormRequest('#rating_btn{{$tutor->id}}','#rating_form{{$tutor->id}}','/students/subject-rate-tutor/{{$tutor->id}}/subject/{{$subject_id}}','POST','#rating_status{{$tutor->id}}','Rate','no')" class="btn btn-info"><i class="fa fa-check"></i> Rate</button>

                                                </div>
                                            </form>
                                        </div>    
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-xlg-4">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xlg-4 text-center">
                                            <a href="tutors/profile/{{$tutor->id}}">
                                                @if($tutor->pix != "")
                                                    <img src="the_tutors/{{$tutor->pix}}" alt="user"/>
                                                @else 
                                                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive" alt="user"/>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xlg-4">
                                            <p></p><a href="/students/tutors/profile/{{$tutor->id}}" class="text-primary" style="font-size:20px">{{$tutor_fullname}}</a>  <p></p>
                                            <p><i class="mdi mdi-cellphone"></i> {{$tutor->phone}}</p>
                                            <p><i class="mdi mdi-email-outline"></i> {{$tutor->email}}</p>
                                            <p>
                                                @if($count_ratings == 0)
                                                    <small class='text-danger'> No rating yet </small>
                                                @else
                                                    <i class="mdi mdi-star"></i> {{$tutor_rating}} 
                                                @endif
                                            </p>

                                        </div> <br/><p></p>

                                        <div class="container button-group" align="center">
                                            <a href="/students/tutors/profile/{{$tutor->id}}"><button type="button" class="btn btn-sm waves-effect waves-light btn-rounded btn-success">View Profile</button></a>
                                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Rate Tutor" data-target="#RateTutorModal{{$tutor->id}}" data-whatever="@mdo"><i class="mdi mdi-thumbs-up-down"></i> Rate tutor</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
@endsection



