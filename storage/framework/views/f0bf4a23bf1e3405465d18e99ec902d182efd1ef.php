<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use App\Appointments;
use URL;
?>



<?php $__env->startSection('title'); ?>
    E-learning |  Tutor | Students
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Students</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </div>
        </div>    

        <div class="container-fluid">
                
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

                <div class="row">
                    
                    <?php if($count_students == 0): ?>
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No student yet </p>
                    <?php else: ?>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($student_fullname = Query::getFullname('students',$student->id) ); ?>
                            
                            <div class="col-md-6 col-xlg-4">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xlg-4 text-center">
                                            <a href="students/profile/<?php echo e($student->id); ?>">
                                                <?php if($student->pix != ""): ?>
                                                    <img src="/the_students/<?php echo e($student->pix); ?>" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                <?php else: ?> 
                                                    <img src="<?php echo e(URL::asset('/panels/images/avatar.png')); ?>" class="img-responsive" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xlg-4">
                                            <p></p><a href="students/profile/<?php echo e($student->id); ?>" class="text-primary" style="font-size:20px"><?php echo e($student_fullname); ?></a>
                                            <p></p>  
                                            <p><i class="mdi mdi-cellphone"></i> <?php echo e($student->phone); ?></p>
                                            <p><i class="mdi mdi-email-outline"></i> <?php echo e($student->email); ?></p>
                                            <small> <?php echo e(strtoupper($student->class)); ?> </small>
                                        </div> <br/><p></p>


                                    </div>
                                </div>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
    <br/><br/>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('tutors.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>