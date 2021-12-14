<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
?>


<?php ($student_fullname = Query::getFullname('students',$student->id) ); ?>
                        
<?php $__env->startSection('title'); ?>
    E-learning |  Tutor | <?php echo e($student_fullname); ?>'s Profile
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><?php echo e($student_fullname); ?>'s Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo e($student_fullname); ?>'s Profile</li>
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
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">

                        <div align="center">
                            <div class="align-self-center" align="center">
                             <br/> 
                                <?php if($student->pix != ""): ?>
                                    <img src="/the_students/<?php echo e($student->pix); ?>" alt="user" style="max-width:150px" class="img-responsive img-thumbnail"/>
                                <?php else: ?> 
                                    <img src="<?php echo e(URL::asset('/panels/images/avatar.png')); ?>" class="img-responsive img-circle" style="max-width:150px"/>
                                <?php endif; ?> <br/>
                                
                                <p></p>
                                
                            </div><br/>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body"> <small class="text-muted">Email address </small>
                            <h6><?php echo e($student->email); ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                            <h6><?php echo e($student->phone); ?></h6> <small class="text-muted p-t-30 db">Address</small>
                            <h6><?php echo e($student->address); ?></h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#appointment" role="tab">Appointments</a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            
                            <div class="tab-pane active" id="profile" role="tabpanel">
                                <div class="card-body">
                                    <h3> About <?php echo e($student_fullname); ?> </h3><hr/>
                                    <p class="m-t-30"><?php echo e($student->about); ?></p>
                                </div>
                            </div>

                            <div class="tab-pane" id="appointment" role="tabpanel">
                                <div class="card-body">
                                    <?php if($count_appointments == 0): ?>
                                        <p class="text-danger" style="width:100%;text-align: center;"><?php echo e($student_fullname); ?> hasn't booked any appointment with you</p>
                                    <?php else: ?>
                                        <h4 align="center"> Appointments with <?php echo e($student_fullname); ?> <span class="badge badge-success"><?php echo e($count_appointments); ?> </span></h4>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="row card-body">
                                                    <div class="card b-all shadow-none">
                                                        <div class="table-responsive m-t-40">
                                                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>S/N</th>
                                                                        <th>Title</th>
                                                                        <th>Description</th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    
                                                                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php ($student_fullname = Query::getFullname("students",$appointment->student_id)); ?>

                                                                    <tr>
                                                                        <td><?php echo e($loop->iteration); ?></td>
                                                
                                                                        <td>
                                                                            <a href="/students/appointment/view/<?php echo e($appointment->id); ?>">
                                                                            <?php echo e(ucfirst(substr($appointment->title,0,50))); ?>

                                                                            </a>
                                                                        </td>
                                                                        <td><?php echo html_entity_decode(nl2br(substr($appointment->content,0,100))); ?> ...</td>
                                                                        <td>
                                                                            <?php if($appointment->status == "0"): ?>
                                                                                <small class='text-warning'> pending </small>
                                                                            <?php elseif($appointment->status == "1"): ?>
                                                                                <small class='text-info'> approved </small>
                                                                            <?php else: ?>
                                                                                <small class='text-danger'> declined </small>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <small><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($appointment->created_at))->diffForHumans()); ?> </small>
                                                                        </td>
                                                                    </tr>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </tbody>
                                                        </table>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php echo e($appointments->links()); ?>

                                            </div>
                                        <?php endif; ?>
                                        </div>
                                </div>
                        </div>
                    </div>

                </div>
                <!-- Column -->
            </div>
        </div>
    <br/><br/>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('tutors.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>