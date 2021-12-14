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
use DB;
?>

@extends('students.app')
@php($subject = ucwords(Subjects::findOrFail($subject_id)->name))

@section('title')
    @if($count_answers == 0)
        E-learning | {{$subject}} Questions
    @else
        E-learning | {{$subject}} Result
    @endif
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">
                    @if($count_answers == 0)
                        {{$subject}} Questions
                    @else
                        {{$subject}} Result
                    @endif
                </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">
                        @if($count_answers == 0)
                            {{$subject}} Questions
                        @else
                            {{$subject}} Result
                        @endif
                    </li>
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
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No {{$subject}} question yet </p>
                    
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                   
                                    @if($count_answers == 0)

                                        <div class="col-md-offset-2 col-xs-10">
                                            
                                            <br/><br/>
                                            
                                            <form class="form-horizontal" id="submit-answer{{$subject_id}}" method="post">
                                                {{csrf_field() }}

                                                @forelse($questions as $question)
                                                    @php($i = $loop->iteration)
                                                    
                                                    @if( ($i==1) && ($i == $count_questions) )
                                                        
                                                        @if($count_questions == 1)

                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif 
                                                                </p>
                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>

                                                        @elseif($count_questions == 2)
                                                            
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>

                                                        @else
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>
                                                        @endif
                                                    
                                                    @elseif( ($i==1) && ($i !== $count_questions) )
                                                        
                                                        @if($count_questions == 1)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        
                                                        @elseif($count_questions == 2)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        @else
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        @endif

                                                    @elseif($i < $count_questions)
                                                        
                                                        @if($count_questions == 1)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        @elseif($count_questions == 2)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        @else
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        @endif

                                                    @elseif($i == $count_questions)
                                                        
                                                        @if($count_questions == 1)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> 
                                                                <br/> <br/>
                                                            </div>
                                                        @elseif($count_questions == 2)
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'><i class="fa fa-check"></i> Submit</button>
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> <br/> 
                                                                <br/>
                                                            </div>
                                                        @else
                                                            <div id="question_div{{$i}}" class="all_questions_div">
                                                                <span class="badge badge-info"><b>{{$i}}</b></span> 
                                                                &nbsp; {{ucfirst($question->question)}} 
                                                                
                                                                <input type="hidden" name="question_id{{$question->id}}" value="{{$question->id}}"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    @if($question->type == "boolean")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option{{$question->id}}" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option{{$question->id}}" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    @elseif($question->type == "multiple")
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->a}}" type="radio" name="option{{$question->id}}" value="a"/>
                                                                                <label for="{{$question->a}}">{{ucfirst($question->a)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->b}}" type="radio" name="option{{$question->id}}" value="b"/>
                                                                                <label for="{{$question->b}}">{{ucfirst($question->b)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->c}}" type="radio" name="option{{$question->id}}" value="c"/>
                                                                                <label for="{{$question->c}}">{{ucfirst($question->c)}}</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="{{$question->d}}" type="radio" name="option{{$question->id}}" value="d"/>
                                                                                <label for="{{$question->d}}">{{ucfirst($question->d)}}</label>
                                                                            </div>
                                                                        </div>

                                                                    @endif
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="{{$i}}" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="{{$i}}" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button> 
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> <br/> 

                                                                
                                                                <br/> <br/>
                                                            </div>
                                                        @endif
                                                    
                                                    @endif

                                                @empty
                                                    <h2 class="text-danger"><i class="fa fa-remove"></i> No courses yet </h2>
                                                @endforelse
                                            </form>
                                        <br/><br/>
                                    </div></div></div>

                                    @else
                                        <h2 class="text-primary"> Result under compilation. Please try again </h2>
                                    </div>

                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </span>
    </p>
    <br/><br/>

    <script type="text/javascript">
        
        $(document).ready(function() {
            $('.submit-answer').click(function() {

                var confirm = window.confirm('Submit answer?');

                if(!confirm) {
                    return false;
                } else {
                    var subject_id = "<?php echo $subject_id;?>";
                    var data = $("form#submit-answer{{$subject_id}}").serialize();
                    var url = '/students/submit-answer/'+subject_id;
                    $(this).attr("disabled",true);
                    $(this).html("Please wait ...");
                    
                    $.ajax(
                    {
                        type: 'POST',
                        url: url,
                        data: data,
                        
                        headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(msg) {
                            $("#answer_status").fadeIn("fast");
                            $("#answer_status").html(msg);
                            $('.submit-answer').attr("disabled",false);
                            $('.submit-answer').html("<i class='fa fa-check'></i> Submit");
                        },
                        error: function(error) {
                            $("#answer_status").fadeIn("fast");
                            $("#answer_status").html("<p style='color:red'>Unable to perform operation</p>");
                            $('.submit-answer').attr("disabled",false);
                            $('.submit-answer').html("<i class='fa fa-check'></i> Submit");
                        }
                        
                    });
                }
            });
        });
    </script>
@endsection



