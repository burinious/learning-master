@extends('app')

@section('title')
    E-learning | Home
@endsection

@section('content')
	<section>
        <div style="background-image:url(panels/assets/images/background/login-register.jpg);">
            <br/><br/>
            <div   style="margin:10px">
            <div class="card container">
            	<div class="card-body">
                    <h3 class="box-title m-b-20" align="center">Welcome to Learning Management System</h3> <hr/>
                    <p> This is a web-based platform developed for secondary school students to foster a smooth interaction between students and their desired tutors.  <br/>
                    This system is made up of two panels, namely: 
                    	<ul>
                    		<li> Students' panel </li>
                    		<li> Admin panel </li>
                    	</ul>
                    <br/>

                    <div class="col-md-6 col-sm-6 col-xs-12" style="float:left">
	                    <h5><b> STUDENTS' PANEL </b></h5>
	                    This panel is made up of the following features: 

                    	<ul>
                    		<li> Registration and login of students </li>
                    		<li> Live chat with their desired tutors </li>
                    		<li> Creating new and joining already existing discussion groups </li>
                    		<li> Rating and writing feedbacks about each tutor </li>
                    		<li> Downloads of course materials and assignments </li>
                    		<li> Submission of assignments for grading </li>
                    		<li> Writing CBT  </li>
                    	</ul> 
                    	<div class="col-xs-12">
                            <a href="students" class="btn btn-info btn-md text-uppercase waves-effect waves-light">Go to students' panel <i class="fa fa-arrow-circle-right"></i></a>
                        </div> <br/><br/>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12"  style="float:right">
	                    <h5><b> TUTORS' PANEL </b></h5>
	                    This panel is made up of the following features: 

                    	<ul>
                    		<li> Registration and login of tutors </li>
                    		<li> Live chat with their desired students </li>
                    		<li> Creating new and joining already existing discussion groups </li>
                    		<li> Uploads of course materials and assignments </li>
                    		<li> Grading of students' assignments </li>
                    		<li> Marking CBT taken by students  </li>
                    	</ul>
                    	<div class="col-xs-12">
                            <a href="tutors"  class="btn btn-success btn-md text-uppercase waves-effect waves-light">Go to tutors' panel <i class="fa fa-arrow-circle-right"></i></a>
                        </div> <br/><br/>
                    </div>
                </div>
            </div> 
        </div>
            <br/><br/><br/>


    </section> <br/><br/><br/>
    
@endsection

