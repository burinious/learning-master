<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Query;
use Session;
?>



<?php $__env->startSection('title'); ?>
    E-learning | Tutors Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<section id="wrapper">
        <div class="the-register" style="background-image:url(/panels/assets/images/background/login-register.jpg);">
            <div class="login-box card container">
                <br/>
                <?php if(session('error')): ?>
                    <div class='alert alert-danger'>
                        <i class="fa fa-remove"></i> <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class='alert alert-success'>
                        <i class="fa fa-check"></i> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(Session::has('operation')): ?> 
                    <div class='alert alert-success'>
                        <i class="fa fa-check"></i> <?php echo e(session('operation')); ?>

                    </div>
                <?php endif; ?>

                <?php (Session::forget('operation')); ?>

                
                <div class="card-body">
                    <div class="col-xs-12" align="center">
                        <a href="<?php echo e(route('studentIndex')); ?>"  class="btn btn-success btn-sm text-uppercase waves-effect waves-light">Go to students' panel <i class="fa fa-arrow-circle-right"></i></a>
                    </div> <br/>
                    <form class="form-horizontal form-material" method="post" id="loginform" action="<?php echo e(route('tutorSignin')); ?>" onsubmit="return false">
                        <?php echo e(csrf_field()); ?>

                        <h3 class="box-title m-b-20" align="center">Sign In as a Tutor</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="tutor_id" required="" placeholder="Tutor ID"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="password" placeholder="Password"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <div id="login_status" align="center"></div>

                                <button type="button" id="login_tutor_btn" onclick="return ajaxFormRequest('#login_tutor_btn','#loginform','tutors/tutor-signin','POST','#login_status','Log In','no')" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">Log In </button>
                                
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
                        <?php echo e(csrf_field()); ?>

                        <h3 class="box-title m-b-20" align="center">Sign Up as a Tutor</h3>
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
                                <?php echo Query::selectItem('subjects','subject_id','-- Select subject --'); ?>

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

                                <button type="button" id="register_tutor_btn" onclick="return ajaxFormRequest('#register_tutor_btn','#registerform','tutors/tutor-signup','POST','#register_status','Sign Up','no')" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">Sign Up </button>
                                
                            </div>
                        </div>
                        
                        Already have an account? <a href="javascript:void(0)" id="to-the-login" class="text-dark"> Login now</a> 
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br/><br/>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('tutors.front_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>