<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
use URL;
use App\Students;
?>



<?php $__env->startSection('title'); ?>
    E-learning | Tutor Materials
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Materials</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Materials</li>
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
                    <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark pull-right" data-toggle="modal" data-target="#UploadMaterialModal">+ Upload new material</button></h2>
                <div style="clear:both;"></div> <br/>

                <div class="modal fade" id="UploadMaterialModal" tabindex="-1" role="dialog" aria-labelledby="UploadMaterialModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="UploadMaterialModalLabel"><i class="fa fa-upload"></i> Upload Material</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" id="upload_material_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>

                                    
                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Title</small> <br/>
                                        <input type="text" name="title" class="form-control"/>
                                    </div>

                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Select student</small> <br/>
                                        <?php echo Query::selectMultiItem('students','student_id','-- Select student -- ','surname'); ?>

                                    </div>

                                    <small for="recipient-name" class="control-label">Select material</small> <br/>
                                    <input type="file" name="file" accept=".pdf,.PDF,.doc,.docx"/>
                                    <br/><br/>

                                    <div class="form-group">
                                        <small for="recipient-name" class="control-label">Additional information (maximum of 255 characters)</small> <br/><p></p>
                                        <textarea class="form-control form-material" maxlength="255" name="note" rows="5"> </textarea>
                                    </div>

                                    <div class="modal-footer" style="border:0px">
                                        <div id="upload_status"></div>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="upload_btn" onclick="return ajaxFormRequest('#upload_btn','#upload_material_form','/tutors/upload-material','POST','#upload_status','Upload','yes')" class="btn btn-info"><i class="fa fa-upload"></i> Upload</button>

                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <?php if($count_materials == 0): ?>
                        <p class="alert alert-danger" style="width:100%;text-align: center;"> No material yet </p>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="card-body">
                                    <div class="form-material container">
                                        <input class="form-control p-20" type="text" id="material" placeholder="Search material" maxlength="25" onkeyup="return searchItem('#material','#search_div','real_div','search_div','/tutors/search-material')"/>
                                    </div>
                                    
                                    <ul class="feeds" id="real_div">

                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ($student_fullname = Query::getFullname('students',$material->student_id)); ?>
                                            
                                            <?php ($subject = Query::getValue('subjects','id',$material->subject_id,'name')); ?>

                                            <li>
                                                <div class="bg-info" style="color:#fff;padding:5px;font-size:18px"><?php echo e($loop->iteration); ?></div> 
                                                
                                                <?php echo e(ucfirst($material->title)); ?>


                                                <p style="margin-left:50px">
                                                    <a href="/the_materials/<?php echo e($material->path); ?>"><?php echo e(ucfirst($material->path)); ?></a> &nbsp; &nbsp;

                                                    <small style='font-size:13px'><?php echo e($subject); ?> &nbsp; &nbsp;  <?php echo e($student_fullname); ?> &nbsp; &nbsp; <?php echo e($material->size); ?></small> 
                                                    <span class="text-muted"><?php echo e(\Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans()); ?></span>
                                                    <br/><small  style='font-size:14px'> <?php echo e(ucfirst($material->note)); ?></small>
                                                </p><hr/>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div id="search_div"></div>
                                </div>
                            </div>
                            
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    <br/><br/>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('tutors.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>