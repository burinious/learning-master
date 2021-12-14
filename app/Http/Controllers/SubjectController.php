<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Subjects;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Tutors;
use App\Students;
use DB;
use Session;

class SubjectController extends Controller
{
    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$subjects = Subjects::orderBy('name','ASC')->get();	
		$count_subjects = Subjects::orderBy('name','ASC')->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "subjects" => $subjects, "count_subjects" => $count_subjects);
		return view('students.subjects')->with($data);
	}

	public function search($subject) {
		$subjects = Subjects::where('name','LIKE',$subject.'%')->orWhere('name','LIKE','%'.$subject)->orWhere('name','LIKE','%'.$subject.'%')->get();
		$count_subject = Subjects::where('name','LIKE',$subject.'%')->orWhere('name','LIKE','%'.$subject)->orWhere('name','LIKE','%'.$subject.'%')->count();

		if($count_subject == 0) {
			echo "<p class='text-danger'> No match found </p>";
		} else {
			echo '<ul class="feeds" id="real_div">';

            foreach($subjects as $subject) {
            	$count_subject_tutors = Query::countTheValues('tutors','subject_id',$subject->id);
                ?>
                <li>
                    <div class="bg-light-info"><i class="fa fa-file"></i></div> 
                    <?php echo ucwords($subject->name);?>
                    <p style="margin-left:50px">
                        <?php

                        if($count_subject_tutors == 0) {
                            echo "<small>".$count_subject_tutors." tutor </small>";
                        } else {
                            ?>
	                            <small> 
	                                <a href="/students/subject/tutors/<?php echo $subject->id;?>"> 
	                                    <?php echo $count_subject_tutors;
	                                    
	                                    echo ($count_subject_tutors == 1 ) ? " tutor" : " tutors" 
	                                    ?>
	                                </a>
	                            </small>
	                         <?php
                        	}
                        ?> 
                    </p>
                </li>

            	<?php
            }

            echo "</ul>";
        }
	}

	public function tutors($subject_id) {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
		$tutors = Tutors::orderBy('surname','ASC')->where('subject_id',$subject_id)->get();	
		$count_tutors = Tutors::orderBy('surname','ASC')->where('subject_id',$subject_id)->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "tutors" => $tutors, "count_tutors" => $count_tutors, "subject_id" => $subject_id);
		return view('students.view-subject-tutors')->with($data);
	}
}
