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
    E-learning | Subjects
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Subjects</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Subjects</li>
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
                    
                    @if($count_subjects == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No subject yet </p>
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <div class="form-material container">
                                        <input class="form-control p-20" type="text" id="subject" placeholder="Search subject" maxlength="25" onkeyup="return searchItem('#subject','#search_div','real_div','search_div','/students/search-subject')"/>
                                    </div>
                                    
                                    <ul class="feeds" id="real_div">

                                        @foreach($subjects as $subject)
                                            @php($count_subject_tutors = Query::countTheValues('tutors','subject_id',$subject->id))
                                            <li>
                                                <div class="bg-light-info"><i class="fa fa-file"></i></div> 
                                                {{ucwords($subject->name)}}
                                                <p style="margin-left:50px">
                                                    @if($count_subject_tutors == 0)
                                                        <small> {{$count_subject_tutors}} tutor </small> 
                                                    @else
                                                        <small> 
                                                            <a href="/students/subject/tutors/{{$subject->id}}"> 
                                                                {{$count_subject_tutors}} 
                                                                
                                                                @if($count_subject_tutors == 1 ) 
                                                                    tutor
                                                                @else
                                                                    tutors
                                                                @endif 
                                                            </a>
                                                        </small> 
                                                    @endif
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div style="clear:both" id="search_div"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    <br/><br/>
@endsection



