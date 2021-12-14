<?php

Route::get('/', function() {
	return view('index');
});


//tutor panel routes

Route::group(['prefix' => 'tutors'], function() {
	
	Route::get('/', 'TutorController@index')->name('tutorIndex');
	
	Route::get('/logout', 'TutorController@logout')->name('tutorLogout');
	
	Route::get('/dashboard', 'TutorController@dashboard')->name('tutorDashboard');
		
	Route::get('/profile', 'TutorController@profile')->name('tutorProfile');
		
	Route::get('/edit-profile', 'TutorController@editProfile')->name('tutorEditProfile');
		
	Route::get('/students', 'TutorController@students')->name('tutorStudents');
		
	Route::get('/all-users', 'GroupController@allTutorUsers')->name('allTutorUsers');
	
	Route::get('/load-users-modal/{group}', 'GroupController@allTutorUsersModal')->where('group','[0-9]+');
	
	Route::get('/load-group-details/{group}', 'GroupController@groupTutorDetails')->where('group','[0-9]+');
	
	Route::get('/edit-group-details-modal/{group}', 'GroupController@editTutorGroupDetailsModal')->where('group','[0-9]+');
	
	Route::get('/all-group-users/{group}', 'GroupController@allTutorGroupUsers')->where('group','[0-9]+');
	
	Route::get('/remove-group-member/{group}/{member_id}', 'GroupController@removeTutorGroupMember')->where('group','[0-9]+')->where('member_id','[0-9]+');
	
	Route::get('/groups', 'GroupController@tutorIndex')->name('tutorGroups');
		
	Route::get('/group-details/{id}', 'GroupController@tutorGroupDetails')->where('id','[0-9]+');
		
	Route::get('/chat-student-details/{student}', 'ChatController@tutorChatDetails')->where('student','[0-9]+');
		
	Route::get('/view-chat-student-details/{student}', 'ChatController@tutorChatStudentDetails')->where('student','[0-9]+');
		
	Route::get('/delete-group/{id}', 'GroupController@tutorDeleteGroup')->where('id','[0-9]+');
		
	Route::get('/exit-group/{id}', 'GroupController@tutorExitGroup')->where('id','[0-9]+');
		
	Route::get('/group-members/{id}', 'GroupController@tutorGroupMembers')->where('id','[0-9]+');
		
	Route::get('/group-chats/{group}', 'GroupController@tutorChatDetails')->where('group','[0-9]+');

	Route::get('/chat', 'ChatController@tutorIndex')->name('tutorChat');
	
	Route::get('/quiz', 'QuestionController@tutorIndex')->name('tutorQuiz');
		
	Route::get('/quiz/delete/{question}', 'QuestionController@deleteQuestion')->where('question','[0-9]+');
		
	Route::get('/appointments', 'AppointmentController@tutorIndex')->name('tutorAppointments');

	Route::get('/appointment-chats/{appointment}', 'AppointmentController@chatDetails')->where('appointment','[0-9]+');

	Route::get('/approve-appointment/{id}', 'AppointmentController@approve')->where('id','[0-9]+');
	
	Route::get('/appointment/view/{id}', 'AppointmentController@tutorDetails')->where('id','[0-9]+');
	
	Route::get('/materials', 'MaterialController@tutorIndex')->name('tutorMaterials');
	
	Route::get('/assignments', 'AssignmentController@tutorIndex')->name('tutorAssignments');
	
	Route::get('/students/profile/{id}', 'TutorController@studentProfile')->where('id','[0-9]+');
	
	Route::get('/search-group/{group}', 'GroupController@tutorSearch');

	Route::get('/search-material/{material}', 'MaterialController@tutorSearch');

	Route::get('/search-assignment/{assignment}', 'AssignmentController@search');

	
	//post

	Route::post('/add-group/', 'GroupController@addTutorGroup')->name('addTutorGroup');

	Route::post('/add-question/', 'QuestionController@addQuestion')->name('addQuestion');

	Route::post('/update-question/{question}', 'QuestionController@updateQuestion')->where('question','[0-9]+');

	Route::post('/respond-appointment/{appointment}', 'AppointmentController@tutorRespond')->where('appointment','[0-9]+');
	
	Route::post('/send-group-chat/{group}', 'GroupController@sendTutorChat')->where('group','[0-9]+');
	
	Route::post('/send-chat/', 'ChatController@sendTutorChat')->name('sendTutorChat');
	
	Route::post('/upload-material/', 'MaterialController@upload')->name('uploadMaterial');
	
	Route::post('/upload-assignment/', 'AssignmentController@upload')->name('uploadAssignment');
	
	Route::post('/add-group-member/{group}', 'GroupController@addTutorGroupMember')->where('group','[0-9]+');

	Route::post('/update-group-details/', 'GroupController@updateTutorGroupDetails')->name('updateTutorGroupDetails');

	Route::post('/change-pix/', 'TutorController@changePix')->name('tutorChangePix');

	Route::post('/delete-group/{id}', 'GroupController@tutorDeleteGroup')->where('id','[0-9]+');
	
	Route::post('/leave-group/{id}', 'GroupController@tutorLeaveGroup')->where('id','[0-9]+');

	Route::post('/update-profile/', 'TutorController@updateProfile')->name('updateTutorProfile');
	
	Route::post('/update-password/', 'TutorController@changePassword')->name('updateTutorPassword');
		
	Route::post('/tutor-signin/', 'TutorController@Signin')->name('tutorSignin');
		
	Route::post('/tutor-signup/', 'TutorController@Signup')->name('tutorSignup');
		
});


//student panel routes

Route::group(['prefix' => 'students'], function() {
	
	Route::get('/', 'StudentController@index')->name('studentIndex');
	
	Route::get('/logout', 'StudentController@logout')->name('studentLogout');
	
	Route::get('/dashboard', 'StudentController@dashboard')->name('studentDashboard');
		
	Route::get('/profile', 'StudentController@profile')->name('studentProfile');
		
	Route::get('/edit-profile', 'StudentController@editProfile')->name('studentEditProfile');
		
	Route::get('/tutors', 'StudentController@tutors')->name('studentTutors');
		
	Route::get('/all-users', 'GroupController@allUsers')->name('allUsers');
	
	Route::get('/load-users-modal/{group}', 'GroupController@allUsersModal')->where('group','[0-9]+');
	
	Route::get('/load-group-details/{group}', 'GroupController@groupDetails')->where('group','[0-9]+');
	
	Route::get('/edit-group-details-modal/{group}', 'GroupController@editGroupDetailsModal')->where('group','[0-9]+');
	
	Route::get('/all-group-users/{group}', 'GroupController@allGroupUsers')->where('group','[0-9]+');
	
	Route::get('/remove-group-member/{group}/{member_id}', 'GroupController@removeGroupMember')->where('group','[0-9]+')->where('member_id','[0-9]+');
	
	Route::get('/groups', 'GroupController@studentIndex')->name('studentGroups');
		
	Route::get('/group-details/{id}', 'GroupController@studentGroupDetails')->where('id','[0-9]+');
		
	Route::get('/chat-tutor-details/{tutor}', 'ChatController@studentChatDetails')->where('tutor','[0-9]+');
		
	Route::get('/view-chat-tutor-details/{tutor}', 'ChatController@studentChatTutorDetails')->where('tutor','[0-9]+');
		
	Route::get('/delete-group/{id}', 'GroupController@studentDeleteGroup')->where('id','[0-9]+');
		
	Route::get('/exit-group/{id}', 'GroupController@studentExitGroup')->where('id','[0-9]+');
		
	Route::get('/group-members/{id}', 'GroupController@studentGroupMembers')->where('id','[0-9]+');
		
	Route::get('/group-chats/{group}', 'GroupController@chatDetails')->where('group','[0-9]+');

	Route::get('/subjects', 'SubjectController@studentIndex')->name('studentSubjects');
		
	Route::get('/chat', 'ChatController@studentIndex')->name('studentChat');
	
	Route::get('/quiz', 'QuestionController@studentIndex')->name('studentQuiz');
		
	Route::get('/quiz/view/{subject}', 'QuestionController@viewSubjectQuestions')->where('subject','[0-9]+');
		
	Route::get('/appointments', 'AppointmentController@studentIndex')->name('studentAppointments');

	Route::get('/appointment-chats/{appointment}', 'AppointmentController@chatDetails')->where('appointment','[0-9]+');

	Route::get('/appointment/view/{id}', 'AppointmentController@details')->where('id','[0-9]+');
	
	Route::get('/materials', 'MaterialController@studentIndex')->name('studentMaterials');
	
	Route::get('/assignments', 'AssignmentController@studentIndex')->name('studentAssignments');
	
	Route::get('/tutors/profile/{id}', 'StudentController@tutorProfile')->where('id','[0-9]+');
	
	Route::get('/subject/tutors/{id}', 'SubjectController@tutors')->where('id','[0-9]+');
	
	Route::get('/search-group/{group}', 'GroupController@search');

	Route::get('/search-subject/{subject}', 'SubjectController@search');

	Route::get('/search-material/{material}', 'MaterialController@search');

	Route::get('/search-assignment/{assignment}', 'AssignmentController@search');

	
	//post

	Route::post('/add-group/', 'GroupController@addStudentGroup')->name('addStudentGroup');

	Route::post('/submit-answer/{subject}', 'AnswerController@submitAnswer')->where('subject','[0-9]+');
	
	Route::post('/book-appointment/{tutor}', 'AppointmentController@book')->where('tutor','[0-9]+');
	
	Route::post('/grade-student-solution/{solution}', 'AssignmentController@grade')->where('grade','[0-9]+');
	
	Route::post('/respond-appointment/{appointment}', 'AppointmentController@studentRespond')->where('appointment','[0-9]+');
	
	Route::post('/send-group-chat/{group}', 'GroupController@sendChat')->where('group','[0-9]+');
	
	Route::post('/send-chat/', 'ChatController@sendChat')->name('sendStudentChat');
	
	Route::post('/upload-ass-solution/{ass}', 'AssignmentController@submitSolution')->where('ass','[0-9]+');
	
	Route::post('/add-group-member/{group}', 'GroupController@addStudentGroupMember')->where('group','[0-9]+');

	Route::post('/update-group-details/', 'GroupController@updateGroupDetails')->name('updateGroupDetails');

	Route::post('/change-pix/', 'StudentController@changePix')->name('changePix');

	Route::post('/delete-group/{id}', 'GroupController@studentDeleteGroup')->where('id','[0-9]+');
	
	Route::post('/leave-group/{id}', 'GroupController@studentLeaveGroup')->where('id','[0-9]+');

	Route::post('/rate-tutor/{id}', 'StudentController@rateTutor')->where('id','[0-9]+');

	Route::post('/subject-rate-tutor/{id}/subject/{subject}', 'StudentController@rateSubjectTutor')->where('id','[0-9]+')->where('subject','[0-9]+');

	Route::post('/update-profile/', 'StudentController@updateProfile')->name('updateStudentProfile');
	
	Route::post('/book-appointment/', 'AppointmentController@book')->name('BookAppointment');

	Route::post('/update-student-password/', 'StudentController@changePassword')->name('updateStudentPassword');
		
	Route::post('/student-signin/', 'StudentController@Signin')->name('studentSignin');
		
	Route::post('/student-signup/', 'StudentController@Signup')->name('studentSignup');
		
});



