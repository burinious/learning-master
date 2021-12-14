<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Tutors;
use App\Students;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Appointments;
use App\Assignments;
use App\Materials;
use DB;
use Session;

class TutorController extends Controller
{
    public function index() {
		return view('tutors.index');
	}

	public function students() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$count_students = Students::orderBy('id','DESC')->count();	
		$students = Students::orderBy('id','DESC')->get();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "count_students" => $count_students,"students" => $students);
		return view('tutors.students')->with($data);
	}

	public function studentProfile($id) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$student = Students::findOrFail($id);
		$appointments = Appointments::orderBy('id','DESC')->where('student_id',$id)->where('tutor_id',$tutor_id)->paginate(15);
		$count_appointments = Appointments::orderBy('id','DESC')->where('student_id',$id)->where('tutor_id',$tutor_id)->count();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "student" => $student, "appointments" => $appointments, "count_appointments" => $count_appointments);
		return view('tutors.view-student-profile')->with($data);
	}

	public function Signin(Request $request) {
		$tutor = new Tutors;
		$tutor->tutor_id = $request->tutor_id;
		$tutor->password = $request->password;
		$check_login = Query::checkLogin('tutors','tutor_id',$request->tutor_id,$request->password);
		
		if(empty($request->tutor_id) || empty($request->password)) {
			return "<p style='color:red'>Incorrect login details. </p>";
		} else if ($check_login == "1") {
			$tutor_id = Tutors::where('tutor_id',$request->tutor_id)->value('id');
			$tutor_session_id = Session::put('tutor_id',$tutor_id);
			Session::save();
			?>

			<script type="text/javascript">
				document.getElementById("loginform").reset();
				setTimeout(function() {
					window.location="/tutors/dashboard";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Login successful. Please wait.. </p>";
		} else {
			return "<p style='color:red'>Incorrect login details. </p>";
		}
	}

	public function dashboard() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$materials = Materials::orderBy('id','DESC')->where('tutor_id',$tutor_id)->take(5)->get();	
		$count_materials = Materials::orderBy('id','DESC')->where('tutor_id',$tutor_id)->count();	
		$assignments = Assignments::orderBy('id','DESC')->where('tutor_id',$tutor_id)->take(5)->get();
		$count_assignments = Assignments::orderBy('id','DESC')->where('tutor_id',$tutor_id)->count();
		$students = Students::orderBy('id','DESC')->get();	
		$count_students = Students::orderBy('id','DESC')->count();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "students" => $students, "count_students" => $count_students, "materials" => $materials, "count_materials" => $count_materials, "assignments" => $assignments, "count_assignments" => $count_assignments);
		return view('tutors.dashboard')->with($data);
	}

	public function profile() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$tutors = Tutors::orderBy('id','DESC')->get();	
		$count_tutors = Tutors::orderBy('id','DESC')->count();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor);
		return view('tutors.profile')->with($data);
	}

	public function changePix(Request $request) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$tutor = Tutors::findOrFail($tutor_id);
		$folder = "the_tutors/";
		
        if(!empty($_FILES["photo"]['name'])) {
    		$photo_tmp =  $_FILES["photo"]['tmp_name'];
      		$photo_name =  $_FILES["photo"]['name'];
            $photo_type =  $_FILES["photo"]['type'];
            
            if($photo_type == "image/png" || $photo_type == "image/PNG" || $photo_type == "image/jpg" || $photo_type == "image/JPG" || $photo_type == "image/jpeg" || $photo_type == "image/JPEG") {

                $tutor->pix = $tutor->tutor_id.".jpg";
                $path = $folder.$tutor->pix;
                move_uploaded_file($photo_tmp,$path);
            } else {
        	 	return "<p style='color:red'>Please select a picture. </p>";
		    }
        } else {
         	return "<p style='color:red'>Please select a picture. </p>";
		}
        
        $tutor->save();
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

	public function updateProfile(Request $request) {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$tutor = Tutors::findOrFail($tutor_id);
		$email_exists = Tutors::where('email',$request->email)->where('id','<>',$tutor_id)->count();
		$phone_exists = Tutors::where('phone',$request->phone)->where('id','<>',$tutor_id)->count();

    	if(empty($request->email) || empty($request->surname) || empty($request->firstname) || empty($request->phone) || empty($request->address) ) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else if($email_exists > 0) {
			return "<p style='color:red'>Email address exists. Try again. </p>";
		} else if($phone_exists > 0) {
			return "<p style='color:red'>Phone number exists. Try again. </p>";
		} else {
			$tutor->email = $request->email;
			$tutor->surname = $request->surname;
			$tutor->firstname = $request->firstname;
			$tutor->phone = $request->phone;
			$tutor->address = $request->address;
			$tutor->about = $request->about;
			$tutor->save();
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

	public function Signup(Request $request) {
		$tutor = new Tutors;
		$email_exists = Tutors::where('email',$request->email)->count();
		$phone_exists = Tutors::where('phone',$request->phone)->count();
		
    	if(empty($request->email) || empty($request->surname) || empty($request->firstname) || empty($request->phone) || empty($request->subject_id) || empty($request->password) || empty($request->confirm_password) ) {
			return "<p style='color:red'>Please fill all fields. </p>";
		} else if($email_exists > 0) {
			return "<p style='color:red'>Email address exists. Try again. </p>";
		} else if($phone_exists > 0) {
			return "<p style='color:red'>Phone number exists. Try again. </p>";
		} else if(strcmp($request->password,$request->confirm_password) !== 0) {
			return "<p style='color:red'>Password does not match</p>";
		}  else {
			$tutor->email = $request->email;
			$tutor->surname = $request->surname;
			$tutor->firstname = $request->firstname;
			$tutor->phone = $request->phone;
			$tutor->subject_id = $request->subject_id;
			$tutor->salt = Misc::GenerateSalt();
			$tutor->tutor_id = Misc::GeneratePin(6);
			$tutor_id_exists = Tutors::where('tutor_id',$tutor->tutor_id)->count();

			while($tutor_id_exists) {
				$tutor->tutor_id = Misc::GeneratePin(6);
			}
			
			$tutor->password = crypt($request->password,$tutor->salt);
			$tutor->save();
			Session::put('operation',"Your registration was successful. Your Tutor ID is ".$tutor->tutor_id);
        	?>

			<script type="text/javascript">
				document.getElementById("registerform").reset();
				setTimeout(function() {
					window.location="/tutors";
				},1000); 
			</script>

			<?php
			return "<p style='color:green'>Your registration was successful.  Your Tutor ID is <b>".$tutor->tutor_id."</b></p>";
			
		}
	}

	public function changePassword(Request $request) {
		$tutor = new Tutors;
		$current_password = $request->current_password;
		$new_password = $request->new_password;
		$confirm_password = $request->confirm_new_password;
		
		if(empty($request->current_password) || empty($request->new_password) || empty($request->confirm_new_password)) {
			return "<p style='color:red'>Incorrect details.</p>";
		} else if(strcmp($new_password,$confirm_password) !== 0) {
			return "<p style='color:red'>Password does not match.</p>";
		}
		else {
			$tutor_id = Session::get('tutor_id');
			$tutor_salt = DB::table('tutors')->where('id',$tutor_id)->value('salt');
			$tutor_password = DB::table('tutors')->where('id',$tutor_id)->value('password');
			$hashed_current_password = crypt($current_password,$tutor_salt);
			
			if(strcmp($hashed_current_password,$tutor_password) == 0) {
				$hashed_new_password = crypt($new_password,$tutor_salt);
				$tutor = Tutors::findOrFail($tutor_id);
				$tutor->password = $hashed_new_password;
				$tutor->save();
				Session::put('operation','Password successfully changed. Kindly relogin.');
				Session::forget('tutor_id');
				?>

				<script type="text/javascript">
					setTimeout(function() {
						window.location="/tutors";
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
		Session::forget('tutor_id');
		return redirect()->route('tutorIndex')->with('success','You are logged out.');
	}
}
