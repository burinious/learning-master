<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
?>



<?php $__env->startSection('title'); ?>
    E-learning | Students Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if(Session::has('student_id')): ?> 
        <?php ($student_fullname = Query::getFullname('students',$the_student->id) ); ?>

        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>    

            <div class="container-fluid">
                    <h2> Welcome back, <?php echo e($student_fullname); ?> </h2>
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
                
                <div class="row">
                    
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="card m-b-0">
                            <div class="card-body">
                                <h4 class="card-title">Recently uploaded materials</h4>
                                
                                <?php if($count_materials == 0): ?>
                                    <br/><br/><p class="text-danger" style="width:100%;text-align: center;"> No material yet </p>
                                <?php else: ?>
                                    <ul class="feeds">
                                    
                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ($tutor_fullname = Query::getFullname('tutors',$material->tutor_id)); ?>
                                            
                                            <?php ($subject = Query::getValue('subjects','id',$material->subject_id,'name')); ?>

                                            <li>
                                                <div class="bg-info" style="color:#fff;padding:5px;font-size:18px"><?php echo e($loop->iteration); ?></div> 
                                                
                                                <?php echo e(ucfirst($material->title)); ?>


                                                <p style="margin-left:50px">
                                                    <a href="/the_materials/<?php echo e($material->path); ?>"><?php echo e(ucfirst($material->path)); ?></a> &nbsp; &nbsp;

                                                    <span class="text-muted"><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans()); ?></span>
                                                    <br/>
                                                </p><hr/>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div align="center">
                                            <a href="<?php echo e(route('studentMaterials')); ?>" class="btn btn-md btn-primary btn-rounded" type="button">All materials <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div><br/><br/>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="card">
                            <div class="card-body bg-inverse" style="background: url(../assets/images/background/user-info.jpg) / cover;">
                                <h4 class="text-white card-title">Recently uploaded assignments</h4>
                            </div>
                            <div class="card m-b-0">
                                <div class="card-body">
                                    
                                    <?php if($count_assignments == 0): ?>
                                        <br/><br/><p class="text-danger" style="width:100%;text-align: center;"> No assignment yet </p>
                                    <?php else: ?>
                                        <ul class="feeds">

                                            <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php ($tutor_fullname = Query::getFullname('tutors',$assignment->tutor_id)); ?>
                                               
                                               <?php ($subject = Query::getValue('subjects','id',$assignment->subject_id,'name')); ?>
                                                
                                                <li>
                                                    <div class="bg-primary" style="color:#fff;padding:5px;font-size:18px"><?php echo e($loop->iteration); ?></div> 
                                                     
                                                    <?php echo e(ucfirst($assignment->title)); ?>


                                                    <p style="margin-left:50px">
                                                        <a href="/the_assignments/all/<?php echo e($assignment->path); ?>"><?php echo e(ucfirst($assignment->path)); ?></a> &nbsp; &nbsp;
                                                    
                                                        <span class="text-muted"><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($assignment->created_at))->diffForHumans()); ?></span>
                                                        <br/>
                                                        <button class="btn btn-sm btn-info btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#SubmitSolutionModal<?php echo e($assignment->tutor_id); ?>">View solution</button>
                                                        <br/>
                                                    </p><hr/>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <div align="center">
                                                <a href="<?php echo e(route('studentAssignments')); ?>" class="btn btn-md btn-primary btn-rounded" type="button">All assignments <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                        </div>

                    </div>

                    <br/>
                    
                    
                    </div>
        
            </div>
        </section>
        <br/><br/>
    <?php else: ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('students.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>