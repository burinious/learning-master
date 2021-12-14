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

@extends('students.app')

@section('title')
    E-learning | Students Tutors
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Tutors</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Tutors</li>
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
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No tutor yet </p>
                    @else
                        @foreach($tutors as $tutor)
                            @php($tutor_fullname = Query::getFullname('tutors',$tutor->id) )
                            @php($count_ratings = Query::countTheValues('ratings','tutor_id',$tutor->id))
                            @php($tutor_rating = Query::tutorRating($tutor->id))
                            @php($appointment_status = Appointments::where('tutor_id',$tutor->id)->where('student_id',$student_id)->where('status','0')->count())

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $(".textarea_editor{{$tutor->id}}").wysihtml5();
                                });
                            </script>
                            
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
                                                <input type="hidden" name="page" value="tutor"/>
                                                
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


                            <div class="modal fade" id="BookAppointmentModal{{$tutor->id}}" tabindex="-1" role="dialog" aria-labelledby="BookAppointmentModalLabel{{$tutor->id}}">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="BookAppointmentModalLabel{{$tutor->id}}"><i class="fa fa-book"></i> Book Appointment with {{$tutor_fullname}}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" id="book_form{{$tutor->id}}" method="POST" onsubmit="return false">
                                                {{csrf_field()}}
                                                
                                                <div class="form-group">
                                                    <small for="recipient-name" class="control-label">Title</small> <br/><p></p>
                                                    <input type="text" name="title" id="title" class="form-control"/>
                                                </div>

                                                <div class="form-group">
                                                    <small for="recipient-name" class="control-label">Type your message here</small> <br/><p></p>
                                                    <textarea class="textarea_editor{{$tutor->id}} form-control" rows="15" name="message"></textarea>
                                                </div>

                                                <div class="modal-footer" style="border:0px">
                                                    <div id="book_status{{$tutor->id}}"></div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="button" id="book_btn{{$tutor->id}}" onclick="return ajaxFormRequest('#book_btn{{$tutor->id}}','#book_form{{$tutor->id}}','/students/book-appointment/{{$tutor->id}}','POST','#book_status{{$tutor->id}}','Book','no')" class="btn btn-info"><i class="fa fa-check"></i> Book</button>

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
                                                    <img src="/learning/the_tutors/{{$tutor->pix}}" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                @else 
                                                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" class="img-responsive" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                @endif
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xlg-4">
                                            <p></p><a href="tutors/profile/{{$tutor->id}}" class="text-primary" style="font-size:20px">{{$tutor_fullname}}</a>  <p></p>
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
                                            
                                            @if($appointment_status == 0)
                                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Book Appointment" data-target="#BookAppointmentModal{{$tutor->id}}" data-whatever="@mdo"><i class="fa fa-book"></i> Book Appointment</button>
                                            @endif
                                            <!-- <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-primary"><i class="mdi mdi-email-open"></i> Chat</button> -->
                                           
                                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-info" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Rate Tutor" data-target="#RateTutorModal{{$tutor->id}}" data-whatever="@mdo"><i class="mdi mdi-thumbs-up-down"></i> Rate tutor</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>
    <br/><br/>
@endsection



