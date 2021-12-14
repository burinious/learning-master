<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
use App\Tutors;
use DB;
?>

@extends('students.app')

@section('title')
    E-learning | Student | Assignments
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Assignments</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Assignments</li>
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
                    
                    @if($count_assignments == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No assignment yet </p>
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <div class="form-material container">
                                        <input class="form-control p-20" type="text" id="assignment" placeholder="Search assignment" maxlength="25" onkeyup="return searchItem('#assignment','#search_div','real_div','search_div','/students/search-assignment')"/>
                                    </div>
                                    
                                    <ul class="feeds" id="real_div">

                                        @foreach($assignments as $assignment)
                                            @php($tutor_fullname = Query::getFullname('tutors',$assignment->tutor_id))
                                           
                                           @php($subject = Query::getValue('subjects','id',$assignment->subject_id,'name'))
                                            
                                            @php($solution_exists = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->count())

                                            @if($solution_exists == 0)
                                                <div class="modal fade" id="submitSolutionModal{{$assignment->id}}" tabindex="-1" role="dialog" aria-labelledby="submitSolutionModalLabel{{$assignment->id}}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="submitModalLabel{{$assignment->id}}">Submit solution</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <small class='text-info'><b><i> Note that, you can only submit solution to an assignment once. </i></b></small>
                                                                <br/><br/>
                                                                <form class="form-horizontal form-material" id="upload_solution_form{{$assignment->id}}" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                                                    {{csrf_field()}}
                                                                    
                                                                    <input type="file" name="file"  accept=".pdf,.PDF,.doc,.docx"/>
                                                                    <br/><br/>

                                                                    <div class="modal-footer" style="border:0px">
                                                                        <div id="upload_solution_status{{$assignment->id}}"></div>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                         <button type="button" id="upload_solution_btn{{$assignment->id}}" onclick="return ajaxFormRequest('#upload_solution_btn{{$assignment->id}}','#upload_solution_form{{$assignment->id}}','/students/upload-ass-solution/{{$assignment->id}}','POST','#upload_solution_status{{$assignment->id}}','Submit','yes')" class="btn btn-info"><i class="fa fa-upload"></i> Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <li>
                                                <div class="bg-primary" style="color:#fff;padding:5px;font-size:18px">{{$loop->iteration}}</div> 
                                                 
                                                {{ucfirst($assignment->title)}}

                                                <p style="margin-left:50px">
                                                    <a href="/the_assignments/all/{{$assignment->path}}">{{ucfirst($assignment->path)}}</a> &nbsp; &nbsp;
                                                
                                                    <small style='font-size:13px'>{{$subject}} &nbsp; &nbsp;  {{$tutor_fullname}} &nbsp; &nbsp; {{$assignment->size}}</small> 
                                                    <span class="text-muted">{{\Carbon\Carbon::createFromTimeStamp(strtotime($assignment->created_at))->diffForHumans()}}</span>
                                                    <br/><small  style='font-size:14px'> {{ucfirst($assignment->note)}}</small>
                                                    <br/><br/>
                                                    
                                                    @if($solution_exists == 1)

                                                        @php($solution = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->value('path'))

                                                        @php($score = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->value('grade'))

                                                        @php($total_score = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->value('obtainable'))

                                                        <a href="/the_assignments/submitted/{{$solution}}" class="btn btn-sm btn-info btn-rounded pull-right">View solution</a>

                                                        @if($score != "" && $total_score != "") 
                                                            @php($display_score = $score." / ".$total_score)
                                                        
                                                            <b style='color:green'> {{$display_score}} </b>
                                                        @else
                                                            <b style='color:red'> No grade yet </b>
                                                        @endif


                                                    @else
                                                        <button style="margin-right:20px" class="btn btn-sm btn-primary btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#submitSolutionModal{{$assignment->id}}">Submit solution</button> 
                                                    @endif
                                                    <br/>
                                                </p><hr/>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div id="search_div"></div>
                                </div>
                            </div>
                            
                        </div>
                    @endif
                </div>
            </div>
    <br/><br/>
@endsection



