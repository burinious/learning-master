<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Questions;
use App\Answers;
use App\MyLib\Misc;
use App\MyLib\Query;
use App\Tutors;
use App\Students;
use DB;
use Session;

class QuestionController extends Controller
{
    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = students::where('id',$student_id)->first();
		$questions = Questions::groupBy('subject_id')->select('subject_id')->paginate(15);	
		$count_questions = Questions::groupBy('subject_id')->select('subject_id')->count();	
		$data = array("student_id" => $student_id, "the_student" => $the_student, "questions" => $questions, "count_questions" => $count_questions);
		return view('students.quiz')->with($data);
	}

	public function tutorIndex() {
		$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$questions = Questions::where('tutor_id',$tutor_id)->orderBy('id','DESC')->paginate(15);	
		$count_questions = Questions::where('tutor_id',$tutor_id)->orderBy('id','DESC')->count();	
		$data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "questions" => $questions, "count_questions" => $count_questions);
		return view('tutors.quiz')->with($data);
	}

	public function addQuestion(Request $request) {
    	$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$question = new Questions();
    	$question->question = $request->question;
        $question->type = $request->question_type;

        if($request->question_type == "multiple") {
        	$question->a = $request->option_a;
	        $question->b = $request->option_b;
    	    $question->c = $request->option_c;
    	    $question->d = $request->option_d; 
    	    $question->answer = $request->correct_option;    	    
        } else if($request->question_type == "boolean") {
            $question->answer = $request->correct_boolean_option;           
        } 
        
        $question_exists = Questions::where('question',$request->question)->where('subject_id',$the_tutor->subject_id)->count();
        
    	if(empty($request->question) || empty($request->question_type)) {
    		return "<p style='color:red'>Fill all fields. </p>";
		} else if( ($request->question_type == "multiple") && ( (empty($request->option_a) || empty($request->option_b) || empty($request->option_c) ||  empty($request->option_d) ||  empty($request->correct_option) ) ) ) {
			return "<p style='color:red'>Fill all fields. </p>";
		} else if( ($request->question_type == "boolean") && (empty($request->correct_boolean_option) ) ) {
        	return "<p style='color:red'>Select the correct option. </p>";
		} else if($question_exists > 0) {
			return "<p style='color:red'>Question has been added before. </p>";
		} else {
			$question->subject_id = $the_tutor->subject_id;
			$question->tutor_id = $tutor_id;
			$question->save();
			Session::put('operation',"Question was successfully added. ");
        	?>

			<script type="text/javascript">
				window.location="quiz";
			</script>

			<?php
			return "<p style='color:green'>Question was successfully added. </p>";
		}
    }

    public function updateQuestion(Request $request, $id) {
    	$tutor_id = Session::get('tutor_id');
		$the_tutor = Tutors::where('id',$tutor_id)->first();
		$question = Questions::findOrFail($id);
    	$question->question = $request->question;
        $question->type = $request->question_type;

        if($request->question_type == "multiple") {
        	$question->a = $request->option_a;
	        $question->b = $request->option_b;
    	    $question->c = $request->option_c;
    	    $question->d = $request->option_d; 
    	    $question->answer = $request->correct_option;    	    
        } else if($request->question_type == "boolean") {
            $question->answer = $request->correct_boolean_option;           
        } 
        
        $question_exists = Questions::where('question',$request->question)->where('subject_id',$the_tutor->subject_id)->where('id','<>',$id)->count();
        
    	if(empty($request->question) || empty($request->question_type)) {
    		return "<p style='color:red'>Fill all fields. </p>";
		} else if( ($request->question_type == "multiple") && ( (empty($request->option_a) || empty($request->option_b) || empty($request->option_c) ||  empty($request->option_d) ||  empty($request->correct_option) ) ) ) {
			return "<p style='color:red'>Fill all fields. </p>";
		} else if( ($request->question_type == "boolean") && (empty($request->correct_boolean_option) ) ) {
        	return "<p style='color:red'>Select the correct option. </p>";
		} else if($question_exists > 0) {
			return "<p style='color:red'>Question has been added before. </p>";
		} else {
			$question->subject_id = $the_tutor->subject_id;
			$question->tutor_id = $tutor_id;
			$question->save();
			Session::put('operation',"Question was successfully updated. ");
        	?>

			<script type="text/javascript">
				window.location="quiz";
			</script>

			<?php
			return "<p style='color:green'>Question was successfully updated. </p>";
		}
    }

    public function viewSubjectQuestions($subject_id) {
        $student_id = Session::get('student_id');
		$the_student = students::where('id',$student_id)->first();
		$questions = Questions::where('subject_id',$subject_id)->get();
        $count_answers = Answers::where('subject_id',$subject_id)->where('student_id',$student_id)->count();
        $count_questions = Questions::where('subject_id',$subject_id)->count();
        $answered_questions = Answers::where('student_id',$student_id)->where('subject_id',$subject_id)->get();
    	return view('students.view-quiz', compact('student_id','the_student','subject_id','questions','count_questions', 'count_answers', 'answered_questions'));
    } 

    public function deleteQuestion($id) {
        $question = Questions::findOrFail($id);
        Answers::where('question_id',$id)->delete();
        $question->delete();
        return redirect()->route('tutorQuiz')->with('success','Question was successfully deleted.');
	}

}
