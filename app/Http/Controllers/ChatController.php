<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Chat;
use App\Students;
use App\Tutors;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;

class ChatController extends Controller
{
    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$tutors =  Tutors::orderBy('id','DESC')->get();
		$count_tutors =  Tutors::orderBy('id','DESC')->count();
		$data = array("student_id" => $student_id, "the_student" => $the_student, "tutors" => $tutors, "count_tutors" => $count_tutors);
		return view('students.chat')->with($data);
	}

    public function tutorIndex() {
        $tutor_id = Session::get('tutor_id');
        $the_tutor = Tutors::where('id',$tutor_id)->first();
        $students =  Students::orderBy('id','DESC')->get();
        $count_students =  Tutors::orderBy('id','DESC')->count();
        $data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "students" => $students, "count_students" => $count_students);
        return view('tutors.chat')->with($data);
    }

	//student chat details

    public function studentChatDetails($tutor) {
		$student_id = Session::get('student_id');
		$tutor_fullname = Query::getFullname('tutors',$tutor);
        echo '<div class="chat-rbox" style="margin-top:-30px">';
		
		?>
			<script type="text/javascript">
       			$(document).ready(function() {
           			var tutor = "<?php echo $tutor;?>";
           			setInterval(function() {
           				ajaxNoLoadingRequest("/students/view-chat-tutor-details/"+tutor,"#the_chat_details_div"+tutor,"","GET");
           			},2000);
           		});
           </script>

           <div id="the_chat_details_div<?php echo $tutor;?>"></div>
           <div id="refresh_div" style="display:none"><small> Loading new chat...... </small></div>

			<div class="card-body b-t">
                    	
            	<form class="form-horizontal form-material" id="chat_form" method="POST" onsubmit="return false">
                    <?php echo csrf_field();?>
                    <input type="hidden" name="tutor_id" value="<?php echo $tutor;?>"/>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <br/><p></p>
                            <textarea placeholder="Type your message here" class="form-control form-material" rows="5" name="message"></textarea>
                        </div>
                        <div class="container">
                            <button type="button" id="chat_btn" onclick="return ajaxFormRequest('#chat_btn','#chat_form','/students/send-chat/','POST','#chat_status','Send','no')" class="btn btn-info"><i class="fa fa-paper-plane-o"></i> Send</button>
                            <br/> <p></p>
                            <div id="chat_status"></div>

                        </div>
                    </div>
                </form>
            </div>
        <?php
	}

	public function studentChatTutorDetails($tutor) {
		$student_id = Session::get('student_id');
		$tutor_fullname = Query::getFullname('tutors',$tutor);
        $chats = Chat::where('student_id',$student_id)->where('tutor_id',$tutor)->get();		
		echo "<br/><h4 style='background-color:#666;padding:20px;color:#fff'> Your chat with ".$tutor_fullname."</h4><br/>";
        echo '<div class="chat-rbox" style="margin-top:-30px">';
		
		echo '<ul class="chat-list p-20" id="chat_list" style="overflow-y:scroll;height:500px">';
           
		foreach($chats as $chat) {
				
			if($chat->type == "student") {
				$user_fullname = Query::getFullname('students',$chat->student_id);
				$user_pix = Query::getValue('students','id',$chat->student_id,'pix');

				if($user_pix != "") {
        		    $img = "<img src='/the_students/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
        		} else {
        			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                }

    		} else if($chat->type == "tutor") {
				$user_fullname = Query::getFullname('tutors',$chat->tutor_id);
				$user_pix = Query::getValue('students','id',$chat->tutor_id,'pix');

				if($user_pix != "") {
        		    $img = "<img src='/the_tutors/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
        		} else {
        			$img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                }
    		}
			
        	if($student_id  && $chat->type == "student") {
        		?>
    			<li class="reverse">
                    <div class="chat-content">
                        <div class='box bg-light-inverse' style='background-color:#98BBDB;color:#000;text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
                        </div>
                    </div>
                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
                </li>
	            <?php
            } else {
            	?>
            	<li>
                    <div class="chat-content">
                    	<div class='box bg-light-info' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
                        </div>
                    </div>
                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
                </li>
                <?php
            }

		}
		echo "</ul>";
	}

	
    //tutor chat details

    public function tutorChatDetails($student) {
        $tutor_id = Session::get('tutor_id');
        $student_fullname = Query::getFullname('students',$student);
        echo '<div class="chat-rbox" style="margin-top:-30px">';
        
        ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    var student = "<?php echo $student;?>";
                    setInterval(function() {
                        ajaxNoLoadingRequest("/tutors/view-chat-student-details/"+student,"#the_chat_details_div"+student,"","GET");
                    },2000);
                });
           </script>

           <div id="the_chat_details_div<?php echo $student;?>"></div>
           <div id="refresh_div" style="display:none"><small> Loading new chat...... </small></div>

            <div class="card-body b-t">
                        
                <form class="form-horizontal form-material" id="chat_form" method="POST" onsubmit="return false">
                    <?php echo csrf_field();?>
                    <input type="hidden" name="student_id" value="<?php echo $student;?>"/>
                    
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <br/><p></p>
                            <textarea placeholder="Type your message here" class="form-control form-material" rows="5" name="message"></textarea>
                        </div>
                        <div class="container">
                            <button type="button" id="chat_btn" onclick="return ajaxFormRequest('#chat_btn','#chat_form','/tutors/send-chat/','POST','#chat_status','Send','no')" class="btn btn-info"><i class="fa fa-paper-plane-o"></i> Send</button>
                            <br/> <p></p>
                            <div id="chat_status"></div>

                        </div>
                    </div>
                </form>
            </div>
        <?php
    }

    public function tutorChatStudentDetails($student) {
        $tutor_id = Session::get('tutor_id');
        $student_fullname = Query::getFullname('students',$student);
        $chats = Chat::where('student_id',$student)->where('tutor_id',$tutor_id)->get();       
        echo "<br/><h4 style='background-color:#666;padding:20px;color:#fff'> Your chat with ".$student_fullname."</h4><br/>";
        echo '<div class="chat-rbox" style="margin-top:-30px">';
        echo '<ul class="chat-list p-20" id="chat_list" style="overflow-y:scroll;height:500px">';
           
        foreach($chats as $chat) {
                
            if($chat->type == "student") {
                $user_fullname = Query::getFullname('students',$chat->student_id);
                $user_pix = Query::getValue('students','id',$chat->student_id,'pix');

                if($user_pix != "") {
                    $img = "<img src='/the_students/".$user_pix."' class='img-responsive img-circle' style='width:50px;height:50px'/>";
                } else {
                    $img = "<img src='/panels/images/avatar.png' class='img-responsive img-circle'/>";
                }

            } else if($chat->type == "tutor") {
                $user_fullname = Query::getFullname('tutors',$chat->tutor_id);
                $user_pix = Query::getValue('students','id',$chat->tutor_id,'pix');

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
                        </div>
                    </div>
                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <div class="chat-content">
                        <div class='box bg-light-info' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
                        </div>
                    </div>
                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
                </li>
                <?php
            }

        }
        echo "</ul>";
    }

    
    //send chat

    public function sendChat(Request $request) {
		$student_id = Session::get('student_id');
		$chat = new Chat();
		
    	if(empty($request->message) && ($request->tutor_id) ) {
			return "<small style='color:red'>Please enter your chat. </small>";
		} else {
			$chat->tutor_id = $request->tutor_id;
			$chat->content = $request->message;
			$chat->student_id = $student_id;
			$chat->type = "student";
			$chat->save();
			?>

			<script type="text/javascript">
				var tutor = "<?php echo $request->tutor_id;?>";
				document.getElementById("chat_form").reset();
				ajaxNoLoadingRequest("/students/view-chat-tutor-details"+tutor,"#the_chat_details_div","","GET");
			</script>

			<?php
		}
	}

    public function sendTutorChat(Request $request) {
        $tutor_id = Session::get('tutor_id');
        $chat = new Chat();
        
        if(empty($request->message) && ($request->student_id) ) {
            return "<small style='color:red'>Please enter your chat. </small>";
        } else {
            $chat->student_id = $request->student_id;
            $chat->content = $request->message;
            $chat->tutor_id = $tutor_id;
            $chat->type = "tutor";
            $chat->save();
            ?>

            <script type="text/javascript">
                var student = "<?php echo $request->student_id;?>";
                document.getElementById("chat_form").reset();
                ajaxNoLoadingRequest("/tutors/view-chat-student-details"+student,"#the_chat_details_div","","GET");
            </script>

            <?php
        }
    }



}
