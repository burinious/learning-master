<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Answers;
use App\Students;
use App\Questions;
use DB;
use Session;

class AnswerController extends Controller
{
    public function submitAnswer(Request $request,$id) {
    	$answer = new Answers();
    	$student_id = Session::get('student_id');
    	$all_questions = Questions::where('subject_id',$id)->get();
    	$data = array();

    	foreach($all_questions as $question) {
    		$the_question = "question_id$question->id";
    		$option = "option$question->id";

    		if($request->has("$the_question")) {
				$question_id = $request->$the_question;
				$chosen_option = $request->$option;
				
				$data[] = [
                    'student_id' => $student_id,
                    'question_id' => $question_id,
                    'subject_id' => $id,
                    'chosen_option' => $chosen_option,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ];
            }
		}
		
		if(count($data) > 0) {
			$insert_answers = DB::table('answers')->insert($data);

			if($insert_answers) {
				?>
					<script type="text/javascript">
						var subject_id = "<?php echo $id;?>";
						alert("Your answers were successfully submitted");
						window.location="quiz/view/"+subject_id;
					</script>
				<?php
			}
		} else {
			return "<p style='color:red'>No selected answer. </p>";
		}
    }
}
