<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Students;
use App\Tutors;
use App\Assignments;
use App\AssignmentSolution;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;

class AssignmentController extends Controller
{
    public function studentIndex() {
		$student_id = Session::get('student_id');
		$the_student = Students::where('id',$student_id)->first();
        $assignments = Assignments::orderBy('id','DESC')->where('student_id',$student_id)->get();	
		$count_assignments = Assignments::orderBy('id','DESC')->where('student_id',$student_id)->count();
		$data = array("student_id" => $student_id, "the_student" => $the_student, "assignments" => $assignments, "count_assignments" => $count_assignments);
		return view('students.assignments')->with($data);
	}

    public function tutorIndex() {
        $tutor_id = Session::get('tutor_id');
        $the_tutor = Tutors::where('id',$tutor_id)->first();
        $assignments = Assignments::orderBy('id','DESC')->where('tutor_id',$tutor_id)->get();   
        $count_assignments = Assignments::orderBy('id','DESC')->where('tutor_id',$tutor_id)->count();   
        $data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "assignments" => $assignments, "count_assignments" => $count_assignments);
        return view('tutors.assignments')->with($data);
    }

	public function search($assignment) {
		$student_id = Session::get('student_id');
		$assignments = Assignments::where('title','LIKE',$assignment.'%')->orWhere('title','LIKE','%'.$assignment)->orWhere('title','LIKE','%'.$assignment.'%')->orWhere('path','LIKE',$assignment.'%')->orWhere('path','LIKE','%'.$assignment)->orWhere('path','LIKE','%'.$assignment.'%')->where('student_id',$student_id)->get();
		$count_assignment = Assignments::where('title','LIKE',$assignment.'%')->orWhere('title','LIKE','%'.$assignment)->orWhere('title','LIKE','%'.$assignment.'%')->orWhere('path','LIKE',$assignment.'%')->orWhere('path','LIKE','%'.$assignment)->orWhere('path','LIKE','%'.$assignment.'%')->where('student_id',$student_id)->count();

		if($count_assignment == 0) {
			echo "<p class='text-danger'> No match found </p>";
		} else {
			echo '<ul class="feeds" id="real_div">';

            foreach($assignments as $key=>$assignment) {
            	$counter = $key+1;
            	$tutor_fullname = Query::getFullname('tutors',$assignment->tutor_id);
                $subject = Query::getValue('subjects','id',$assignment->subject_id,'name');
                $solution_exists = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->count();

                if($solution_exists == 0) {
                	?>
                	<div class="modal fade" id="submitTheSolutionModal<?php echo $assignment->id;?>" tabindex="-1" role="dialog" aria-labelledby="submitTheSolutionModalLabel<?php echo $assignment->id;?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="submitTheModalLabel<?php echo $assignment->id;?>">Submit solution</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <small class='text-info'><b><i> Note that, you can only submit solution to an assignment once. </i></b></small>
                                    <br/><br/>
                                    <form class="form-horizontal form-material" id="upload_the_solution_form<?php echo $assignment->id;?>" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                        <?php echo csrf_field();?>
                                        
                                        <input type="file" name="file"  accept=".pdf,.PDF,.doc,.docx"/>
                                        <br/><br/>

                                        <div class="modal-footer" style="border:0px">
                                            <div id="upload_the_solution_status<?php echo $assignment->id;?>"></div>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                             <button type="button" id="upload_the_solution_btn<?php echo $assignment->id;?>" onclick="return ajaxFormRequest('#upload_the_solution_btn<?php echo $assignment->id;?>','#upload_the_solution_form<?php echo $assignment->id;?>','/students/upload-ass-solution/<?php echo $assignment->id;?>','POST','#upload_the_solution_status<?php echo $assignment->id;?>','Submit','yes')" class="btn btn-info"><i class="fa fa-upload"></i> Submit</button>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <li>
                    <div class="bg-primary" style="color:#fff;padding:5px;font-size:18px"><?php echo $counter;?></div> 
                     
                    <?php echo ucfirst($assignment->title);?>

                    <p style="margin-left:50px">
                        <a href="/the_assignments/all/<?php echo $assignment->path;?>"><?php echo ucfirst($assignment->path);?></a> &nbsp; &nbsp;
                    
                        <small style='font-size:13px'><?php echo $subject;?> &nbsp; &nbsp;  <?php echo $tutor_fullname;?> &nbsp; &nbsp; <?php echo $assignment->size;?></small> 
                        <span class="text-muted"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($assignment->created_at))->diffForHumans();?></span>
                        <br/><small  style='font-size:14px'> <?php echo ucfirst($assignment->note);?></small>
                        <br/><br/>
                        
                        <?php
                        if($solution_exists == 1) {
                        	$solution = DB::table('ass_solutions')->where('assignment_id',$assignment->id)->where('user_id',$student_id)->value('path');
                
                            ?>
                            <a href="/the_assignments/submitted/<?php echo $solution;?>" class="btn btn-sm btn-info btn-rounded pull-right">View solution</a>
                        	<?php
                        } else {
                            ?>
                            <button style="margin-right:20px" class="btn btn-sm btn-primary btn-rounded pull-right" type="button"  data-toggle="modal" data-target="#submitTheSolutionModal<?php echo $assignment->id;?>">Submit solution</button> 
                        <?php
                        }
                        ?>
                        <br/>
                    </p><hr/>
                </li>
			<?php
			}
			echo "</ul>";
		}
	}

	public function grade(Request $request,$solution) {
        $tutor_id = Session::get('tutor_id');
        $score = $request->score;
        $total_score = $request->total_score;
        
        if(empty($tutor_id) || empty($score) || empty($total_score) ) {
            return "<p style='color:red'>Fill both fields. </p>";
        } else if($score > $total_score) {
            return "<p style='color:red'>Score cannot be greater than total score. </p>";
        } else {
            $solution = AssignmentSolution::findOrFail($solution);
            $solution->grade = $score;
            $solution->obtainable = $total_score;
            $solution->save();
            Session::put('operation',"Student was successfully graded.");
                ?>

                <script type="text/javascript">
                    setTimeout(function() {
                        window.location="assignments";
                    },1000); 
                </script>

                <?php
            return "<p style='color:green'>Student was successfully graded.</b></p>";
        }
    }

    public function submitSolution(Request $request,$assignment) {
		$student_id = Session::get('student_id');
		$folder = "the_assignments/submitted/";
		$solution = new AssignmentSolution();

        if(!empty($_FILES["file"]['name'])) {
    		$file_tmp =  $_FILES["file"]['tmp_name'];
      		$file_name =  $_FILES["file"]['name'];
            $file_type =  $_FILES["file"]['type'];
            $file_size =  $_FILES["file"]['size'];
           	$solution->path = $file_name;
            $path = $folder.$file_name;
            
            if(file_exists($path)) {
            	return "<p style='color:red'>File exists. Kindly rename the file. </p>";
            } else {
            	move_uploaded_file($file_tmp,$path);
	            $solution->user_id = $student_id;
	            $solution->size = Misc::GetFileSize($file_size);
	            $solution->assignment_id = $assignment;
	          	$solution->save();
	          	Session::put('operation',"Your solution was successfully uploaded.");
				?>

				<script type="text/javascript">
					setTimeout(function() {
						window.location="assignments";
					},1000); 
				</script>

				<?php
				return "<p style='color:green'>Your solution was successfully uploaded.</b></p>";
	        }
        } else {
         	return "<p style='color:red'>Please select a file. </p>";
		}
    }

    public function upload(Request $request) {
        $assignment = new Assignments();
        $tutor_id = Session::get('tutor_id');
        $selected_students = $request->get('student_id');
        $count_students = count($selected_students);

        if( ($count_students == 0) || empty($tutor_id) || empty($request->title) ) {
            return "<p style='color:red'>Please fill all fields. </p>";
        } else {
            $note = trim($request->note);
            $folder = "the_assignments/all/";
            $data = array();

            if(!empty($_FILES["file"]['name'])) {
                $file_tmp =  $_FILES["file"]['tmp_name'];
                $file_name =  $_FILES["file"]['name'];
                $file_type =  $_FILES["file"]['type'];
                $file_size =  Misc::GetFileSize($_FILES["file"]['size']);
                $path = $folder.$file_name;
                    
                if($count_students > 0) {
                    $subject_id = Query::getValue('tutors','id',$tutor_id,'subject_id');

                    foreach($selected_students as $student) {

                        $title_exists = Assignments::where('title',$request->title)->where('tutor_id',$tutor_id)->where('student_id',$student);

                        $data[] = [
                            'student_id' => $student,
                            'title' => $request->title,
                            'tutor_id' => $tutor_id,
                            'subject_id' => $subject_id,
                            'path' => $file_name,
                            'size' => $file_size,
                            'note' => $note,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ];
                    }

                    DB::table('assignments')->insert($data);
                    move_uploaded_file($file_tmp,$path);

                    ($count_students == 1) ? Session::put('operation',"Assignment was successfully sent to the student.") : Session::put('operation',"Assignment was successfully sent to the selected students.");;
                    ?>

                    <script type="text/javascript">
                        setTimeout(function() {
                            window.location="/tutors/assignments";
                        },1000); 
                    </script>

                    <?php
                    return ($count_students == 1) ? "<p style='color:green'>Assignment was successfully sent to the student.</b></p>" : "<p style='color:green'>Assignment was successfully sent to the selected students.</b></p>";
                }

            } else {
                return "<p style='color:red'>Please select the file. </p>";
            }
            
        }
    }

}

?>