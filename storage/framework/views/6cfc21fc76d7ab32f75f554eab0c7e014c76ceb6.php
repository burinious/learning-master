<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Subjects;
use Session;
use URL;
?>



<?php $__env->startSection('title'); ?>
    E-learning | Tutor | Quiz
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
    <?php ($subject = Subjects::findOrFail($the_tutor->subject_id)->name); ?>

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

                <h2 class="add-ct-btn pull-right">
                    <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark pull-right" data-toggle="modal" data-target="#AddQuestionModal">+Add new question</button></h2>
                <div style="clear:both;"></div> <br/>

                <div class="modal fade" id="AddQuestionModal" tabindex="-1" role="dialog" aria-labelledby="AddQuestionModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="AddQuestionModalLabel"><i class="fa fa-add_question"></i> Set <?php echo e($subject); ?> Questions </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal form-material" id="add_question_form" method="POST" onsubmit="return false">
                                    <?php echo e(csrf_field()); ?>

                                    
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                        <label class="control-label" for="demo-is-inputsmall">Question</label>
                                        <input type="text" value="<?php echo e(old('question')); ?>" class="form-control input-sm" name="question" id="question"/>  
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-xs-12"> <br/>
                                        <label class="control-label" for="demo-is-inputsmall">Select type</label>
                                            <?php echo Query::selectQuestionType(); ?> <br/><br/>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-12 col-xs-12" id="boolean_answer_div" style="display:none">
                                        <label class="control-label" for="demo-is-inputsmall">Correct option</label>
                                        <select name="correct_boolean_option" id="correct_boolean_option" value="<?php echo e(old('correct_boolean_option')); ?>" class="form-control">
                                            <option value=''> -- Select correct option  -- </option> 
                                            <option value='true'> True </option> 
                                            <option value='false'> False </option> 
                                        </select>
                                    </div>

                                    <div id="multiple_answer_div" style="display:none">

                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <small>Option A</small>
                                            <input type="text" value="<?php echo e(old('option_a')); ?>" class="form-control input-sm" name="option_a" id="option_a"/> <br/><br/>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <small>Option B</small>
                                            <input type="text" value="<?php echo e(old('option_b')); ?>" class="form-control input-sm" name="option_b" id="option_b"/> <br/><br/> 
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <small>Option C</small>
                                            <input type="text" value="<?php echo e(old('option_c')); ?>" class="form-control input-sm" name="option_c" id="option_c"/>  <br/><br/>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <small>Option D</small>
                                            <input type="text" value="<?php echo e(old('option_d')); ?>" class="form-control input-sm" name="option_d" id="option_d"/>  
                                        </div>


                                        <div class="col-sm-12 col-md-12 col-xs-12"><br/>
                                            <label class="control-label" for="demo-is-inputsmall">Correct option</label>
                                            <select name="correct_option" id="correct_option" value="<?php echo e(old('correct_option')); ?>" class="form-control">
                                                <option value=''> -- Select correct option  -- </option> 
                                                <option value='a'> Option A </option> 
                                                <option value='b'> Option B </option> 
                                                <option value='c'> Option C </option>
                                                <option value='d'> Option D </option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer" style="border:0px">
                                        <div id="add_question_status"></div>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="add_question_btn" onclick="return ajaxFormRequest('#add_question_btn','#add_question_form','/tutors/add-question','POST','#add_question_status','Add','yes')" class="btn btn-info"><i class="fa fa-plus"></i> Add</button>

                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <?php if($count_questions == 0): ?>
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No question yet </p>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <script type="text/javascript">
                                            
                                            $(document).ready(function() {
                                                var type = "<?php echo e($question->type); ?>";

                                                if(type == "boolean") {
                                                    $("#the_multiple_boolean_div<?php echo e($question->id); ?>").show("fast");
                                                    $("#multiple_answer_div<?php echo e($question->id); ?>").hide("fast");
                                                } else if(type == "multiple") {
                                                    $("#the_multiple_boolean_div<?php echo e($question->id); ?>").hide("fast");
                                                    $("#multiple_answer_div<?php echo e($question->id); ?>").show("fast");
                                                }
                                            });

                                        </script>
                                        <p class="text-info" style="font-size:16px"><span class="badge badge-info"><?php echo e($loop->iteration); ?></span> &nbsp; <?php echo e(ucfirst($question->question)); ?> </p> 
                                        
                                        <div class="modal fade" id="updateQuestionModal<?php echo e($question->id); ?>" tabindex="-1" role="dialog" aria-labelledby="updateQuestionModalLabel<?php echo e($question->id); ?>">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="UpdateQuestionModalLabel<?php echo e($question->id); ?>"><i class="fa fa-add_question"></i> Update Question </h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <form class="form-horizontal form-material" id="update_question_form<?php echo e($question->id); ?>" method="POST" onsubmit="return false">
                                                            <?php echo e(csrf_field()); ?>

                                                            
                                                            <div class="col-sm-12 col-md-12 col-xs-12">
                                                                <label class="control-label" for="demo-is-inputsmall">Question</label>
                                                                <input type="text" class="form-control input-sm" name="question" id="question" value="<?php echo e(ucfirst($question->question)); ?>"/><p></p>  
                                                            </div>

                                                            <div class="col-sm-12 col-md-12 col-xs-12">
                                                                <br/>
                                                                <label class="control-label" for="demo-is-inputsmall">Select type</label>
                                                                    <?php echo Query::selectedQuestionType($question->type,$question->id); ?> <p></p>
                                                            </div>
                                                            
                                                            <div id="the_multiple_answer_div<?php echo e($question->id); ?>">
                                                                
                                                                <br/>

                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <small>Option A</small>
                                                                    <input type="text" value="<?php echo e(ucfirst($question->a)); ?>" class="form-control input-sm" name="option_a" id="option_a"/>  <p></p> 
                                                                </div>

                                                                <br/>
                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <small>Option B</small>
                                                                    <input type="text" value="<?php echo e(ucfirst($question->b)); ?>" class="form-control input-sm" name="option_b" id="option_b"/> <p></p> 
                                                                </div>

                                                                <br/>
                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <small>Option C</small>
                                                                    <input type="text" value="<?php echo e(ucfirst($question->c)); ?>" class="form-control input-sm" name="option_c" id="option_c"/>  <p></p>
                                                                </div>

                                                                <br/>
                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <small>Option D</small>
                                                                    <input type="text" value="<?php echo e(ucfirst($question->d)); ?>" class="form-control input-sm" name="option_d" id="option_d"/> <p></p> 
                                                                </div>


                                                                <br/>
                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <label class="control-label" for="demo-is-inputsmall">Correct option</label>
                                                                    <?php if($question->type == "multiple"): ?>
                                                                        <?php echo Query::selectedCorrectOption($question->answer); ?>

                                                                    <?php endif; ?>
                                                                </div>

                                                            </div>
                                                            
                                                            <div id="the_multiple_boolean_div<?php echo e($question->id); ?>">

                                                                <div class="col-sm-12 col-md-12 col-xs-12">
                                                                    <label class="control-label" for="demo-is-inputsmall">Correct option</label>
                                                                    <?php if($question->type == "boolean"): ?>
                                                                        <?php echo Query::selectedCorrectBooleanOption($question->answer); ?>

                                                                    <?php endif; ?>
                                                                </div>

                                                            </div>

                                                            <br/>

                                                            <div class="modal-footer" style="border:0px">
                                                                <div id="update_question_status<?php echo e($question->id); ?>"></div>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="button" id="update_question_btn<?php echo e($question->id); ?>" onclick="return ajaxFormRequest('#update_question_btn<?php echo e($question->id); ?>','#update_question_form<?php echo e($question->id); ?>','/tutors/update-question/<?php echo e($question->id); ?>','POST','#update_question_status<?php echo e($question->id); ?>','Save changes','yes')" class="btn btn-info"><i class="fa fa-check"></i> Save changes</button>

                                                            </div>
                                                        </form>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div style="font-size:14px;margin-left:20px">
                                            <a href="#" class="text-primary" data-toggle="modal" data-target="#updateQuestionModal<?php echo e($question->id); ?>"><i class="fa fa-pencil"></i> Edit</a> &nbsp; &nbsp;

                                            <a href="quiz/delete/<?php echo e($question->id); ?>" class="text-danger" onclick="return confirm('Answers to this question will be deleted as well \n \n Delete question?')"><i class="fa fa-remove"></i> Delete</a> 
                                        </div>
                                        <br/><hr/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    <br/><br/>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('tutors.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>