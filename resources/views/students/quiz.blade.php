<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Questions;
use App\Subjects;
use Session;
use URL;
?>

@extends('students.app')

@section('title')
    E-learning | Quiz
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Quiz</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Quiz</li>
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
                    
                    @if($count_questions == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No question yet </p>
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                   <ul class="feeds" id="real_div">

                                        @foreach($questions as $question)
                                            @php($count_subject_questions = Query::countTheValues('questions','subject_id',$question->subject_id))
                                            <li>
                                                <div class="bg-light-info"><i class="fa fa-question"></i></div> 
                                                <a href="quiz/view/{{$question->subject_id}}" style="font-weight: bold"> 
                                                    {{ucwords(Subjects::findOrFail($question->subject_id)->name)}}
                                                </a>
                                                <p style="margin-left:50px">
                                                    @if($count_subject_questions == 0)
                                                        <small> {{$count_subject_questions}} question </small> 
                                                    @else
                                                        <small> 
                                                            {{$count_subject_questions}} 
                                                            
                                                            @if($count_subject_questions == 1 ) 
                                                                question
                                                            @else
                                                                questions
                                                            @endif 
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



