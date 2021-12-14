<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Students;
use App\Tutors;
use App\Appointments;
use App\AppointmentChat;
use DB;
use Session;

class AppointmentController extends Controller
{
    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$appointments = Appointments::orderBy('id','DESC')->where('student_id',$student_id)->paginate(20);	
		$count_appointments = Appointments::where('student_id',$student_id)->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "appointments" => $appointments, "count_appointments" => $count_appointments);
		return view('students.appointments')->with($data);
	}

	public function tutorIndex() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$appointments = Appointments::orderBy('id','DESC')->where('tutor_id',$tutor_id)->paginate(20);	
		$count_appointments = Appointments::where('tutor_id',$tutor_id)->count();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "appointments" => $appointments, "count_appointments" => $count_appointments);
		return view('tutors.appointments')->with($data);
	}

	public function details($id) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$appointment = Appointments::findOrFail($id);			
		$data = array("student_id" => $student_id, "the_student" => $the_student, "appointment" => $appointment);
		return view('students.view-appointment')->with($data);
	}

	public function tutorDetails($id) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$appointment = Appointments::findOrFail($id);			
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "appointment" => $appointment);
		return view('tutors.view-appointment')->with($data);
	}

	public function chatDetails($id) {
		$student_id = Session::get('student_id');
		$tutor_id = Session::get('tutor_id');
		$chats = AppointmentChat::where('appointment_id',$id)->get();		
		$count_chat = AppointmentChat::where('appointment_id',$id)->count();		
		echo '<div class="chat-rbox" style="margin-top:-30px">';
		
		if($count_chat == 0) {
			echo '<p class="text-danger" style="width:100%;text-align: center;"> No response yet </p>';
		} else {
			
			echo '<ul class="chat-list p-20" id="chat_list" style="overflow-y:scroll;height:500px">';
               
			foreach($chats as $chat) {
				
				if($chat->type == "student") {
					$user_fullname = Query::getFullname('students',$chat->user_id);
	    		} else if($chat->type == "tutor") {
					$user_fullname = Query::getFullname('tutors',$chat->user_id);
	    		}
				
	        	if($student_id) {
	        		if($chat->type == "tutor") {
	        			?>
	        			<li>
		                    <div class="chat-content">
		                        <div class='box bg-light-inverse' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
		                        </div>
		                    </div>
		                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
		                </li>
		                <?php
		            } else {
	        			?>
	        			<li class="reverse">
		                    <div class="chat-content">
		                        <div class='box bg-light-info' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
		                        </div>
		                    </div>
		                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
		                </li>
	        			<?php
	        		}
	        	} else if($tutor_id) {
	        		if($chat->type == "tutor") {
	        			?>
	        			<li class="reverse">
	        				<div class="chat-content">
		                        <div class='box bg-light-info' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
		                        </div>
		                    </div>
		                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
		                </li>
	        			<?php
	        		} else {
	        			?>
	        				<li>
			                    <div class="chat-content">
			                        <div class='box bg-light-inverse' style='text-align:left'><?php echo html_entity_decode(nl2br($chat->content));?>
			                        </div>
			                    </div>
			                    <div class="chat-time"><small><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans();?> </small></div>
			                </li>
	        			<?php
	        		}
	        	}
			}
		}
		echo "</ul></div>";
	}

	public function book(Request $request,$tutor_id) {
		$student_id = Session::get('student_id');
		$appointment = new Appointments;
		$appointment_exists = Appointments::where('title',$request->title)->where('student_id',$student_id)->count();
		$appointment_exists = Appointments::where('title',$request->title)->where('student_id',$student_id)->count();
		$appointment_status = Appointments::where('tutor_id',$tutor_id)->where('student_id',$student_id)->where('status','0')->count();
		

    	if(empty($request->title) || empty($request->message) || empty($tutor_id) ) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else if($appointment_exists > 0) {
			return "<p style='color:red'>You have booked this appointment before. Kindly change the title. </p>";
		} else if($appointment_status > 0) {
			return "<p style='color:red'>You cannot book appointment with this tutor until all pending appointments with this tutor has been approved. </p>";
		} else {
			$appointment->title = $request->title;
			$appointment->content = $request->message;
			$appointment->student_id = $student_id;
			$appointment->tutor_id = $tutor_id;
			$appointment->save();
			Session::put('operation',"Your appointment was successfully booked. You will be contacted by the tutor.");
        	?>

			<script type="text/javascript">
				setTimeout(function() {
					window.location="/students/appointments";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Your appointment was successfully booked. You will be contacted by the tutor.</b></p>";
		}
	}

	public function studentRespond(Request $request,$appointment_id) {
		$student_id = Session::get('student_id');
		$chat = new AppointmentChat();
		
    	if(empty($request->message) || empty($appointment_id) ) {
			return "<p style='color:red'>Please enter your response. </p>";
		} else {
			$chat->content = $request->message;
			$chat->appointment_id = $appointment_id;
			$chat->user_id = $student_id;
			$chat->type = "student";
			$chat->save();
			
			?>

			<script type="text/javascript">
				var appointment = "<?php echo $appointment_id;?>";
				document.getElementById("respond_appointment_form").reset();
				ajaxNoLoadingRequest("/students/appointment-chats/"+appointment,"#message_student_div"+appointment,"","GET","yes");
			</script>

			<?php
		}
	}

	public function approve ($id) {
		$tutor_id = Session::get('tutor_id');
		$appointment = Appointments::findOrFail($id);
		
		if($tutor_id) {
			$appointment->status = "1";
			$appointment->save();
			Session::put('operation',"Appointment was approved.");
        	?>

			<script type="text/javascript">
				var appointment = "<?php echo $id;?>";
				setTimeout(function() {
					window.location="/tutors/appointment/view/"+appointment;
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Appointment was approved.</b></p>";
		} else {
			return false;
		}
	
	}
	
	public function tutorRespond(Request $request,$appointment_id) {
		$tutor_id = Session::get('tutor_id');
		$chat = new AppointmentChat();
		
    	if(empty($request->message) || empty($appointment_id) ) {
			return "<p style='color:red'>Please enter your response. </p>";
		} else {
			$chat->content = $request->message;
			$chat->appointment_id = $appointment_id;
			$chat->user_id = $tutor_id;
			$chat->type = "tutor";
			$chat->save();
			
			?>

			<script type="text/javascript">
				var appointment = "<?php echo $appointment_id;?>";
				document.getElementById("respond_appointment_form").reset();
				ajaxNoLoadingRequest("/tutors/appointment-chats/"+appointment,"#message_tutor_div"+appointment,"","GET","yes");
			</script>

			<?php
		}
	}
}
