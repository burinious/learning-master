<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Students;
use App\Tutors;
use App\Materials;
use App\MyLib\Misc;
use App\MyLib\Query;
use DB;
use Session;

class MaterialController extends Controller 
{
	public function studentIndex() {
		$student_id = Session::get('student_id');
		$materials = Materials::orderBy('id','DESC')->where('student_id',$student_id)->get();	
		$count_materials = Materials::orderBy('id','DESC')->where('student_id',$student_id)->count();	
		$the_student = Students::where('id',$student_id)->first();
		$data = array("student_id" => $student_id, "the_student" => $the_student, "materials" => $materials, "count_materials" => $count_materials);
		return view('students.materials')->with($data);
	}

    public function tutorIndex() {
        $tutor_id = Session::get('tutor_id');
        $the_tutor = Tutors::where('id',$tutor_id)->first();
        $materials = Materials::orderBy('id','DESC')->where('tutor_id',$tutor_id)->get();   
        $count_materials = Materials::orderBy('id','DESC')->where('tutor_id',$tutor_id)->count();   
        $data = array("tutor_id" => $tutor_id, "the_tutor" => $the_tutor, "materials" => $materials, "count_materials" => $count_materials);
        return view('tutors.materials')->with($data);
    }

	public function search($material) {
		$student_id = Session::get('student_id');
		
        $materials = Materials::where('student_id',$student_id)->where('title','LIKE',$material.'%')->orWhere('title','LIKE','%'.$material)->orWhere('title','LIKE','%'.$material.'%')->orWhere('path','LIKE',$material.'%')->orWhere('path','LIKE','%'.$material)->orWhere('path','LIKE','%'.$material.'%')->get();
		
        $count_material = Materials::where('student_id',$student_id)->where('title','LIKE',$material.'%')->orWhere('title','LIKE','%'.$material)->orWhere('title','LIKE','%'.$material.'%')->orWhere('path','LIKE',$material.'%')->orWhere('path','LIKE','%'.$material)->orWhere('path','LIKE','%'.$material.'%')->count();

		if($count_material == 0) {
			echo "<p class='text-danger'> No match found </p>";
		} else {
			echo '<ul class="feeds" id="real_div">';

            foreach($materials as $key=>$material) {
            	$counter = $key+1;
            	$tutor_fullname = Query::getFullname('tutors',$material->tutor_id);
            	$subject = Query::getValue('subjects','id',$material->subject_id,'name');

                ?>
                <li>
                    <div class="bg-info" style="color:#fff;padding:5px;font-size:18px"><?php echo $counter;?></div> 
                    
                    <?php echo ucfirst($material->title);?>

                    <p style="margin-left:50px">
                        <a href="/the_materials/<?php echo $material->path;?>"><?php echo ucfirst($material->path);?></a> &nbsp; &nbsp;

                        <small style='font-size:13px'><?php echo $subject;?> &nbsp; &nbsp; <?php echo $tutor_fullname;?> &nbsp; &nbsp; <?php echo $material->size;?></small> 
                        <span class="text-muted"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans();?></span>
                        <br/><small  style='font-size:14px'> <?php echo ucfirst($material->note);?></small>
                    </p><hr/>
                </li>

            	<?php
            }

            echo "</ul>";
        }
	}


    public function tutorSearch($material) {
        $tutor_id = Session::get('tutor_id');
        $materials = Materials::where('title','LIKE',$material.'%')->orWhere('title','LIKE','%'.$material)->orWhere('title','LIKE','%'.$material.'%')->orWhere('path','LIKE',$material.'%')->orWhere('path','LIKE','%'.$material)->orWhere('path','LIKE','%'.$material.'%')->where('tutor_id',$tutor_id)->get();
        $count_material = Materials::where('title','LIKE',$material.'%')->orWhere('title','LIKE','%'.$material)->orWhere('title','LIKE','%'.$material.'%')->orWhere('path','LIKE',$material.'%')->orWhere('path','LIKE','%'.$material)->orWhere('path','LIKE','%'.$material.'%')->where('tutor_id',$tutor_id)->count();

        // $materials = Materials::where([
        //         ['tutor_id','=',$tutor_id],
        //     ])->orWhere([
        //         ['title','LIKE',$material.'%'],
        //         ['title','LIKE','%'.$material], 
        //         ['title','LIKE','%'.$material.'%'],
        //         ['path','LIKE',$material.'%'],
        //         ['path','LIKE','%'.$material],
        //         ['path','LIKE','%'.$material.'%'],
        //     ])->get();

        // $count_materials = Materials::where([
        //         ['tutor_id','=',$tutor_id],
        //     ])->orWhere([
        //         ['title','LIKE',$material.'%'],
        //         ['title','LIKE','%'.$material], 
        //         ['title','LIKE','%'.$material.'%'],
        //         ['path','LIKE',$material.'%'],
        //         ['path','LIKE','%'.$material],
        //         ['path','LIKE','%'.$material.'%'],
        //     ])->count();

        if($count_material == 0) {
            echo "<p class='text-danger'> No match found </p>";
        } else {
            echo '<ul class="feeds" id="real_div">';

            foreach($materials as $key=>$material) {
                $counter = $key+1;
                $tutor_fullname = Query::getFullname('tutors',$material->tutor_id);
                $subject = Query::getValue('subjects','id',$material->subject_id,'name');

                ?>
                <li>
                    <div class="bg-info" style="color:#fff;padding:5px;font-size:18px"><?php echo $counter;?></div> 
                    
                    <?php echo ucfirst($material->title);?>

                    <p style="margin-left:50px">
                        <a href="/the_materials/<?php echo $material->path;?>"><?php echo ucfirst($material->path);?></a> &nbsp; &nbsp;

                        <small style='font-size:13px'><?php echo $subject;?> &nbsp; &nbsp; <?php echo $tutor_fullname;?> &nbsp; &nbsp; <?php echo $material->size;?></small> 
                        <span class="text-muted"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($material->created_at))->diffForHumans();?></span>
                        <br/><small  style='font-size:14px'> <?php echo ucfirst($material->note);?></small>
                    </p><hr/>
                </li>

                <?php
            }

            echo "</ul>";
        }
    }

    public function upload(Request $request) {
        $material = new Materials();
        $tutor_id = Session::get('tutor_id');
        $selected_students = $request->get('student_id');
        $count_students = count($selected_students);

        if( ($count_students == 0) || empty($tutor_id) || empty($request->title) ) {
            return "<p style='color:red'>Please fill all fields. </p>";
        } else {
            $note = trim($request->note);
            $folder = "the_materials/";
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

                        $title_exists = Materials::where('title',$request->title)->where('tutor_id',$tutor_id)->where('student_id',$student);

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

                    DB::table('materials')->insert($data);
                    move_uploaded_file($file_tmp,$path);

                    ($count_students == 1) ? Session::put('operation',"Material was successfully sent to the student.") : Session::put('operation',"Material was successfully sent to the selected students.");;
                    ?>

                    <script type="text/javascript">
                        setTimeout(function() {
                            window.location="/tutors/materials";
                        },1000); 
                    </script>

                    <?php
                    return ($count_students == 1) ? "<p style='color:green'>Material was successfully sent to the student.</b></p>" : "<p style='color:green'>Material was successfully sent to the selected students.</b></p>";
                }

            } else {
                return "<p style='color:red'>Please select the file. </p>";
            }
            
        }
	}

}
