<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use Session;
?>



<?php $__env->startSection('title'); ?>
    E-learning | Student | My Groups
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">My Groups</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">My Groups</li>
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
                <button type="button" class="btn btn-rounded btn-sm btn-info waves-effect waves-dark" data-toggle="modal" data-target="#AddGroupModal" data-whatever="@mdo">+ Add new group</button></h2>
            <div style="clear:both;"></div> <br/>
            
            <div class="row">
                <!-- <script type="text/javascript">
                    $(document).ready(function() {
                        ajaxLoadingRequest("/students/load-side-groups/","#side_groups_div","","GET");
                    });
                </script>
 -->
                <div id="side_groups_div"></div>

                <?php if($count_groups == 0): ?>
                    <p class="alert alert-danger" style="width:100%;text-align: center;"><i class="fa fa-remove"></i> You've not created or belong to any group yet </p>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner">
                                        <div class="form-material">
                                            <!-- <form class="form-horizontal form-material" id="search_group_form" method="POST">
                                                <?php echo e(csrf_field()); ?>

                                                <input class="form-control p-20" type="text" id="group" placeholder="Search Group" maxlength="25" onKeyup=" searchStudentGroups()"/>
                                            </form> -->
                                        </div>
                                        <ul class="chatonline style-none" id="real_div">
                                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php ($count_group_members = Query::countTheValues('group_members','group_id',$group->group_id)); ?>
                                                <?php ($group_name = Query::getValue('groups','id',$group->group_id,'name')); ?>

                                                <script type="text/javascript">
                                                    
                                                    loadGroupDetails = (group) => {
                                                        ajaxLoadingRequest("/students/group-details/"+group,"#group_details_div","","GET");
                                                    }

                                                </script>

                                                <li onClick="loadGroupDetails('<?php echo e($group->group_id); ?>')">
                                                    <a href="javascript:void(0)"><span id="group_name<?php echo e($group->group_id); ?>"> <?php echo e(ucwords($group_name)); ?>                                                    <small class="text-default"> <span id="count_the_members<?php echo e($group->group_id); ?>"> <?php echo e($count_group_members); ?> </span> Members
                                                    </small>
                                                    </span></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                            
                                        </ul>

                                        <div id="search_div"></div>
                                    </div>
                                </div>
                                <!-- .chat-left-panel -->
                                
                                <!-- .chat-right-panel -->
                                    <div class="chat-right-aside">
                                        <div id="group_details_div"></div>
                                    </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
    
        <div class="modal fade" id="AddGroupModal" tabindex="-1" role="dialog" aria-labelledby="AddGroupModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="AddGroupModal"><i class="mdi mdi-plus"></i> Add new group</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material" id="add_group_form" method="POST" onsubmit="return false" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                            <div id="phase_one">
                                <div class="form-group">
                                    <small for="recipient-name" class="control-label">Group name (maximum of 25 characters)</small>
                                    <input type="text" name="group_name" id="group_name" class="form-control" maxlength="25"/>
                                </div>

                                <div class="form-group">
                                    <small for="recipient-name" class="control-label">Short description about the group (maximum of 255 characters)</small> <br/><p></p>
                                    <textarea class="form-control form-material" maxlength="255" id="description" name="group_desc" rows="5"> </textarea>
                                </div>

                                <!-- <div class="form-group">
                                    <small for="recipient-name" class="control-label">Group display picture</small> <br/>
                                    <input type="file" name="photo" id="photo" accept=".png,.jpg,.JPG,.JPEG,.PNG"/>
                                    
                                    <div id='preview_div' style="display:none;">
                                        <p>Preview image</p>
                                        <img id="preview_pix" style='max-width: 200px' src="#" class="img-responsive img-thumbnail"/>
                                    </div>

                                </div> -->

                                <div class="modal-footer" style="border:0px">
                                    <button type="button" id="group_details_btn" onclick="return checkGroupDetails()" class="btn btn-info">Continue <i class="fa fa-arrow-circle-right"></i> </button>
                                </div>
                                <div id="phase_one_status"></div>
                            </div>

                            <div id="phase_two" style="display:none">
                                
                                <h4>Add members to group</h4>
                                
                                <div id="all_users_div"></div>
                                <br/>

                                <div>
                                    <button type="button" onClick="PrevBtn('#phase_two','#phase_one')" class="btn btn-primary pull-left"> <i class="fa fa-arrow-circle-left"></i> Back</button>

                                    <button type="button" id="add_group_btn" onclick="return ajaxFormRequest('#add_group_btn','#add_group_form','/students/add-group','POST','#phase_two_status','Add Group','yes')" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add Group </button>
                                </div>
                                <div style="clear: both;"></div>
                                <div id="phase_two_status"></div>
                                
                            </div>
                            
                        </form>

                        
                    </div>    
                </div>
            </div>
        </div>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('students.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>