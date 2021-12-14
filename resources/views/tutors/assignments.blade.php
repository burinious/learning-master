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

@extends('tutors.app')

@section('title')
    E-learning |  Tutor | Assignments
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

                <h2 class="add-ct-btn pull-right">
                    <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark pull-right" data-toggle="modal" data-target="#UploadAssignmentModal">+ Upload new assignment</button></h2>
                <div style="clear:both;"></div> <br/>

                <div class="modal fade" id="UploadAssignmentModal" tabindex="-1" role="dialog" aria-labelledby="UploadAssignmentModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="UploadAssignmentModalLabel"><i class="fa fa-upload"></i> Upload Assignment</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" id="upload_assignment_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    
                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Title</small> <br/>
                                        <input type="text" name="title" class="form-control"/>
                                    </div>

                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Select student</small> <br/>
                                        {!! Query::selectMultiItem('students','student_id','-- Select student -- ','surname') !!}
                                    </div>

                                    <small for="recipient-name" class="control-label">Select assignment</small> <br/>
                                    <input type="file" name="file" accept=".pdf,.PDF,.doc,.docx"/>
                                    <br/><br/>

                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Additional information (maximum of 255 characters)</small> <br/><p></p>
                                        <textarea class="form-control form-assignment" maxlength="255" name="note" rows="5"> </textarea>
                                    </div>

                                    <div class="modal-footer" style="border:0px">
                                        <div id="upload_status"></div>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="upload_btn" onclick="return ajaxFormRequest('#upload_btn','#upload_assignment_form','/tutors/upload-assignment','POST','#upload_status','Upload','yes')" class="btn btn-info"><i class="fa fa-upload"></i> Upload</button>

                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    @if($count_assignments == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No assignment yet </p>
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <div class="form-material container">
                                        <input class="form-control p-20" type="text" id="assignment" placeholder="Search assignment" maxlength="25" onkeyup="return searchItem('#assignment','#search_div','real_div','search_div','/tutors/search-assignment')"/>
                                    </div>
                                    
                                    <ul class="feeds" id="real_div">

                                        @foreach($assignments as $assignment)
                                            @php($student_fullname = Query::getFullname('students',$assignment->student_id))
                                            
                                            @php($subject = Query::getValue('subjects','id',$assignment->subject_id,'name'))
                                            
                                            @php($solution_exists = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->count())

                                            @if($solution_exists == 1)
                                                @php($solution_id = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('id'))

                                                @php($total_score = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('obtainable'))

                                                <div class="modal fade" id="gradeStudentModal{{$solution_id}}" tabindex="-1" role="dialog" aria-labelledby="gradeStudentModalLabel{{$solution_id}}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="gradeStudentModalLabel{{$solution_id}}">Grade student</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal form-material" id="grade_student_form{{$solution_id}}" method="POST" onsubmit="return false">
                                                                    {{csrf_field()}}
                                                                        
                                                                    <div class="form-group">
                                                                        <small for="recipient-name" class="control-label">Score</small>
                                                                        <input type="text" name="score" id="score" class="form-control" maxlength="3"/>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <small for="recipient-name" class="control-label">Total Score</small>
                                                                        <input type="text" name="total_score" id="total_score" class="form-control" maxlength="3"/>
                                                                    </div>

                                                                    <div class="modal-footer" style="border:0px">
                                                                        <div id="grade_student_status{{$solution_id}}"></div>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                         <button type="button" id="grade_student_btn{{$solution_id}}" onclick="return ajaxFormRequest('#grade_student_btn{{$solution_id}}','#grade_student_form{{$solution_id}}','/students/grade-student-solution/{{$solution_id}}','POST','#grade_student_status{{$solution_id}}','Grade','yes')" class="btn btn-info"><i class="fa fa-check"></i> Grade</button>
                                                                    </div>
                                                                </form>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="updateStudentGradeModal{{$solution_id}}" tabindex="-1" role="dialog" aria-labelledby="updateStudentGradeModalLabel{{$solution_id}}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="updateStudentGradeModalLabel{{$solution_id}}">Update Student Grade</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal form-material" id="ugrade_student_form{{$solution_id}}" method="POST" onsubmit="return false">
                                                                    {{csrf_field()}}
                                                                        
                                                                    <div class="form-group">
                                                                        <small for="recipient-name" class="control-label">Score</small>
                                                                        <input type="text" name="score" id="score" class="form-control" maxlength="3"/>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <small for="recipient-name" class="control-label">Total Score</small>
                                                                        <input type="text" name="total_score" id="total_score" class="form-control" maxlength="3" readonly value="{{$total_score}}" style="background-color:#ccc;padding:10px"/>
                                                                    </div>

                                                                    <div class="modal-footer" style="border:0px">
                                                                        <div id="ugrade_student_status{{$solution_id}}"></div>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                         <button type="button" id="ugrade_student_btn{{$solution_id}}" onclick="return ajaxFormRequest('#ugrade_student_btn{{$solution_id}}','#ugrade_student_form{{$solution_id}}','/students/grade-student-solution/{{$solution_id}}','POST','#ugrade_student_status{{$solution_id}}','Update','yes')" class="btn btn-info"><i class="fa fa-check"></i> Update</button>
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
                                                
                                                    <small style='font-size:13px'>{{$subject}} &nbsp; &nbsp;  {{$student_fullname}} &nbsp; &nbsp; {{$assignment->size}}</small> 
                                                    <span class="text-muted">{{\Carbon\Carbon::createFromTimeStamp(strtotime($assignment->created_at))->diffForHumans()}}</span>
                                                    <br/><small  style='font-size:14px'> {{ucfirst($assignment->note)}}</small>
                                                    <br/><br/>
                                                    
                                                    @if($solution_exists == 1)

                                                        @php($solution = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('path'))

                                                        @php($solution_id = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('id'))
                                                        
                                                        @php($score = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('grade'))

                                                        @php($total_score = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$assignment->student_id)->value('obtainable'))

                                                        <a href="/the_assignments/submitted/{{$solution}}" class="btn btn-sm btn-info btn-rounded pull-right"><i class="fa fa-eye"></i> View solution</a>

                                                        @if($score != "" && $total_score != "") 
                                                            @php($display_score = $score." / ".$total_score)
                                                            
                                                            <button style="margin-right:20px" class="btn btn-sm btn-primary btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#updateStudentGradeModal{{$solution_id}}"><i class="fa fa-pencil"></i> Update grade</button> 
                                                            <b style='color:green'> {{$display_score}} </b>
                                                            
                                                        @else 
                                                            <b style='color:red'> No grade yet </b>
                                                            
                                                            <button style="margin-right:20px" class="btn btn-sm btn-primary btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#gradeStudentModal{{$solution_id}}"><i class="fa fa-check"></i> Grade student</button> 
                                                        @endif

                                                    @else 
                                                        <b style='color:red'> No solution yet </b>
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



