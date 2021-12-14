<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use Session;
?>

@extends('students.front_app')

@section('title')
    E-learning | Students Login
@endsection

@section('content')
	<section id="wrapper">
        <div class="the-register" style="background-image:url(/panels/assets/images/background/login-register.jpg);">
            <br/> <br/>
            <div class="login-box card container">
                
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
                
                <div class="card-body">
                    <div class="col-xs-12" align="center">
                        <a href="{{ route('tutorIndex') }}"  class="btn btn-success btn-sm text-uppercase waves-effect waves-light">Go to tutors' panel <i class="fa fa-arrow-circle-right"></i></a>
                    </div> <br/>
                    <form class="form-horizontal form-material" method="post" id="loginform" action="{{ route('studentSignin') }}" onsubmit="return false">
                        {{ csrf_field() }}
                        <h3 class="box-title m-b-20" align="center">Sign In as a Student</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="student_id" required="" placeholder="Student ID"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="password" placeholder="Password"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <div id="login_status" align="center"></div> <p></p>

                                <button type="button" id="login_student_btn" onclick="return ajaxFormRequest('#login_student_btn','#loginform','students/student-signin','POST','#login_status','Log In','no')" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">Log In </button>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                     <a href="javascript:void(0)" id="to-register" class="text-dark"><i class="fa fa-user"></i> Register now</a> 
                                </div> 
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                        </div>
                       
                    </form>

                    <form class="form-horizontal form-material" method="post" id="recoverform" action="#">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3 class="box-title m-b-20" align="center">Recover Password</h3>
                        
                                <p class="text-muted">Enter your email address and instructions will be sent to you! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email address"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                            <br/>
                            <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"> Login now</a> 
                        </div>
                    </form>

                    <form class="form-horizontal form-material" id="registerform" action="#" method="post" style="display:none" onsubmit="return false">
                        {{ csrf_field() }}
                        <h3 class="box-title m-b-20" align="center">Sign Up as a Student</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="surname" placeholder="Surname">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="firstname" placeholder="Firstname">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" required="" name="email" placeholder="Email address">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="phone" placeholder="Phone number">
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                {!! Misc::selectClass() !!}
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" required="" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="confirm_password" required="" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <div id="register_status"></div>

                                <button type="button" id="register_student_btn" onclick="return ajaxFormRequest('#register_student_btn','#registerform','students/student-signup','POST','#register_status','Sign Up','no')" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">Sign Up </button>
                                
                            </div>
                        </div>
                        
                        Already have an account? <a href="javascript:void(0)" id="to-the-login" class="text-dark"> Login now</a> 
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br/><br/>
@endsection

