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


<?php ($subject = ucwords(Subjects::findOrFail($subject_id)->name)); ?>

<?php $__env->startSection('title'); ?>
    <?php if($count_answers == 0): ?>
        E-learning | <?php echo e($subject); ?> Questions
    <?php else: ?>
        E-learning | <?php echo e($subject); ?> Result
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">
                    <?php if($count_answers == 0): ?>
                        <?php echo e($subject); ?> Questions
                    <?php else: ?>
                        <?php echo e($subject); ?> Result
                    <?php endif; ?>
                </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">
                        <?php if($count_answers == 0): ?>
                            <?php echo e($subject); ?> Questions
                        <?php else: ?>
                            <?php echo e($subject); ?> Result
                        <?php endif; ?>
                    </li>
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
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No <?php echo e($subject); ?> question yet </p>
                    
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                   
                                    <?php if($count_answers == 0): ?>

                                        <div class="col-md-offset-2 col-xs-10">
                                            
                                            <br/><br/>
                                            
                                            <form class="form-horizontal" id="submit-answer<?php echo e($subject_id); ?>" method="post">
                                                <?php echo e(csrf_field()); ?>


                                                <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php ($i = $loop->iteration); ?>
                                                    
                                                    <?php if( ($i==1) && ($i == $count_questions) ): ?>
                                                        
                                                        <?php if($count_questions == 1): ?>

                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?> 
                                                                </p>
                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>

                                                        <?php elseif($count_questions == 2): ?>
                                                            
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?> 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>

                                                        <?php else: ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php endif; ?>
                                                    
                                                    <?php elseif( ($i==1) && ($i !== $count_questions) ): ?>
                                                        
                                                        <?php if($count_questions == 1): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        
                                                        <?php elseif($count_questions == 2): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php else: ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?> 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php endif; ?>

                                                    <?php elseif($i < $count_questions): ?>
                                                        
                                                        <?php if($count_questions == 1): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php elseif($count_questions == 2): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php else: ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='next btn btn-md btn-info' type='button'> Next <i class="fa fa-arrow-right"></i></button>
                                                                </div> <br/>
                                                            </div>
                                                        <?php endif; ?>

                                                    <?php elseif($i == $count_questions): ?>
                                                        
                                                        <?php if($count_questions == 1): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?> 
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button>
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> 
                                                                <br/> <br/>
                                                            </div>
                                                        <?php elseif($count_questions == 2): ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>  
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'><i class="fa fa-check"></i> Submit</button>
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> <br/> 
                                                                <br/>
                                                            </div>
                                                        <?php else: ?>
                                                            <div id="question_div<?php echo e($i); ?>" class="all_questions_div">
                                                                <span class="badge badge-info"><b><?php echo e($i); ?></b></span> 
                                                                &nbsp; <?php echo e(ucfirst($question->question)); ?> 
                                                                
                                                                <input type="hidden" name="question_id<?php echo e($question->id); ?>" value="<?php echo e($question->id); ?>"/>

                                                                <p style="font-size:14px;padding:10px;text-align: left">
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="true" type="radio" name="option<?php echo e($question->id); ?>" value="true"/>
                                                                                <label for="true">True</label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="false" type="radio" name="option<?php echo e($question->id); ?>" value="false"/>
                                                                                <label for="false">False</label>
                                                                            </div>
                                                                        </div>

                                                                    <?php elseif($question->type == "multiple"): ?>
                                                                        <div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->a); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="a"/>
                                                                                <label for="<?php echo e($question->a); ?>"><?php echo e(ucfirst($question->a)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->b); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="b"/>
                                                                                <label for="<?php echo e($question->b); ?>"><?php echo e(ucfirst($question->b)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->c); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="c"/>
                                                                                <label for="<?php echo e($question->c); ?>"><?php echo e(ucfirst($question->c)); ?></label>
                                                                            </div>
                                                                            <div class="md-radio">
                                                                                <input id="<?php echo e($question->d); ?>" type="radio" name="option<?php echo e($question->id); ?>" value="d"/>
                                                                                <label for="<?php echo e($question->d); ?>"><?php echo e(ucfirst($question->d)); ?></label>
                                                                            </div>
                                                                        </div>

                                                                    <?php endif; ?>
                                                                </p>

                                                                <br/>
                                                                <div class="col-md-offset-1 col-md-12">
                                                                    <button id="<?php echo e($i); ?>" class='previous btn btn-md btn-info' type='button'><i class="fa fa-arrow-left"></i> Prev </button>
                                                                    &nbsp; &nbsp;
                                                                    <button id="<?php echo e($i); ?>" class='submit-answer btn btn-md btn-info' type='button'> <i class="fa fa-check"></i> Submit</button> 
                                                                    <br/><br/>
                                                                    <div id="answer_status"></div>
                                                                </div> <br/> 

                                                                
                                                                <br/> <br/>
                                                            </div>
                                                        <?php endif; ?>
                                                    
                                                    <?php endif; ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <h2 class="text-danger"><i class="fa fa-remove"></i> No courses yet </h2>
                                                <?php endif; ?>
                                            </form>
                                        <br/><br/>
                                    </div></div></div>

                                    <?php else: ?>
                                        <h2 class="text-primary"> Result under compilation. Please try again </h2>
                                    </div>

                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
                    var data = $("form#submit-answer<?php echo e($subject_id); ?>").serialize();
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
<?php $__env->stopSection(); ?>




<?php echo $__env->make('students.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>