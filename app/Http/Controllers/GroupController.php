<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Subjects;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Students;
use App\Tutors;
use App\Groups;
use App\GroupMembers;
use App\GroupChat;
use DB;
use Session;

class GroupController extends Controller
{
    //for students

    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$groups =  GroupMembers::distinct()->where('type','student')->where('user_id',$student_id)->get();
		$count_groups = GroupMembers::distinct()->where('type','student')->where('user_id',$student_id)->count();
		$data = array("student_id" => $student_id, "the_student" => $the_student, "groups" => $groups, "count_groups" => $count_groups);
		return view('students.groups')->with($data);
	}

	public function allUsers() {
		$student_id = Session::get('student_id');
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$students = Students::orderBy('id','DESC')->where('id','<>',$student_id)->get();	
		$convert_tutors = json_decode(json_encode($tutors,true));
		$convert_students = json_decode(json_encode($students,true));
		$all_users = array_merge($convert_students,$convert_tutors);
		$count_all_users = count($all_users);

		if($count_all_users == 0) {
            echo '<p class="text-danger" style="width:100%;text-align: center;"> No user yet </p>';
		} else {
        	?>
        	<ul class="feeds">

                <?php
                
                foreach($all_users as $key=>$user) {
                	$counter = $key+1;
                	$check = $user->type."-".$user->id;

                	if($user->type == "student") {
                		
                		if($user->pix != "") {
                		    $img = "<img src='/the_students/".$user->pix."' class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('students','id',$user->id,'phone');
                		$class = Query::getValue('students','id',$user->id,'class');
                		$user_fullname = Query::getFullname('students',$user->id);
                		$tutor_rating = "";
                	} else {

                		if($user->pix != "") {
                		    $img = "<img src='/the_tutors/".$user->pix."' class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('tutors','id',$user->id,'phone');
                		$count_ratings = Query::countTheValues('ratings','tutor_id',$user->id);
                        $tutor_rating = "<i class='mdi mdi-star'></i> ".Query::tutorRating($user->id);
						$user_fullname = Query::getFullname('tutors',$user->id);
                	}
                	?>
                    <li>
                        <div class="bg-light-info"><?php echo $img;?></div> 
                        <?php echo $user_fullname;?>
                        <div class="demo-checkbox pull-right">
			                <input type="checkbox" id="basic_checkbox_<?php echo $counter;?>" name="members[]" value="<?php echo $check;?>"/>
			                <label for="basic_checkbox_<?php echo $counter;?>"></label>
			            </div>
                        <p style="margin-left:50px">
                           <small> 
                                <?php echo ucfirst($user->type);?> &nbsp;  &nbsp; <?php echo $tutor_rating;?> &nbsp; &nbsp; <?php echo $user->phone;?>
                            </small> 
                            <hr/>
				        </p> 
                    </li>
                    <?php
            	}
            	?>
            </ul>
            <?php
        }
	}

	public function allUsersModal($group_id) {
		?>
			<form class="form-horizontal form-material" id="add_group_member_form" method="POST" onsubmit="return false">
                <?php echo csrf_field();?>
                
                <script type="text/javascript">
                	var group_id = "<?php echo $group_id;?>";
                	ajaxRequest("/students/all-group-users/"+group_id,"#all_users_div","GET");
                </script>

                <div id="all_users_div"></div>
                <br/>

                <button type="button" id="add_group_member_btn" onclick="return ajaxFormRequest('#add_group_member_btn','#add_group_member_form','/students/add-group-member/'+group_id,'POST','#phase_two_status','Add Members','yes')" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add Members </button>
                
                <div style="clear: both;"></div>
                <div id="phase_two_status"></div>
                
            </form>
		<?php
	}

	public function editGroupDetailsModal($group_id) {
		$group = Groups::findOrFail($group_id);
		?>
			<form class="form-horizontal form-material" id="update_group_form" method="POST" onsubmit="return false">
                <?php echo csrf_field();?>
                <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>"/>
                <div class="form-group">
                    <small for="recipient-name" class="control-label">Group name (maximum of 25 characters)</small>
                    <input type="text" name="group_name" value="<?php echo $group->name;?>" id="group_name" class="form-control" maxlength="25"/>
                </div>

                <div class="form-group">
                    <small for="recipient-name" class="control-label">Short description about the group (maximum of 255 characters)</small> <br/><p></p>
                    <textarea class="form-control form-material" maxlength="255" id="description" name="group_desc" rows="5"><?php echo ucfirst($group->description);?></textarea>
                </div>

                <br/>

                <button type="button" id="update_group_btn" onclick="return ajaxFormRequest('#update_group_btn','#update_group_form','/students/update-group-details','POST','#phase_two_status','Save changes','yes')" class="btn btn-info pull-right"><i class="fa fa-check"></i> Save changes </button>
                
                <div style="clear: both;"></div>
                <div id="phase_two_status"></div>
                
            </form>
		<?php
	}

	public function allGroupUsers($group_id) {
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$students = Students::orderBy('id','DESC')->get();	
		$convert_tutors = json_decode(json_encode($tutors,true));
		$convert_students = json_decode(json_encode($students,true));
		$all_users = array_merge($convert_students,$convert_tutors);
		$count_all_users = count($all_users);

		if($count_all_users == 0) {
            echo '<p class="text-danger" style="width:100%;text-align: center;"> No user yet </p>';
		} else {
        	?>
        	<ul class="feeds">

                <?php
                
                foreach($all_users as $key=>$user) {
                	$counter = $key+1;
                	$check = $user->type."-".$user->id;

                	if($user->type == "student") {
                		$user_exists = GroupMembers::where('type','student')->where('user_id',$user->id)->where('group_id',$group_id)->count();

                		if($user->pix != "") {
                		    $img = "<img src='/the_students/".$user->pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('students','id',$user->id,'phone');
                		$class = Query::getValue('students','id',$user->id,'class');
                		$user_fullname = Query::getFullname('students',$user->id);
                		$tutor_rating = "";
                	} else {
                		$user_exists = GroupMembers::where('type','tutor')->where('user_id',$user->id)->where('group_id',$group_id)->count();

                		if($user->pix != "") {
                		    $img = "<img src='/the_tutors/".$user->pix."' class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('tutors','id',$user->id,'phone');
                		$count_ratings = Query::countTheValues('ratings','tutor_id',$user->id);
                        $tutor_rating = "<i class='mdi mdi-star'></i> ".Query::tutorRating($user->id);
						$user_fullname = Query::getFullname('tutors',$user->id);
                	}
                	?>
                    <li>
                        <div class="bg-light-info"><?php echo $img;?></div> 
                        
                        <?php echo $user_fullname;?>
                        
                        <?php

		                if($user_exists == 0) {
		                	?>
		                	<div class="demo-checkbox pull-right">
			            		<input type="checkbox" id="basic_checkbox_<?php echo $counter;?>" name="members[]" value="<?php echo $check;?>"/>
		                		<label for="basic_checkbox_<?php echo $counter;?>"></label>
		                	</div>
		                	<?php
		                } else {
		                	echo "<small class='text-warning pull-right'> Member already added </small>";
		                }
		                ?>

                        <p style="margin-left:50px">
                           <small> 
                                <?php echo ucfirst($user->type);?> &nbsp;  &nbsp; <?php echo $tutor_rating;?> &nbsp; &nbsp; <?php echo $user->phone;?>
                            </small> 
                            <hr/>
				        </p> 
                    </li>
                    <?php
            	}
            	?>
            </ul>
            <?php
        }
	}

	public function updateGroupDetails(Request $request) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$group_exists = Groups::where('name',$request->group_name)->where('type','student')->where('user_id',$student_id)->where('id','<>',$request->group_id)->count();
		
    	if(empty($request->group_id) || empty($request->group_name) || empty(trim($request->group_desc))) {
			return "<p style='color:red'>Please fill both fields. </p>";
		} else if($group_exists > 0) {
		 	return "<p style='color:red'>You have added this group before. </p>";
		} else {
			$group = Groups::findOrFail($request->group_id);
			$group->name = $request->group_name;
			$group->description = $request->group_desc;
			$group->save();
			?>
				<script type="text/javascript">
					var group = "<?php echo $request->group_id;?>";
					var group_name = "<?php echo $request->group_name;?>";
					$("#EditGroupDetailsModal").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					ajaxLoadingRequest("/students/group-details/"+group,"#group_details_div","","GET");
				</script>
			<?php
			return "<p style='color:green'>Group details was successfully added.</b></p>";
		}
	}

	public function addStudentGroup(Request $request) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$group_exists = Groups::where('name',$request->group_name)->where('type','student')->where('user_id',$student_id)->count();

    	if(empty($request->group_name) || empty(trim($request->group_desc))) {
			return "<p style='color:red'>Please fill both fields. </p>";
		} else if($group_exists > 0) {
		 	return "<p style='color:red'>You have added this group before. </p>";
		} else {
			$group = new Groups();
			$group->name = $request->group_name;
			$group->description = $request->group_desc;
			$group->user_id = $student_id;
			$group->type = "student";
			$folder = "the_groups/";
			$group->unique_id = time().mt_rand(111111,999999);
    	   	
          //   if(!empty($_FILES["photo"]['name'])) {
        		// $photo_tmp =  $_FILES["photo"]['tmp_name'];
          //       $photo_name =  $_FILES["photo"]['name'];
          //       $photo_type =  $_FILES["photo"]['type'];
                
          //       if($photo_type == "image/png" || $photo_type == "image/PNG" || $photo_type == "image/jpg" || $photo_type == "image/JPG" || $photo_type == "image/jpeg" || $photo_type == "image/JPEG") {
                    
          //           $group->pix = $group->unique_id.".jpg";
          //           $path = $folder.$group->unique_id.".jpg";
          //           move_uploaded_file($photo_tmp,$path);
          //       }
          //   } else {
          //   	$group->pix = "";
          //   }
            
            $group->save();
			
			$group_id = Groups::where('name',$group->name)->where('type','student')->where('user_id',$group->user_id)->value('id');
			$data = array();
			$user_data = array();
			$selected_members = $request->get('members');
           	$count_members =  count($selected_members);

			if($count_members > 0) {

				foreach($selected_members as $member) {
					$the_member = explode("-",$member);				
					$member_type = $the_member[0];
					$member_user_id = $the_member[1];
					$user_exists = GroupMembers::where('type',$member_type)->where('user_id',$member_user_id)->where('group_id',$group_id)->count();

					if($user_exists == 0) {
						$data[] = [
							'group_id' => $group_id,
							'type' => $member_type,
							'user_id' => $member_user_id,
							'created_at' => date("Y-m-d H:i:s"),
		                    'updated_at' => date("Y-m-d H:i:s")
						];
					}
				}

				if(count($data) > 0) {
					DB::table('group_members')->insert($data);

					$user_data[] = [
						'group_id' => $group_id,
						'type' => 'student',
						'user_id' => $student_id,
						'created_at' => date("Y-m-d H:i:s"),
	                    'updated_at' => date("Y-m-d H:i:s")
					];
					DB::table('group_members')->insert($user_data);
				} 

				Session::put('operation',"Group details was successfully added.");
	        	?>

				<script type="text/javascript">
					setTimeout(function() {
						window.location="/students/groups";
					},1000); 
				</script>

				<?php
				return "<p style='color:green'>Group details was successfully added.</b></p>";
			} else {
				$group_id = Groups::where('name',$group->name)->where('type','student')->where('user_id',$group->user_id)->delete();
				return "<p style='color:red'>At least one user must be added to the group.</b></p>";
			}
		}
	}

	public function addStudentGroupMember(Request $request,$group_id) {
		$data = array();
		$selected_members = $request->get('members');
       	$count_members =  count($selected_members);

		if($count_members > 0) {
			
			foreach($selected_members as $member) {
				$the_member = explode("-",$member);				
				$member_type = $the_member[0];
				$member_user_id = $the_member[1];
				$user_exists = GroupMembers::where('type',$member_type)->where('user_id',$member_user_id)->where('group_id',$group_id)->count();

				if($user_exists == 0) {
					$data[] = [
						'group_id' => $group_id,
						'type' => $member_type,
						'user_id' => $member_user_id,
						'created_at' => date("Y-m-d H:i:s"),
		                'updated_at' => date("Y-m-d H:i:s")
					];
				}
			}

			if(count($data) > 0) {
				$add_group_members = DB::table('group_members')->insert($data);
			} else {
				return "<p style='color:red'>No member added.</b></p>";
			}
			$count_group_members = GroupMembers::where('group_id',$group_id)->count();
			?>

			<script type="text/javascript">
				var group = "<?php echo $group_id;?>";
				var count_members = "<?php echo $count_group_members;?>";
				document.getElementById('count_the_members'+group).innerHTML = count_members;
				document.getElementById('count_group_members').innerHTML = count_members;
				$("#AddGroupMemberModal").modal('hide');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
				ajaxLoadingRequest("/students/group-members/"+group,"#group_members_div","","GET");
			</script>

			<?php
			return "<p style='color:green'>Group members were successfully added.</b></p>";
		} else {
			return "<p style='color:red'>At least one user must be added to the group.</b></p>";
		}
	}

	public function search($group) {
		$student_id = Session::get('student_id');
		//$groups = DB::table('group_members')->join('groups','groups.id','=','group_members.group_id')->select('group_members.*','groups.*')->get();
		$groups =  GroupMembers::distinct()->where('type','student')->where('user_id',$student_id)->get();
		$count_groups = GroupMembers::distinct()->where('type','student')->where('user_id',$student_id)->count();

		if($count_groups  == 0) {

		} else {
			echo '<ul class="chatonline style-none">';
	        
	        foreach($groups as $group) {

	            $count_group_members = Query::countTheValues('group_members','group_id',$group->group_id);
	            $group_name = Query::getValue('groups','id',$group->group_id,'name');
				
				?>

	                <script type="text/javascript">
	                    loadGroupDetails = (group) => {
	                        ajaxLoadingRequest("/students/group-details/"+group,"#group_details_div","","GET");
	                    }

	                </script>

	                <li onClick="loadGroupDetails('<?php echo $group->group_id;?>')">
	                    <a href="javascript:void(0)"><span id="group_name<?php echo $group->group_id;?>"> <?php echo $group_name;?>soskpo                                              
	                    <small class="text-default"> <span id="count_the_members<?php echo $group->group_id;?>"> <?php echo $count_group_members;?> </span> Members
	                    </small>
	                    </span></a>
	                </li>
	            <?php
	        }
	        echo "</ul>";
		}
	}

	public function studentGroupMembers($group_id) {
		$student_id = Session::get('student_id');
		$group = Groups::findOrFail($group_id);
		$group_members = GroupMembers::where('group_id',$group_id)->get();
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		$created_by = Query::getValue('groups','id',$group_id,'user_id');
		
		if($count_group_members == 0) {
       		echo '<br/><p class="text-danger" style="width:100%;text-align: center;"> No member yet </p>';
       	} else {

           	foreach($group_members as $group_member) {
				
				if($student_id) {
					
					if( ($group_member->type == "student") && ($group_member->user_id == $student_id) ) {
						$is_student = "yes";
					} else {
						$is_student =  "no";
					}

					if( ($group_member->type == "student") && ($group_member->user_id == $created_by) ) {
						$is_creator = "yes";
					} else {
						$is_creator = "no";
					}
				} else {
					$is_student =  "no";
				}

				if($group_member->type == "student") {
					$member_pix = Students::where('id',$group_member->user_id)->value('pix');

					if($member_pix != "") {
            		    $img = "<img src='/the_students/".$member_pix."' class='img-responsive img-circle'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

					$member_fullname = 	Query::getFullname('students',$group_member->user_id);
					$member_phone = Students::where('id',$group_member->user_id)->value('phone');
					$tutor_rating = "";
               	} else {
               		$member_pix = Tutors::where('id',$group_member->user_id)->value('pix');
               		$member_subject = Tutors::where('id',$group_member->user_id)->value('subject_id');
               		$the_subject = Subjects::where('id',$member_subject)->value('name');

					if($member_pix != "") {
            		    $img = "<img src='/the_tutors/".$member_pix."' class='img-responsive img-circle'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

               		$member_fullname = 	Query::getFullname('tutors',$group_member->user_id);
					$member_phone = Tutors::where('id',$group_member->user_id)->value('phone');
					$count_ratings = Query::countTheValues('ratings','tutor_id',$group_member->user_id);
					$tutor_rating = Query::tutorRating($group_member->user_id);
               	}

               	?>

               	<script type="text/javascript">
               		var group_id = "<?php echo $group_id;?>";
               		var member_type = "<?php echo $group_member->type;?>";
               		var member_id = "<?php echo $group_member->id;?>";
               		var member_fullname = "<?php echo $member_fullname;?>";
               		var group_name = "<?php echo $group->name;?>";
               	</script>

               	<a href="#">
                    <div class="user-img"> 
                    	<?php echo $img;?>
                    	<!-- <span class="profile-status online pull-right"></span>  -->
                    </div>
                    <div class="mail-contnet">
                        
                        <?php

                        	if($student_id && $is_creator == "yes") {
                        		
                        		if($is_creator == "no") {
	                        		?>
		                        	<h5><?php echo $member_fullname;?></h5> 
			                    
			                        <div class="pull-right">
						                <button type="button" id="remove_member_btn" onclick="return ajaxBtnRequest('#remove_member_btn<?php echo $group_member->id;?>','/students/remove-group-member/<?php echo $group_id;?>/<?php echo $group_member->id;?>','#remove_status<?php echo $group_member->id;?>','Remove','yes','Remove <?php echo $member_fullname;?> from '+group_name+' group?')" class="btn btn-rounded btn-sm btn-danger pull-right"> Remove </button>
						                <div style="clear:both" id="remove_status<?php echo $group_member->id;?>"></div>
						            </div>
						            <?php
	                        	}
	                        }
		                	else {
		                		
		                		?>
	                        	<h5><?php echo $member_fullname;?></h5> 
		                    
		                        <span class="mail-desc"><i class="fa fa-phone"></i> <?php echo $member_phone;?> &nbsp;  &nbsp; 
		                        	<?php

		                        	if($group_member->type == "tutor") {
		                        		echo ($count_ratings == 0) ? "<small class='text-danger'> No rating yet </small>" : " <i class='mdi mdi-star'></i> ".$tutor_rating;
		                        		echo "&nbsp;  &nbsp;  &nbsp; <span class='text-primary'>".$the_subject."</span>";
		                        	}

		                        	?>
		                           
		                        </span>
		                        <?php
			                }
		                ?>
		                
                    </div>
                </a>
            	<?php
           	}
    	}
    }


	public function studentGroupDetails($group_id) {
		$group = Groups::findOrFail($group_id);
		$group_members = GroupMembers::where('group_id',$group_id)->get();
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		$created_by = Query::getValue('groups','id',$group_id,'user_id');
		$created_by_type = Query::getValue('groups','id',$group_id,'type');
		$student_id = Session::get('student_id');
		
		if( (strcmp($created_by,$student_id) == 0) && ($created_by_type == "student")) {
			$created_status = "yes";
		} else {
			$created_status = "no";
		}

		if($group->type == "student") {
			$created_by = Query::getFullname('students',$group->user_id);
        } else if($group->type == "tutor") {
			$created_by = Query::getFullname('tutors',$group->user_id);
        }
        
		?>
			<script type="text/javascript">
				var the_group_id = "<?php echo $group_id;?>";
				var group_name = "<?php echo $group->name;?>";
			</script>

	      	<div class="chat-main-header">
                <div class="p-20 b-b">
                	<h3 class="box-title" style="background-color:#666;padding:10px;color:#fff" id="the_group_name<?php echo $group_id;?>">
                		<?php echo ucwords($group->name);?>  &nbsp;  
                	</h3>

                	<p><small> <?php echo ucfirst($group->description);?> </small> </p> 
                	<small> Created by <b><?php echo $created_by;?></small>
					<hr/>

            		<div align="right">
            		
	            		<?php
	                    
	                    if($created_status == "no") {
	                    	?>
	                    	<button id="exit_group_btn" class="waves-effect waves-light btn-sm btn-rounded btn-warning " onclick="return ajaxBtnRequest('#exit_group_btn','/students/exit-group/'+the_group_id,'#the_status','Exit group','yes','Exit '+group_name+' group?')"><i class="mdi mdi-exit-to-app"></i> Exit group </button>  &nbsp;
	                    <?php
	                	}else if($created_status == "yes") {
	                    	?>
	                    	<button class="btn btn-sm btn-primary btn-rounded" type="button" id="edit_group_details_btn<?php echo $group_id;?>" data-toggle="modal" data-target="#EditGroupDetailsModal"><i class="fa fa-pencil"></i> Update group details</button>
		            		&nbsp; 

		            		<button class="waves-effect waves-light btn-sm btn-rounded btn-danger" onclick="return ajaxBtnRequest('#delete_group_btn','/students/delete-group/'+the_group_id,'#the_status','Delete group','yes','All the members and chats will be deleted from this group as well \n \n Delete '+group_name+' group?')"><i class="fa fa-trash"></i> Delete group </button>	
	                    	<?php
	                    }
	                    ?>

	                    <small id="the_status"></small>
	                </div>

                </div>
            </div>

            <div id="the_modal_status"></div>

            <?php

            if($created_status == "yes") {
            	?>
	            <div class="modal fade" id="EditGroupDetailsModal" tabindex="-1" role="dialog" aria-labelledby="EditGroupDetailsModal">
			        <div class="modal-dialog modal-lg" role="document">
			            
			            <div class="modal-content">
			                <div class="modal-header">
			                    <h4 class="modal-title" id="EditGroupDetailsModal"><i class="mdi mdi-pencil"></i> Edit Group Details</h4>
			                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                </div>
			                <div class="modal-body">
			                    
			                   <script type="text/javascript">
			                   		$("#edit_group_details_btn<?php echo $group_id;?>").click(function() {
			                   			var group = "<?php echo $group_id;?>";
			                   			ajaxLoadingRequest("/students/edit-group-details-modal/"+group,"#edit_group_details_div"+group,"","GET");
			                   		});
			                   </script> 

			                   <div id="edit_group_details_div<?php echo $group_id;?>"></div>

			                </div>    
			            </div>

			        </div>
			    </div>
			<?php
			}
			?>

            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#chat" role="tab">Chat</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#members" role="tab"><span class="badge badge-info ml-auto" id="count_group_members"><?php echo $count_group_members;?></span> Members</a> </li>
            </ul>
            
            <div class="tab-content">
                
                <div class="tab-pane active" id="chat" role="tabpanel">
                	<div style="clear: both"></div>
                	<script type="text/javascript">
                   		var group = "<?php echo $group_id;?>";
                       	setInterval(function() {
                       		ajaxNoLoadingRequest("/students/group-chats/"+group,"#group_chat_div<?php echo $group_id;?>","","GET");
                       	}, 3000);
                    </script>

                    <div id="group_chat_div<?php echo $group_id;?>"></div> <br/>
                    <div id="refresh_div" style="display:none"><small> Loading new chat...... </small></div>

                    <div class="card-body b-t">
                    	
                    	<form class="form-horizontal form-material" id="group_chat_form<?php echo $group_id;?>" method="POST" onsubmit="return false">
                            <?php echo csrf_field();?>

	                        <div class="row">
	                            <div class="col-md-12 col-sm-12">
	                                <br/><p></p>
                                    <textarea placeholder="Type your message here" class="form-control form-material" rows="5" name="message"></textarea>
	                            </div>
	                            <div class="container">
	                                <button type="button" id="chat_btn<?php echo $group_id;?>" onclick="return ajaxFormRequest('#chat_btn<?php echo $group_id;?>','#group_chat_form<?php echo $group_id;?>','/students/send-group-chat/<?php echo $group_id;?>','POST','#group_chat_status<?php echo $group_id;?>','Send','no')" class="btn btn-info"><i class="fa fa-paper-plane-o"></i> Send</button>
	                                <br/> <p></p>
	                                <div id="group_chat_status<?php echo $group_id;?>"></div>

	                            </div>
	                        </div>
	                    </form>
                    </div>

                </div>

                <div class="tab-pane" id="members" role="tabpanel">
                    <div class="message-box contact-box">
                    
                    <h2 class="add-ct-btn">

                    	<button type="button" id="modal_users_btn<?php echo $group_id;?>" class="btn btn-circle btn-lg btn-info waves-effect waves-dark" data-toggle="modal" data-target="#AddGroupMemberModal">+</button>
                    </h2>

                    <div id="the_modal_status"></div>

                    <div class="modal fade" id="AddGroupMemberModal" tabindex="-1" role="dialog" aria-labelledby="AddGroupMemberModal">
				        <div class="modal-dialog modal-lg" role="document">
				            
				            <div class="modal-content">
				                <div class="modal-header">
				                    <h4 class="modal-title" id="AddGroupMemberModal"><i class="mdi mdi-plus"></i> Add member to <?php echo ucwords($group->name);?> group</h4>
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                </div>
				                <div class="modal-body">
				                    
				                   <script type="text/javascript">
				                   		$("#modal_users_btn<?php echo $group_id;?>").click(function() {
				                   			var group = "<?php echo $group_id;?>";
				                   			ajaxLoadingRequest("/students/load-users-modal/"+group,"#add_group_members_div"+group,"","GET");
				                   		});
				                   </script> 

				                   <div id="add_group_members_div<?php echo $group_id;?>"></div>

				                </div>    
				            </div>

				        </div>
				    </div>

                    <div class="message-widget contact-widget">
                       	
                       	<script type="text/javascript">
                       		var group = "<?php echo $group_id;?>";
                           	ajaxLoadingRequest("/students/group-members/"+group,"#group_members_div","","GET");
                        </script>

                        <div id="group_members_div"></div>

                    </div>
                </div>
                </div>

            </div>
            
        </div>
        
		<?php
	}

	public function sendChat(Request $request,$group_id) {
		$student_id = Session::get('student_id');
		$chat = new GroupChat();
		
    	if(empty($request->message) || empty($group_id) ) {
			return "<small style='color:red'>Please enter your chat. </small>";
		} else {
			$chat->content = $request->message;
			$chat->group_id = $group_id;
			$chat->user_id = $student_id;
			$chat->type = "student";
			$chat->save();
			?>

			<script type="text/javascript">
				var group = "<?php echo $group_id;?>";
				document.getElementById("group_chat_form"+group).reset();
				ajaxNoLoadingRequest("/students/group-chats/"+group,"#group_chat_div<?php echo $group_id;?>","","GET","yes");
			</script>

			<?php
		}
	}


	public function chatDetails($id) {
		$student_id = Session::get('student_id');
		$tutor_id = Session::get('tutor_id');
		$chats = GroupChat::where('group_id',$id)->get();		
		$count_chat = GroupChat::where('group_id',$id)->count();		
		echo '<div class="chat-rbox" style="margin-top:-30px">';
		
		if($count_chat == 0) {
			echo '<br/><br/><p class="text-danger" style="width:100%;text-align: center;"> No chat yet </p>';
		} else {
			
			echo '<ul class="chat-list p-20" id="chat_list" style="overflow-y:scroll;height:500px">';
               
			foreach($chats as $chat) {
					
				if( ($chat->type == "student") && ($chat->user_id == $student_id) ) {
					$is_student = "yes";
				} else {
					$is_student =  "no";
				}

				if( ($chat->type == "tutor") && ($chat->user_id == $tutor_id) ) {
					$is_tutor = "yes";
				} else {
					$is_tutor =  "no";
				}				

				if($chat->type == "student") {
					$user_fullname = Query::getFullname('students',$chat->user_id);
					$user_pix = Query::getValue('students','id',$chat->user_id,'pix');

					if($user_pix != "") {
            		    $img = "<img src='/the_students/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

	    		} else if($chat->type == "tutor") {
					$user_fullname = Query::getFullname('tutors',$chat->user_id);
					$user_pix = Query::getValue('students','id',$chat->user_id,'pix');

					if($user_pix != "") {
            		    $img = "<img src='/the_tutors/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }
	    		}
				
	        	if($student_id && $chat->type == "student") {
	        		?>
	        			<li class="reverse">
		                	<div class="chat-content">
	                            <div class='box bg-light-inverse' style='background-color:#98BBDB;color:#000;text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
		                        <br/>
	                    		<div align="right" style="margin-top:10px;font-size:12px"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small> </div>
		                    </div>
		                </li>
		            <?php
		        }  
		        else {
	            	?>
	            	<li>
	                    <small><b><?php echo $user_fullname;?></b></small> <br/>
                        <div class="chat-content">
	                    	<div class='box bg-light-info' style='text-align:left'>
	                    		<?php echo html_entity_decode(nl2br($chat->content));?>
	                        <br/>
	                    		<div align="right" style="margin-top:10px;font-size:12px"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small> </div>
	                    </div>
	                </li>
	                <?php
	            }
	        }
		}
		echo "</ul></div>";
	}

	public function removeGroupMember($group_id,$member_id) {
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		
		if($count_group_members == 2) {
			return "<small style='color:red'> You must have at least 2 members in a group </small>";
		} else {
			GroupMembers::where('id',$member_id)->delete();
			$count_the_group_members = GroupMembers::where('group_id',$group_id)->count();
			echo "<p style='color:green'>Group member was successfully deleted.</b></p>";		
			?>
				<script type="text/javascript">
					var group = "<?php echo $group_id;?>";
					var count_members = "<?php echo $count_the_group_members;?>";
					document.getElementById('count_the_members'+group).innerHTML = count_members;
					document.getElementById('count_group_members').innerHTML = count_members;
					ajaxLoadingRequest("/students/group-members/"+group,"#group_members_div","","GET");
	            </script>
			<?php
		}
	}

	public function studentDeleteGroup($group_id) {
		GroupMembers::where('group_id',$group_id)->delete();
		GroupChat::where('group_id',$group_id)->delete();
		Groups::where('id',$group_id)->delete();
		echo "<p style='color:green'>Group details was successfully deleted.</b></p>";		
		?>
			<script type="text/javascript">
				window.location="groups";
            </script>
		<?php
	}

	public function studentExitGroup($group_id) {
		$student_id = Session::get('student_id');
		$group_name = Groups::where('id',$group_id)->value('name');
		GroupMembers::where('group_id',$group_id)->where('type','student')->where('user_id',$student_id)->delete();
		GroupChat::where('group_id',$group_id)->where('type','student')->where('user_id',$student_id)->delete();
		echo "<p style='color:green'>You've successfully left ".$group_name." group.</b></p>";		
		?>
			<script type="text/javascript">
				window.location="groups";
            </script>
		<?php
	}


	// for tutors

	public function tutorIndex() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$groups =  GroupMembers::distinct()->where('type','tutor')->where('user_id',$tutor_id)->get();
		$count_groups = GroupMembers::distinct()->where('type','tutor')->where('user_id',$tutor_id)->count();
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "groups" => $groups, "count_groups" => $count_groups);
		return view('tutors.groups')->with($data);
	}

	public function allTutorUsers() {
		$tutor_id = Session::get('tutor_id');
		$students = Students::orderBy('id','DESC')->get();	
		$tutors = Tutors::orderBy('id','DESC')->where('id','<>',$tutor_id)->get();	
		$convert_tutors = json_decode(json_encode($tutors,true));
		$convert_students = json_decode(json_encode($students,true));
		$all_users = array_merge($convert_students,$convert_tutors);
		$count_all_users = count($all_users);

		if($count_all_users == 0) {
            echo '<p class="text-danger" style="width:100%;text-align: center;"> No user yet </p>';
		} else {
        	?>
        	<ul class="feeds">

                <?php
                
                foreach($all_users as $key=>$user) {
                	$counter = $key+1;
                	$check = $user->type."-".$user->id;

                	if($user->type == "student") {
                		
                		if($user->pix != "") {
                		    $img = "<img src='/the_students/".$user->pix."' class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('students','id',$user->id,'phone');
                		$class = Query::getValue('students','id',$user->id,'class');
                		$user_fullname = Query::getFullname('students',$user->id);
                		$tutor_rating = "";
                	} else {

                		if($user->pix != "") {
                		    $img = "<img src='/the_tutors/".$user->pix."' class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('tutors','id',$user->id,'phone');
                		$count_ratings = Query::countTheValues('ratings','tutor_id',$user->id);
                        $tutor_rating = "<i class='mdi mdi-star'></i> ".Query::tutorRating($user->id);
						$user_fullname = Query::getFullname('tutors',$user->id);
                	}
                	?>
                    <li>
                        <div class="bg-light-info"><?php echo $img;?></div> 
                        <?php echo $user_fullname;?>
                        <div class="demo-checkbox pull-right">
			                <input type="checkbox" id="basic_checkbox_<?php echo $counter;?>" name="members[]" value="<?php echo $check;?>"/>
			                <label for="basic_checkbox_<?php echo $counter;?>"></label>
			            </div>
                        <p style="margin-left:50px">
                           <small> 
                                <?php echo ucfirst($user->type);?> &nbsp;  &nbsp; <?php echo $tutor_rating;?> &nbsp; &nbsp; <?php echo $user->phone;?>
                            </small> 
                            <hr/>
				        </p> 
                    </li>
                    <?php
            	}
            	?>
            </ul>
            <?php
        }
	}

	public function addTutorGroup(Request $request) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Students::where('id',$tutor_id)->first();
		$group_exists = Groups::where('name',$request->group_name)->where('type','tutor')->where('user_id',$tutor_id)->count();
		$selected_members = $request->get('members');
        $count_members = count($selected_members);

    	if(empty($request->group_name) || empty(trim($request->group_desc))) {
			return "<p style='color:red'>Please fill both fields. </p>";
		} else if($group_exists > 0) {
		 	return "<p style='color:red'>You have added this group before. </p>";
		} else if($count_members == 0) {
		 	return "<p style='color:red'>Please select at least one member. </p>";
		} else {
			$group = new Groups();
			$group->name = $request->group_name;
			$group->description = $request->group_desc;
			$group->user_id = $tutor_id;
			$group->type = "tutor";
			$group->unique_id = time().mt_rand(111111,999999);
    	   	$group->save();
			
			$group_id = Groups::where('name',$group->name)->where('type','tutor')->where('user_id',$group->user_id)->value('id');
			$data = array();
			$user_data = array();
			$count_members =  count($selected_members);

			if($count_members > 0) {

				foreach($selected_members as $member) {
					$the_member = explode("-",$member);				
					$member_type = $the_member[0];
					$member_user_id = $the_member[1];
					$user_exists = GroupMembers::where('type',$member_type)->where('user_id',$member_user_id)->where('group_id',$group_id)->count();

					if($user_exists == 0) {
						$data[] = [
							'group_id' => $group_id,
							'type' => $member_type,
							'user_id' => $member_user_id,
							'created_at' => date("Y-m-d H:i:s"),
		                    'updated_at' => date("Y-m-d H:i:s")
						];
					}
				}

				if(count($data) > 0) {
					DB::table('group_members')->insert($data);

					$user_data[] = [
						'group_id' => $group_id,
						'type' => 'tutor',
						'user_id' => $tutor_id,
						'created_at' => date("Y-m-d H:i:s"),
	                    'updated_at' => date("Y-m-d H:i:s")
					];
					DB::table('group_members')->insert($user_data);
				} 

				Session::put('operation',"Group details was successfully added.");
	        	?>

				<script type="text/javascript">
					setTimeout(function() {
						window.location="/tutors/groups";
					},1000); 
				</script>

				<?php
				return "<p style='color:green'>Group details was successfully added.</b></p>";
			} else {
				$group_id = Groups::where('name',$group->name)->where('type','student')->where('user_id',$group->user_id)->delete();
				return "<p style='color:red'>At least one user must be added to the group.</b></p>";
			}
		}
	}

	public function tutorGroupDetails($group_id) {
		$group = Groups::findOrFail($group_id);
		$group_members = GroupMembers::where('group_id',$group_id)->get();
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		$created_by = Query::getValue('groups','id',$group_id,'user_id');
		$created_by_type = Query::getValue('groups','id',$group_id,'type');
		$tutor_id = Session::get('tutor_id');
		
		if( (strcmp($created_by,$tutor_id) == 0) && ($created_by_type == "tutor")) {
			$created_status = "yes";
		} else {
			$created_status = "no";
		}

		if($group->type == "student") {
			$created_by = Query::getFullname('students',$group->user_id);
        } else if($group->type == "tutor") {
			$created_by = Query::getFullname('tutors',$group->user_id);
        }
        
		?>
			<script type="text/javascript">
				var the_group_id = "<?php echo $group_id;?>";
				var group_name = "<?php echo $group->name;?>";
			</script>

	      	<div class="chat-main-header">
                <div class="p-20 b-b">
                	<h3 class="box-title" style="background-color:#666;padding:10px;color:#fff" id="the_group_name<?php echo $group_id;?>">
                		<?php echo ucwords($group->name);?>  &nbsp;  
                	</h3>

                	<p><small> <?php echo ucfirst($group->description);?> </small> </p> 
                	<small> Created by <b><?php echo $created_by;?></small>
					<hr/>

            		<div align="right">
            		
	            		<?php
	                    
	                    if($created_status == "no") {
	                    	?>
	                    	<button id="exit_group_btn" class="waves-effect waves-light btn-sm btn-rounded btn-warning " onclick="return ajaxBtnRequest('#exit_group_btn','/tutors/exit-group/'+the_group_id,'#the_status','Exit group','yes','Exit '+group_name+' group?')"><i class="mdi mdi-exit-to-app"></i> Exit group </button>  &nbsp;
	                    <?php
	                	} else if($created_status == "yes") {
	                    	?>
	                    	<button class="btn btn-sm btn-primary btn-rounded" type="button" id="edit_group_details_btn<?php echo $group_id;?>" data-toggle="modal" data-target="#EditGroupDetailsModal"><i class="fa fa-pencil"></i> Update group details</button>
	            			&nbsp; 

	            			<button class="waves-effect waves-light btn-sm btn-rounded btn-danger" onclick="return ajaxBtnRequest('#delete_group_btn','/students/delete-group/'+the_group_id,'#the_status','Delete group','yes','All the members and chats will be deleted from this group as well \n \n Delete '+group_name+' group?')"><i class="fa fa-trash"></i> Delete group </button>	
	                    	<?php
	                    }
	                    ?>

	                    <small id="the_status"></small>
	                </div>

                </div>
            </div>

            <div id="the_modal_status"></div>

            <?php

            if($created_status == "yes") {
            	?>
            	<div class="modal fade" id="EditGroupDetailsModal" tabindex="-1" role="dialog" aria-labelledby="EditGroupDetailsModal">
			        <div class="modal-dialog modal-lg" role="document">
			            
			            <div class="modal-content">
			                <div class="modal-header">
			                    <h4 class="modal-title" id="EditGroupDetailsModal"><i class="mdi mdi-pencil"></i> Edit Group Details</h4>
			                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			                </div>
			                <div class="modal-body">
			                    
			                   <script type="text/javascript">
			                   		$("#edit_group_details_btn<?php echo $group_id;?>").click(function() {
			                   			var group = "<?php echo $group_id;?>";
			                   			ajaxLoadingRequest("/tutors/edit-group-details-modal/"+group,"#edit_group_details_div"+group,"","GET");
			                   		});
			                   </script> 

			                   <div id="edit_group_details_div<?php echo $group_id;?>"></div>

			                </div>    
			            </div>

			        </div>
		    	</div>
		    <?php
			}
			?>

            <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#chat" role="tab">Chat</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#members" role="tab"><span class="badge badge-info ml-auto" id="count_group_members"><?php echo $count_group_members;?></span> Members</a> </li>
            </ul>
            
            <div class="tab-content">
                
                <div class="tab-pane active" id="chat" role="tabpanel">
                	<div style="clear: both"></div>
                	<script type="text/javascript">
                   		var group = "<?php echo $group_id;?>";
                       	setInterval(function() {
                       		ajaxNoLoadingRequest("/tutors/group-chats/"+group,"#group_chat_div<?php echo $group_id;?>","","GET");
                       	}, 3000);
                    </script>

                    <div id="group_chat_div<?php echo $group_id;?>"></div> <br/>
                    <div id="refresh_div" style="display:none"><small> Loading new chat...... </small></div>

                    <div class="card-body b-t">
                    	
                    	<form class="form-horizontal form-material" id="group_chat_form<?php echo $group_id;?>" method="POST" onsubmit="return false">
                            <?php echo csrf_field();?>

	                        <div class="row">
	                            <div class="col-md-12 col-sm-12">
	                                <br/><p></p>
                                    <textarea placeholder="Type your message here" class="form-control form-material" rows="5" name="message"></textarea>
	                            </div>
	                            <div class="container">
	                                <button type="button" id="chat_btn<?php echo $group_id;?>" onclick="return ajaxFormRequest('#chat_btn<?php echo $group_id;?>','#group_chat_form<?php echo $group_id;?>','/tutors/send-group-chat/<?php echo $group_id;?>','POST','#group_chat_status<?php echo $group_id;?>','Send','no')" class="btn btn-info"><i class="fa fa-paper-plane-o"></i> Send</button>
	                                <br/> <p></p>
	                                <div id="group_chat_status<?php echo $group_id;?>"></div>

	                            </div>
	                        </div>
	                    </form>
                    </div>

                </div>

                <div class="tab-pane" id="members" role="tabpanel">
                    <div class="message-box contact-box">
                    
                    <h2 class="add-ct-btn">

                    	<button type="button" id="modal_users_btn<?php echo $group_id;?>" class="btn btn-circle btn-lg btn-info waves-effect waves-dark" data-toggle="modal" data-target="#AddGroupMemberModal">+</button>
                    </h2>

                    <div id="the_modal_status"></div>

                    <div class="modal fade" id="AddGroupMemberModal" tabindex="-1" role="dialog" aria-labelledby="AddGroupMemberModal">
				        <div class="modal-dialog modal-lg" role="document">
				            
				            <div class="modal-content">
				                <div class="modal-header">
				                    <h4 class="modal-title" id="AddGroupMemberModal"><i class="mdi mdi-plus"></i> Add member to <?php echo ucwords($group->name);?> group</h4>
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                </div>
				                <div class="modal-body">
				                    
				                   <script type="text/javascript">
				                   		$("#modal_users_btn<?php echo $group_id;?>").click(function() {
				                   			var group = "<?php echo $group_id;?>";
				                   			ajaxLoadingRequest("/tutors/load-users-modal/"+group,"#add_group_members_div"+group,"","GET");
				                   		});
				                   </script> 

				                   <div id="add_group_members_div<?php echo $group_id;?>"></div>

				                </div>    
				            </div>

				        </div>
				    </div>

                    <div class="message-widget contact-widget">
                       	
                       	<script type="text/javascript">
                       		var group = "<?php echo $group_id;?>";
                           	ajaxLoadingRequest("/tutors/group-members/"+group,"#group_members_div","","GET");
                        </script>

                        <div id="group_members_div"></div>

                    </div>
                </div>
                </div>

            </div>
            
        </div>
        
		<?php
	}

	public function tutorGroupMembers($group_id) {
		$tutor_id = Session::get('tutor_id');
		$group = Groups::findOrFail($group_id);
		$group_members = GroupMembers::where('group_id',$group_id)->get();
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		$created_by = Query::getValue('groups','id',$group_id,'user_id');
		
		if($count_group_members == 0) {
       		echo '<br/><p class="text-danger" style="width:100%;text-align: center;"> No member yet </p>';
       	} else {

           	foreach($group_members as $group_member) {
				
				if($tutor_id) {
					
					if( ($group_member->type == "tutor") && ($group_member->user_id == $tutor_id) ) {
						$is_tutor = "yes";
					} else {
						$is_tutor =  "no";
					}

					if( ($group_member->type == "tutor") && ($group_member->user_id == $created_by) ) {
						$is_creator = "yes";
					} else {
						$is_creator = "no";
					}
				} else {
					$is_tutor =  "no";
				}

				if($group_member->type == "tutor") {
					$member_pix = Tutors::where('id',$group_member->user_id)->value('pix');

					if($member_pix != "") {
            		    $img = "<img src='/the_tutors/".$member_pix."' class='img-responsive img-circle'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

					$member_subject = Tutors::where('id',$group_member->user_id)->value('subject_id');
               		$the_subject = Subjects::where('id',$member_subject)->value('name');
					
					$member_fullname = 	Query::getFullname('tutors',$group_member->user_id);
					$member_phone = Students::where('id',$group_member->user_id)->value('phone');
					$count_ratings = Query::countTheValues('ratings','tutor_id',$group_member->user_id);
					$tutor_rating = Query::tutorRating($group_member->user_id);
               	} else {
               		$member_pix = Students::where('id',$group_member->user_id)->value('pix');
               		
					if($member_pix != "") {
            		    $img = "<img src='/the_students/".$member_pix."' class='img-responsive img-circle'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

               		$member_fullname = 	Query::getFullname('students',$group_member->user_id);
					$member_phone = Students::where('id',$group_member->user_id)->value('phone');
				}

               	?>

               	<script type="text/javascript">
               		var group_id = "<?php echo $group_id;?>";
               		var member_type = "<?php echo $group_member->type;?>";
               		var member_id = "<?php echo $group_member->id;?>";
               		var member_fullname = "<?php echo $member_fullname;?>";
               		var group_name = "<?php echo $group->name;?>";

               	</script>

               	<a href="#">
                    <div class="user-img"> 
                    	<?php echo $img;?>
                    	<!-- <span class="profile-status online pull-right"></span>  -->
                    </div>
                    <div class="mail-contnet">
                        
                        <?php

                        	if($is_tutor == "yes") {
                        		echo "<h5>You</h5>";

                        		if($is_creator == "no") {
                        			?>
			                        <div class="pull-right">
						                <button type="button" id="remove_member_btn" onclick="return ajaxBtnRequest('#remove_member_btn<?php echo $group_member->id;?>','/tutors/remove-group-member/<?php echo $group_id;?>/<?php echo $group_member->id;?>','#remove_status<?php echo $group_member->id;?>','Remove','yes','Remove <?php echo $member_fullname;?> from '+group_name+' group?')" class="btn btn-rounded btn-sm btn-danger pull-right"> Remove </button>
						                <div style="clear:both" id="remove_status<?php echo $group_member->id;?>"></div>
						            </div>
						        <?php
                        		}
                        	} 
		                	else {
		                		?>
	                        	<h5><?php echo $member_fullname;?></h5> 
		                        
		                        <?php
		                        
		                        if($is_creator == "no") {
		                        ?>
			                        <div class="pull-right">
						                <button type="button" id="remove_member_btn" onclick="return ajaxBtnRequest('#remove_member_btn<?php echo $group_member->id;?>','/tutors/remove-group-member/<?php echo $group_id;?>/<?php echo $group_member->id;?>','#remove_status<?php echo $group_member->id;?>','Remove','yes','Remove <?php echo $member_fullname;?> from '+group_name+' group?')" class="btn btn-rounded btn-sm btn-danger pull-right"> Remove </button>
						                <div style="clear:both" id="remove_status<?php echo $group_member->id;?>"></div>
						            </div>
						        <?php
						    	}
						    	?>

		                        <span class="mail-desc"><i class="fa fa-phone"></i> <?php echo $member_phone;?> &nbsp;  &nbsp; 
		                        	<?php

		                        	if($group_member->type == "tutor") {
		                        		echo ($count_ratings == 0) ? "<small class='text-danger'> No rating yet </small>" : " <i class='mdi mdi-star'></i> ".$tutor_rating;
		                        		echo "&nbsp;  &nbsp;  &nbsp; <span class='text-primary'>".$the_subject."</span>";
		                        	}

		                        	?>
		                           
		                        </span>
		                        <?php
			                }
		                ?>
		                
                    </div>
                </a>
            	<?php
           	}
    	}
    }

    public function editTutorGroupDetailsModal($group_id) {
		$group = Groups::findOrFail($group_id);
		?>
			<form class="form-horizontal form-material" id="update_group_form" method="POST" onsubmit="return false">
                <?php echo csrf_field();?>
                <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>"/>
                <div class="form-group">
                    <small for="recipient-name" class="control-label">Group name (maximum of 25 characters)</small>
                    <input type="text" name="group_name" value="<?php echo $group->name;?>" id="group_name" class="form-control" maxlength="25"/>
                </div>

                <div class="form-group">
                    <small for="recipient-name" class="control-label">Short description about the group (maximum of 255 characters)</small> <br/><p></p>
                    <textarea class="form-control form-material" maxlength="255" id="description" name="group_desc" rows="5"><?php echo ucfirst($group->description);?></textarea>
                </div>

                <br/>

                <button type="button" id="update_group_btn" onclick="return ajaxFormRequest('#update_group_btn','#update_group_form','/tutors/update-group-details','POST','#phase_two_status','Save changes','yes')" class="btn btn-info pull-right"><i class="fa fa-check"></i> Save changes </button>
                
                <div style="clear: both;"></div>
                <div id="phase_two_status"></div>
                
            </form>
		<?php
	}

	public function updateTutorGroupDetails(Request $request) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$group_exists = Groups::where('name',$request->group_name)->where('type','tutor')->where('user_id',$tutor_id)->where('id','<>',$request->group_id)->count();
		
    	if(empty($request->group_id) || empty($request->group_name) || empty(trim($request->group_desc))) {
			return "<p style='color:red'>Please fill both fields. </p>";
		} else if($group_exists > 0) {
		 	return "<p style='color:red'>You have added this group before. </p>";
		} else {
			$group = Groups::findOrFail($request->group_id);
			$group->name = $request->group_name;
			$group->description = $request->group_desc;
			$group->save();
			?>
				<script type="text/javascript">
					var group = "<?php echo $request->group_id;?>";
					$("#EditGroupDetailsModal").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					ajaxLoadingRequest("/tutors/group-details/"+group,"#group_details_div","","GET");
				</script>
			<?php
			return "<p style='color:green'>Group details was successfully added.</b></p>";
		}
	}

	public function removeTutorGroupMember($group_id,$member_id) {
		$count_group_members = GroupMembers::where('group_id',$group_id)->count();
		
		if($count_group_members == 2) {
			return "<small style='color:red'> You must have at least 2 members in a group </small>";
		} else {
			GroupMembers::where('id',$member_id)->delete();
			$count_the_group_members = GroupMembers::where('group_id',$group_id)->count();
			echo "<p style='color:green'>Group member was successfully deleted.</b></p>";		
			?>
				<script type="text/javascript">
					var group = "<?php echo $group_id;?>";
					var count_members = "<?php echo $count_the_group_members;?>";
					document.getElementById('count_the_members'+group).innerHTML = count_members;
					document.getElementById('count_group_members').innerHTML = count_members;
					ajaxLoadingRequest("/tutors/group-members/"+group,"#group_members_div","","GET");
	            </script>
			<?php
		}
	}

	public function tutorDeleteGroup($group_id) {
		GroupMembers::where('group_id',$group_id)->delete();
		GroupChat::where('group_id',$group_id)->delete();
		Groups::where('id',$group_id)->delete();
		echo "<p style='color:green'>Group details was successfully deleted.</b></p>";		
		?>
			<script type="text/javascript">
				window.location="groups";
            </script>
		<?php
	}

	public function tutorExitGroup($group_id) {
		$tutor_id = Session::get('tutor_id');
		$group_name = Groups::where('id',$group_id)->value('name');
		GroupMembers::where('group_id',$group_id)->where('type','tutor')->where('user_id',$tutor_id)->delete();
		GroupChat::where('group_id',$group_id)->where('type','tutor')->where('user_id',$tutor_id)->delete();
		echo "<p style='color:green'>You've successfully left ".$group_name." group.</b></p>";		
		?>
			<script type="text/javascript">
				window.location="groups";
            </script>
		<?php
	}

	public function allTutorUsersModal($group_id) {
		?>
			<form class="form-horizontal form-material" id="add_group_member_form" method="POST" onsubmit="return false">
                <?php echo csrf_field();?>
                
                <script type="text/javascript">
                	var group_id = "<?php echo $group_id;?>";
                	ajaxRequest("/tutors/all-group-users/"+group_id,"#all_users_div","GET");
                </script>

                <div id="all_users_div"></div>
                <br/>

                <button type="button" id="add_group_member_btn" onclick="return ajaxFormRequest('#add_group_member_btn','#add_group_member_form','/tutors/add-group-member/'+group_id,'POST','#phase_two_status','Add Members','yes')" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add Members </button>
                
                <div style="clear: both;"></div>
                <div id="phase_two_status"></div>
                
            </form>
		<?php
	}


	public function allTutorGroupUsers($group_id) {
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$students = Students::orderBy('id','DESC')->get();	
		$convert_tutors = json_decode(json_encode($tutors,true));
		$convert_students = json_decode(json_encode($students,true));
		$all_users = array_merge($convert_students,$convert_tutors);
		$count_all_users = count($all_users);

		if($count_all_users == 0) {
            echo '<p class="text-danger" style="width:100%;text-align: center;"> No user yet </p>';
		} else {
        	?>
        	<ul class="feeds">

                <?php
                
                foreach($all_users as $key=>$user) {
                	$counter = $key+1;
                	$check = $user->type."-".$user->id;

                	if($user->type == "student") {
                		$user_exists = GroupMembers::where('type','student')->where('user_id',$user->id)->where('group_id',$group_id)->count();

                		if($user->pix != "") {
                		    $img = "<img src='/the_students/".$user->pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('students','id',$user->id,'phone');
                		$class = Query::getValue('students','id',$user->id,'class');
                		$user_fullname = Query::getFullname('students',$user->id);
                		$tutor_rating = "";
                	} else {
                		$user_exists = GroupMembers::where('type','tutor')->where('user_id',$user->id)->where('group_id',$group_id)->count();

                		if($user->pix != "") {
                		    $img = "<img src='/the_tutors/'".$user->pix." class='img-responsive img-circle'/>";
                		} else {
                			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                        }

                		$phone = Query::getValue('tutors','id',$user->id,'phone');
                		$count_ratings = Query::countTheValues('ratings','tutor_id',$user->id);
                        $tutor_rating = "<i class='mdi mdi-star'></i> ".Query::tutorRating($user->id);
						$user_fullname = Query::getFullname('tutors',$user->id);
                	}
                	?>
                    <li>
                        <div class="bg-light-info"><?php echo $img;?></div> 
                        
                        <?php echo $user_fullname;?>
                        
                        <?php

		                if($user_exists == 0) {
		                	?>
		                	<div class="demo-checkbox pull-right">
			            		<input type="checkbox" id="basic_checkbox_<?php echo $counter;?>" name="members[]" value="<?php echo $check;?>"/>
		                		<label for="basic_checkbox_<?php echo $counter;?>"></label>
		                	</div>
		                	<?php
		                } else {
		                	echo "<small class='text-warning pull-right'> Member already added </small>";
		                }
		                ?>

                        <p style="margin-left:50px">
                           <small> 
                                <?php echo ucfirst($user->type);?> &nbsp;  &nbsp; <?php echo $tutor_rating;?> &nbsp; &nbsp; <?php echo $user->phone;?>
                            </small> 
                            <hr/>
				        </p> 
                    </li>
                    <?php
            	}
            	?>
            </ul>
            <?php
        }
	}


	public function addTutorGroupMember(Request $request,$group_id) {
		$data = array();
		$selected_members = $request->get('members');
       	$count_members =  count($selected_members);

		if($count_members > 0) {
			
			foreach($selected_members as $member) {
				$the_member = explode("-",$member);				
				$member_type = $the_member[0];
				$member_user_id = $the_member[1];
				$user_exists = GroupMembers::where('type',$member_type)->where('user_id',$member_user_id)->where('group_id',$group_id)->count();

				if($user_exists == 0) {
					$data[] = [
						'group_id' => $group_id,
						'type' => $member_type,
						'user_id' => $member_user_id,
						'created_at' => date("Y-m-d H:i:s"),
		                'updated_at' => date("Y-m-d H:i:s")
					];
				}
			}

			if(count($data) > 0) {
				$add_group_members = DB::table('group_members')->insert($data);
			} else {
				return "<p style='color:red'>No member added.</b></p>";
			}
			$count_group_members = GroupMembers::where('group_id',$group_id)->count();
			?>

			<script type="text/javascript">
				var count_members = "<?php echo $count_group_members;?>";
				document.getElementById('count_the_members'+group).innerHTML = count_members;
				document.getElementById('count_group_members').innerHTML = count_members;
				var group = "<?php echo $group_id;?>";
				$("#AddGroupMemberModal").modal('hide');
				ajaxLoadingRequest("/tutors/group-members/"+group,"#group_members_div","","GET");
            </script>

			<?php
			return "<p style='color:green'>Group members were successfully added.</b></p>";
		} else {
			return "<p style='color:red'>At least one user must be added to the group.</b></p>";
		}
	}


	public function tutorChatDetails($id) {
		$student_id = Session::get('student_id');
		$tutor_id = Session::get('tutor_id');
		$chats = GroupChat::where('group_id',$id)->get();		
		$count_chat = GroupChat::where('group_id',$id)->count();		
		echo '<div class="chat-rbox" style="margin-top:-30px">';
		
		if($count_chat == 0) {
			echo '<br/><br/><p class="text-danger" style="width:100%;text-align: center;"> No chat yet </p>';
		} else {
			
			echo '<ul class="chat-list p-20" id="chat_list" style="overflow-y:scroll;height:500px">';
               
			foreach($chats as $chat) {
					
				if( ($chat->type == "student") && ($chat->user_id == $student_id) ) {
					$is_student = "yes";
				} else {
					$is_student =  "no";
				}

				if( ($chat->type == "tutor") && ($chat->user_id == $tutor_id) ) {
					$is_tutor = "yes";
				} else {
					$is_tutor =  "no";
				}	

				if($chat->type == "student") {
					$user_fullname = Query::getFullname('students',$chat->user_id);
					$user_pix = Query::getValue('students','id',$chat->user_id,'pix');

					if($user_pix != "") {
            		    $img = "<img src='/the_students/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }

	    		} else if($chat->type == "tutor") {
					$user_fullname = Query::getFullname('tutors',$chat->user_id);
					$user_pix = Query::getValue('students','id',$chat->user_id,'pix');

					if($user_pix != "") {
            		    $img = "<img src='/the_tutors/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
            		} else {
            			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                    }
	    		}
				
	        	if($tutor_id && $chat->type == "tutor") {
	        		?>
	        			<li class="reverse">
		                    <div class="chat-content">
	                            <div class='box bg-light-inverse' style='background-color:#98BBDB;color:#000;text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
		                        <br/>
	                    		<div align="right" style="margin-top:10px;font-size:12px"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small> </div>
		                    </div>
		                    
		                </li>
		            <?php
		        }  
		        else {
	            	?>
	            	<li>
	                    <small><b><?php echo $user_fullname;?></b></small> <br/>
                        <div class="chat-content">
	                    	<div class='box bg-light-info' style='text-align:left'>
	                    		<?php echo html_entity_decode(nl2br($chat->content));?>
	                    		<br/>
	                    		<div align="right" style="margin-top:10px;font-size:12px"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small> </div>
	                        </div>
	                    </div>
	                    <div class="chat-time"></div>
	                </li>
	                <?php
	            }
	        }
		}
		echo "</ul></div>";
	}

	public function sendTutorChat(Request $request,$group_id) {
		$tutor_id = Session::get('tutor_id');
		$chat = new GroupChat();
		
    	if(empty($request->message) || empty($group_id) ) {
			return "<small style='color:red'>Please enter your chat. </small>";
		} else {
			$chat->content = $request->message;
			$chat->group_id = $group_id;
			$chat->user_id = $tutor_id;
			$chat->type = "tutor";
			$chat->save();
			?>

			<script type="text/javascript">
				var group = "<?php echo $group_id;?>";
				document.getElementById("group_chat_form"+group).reset();
				ajaxNoLoadingRequest("/tutors/group-chats/"+group,"#group_chat_div<?php echo $group_id;?>","","GET","yes");
			</script>

			<?php
		}
	}

}	
