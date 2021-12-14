<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use App\Chat;
?>

@extends('tutors.app')

@section('title')
    E-learning | Tutor | Chat
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Chat</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Chat</li>
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

            <div style="clear:both;"></div> <br/>
            
            <div class="row">
                
                <div id="side_students_div"></div>

                @if($count_students == 0)
                    <p class="alert alert-danger" style="width:100%;text-align: center;"><i class="fa fa-remove"></i> No student yet </p>
                @else
                    <div class="col-12">
                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner">
                                        <div class="form-material">
                                            <form class="form-horizontal form-material" id="search_student_form" method="POST">
                                                {{csrf_field()}}
                                                <input class="form-control p-20" type="text" id="student" placeholder="Search student" onKeyup="searchItem()"/>
                                            </form>
                                        </div>
                                        <ul class="chatonline style-none" id="real_div">
                                            @foreach($students as $student)
                                                @php($student_fullname = Query::getFullname('students',$student->id) )
                                                
                                                <script type="text/javascript">
                                                    
                                                    loadStudentDetails = (student) => {
                                                        ajaxLoadingRequest("/tutors/chat-student-details/"+student,"#chat_student_details_div","","GET");
                                                    }

                                                </script>

                                                <li onClick="loadStudentDetails('{{$student->id}}')">
                                                    <a href="javascript:void(0)"><span> {{ucwords($student_fullname)}}                                                    <small class="text-default"> <span> <i class="fa fa-phone"></i> {{$student->phone}} </small>
                                                    </span></a>
                                                </li>
                                            @endforeach                                            
                                        </ul>

                                        <div id="search_div"></div>
                                    </div>
                                </div>
                                <!-- .chat-left-panel -->
                                
                                <!-- .chat-right-panel -->
                                    <div class="chat-right-aside">
                                        <div id="chat_student_details_div"></div>
                                    </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
                        </div>
                    </div>
                @endif
            </div>
            
    
        <div class="modal fade" id="AddstudentModal" tabindex="-1" role="dialog" aria-labelledby="AddstudentModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="AddstudentModal"><i class="mdi mdi-plus"></i> Add new student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" id="add_student_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div id="phase_one">
                                <div class="form-student">
                                    <small for="recipient-name" class="control-label">student name (maximum of 25 characters)</small>
                                    <input type="text" name="student_name" id="student_name" class="form-control" maxlength="25"/>
                                </div>

                                <div class="form-student">
                                    <small for="recipient-name" class="control-label">Short description about the student (maximum of 255 characters)</small> <br/><p></p>
                                    <textarea class="form-control form-material" maxlength="255" id="description" name="student_desc" rows="5"> </textarea>
                                </div>

                                <!-- <div class="form-student">
                                    <small for="recipient-name" class="control-label">student display picture</small> <br/>
                                    <input type="file" name="photo" id="photo" accept=".png,.jpg,.JPG,.JPEG,.PNG"/>
                                    
                                    <div id='preview_div' style="display:none;">
                                        <p>Preview image</p>
                                        <img id="preview_pix" style='max-width: 200px' src="#" class="img-responsive img-thumbnail"/>
                                    </div>

                                </div> -->

                                <div class="modal-footer" style="border:0px">
                                    <button type="button" id="student_details_btn" onclick="return checkstudentDetails()" class="btn btn-info">Continue <i class="fa fa-arrow-circle-right"></i> </button>
                                </div>
                                <div id="phase_one_status"></div>
                            </div>

                            <div id="phase_two" style="display:none">
                                
                                <h4>Add members to student</h4>
                                
                                <div id="all_users_div"></div>
                                <br/>

                                <div>
                                    <button type="button" onClick="PrevBtn('#phase_two','#phase_one')" class="btn btn-primary pull-left"> <i class="fa fa-arrow-circle-left"></i> Back</button>

                                    <button type="button" id="add_student_btn" onclick="return ajaxFormRequest('#add_student_btn','#add_student_form','/students/add-student','POST','#phase_two_status','Add student','yes')" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add student </button>
                                </div>
                                <div style="clear: both;"></div>
                                <div id="phase_two_status"></div>
                                
                            </div>
                            
                        </form>

                        
                    </div>    
                </div>
            </div>
        </div>
    
@endsection

