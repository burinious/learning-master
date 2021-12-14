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



<?php $__env->startSection('title'); ?>
    E-learning | Quiz
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
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
                    
                    <?php if($count_questions == 0): ?>
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No question yet </p>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                   <ul class="feeds" id="real_div">

                                        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ($count_subject_questions = Query::countTheValues('questions','subject_id',$question->subject_id)); ?>
                                            <li>
                                                <div class="bg-light-info"><i class="fa fa-question"></i></div> 
                                                <a href="quiz/view/<?php echo e($question->subject_id); ?>" style="font-weight: bold"> 
                                                    <?php echo e(ucwords(Subjects::findOrFail($question->subject_id)->name)); ?>

                                                </a>
                                                <p style="margin-left:50px">
                                                    <?php if($count_subject_questions == 0): ?>
                                                        <small> <?php echo e($count_subject_questions); ?> question </small> 
                                                    <?php else: ?>
                                                        <small> 
                                                            <?php echo e($count_subject_questions); ?> 
                                                            
                                                            <?php if($count_subject_questions == 1 ): ?> 
                                                                question
                                                            <?php else: ?>
                                                                questions
                                                            <?php endif; ?> 
                                                        </small> 
                                                    <?php endif; ?>
                                                </p>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div style="clear:both" id="search_div"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    <br/><br/>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('students.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>