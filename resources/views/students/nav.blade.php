<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Students;
use URL;
use DB;
use Session;

?>

<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <b>
                    <img src="{{ URL::asset('/panels/assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                </b>
                <span> E-LEARNING </span> </a>
        </div>
        
        <div class="navbar-collapse">
        
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox scale-up-left">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="#">
                                        <div class="btn btn-success btn-circle"><i class="fa fa-file"></i></div>
                                        <div class="mail-contnet">
                                            <h6>Olatigbe Busayo uploaded a new course material</h6> 
                                            <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="btn btn-primary btn-circle"><i class="fa fa-file"></i></div>
                                        <div class="mail-contnet">
                                            <h6>Ologundudu Toluwase uploaded a new assignment</h6> 
                                            <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="btn btn-info btn-circle"><i class="fa fa-user-circle"></i></div>
                                        <div class="mail-contnet">
                                            <h6>Olatigbe Busayo created a new group</h6> 
                                            <span class="time">9 Nov, 2018 &nbsp; 9:30 AM</span> </div>
                                    </a>
                                
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu mailbox scale-up-left" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="#">
                                        <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Ahmed Olawale</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Adeniyi Comfort</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Ewere Nosa Victor</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <a href="#">
                                        <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Ofure Mary</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all messages</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                -->
            </ul>
            
        </div>
    </nav>
</header>

<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <br/>
            <h6 class="container" align="center"><b> STUDENTS' PANEL </b></h6>
                
            <div class="profile-img"> 
                
                @if($the_student->pix != "")
                    <img src="/the_students/{{$the_student->pix}}" alt="user" class="img-responsive img-circle" style="max-width:150px;max-height:150px"/>
                @else 
                    <img src="{{ URL::asset('/panels/images/avatar.png') }}" alt="user" class="img-responsive img-circle"/>
                @endif
                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
            </div>
            <div class="profile-text">
                <h5>{!! Query::getFullname('students',$student_id) !!}</h5>
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                <a href="{{ route('studentLogout') }}" onclick="return confirm('Logout?')" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                <div class="dropdown-menu animated flipInY">
                    <!-- text-->
                    <a href="{{ route('studentProfile') }}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <!-- text-->
                    <a href="#" data-toggle="modal" data-toggle="tooltip" data-target="#editProfileModal" title="Edit Profile" class="dropdown-item"><i class="ti-pencil"></i> Edit Profile</a>
                    
                    <a href="#" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Upload profile picture" data-target="#uploadPixModal" class="dropdown-item"><i class="fa fa-camera"></i> Upload profile pix</a>
                    
                    <!-- text-->
                    <a href="#" data-toggle="modal" data-toggle="tooltip" class="dropdown-item" title="Change password" data-target="#changePasswordModal" data-whatever="@mdo"><i class="mdi mdi-key"></i> Change Password</a>

                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li> <a class="waves-effect waves-dark" href="{{ route('studentDashboard') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentTutors') }}" aria-expanded="false"><i class="mdi mdi-account-multiple-outline"></i><span class="hide-menu">Tutors</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentAppointments') }}" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Appointments</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentSubjects') }}" aria-expanded="false"><i class="mdi mdi-comment-multiple-outline"></i><span class="hide-menu">Subjects</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentChat') }}" aria-expanded="false"><i class="mdi mdi-comment-multiple-outline"></i><span class="hide-menu">Chat</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentGroups') }}" aria-expanded="false"><i class="mdi mdi-group"></i><span class="hide-menu">Groups</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentMaterials') }}" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Materials</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentAssignments') }}" aria-expanded="false"><i class="mdi mdi-file"></i><span class="hide-menu">Assignments</span></a></li>

                <li> <a class="waves-effect waves-dark" href="{{ route('studentQuiz') }}" aria-expanded="false"><i class="fa fa-question"></i><span class="hide-menu">Quiz</span></a></li>

            </ul>
        </nav>
    </div>
</aside>


<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="changePasswordModalLabel1">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-material" id="change_password_form" method="POST" onsubmit="return false">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">New Password</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_new_password">
                    </div>

                    <div class="modal-footer" style="border:0px">
                        <div id="change_password_status"></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <button type="button" id="change_password_btn" onclick="return ajaxFormRequest('#change_password_btn','#change_password_form','/students/update-student-password','POST','#change_password_status','Change Password','no')" class="btn btn-info"><i class="fa fa-check"></i> Change Password</button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>


<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editProfileModalLabel1">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="update_profile_form" method="POST" onsubmit="return false">
                    {{csrf_field()}}


                    <div class="col-md-6 col-sm-6 col-xs-12 pull-left">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Surname</label>
                            <input type="text" class="form-control" name="surname" value="{{$the_student->surname}}">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Firstname</label>
                            <input type="text" class="form-control" name="firstname"  value="{{$the_student->firstname}}">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Email address</label>
                            <input type="email" class="form-control" name="email"  value="{{$the_student->email}}">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Phone number</label>
                            <input type="text" class="form-control" name="phone"  value="{{$the_student->phone}}">
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12  pull-right">
                    
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Class</label>
                                {!! Misc::selectedClass($the_student->class) !!}
                        </div>

                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea style="margin-top:10px" name="address" rows="5" class="form-control">{{$the_student->address}}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">About me</label>
                            <textarea style="margin-top:10px" name="about" rows="5" class="form-control">{{$the_student->about}}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer col-sm-12 col-md-12 col-xs-12" style="border:0px">
                        <div id="update_profile_status"></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <button type="button" id="update_profile_btn" onclick="return ajaxFormRequest('#update_profile_btn','#update_profile_form','/students/update-profile','POST','#update_profile_status','Save changes','no')" class="btn btn-info"><i class="fa fa-check"></i> Save changes</button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>


<div class="modal fade" id="uploadPixModal" tabindex="-1" role="dialog" aria-labelledby="uploadPixModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="uploadPixModalLabel1">Change profile picture</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-material" id="upload_pix_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                    {{csrf_field()}}
                    
                    <input type="file" name="photo" id="photo" accept=".jpg,.png,.jpeg,.JPG,.PNG,.JPEG"/>
                    <div id='preview_div' style="display:none;">
                        <br/>Preview image <br/>
                        <img id="preview_pix" style='max-width: 200px' src="#" class="img-responsive img-thumbnail"/>
                    </div>
                    <br/><br/>

                    <div class="modal-footer" style="border:0px">
                        <div id="upload_pix_status"></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         <button type="button" id="upload_pix_btn" onclick="return ajaxFormRequest('#upload_pix_btn','#upload_pix_form','/students/change-pix','POST','#upload_pix_status','Upload picture','yes')" class="btn btn-info"><i class="fa fa-check"></i> Upload picture</button>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>

