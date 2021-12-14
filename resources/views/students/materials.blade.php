<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
use App\Tutors;
?>

@extends('students.app')

@section('title')
    E-learning | Student | Materials
@endsection

@section('content')
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Materials</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Materials</li>
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
                    
                    @if($count_materials == 0)
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No material yet </p>
                    @else
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <div class="form-material container">
                                        <input class="form-control p-20" type="text" id="material" placeholder="Search material" maxlength="25" onkeyup="return searchItem('#material','#search_div','real_div','search_div','/students/search-material')"/>
                                    </div>
                                    
                                    <ul class="feeds" id="real_div">

                                        @foreach($materials as $material)
                                            @php($tutor_fullname = Query::getFullname('tutors',$material->tutor_id))
                                            
                                            @php($subject = Query::getValue('subjects','id',$material->subject_id,'name'))

                                            <li>
                                                <div class="bg-info" style="color:#fff;padding:5px;font-size:18px">{{$loop->iteration}}</div> 
                                                
                                                {{ucfirst($material->title)}}

                                                <p style="margin-left:50px">
                                                    <a href="/the_materials/{{$material->path}}">{{ucfirst($material->path)}}</a> &nbsp; &nbsp;

                                                    <small style='font-size:13px'>{{$subject}} &nbsp; &nbsp;  {{$tutor_fullname}} &nbsp; &nbsp; {{$material->size}}</small> 
                                                    <span class="text-muted">{{\Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans()}}</span>
                                                    <br/><small  style='font-size:14px'> {{ucfirst($material->note)}}</small>
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



