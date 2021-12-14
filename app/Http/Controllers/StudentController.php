<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Subjects;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Students;
use App\Tutors;
use App\Rating;
use App\Appointments;
use App\Assignments;
use App\Materials;
use DB;
use Session;

class StudentController extends Controller
{
    public function index() {
		$subjects = Subjects::orderBy('name','ASC')->get();	
		$data = array("subjects" => $subjects);
		return view('students.index')->with($data);
	}

	public function dashboard() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$materials = Materials::orderBy('id','DESC')->where('student_id',$student_id)->take(5)->get();	
		$count_materials = Materials::orderBy('id','DESC')->where('student_id',$student_id)->count();	
		$assignments = Assignments::orderBy('id','DESC')->where('student_id',$student_id)->take(5)->get();
		$count_assignments = Assignments::orderBy('id','DESC')->where('student_id',$student_id)->count();
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$count_tutors = Tutors::orderBy('id','DESC')->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "tutors" => $tutors, "count_tutors" => $count_tutors, "materials" => $materials, "count_materials" => $count_materials, "assignments" => $assignments, "count_assignments" => $count_assignments);
		return view('students.dashboard')->with($data);
	}

	public function profile() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$count_tutors = Tutors::orderBy('id','DESC')->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student);
		return view('students.profile')->with($data);
	}

	public function changePix(Request $request) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$student = Students::findOrFail($student_id);
		$folder = "the_students/";
		
        if(!empty($_FILES["photo"]['name'])) {
    		$photo_tmp =  $_FILES["photo"]['tmp_name'];
      		$photo_name =  $_FILES["photo"]['name'];
            $photo_type =  $_FILES["photo"]['type'];
            
            if($photo_type == "image/png" || $photo_type == "image/PNG" || $photo_type == "image/jpg" || $photo_type == "image/JPG" || $photo_type == "image/jpeg" || $photo_type == "image/JPEG") {

                $student->pix = $student->student_id.".jpg";
                $path = $folder.$student->pix;
                move_uploaded_file($photo_tmp,$path);
            } else {
        	 	return "<p style='color:red'>Please select a picture. </p>";
		    }
        } else {
         	return "<p style='color:red'>Please select a picture. </p>";
		}
        
        $student->save();
        Session::put('operation',"Your profile picture was successfully changed");
        	
        ?>

        <script type="text/javascript">
			setTimeout(function() {
				window.location="profile";
			},1000); 
		</script>

		<?php
        return "<p style='color:green'>Your profile picture was successfully changed. </p>";
	}

	public function tutors() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$subjects = Subjects::orderBy('name','ASC')->get();	
		$count_tutors = Tutors::orderBy('id','DESC')->count();	
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "subjects" => $subjects, "count_tutors" => $count_tutors,"tutors" => $tutors);
		return view('students.tutors')->with($data);
	}

	public function tutorProfile($id) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$tutor = Tutors::findOrFail($id);
		$ratings = Rating::orderBy('id','DESC')->where('tutor_id',$id)->get();
		$count_ratings = Rating::where('tutor_id',$id)->count();
		$appointments = Appointments::orderBy('id','DESC')->where('student_id',$student_id)->where('tutor_id',$id)->paginate(15);
		$count_appointments = Appointments::where('student_id',$student_id)->where('tutor_id',$id)->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "tutor" => $tutor, "ratings" => $ratings, "count_ratings" => $count_ratings, "appointments" => $appointments, "count_appointments" => $count_appointments);
		return view('students.view-tutor-profile')->with($data);
	}

	public function Signin(Request $request) {
		$student = new Students;
		$student->student_id = $request->student_id;
		$student->password = $request->password;
		$check_login = Query::checkLogin('students','student_id',$request->student_id,$request->password);
		
		if(empty($request->student_id) || empty($request->password)) {
			return "<p style='color:red'>Incorrect login details. </p>";
		} else if ($check_login == "1") {
			$student_id = Students::where('student_id',$request->student_id)->value('id');
			$student_session_id = Session::put('student_id',$student_id);
			Session::save();
			?>

			<script type="text/javascript">
				document.getElementById("loginform").reset();
				setTimeout(function() {
					window.location="/students/dashboard";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Login successful. Please wait.. </p>";
		} else {
			return "<p style='color:red'>Incorrect login details. </p>";
		}
	}

	public function Signup(Request $request) {
		$student = new Students;
		$email_exists = Students::where('email',$request->email)->count();
		$phone_exists = Students::where('phone',$request->phone)->count();

    	if(empty($request->email) || empty($request->surname) || empty($request->firstname) || empty($request->phone) || empty($request->class) || empty($request->password) || empty($request->confirm_password) ) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else if($email_exists > 0) {
			return "<p style='color:red'>Email address exists. Try again. </p>";
		} else if($phone_exists > 0) {
			return "<p style='color:red'>Phone number exists. Try again. </p>";
		}  else if(strcmp($request->password,$request->confirm_password) !== 0) {
			return "<p style='color:red'>Password does not match</p>";
		}  else {
			$student->email = $request->email;
			$student->surname = $request->surname;
			$student->firstname = $request->firstname;
			$student->phone = $request->phone;
			$student->class = $request->class;
			$student->salt = Misc::GenerateSalt();
			$student->student_id = Misc::GeneratePin(6);
			$student->password = crypt($request->password,$student->salt);
			$student->save();
			Session::put('operation',"Your registration was successful. Your Student ID is ".$student->student_id);
        	?>

			<script type="text/javascript">
				document.getElementById("registerform").reset();
				setTimeout(function() {
					window.location="/students";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Your registration was successful.  Your Student ID is <b>".$student->student_id."</b></p>";
			
		}
	}

	public function updateProfile(Request $request) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$student = Students::findOrFail($student_id);
		$email_exists = Students::where('email',$request->email)->where('id','<>',$student_id)->count();
		$phone_exists = Students::where('phone',$request->phone)->where('id','<>',$student_id)->count();

    	if(empty($request->email) || empty($request->surname) || empty($request->firstname) || empty($request->phone) || empty($request->class) || empty($request->address) ) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else if($email_exists > 0) {
			return "<p style='color:red'>Email address exists. Try again. </p>";
		} else if($phone_exists > 0) {
			return "<p style='color:red'>Phone number exists. Try again. </p>";
		} else {
			$student->email = $request->email;
			$student->surname = $request->surname;
			$student->firstname = $request->firstname;
			$student->phone = $request->phone;
			$student->class = $request->class;
			$student->address = $request->address;
			$student->about = $request->about;
			$student->save();
			Session::put('operation',"Your profile details was successfully updated");
        	?>

			<script type="text/javascript">
				setTimeout(function() {
					window.location="profile";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Your profile details was successfully updated</b></p>";
			
		}
	}

	public function rateTutor(Request $request,$tutor_id) {
		$rate = new Rating();
		$student_id = Session::get('student_id');
		
		if(empty($request->rating) || empty($request->feedback) || empty($tutor_id)) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else {
			$rate->rating = $request->rating;
			$rate->student_id = $student_id;
			$rate->tutor_id = $tutor_id;
			$rate->feedback = $request->feedback;
			$rate->save();
			$tutor_fullname = Query::getFullname('tutors',$tutor_id);
			Session::put("operation",$tutor_fullname." was successfully rated.");
        	$page = $request->page;

        	if($page == "profile") {
	        	?>

				<script type="text/javascript">
					var tutor_id = "<?php echo $tutor_id;?>";

					document.getElementById("rating_form<?php echo $tutor_id;?>").reset();
					setTimeout(function() {
						window.location="/students/tutors/profile/"+tutor_id;
					},1000); 
				</script>

				<?php
			} else {
				?>

				<script type="text/javascript">
					document.getElementById("rating_form<?php echo $tutor_id;?>").reset();
					setTimeout(function() {
						window.location="/students/tutors/";
					},1000); 
				</script>

				<?php
			}
			return "<p style='color:green'>".$tutor_fullname." was successfully rated.</b></p>";
			
		}
	}

	public function rateSubjectTutor(Request $request,$tutor_id,$subject_id) {
		$rate = new Rating();
		$student_id = Session::get('student_id');
		
		if(empty($request->rating) || empty($request->feedback) || empty($tutor_id)) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else {
			$rate->rating = $request->rating;
			$rate->student_id = $student_id;
			$rate->tutor_id = $tutor_id;
			$rate->feedback = $request->feedback;
			$rate->save();
			$tutor_fullname = Query::getFullname('tutors',$tutor_id);
			Session::put("operation",$tutor_fullname." was successfully rated.");
        	?>

			<script type="text/javascript">
				var subject = "<?php echo $subject_id;?>";
				document.getElementById("rating_form<?php echo $tutor_id;?>").reset();
				setTimeout(function() {
					window.location="/students/subject/tutors/"+subject;
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>".$tutor_fullname." was successfully rated.</b></p>";
			
		}
	}

	public function changePassword(Request $request) {
		$student = new Students;
		$current_password = $request->current_password;
		$new_password = $request->new_password;
		$confirm_password = $request->confirm_new_password;
		
		if(empty($request->current_password) || empty($request->new_password) || empty($request->confirm_new_password)) {
			return "<p style='color:red'>Incorrect details.</p>";
		} else if(strcmp($new_password,$confirm_password) !== 0) {
			return "<p style='color:red'>Password does not match.</p>";
		}
		else {
			$student_id = Session::get('student_id');
			$student_salt = DB::table('students')->where('id',$student_id)->value('salt');
			$student_password = DB::table('students')->where('id',$student_id)->value('password');
			$hashed_current_password = crypt($current_password,$student_salt);
			
			if(strcmp($hashed_current_password,$student_password) == 0) {
				$hashed_new_password = crypt($new_password,$student_salt);
				$student = Students::findOrFail($student_id);
				$student->password = $hashed_new_password;
				$student->save();
				Session::put('operation','Password successfully changed. Kindly relogin.');
				Session::forget('student_id');
				?>

				<script type="text/javascript">
					setTimeout(function() {
						window.location="/students";
					},1000); 
				</script>

				<?php
				return "<p style='color:green'>Password successfully changed. Please wait..</p>";
			} else {
				return "<p style='color:red'>Incorrect current password.</p>";
			}
		}
	}

	public function logout() {
		Session::forget('student_id');
		return redirect()->route('studentIndex')->with('success','You are logged out.');
	}
}
