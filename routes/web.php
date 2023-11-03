<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Abc;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Recruiters;
use App\Http\Controllers\Trainers;
use App\Http\Controllers\Aprex;
use App\Http\Controllers\Ebook;
use App\Http\Controllers\Parents;
use App\Http\Controllers\Sub_admin;

use App\Models\Video_hls_secret;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// =============admin=======================
Route::get("/admin",[Admin::class,'login']);
Route::POST("/admin/login",[Admin::class,'admin_login']);
Route::get("/admin/index",[Admin::class,'index']);
Route::get("/admin/logout",[Abc::class,'logout']);



Route::get("/admin/add_question",[Admin::class,'add_question_view']);
Route::post("/admin/add_question",[Admin::class,'add_question']);

Route::get("/admin/add_subject",[Admin::class,'add_subject_view']);
Route::post("/admin/add_subject",[Admin::class,'add_subject']);

Route::get("/admin/create_quiz",[Admin::class,'create_quiz_view']);
Route::post("/admin/create_quiz",[Admin::class,'create_quiz']);

Route::get("/admin/add_quiz",[Admin::class,'add_quiz']);


Route::get("/admin/quiz_master",[Admin::class,'quiz_master']);
// Route::post("/quiz_master/{id}",[Abc::class,'quiz_master']);


Route::get("/admin/edit_subject/{id}",function(){
    return view('users.edit_subject');
});

Route::get("/admin/add_question_to_quiz/{id}",[Admin::class,'add_question_to_quiz']);

Route::get("/admin/delete_question_from_quiz/{id}",[Admin::class,'delete_question_from_quiz']);

Route::get("/admin/create_course",function(){
    return view('admin.create_course');
});
Route::post("/admin/create_course",[Admin::class,'create_course']);

Route::get("/admin/all_users",[Admin::class,'all_users']);

Route::get("/admin/create_internship",[Admin::class,'create_internship_view']);
Route::post("/admin/create_internship",[Admin::class,'create_internship']);

Route::get("/admin/all_internships",[Admin::class,'all_internships']);
Route::get("/admin/internship_applications/{id}",[Admin::class,'internship_applications']);

Route::get("/admin/sitemap",[Admin::class,'sitemap']);

Route::get("/admin/create_assesments",[Admin::class,'create_assesments_view']);
Route::post("/admin/create_assesments",[Admin::class,'create_assesments']);

Route::get("/admin/get_sections",[Admin::class,'get_sections']);
Route::get("/admin/get_sections2",[Admin::class,'get_sections2']);
Route::get("/admin/get_videos",[Admin::class,'get_videos']);

Route::get("/admin/add_videos",[Admin::class,'add_videos_view']);
Route::post("/admin/add_videos",[Admin::class,'add_videos']);

Route::get("/admin/all_courses",[Admin::class,'all_courses']);
Route::get("/admin/default_course_details/{id}",[Admin::class,'default_course_details']);
Route::get("/admin/default_settings",[Admin::class,'default_settings']);
Route::get("/admin/tests",[Admin::class,'tests']);
Route::get("/admin/quizzes",[Admin::class,'quizzes']);
Route::get("/admin/assesments",[Admin::class,'assesments']);
Route::get("/admin/all_jobs",[Admin::class,'all_jobs']);
Route::get("/admin/job_applications/{id}",[Admin::class,'job_applications']);

Route::get("/admin/all_results/{id}",[Admin::class,'all_results']);

Route::get("/admin/create_mini_projects",[Admin::class,'create_mini_projects_view']);
Route::post("/admin/create_mini_projects",[Admin::class,'create_mini_projects']);
Route::get("/admin/mini_projects",[Admin::class,'mini_projects']);

Route::get("/admin/test_details/{id}",[Admin::class,'test_details']);
Route::get("/admin/view_assesment_single/{id}",[Admin::class,'view_assesment_single']);
Route::get("/admin/enrolled_students/{id}",[Admin::class,'enrolled_students']);
Route::get("/admin/quiz_details/{id}",[Admin::class,'quiz_details']);

Route::get("/admin/labs",[Admin::class,'labs']);
Route::get("/admin/add_lab",[Admin::class,'add_lab_view']);
Route::post("/admin/add_lab",[Admin::class,'add_lab']);
Route::get("/admin/create_task",[Admin::class,'create_task_view']);
Route::post("/admin/create_task",[Admin::class,'create_task']);

Route::get("/admin/change_password",[Admin::class,'change_password_view']);
Route::post("/admin/change_password",[Admin::class,'change_password']);

Route::post("/admin/add_trainer",[Admin::class,'add_trainer']);
Route::get("/admin/student_profile/{id}",[Admin::class,'student_profile']);

Route::get("/admin/create_project_task",[Admin::class,'create_project_task_view']);
Route::post("/admin/create_project_task",[Admin::class,'create_project_task']);





// ===================recruiter=============

Route::get("/recruiter/register",[Recruiters::class,'register']);
Route::post("/recruiter/register",[Recruiters::class,'recruiter_register']);

Route::get("/recruiter",[Recruiters::class,'login']);
Route::get("/recruiter/login",[Recruiters::class,'login']);
Route::POST("/recruiter/login",[Recruiters::class,'recruiter_login']);
Route::get("/recruiter/index",[Recruiters::class,'index']);

Route::get("/recruiter/logout",[Recruiters::class,'logout']);

Route::get("/recruiter/all_results",[Recruiters::class,'all_results']);

Route::get("/recruiter/add_question",[Recruiters::class,'add_question_view']);
Route::post("/recruiter/add_question",[Recruiters::class,'add_question']);

Route::get("/recruiter/add_subject",[Recruiters::class,'add_subject_view']);
Route::post("/recruiter/add_subject",[Recruiters::class,'add_subject']);



Route::get("/recruiter/create_quiz",[Recruiters::class,'create_quiz_view']);
Route::post("/recruiter/create_quiz",[Recruiters::class,'create_quiz']);

Route::get("/recruiter/add_quiz",[Recruiters::class,'add_quiz']);


Route::get("/recruiter/quiz_master",[Recruiters::class,'quiz_master']);
Route::get("/recruiter/quiz_details/{id}",[Recruiters::class,'quiz_details']);
// Route::post("/quiz_master/{id}",[Abc::class,'quiz_master']);


// Route::get("/recruiters/edit_subject/{id}",function(){
//     return view('users.edit_subject');
// });

Route::get("/recruiter/add_question_to_quiz/{id}",[Recruiters::class,'add_question_to_quiz']);

Route::get("/recruiter/delete_question_from_quiz/{id}",[Recruiters::class,'delete_question_from_quiz']);

Route::get("/recruiter/all_students",[Recruiters::class,'all_students']);

Route::get("/recruiter/create_job",[Recruiters::class,'create_job_view']);
Route::post("/recruiter/create_job",[Recruiters::class,'create_job']);

Route::get("/recruiter/all_jobs",[Recruiters::class,'all_jobs']);
Route::get("/recruiter/job_applications/{id}",[Recruiters::class,'job_applications']);

Route::get("/recruiter/sitemap",[Recruiters::class,'sitemap']);

Route::get("/recruiter/all_quizzes",[Recruiters::class,'all_quizzes']);
Route::get("/recruiter/all_results/{id}",[Recruiters::class,'all_results']);

Route::get("/recruiter/change_password",[Recruiters::class,'change_password_view']);
Route::post("/recruiter/change_password",[Recruiters::class,'change_password']);

Route::get("/recruiter/student_profile/{id}",[Recruiters::class,'student_profile']);

// ===================trainer=============

// Route::get("/trainer/register",[Trainers::class,'register']);
// Route::post("/trainer/register",[Trainers::class,'trainer_register']);

Route::get("/trainer",[Trainers::class,'login']);
Route::get("/trainer/login",[Trainers::class,'login']);
Route::POST("/trainer/login",[Trainers::class,'trainer_login']);
Route::get("/trainer/index",[Trainers::class,'index']);

Route::get("/trainer/message/{id}",[Trainers::class,'message']);
Route::post("/trainer/send_message",[Trainers::class,'send_message']);


Route::get("/trainer/qna",[Trainers::class,'qna']);
Route::get("/trainer/qna_answer/{id}",[Trainers::class,'qna_answer_view']);
Route::post("/trainer/qna_answer",[Trainers::class,'qna_answer']);

Route::get("/trainer/default_settings",[Trainers::class,'default_settings']);
Route::get("/trainer/logout",[Trainers::class,'logout']);

Route::get("/trainer/change_password",[Trainers::class,'change_password_view']);
Route::post("/trainer/change_password",[Trainers::class,'change_password']);

// ================teacher=====================

Route::get("/teacher/school_qna",[Trainers::class,'school_qna']);
Route::get("/teacher/school_qna_answer/{id}",[Trainers::class,'school_qna_answer_view']);
Route::post("/teacher/school_qna_answer",[Trainers::class,'school_qna_answer']);

Route::get("/teacher/school_message/{id}",[Trainers::class,'school_message']);
Route::post("/teacher/school_send_message",[Trainers::class,'school_send_message']);

// =================users=======================
Route::get("/",[Abc::class,'login']);
Route::get("/index",[Abc::class,'index']);

Route::get("/register",[Abc::class,'register']);
Route::post("/register",[Abc::class,'user_register']);

Route::get("/login",[Abc::class,'login']);
Route::post("/login",[Abc::class,'user_login']);

Route::get("/logout",[Abc::class,'logout']);



Route::get("/default_course_details/{id}",[Abc::class,'default_course_details']);

Route::get("/all_quiz",[Abc::class,'all_quiz']);

Route::get("/course_quizes",[Abc::class,'course_quizes']);
Route::get("/recruiter_quizes",[Abc::class,'recruiter_quizes']);


Route::get("/take_quiz/{id}",[Abc::class,'take_quiz']);

Route::post("/quiz_submit/{id}",[Abc::class,'quiz_submit']);

Route::get("/view_score/{id}",[Abc::class,'view_score']);

Route::get("/all_results",[Abc::class,'all_results']);

Route::get("/add_profile",[Abc::class,'add_profile_view']);
Route::post("/add_profile",[Abc::class,'add_profile']);

Route::get("/message/{id}",[Abc::class,'message']);
Route::post("/send_message",[Abc::class,'send_message']);
Route::post("/send_message2",[Abc::class,'send_message2']);

Route::post("/save_notes",[Abc::class,'save_notes']);
Route::get("/default_live_stream/{id}/{tab}",[Abc::class,'default_live_stream']);
Route::get("/default_live_stream/{id}/{tab}/{video}",[Abc::class,'default_live_stream']);

Route::get("/view_assesment_results/{video}",[Abc::class,'view_assesment_results']);

Route::get("/single_course_test/{id}/{tab}",[Abc::class,'single_course_test']);

Route::get("/qna",[Abc::class,'qna_view']);
Route::post("/qna",[Abc::class,'qna']);

Route::get("/jobs",[Abc::class,'jobs']);
Route::post("/apply_job",[Abc::class,'apply_job']);

Route::get("/internships",[Abc::class,'internships']);
Route::post("/apply_internship",[Abc::class,'apply_internship']);

Route::get("/code",[Abc::class,'code']);
Route::get("/project",[Abc::class,'project']);
Route::get("/prog/{prog}",[Abc::class,'prog']);

Route::get("/sitemap",[Abc::class,'sitemap']);

Route::post("/start_course",[Abc::class,'start_course']);

Route::get("/all_courses",[Abc::class,'all_courses']);

Route::get("/take_assesment/{course}/{section}/{video}",[Abc::class,'take_assesment']);

Route::post("/assesment_submit/{course}/{section}/{video}",[Abc::class,'assesment_submit']);
Route::get("/take_test/{course_id}/{id}",[Abc::class,'take_test']);
Route::post("/test_submit/{id}",[Abc::class,'test_submit']);
Route::get("/view_test_score/{id}/{course_id}",[Abc::class,'view_test_score']);
Route::get("/view_project/{id}",[Abc::class,'view_project']);
Route::get("/view_internship/{id}",[Abc::class,'view_internship']);
Route::get("/start_internship/{id}/{lab}",[Abc::class,'start_internship']);
Route::get("/update_internship_task_status/{id}",[Abc::class,'update_internship_task_status']);
Route::get("/continue_task/{id}/{lab}",[Abc::class,'continue_task']);

Route::get("/start_project/{id}/{lab}",[Abc::class,'start_project']);
Route::get("/update_project_task_status/{id}",[Abc::class,'update_project_task_status']);
Route::get("/continue_project_task/{id}/{lab}",[Abc::class,'continue_project_task']);


Route::get("/lab/{id}",[Abc::class,'lab']);
Route::get("/ebook/{id}",[Abc::class,'ebook']);
Route::get("/assesment_result/{id}",[Abc::class,'assesment_result']);

Route::get("/about",[Abc::class,'about']);
Route::get("/account_information",[Abc::class,'account_information']);
Route::get("/author_profile",[Abc::class,'author_profile']);
Route::get("/blog_sidebar",[Abc::class,'blog_sidebar']);
Route::get("/blog_single",[Abc::class,'blog_single']);
Route::get("/blog",[Abc::class,'blog']);
Route::get("/cart",[Abc::class,'cart']);
Route::get("/checkout",[Abc::class,'checkout']);
Route::get("/coming_soon",[Abc::class,'coming_soon']);
Route::get("/contact_information",[Abc::class,'contact_information']);

Route::get("/search_questions",[Abc::class,'search_questions']);
Route::get("/qna_single/{id}",[Abc::class,'qna_single']);

Route::get("/search_forum_questions",[Abc::class,'search_forum_questions']);
Route::get("/search_courses",[Abc::class,'search_courses']);

Route::get("/change_password",[Abc::class,'change_password_view']);
Route::post("/change_password",[Abc::class,'change_password']);


// ==========================

Route::get("/contact_two",[Abc::class,'contact_two']);
Route::get("/contact",[Abc::class,'contact']);
Route::get("/course_details_2",[Abc::class,'course_details_2']);
Route::get("/course_details",[Abc::class,'course_details']);
Route::get("/courses_grid_1",[Abc::class,'courses_grid_1']);
Route::get("/courses_grid_2",[Abc::class,'courses_grid_2']);
Route::get("/courses_grid_3",[Abc::class,'courses_grid_3']);

Route::get("/default_analytics",[Abc::class,'default_analytics']);
Route::get("/default_author_profile",[Abc::class,'default_author_profile']);
Route::get("/default_categories",[Abc::class,'default_categories']);

Route::get("/default_channel",[Abc::class,'default_channel']);
Route::get("/default_course_details_2",[Abc::class,'default_course_details_2']);


Route::get("/default_follower",[Abc::class,'default_follower']);

Route::get("/default_search",[Abc::class,'default_search']);
Route::get("/default_settings",[Abc::class,'default_settings']);
Route::get("/default_test",[Abc::class,'default_test']);
Route::get("/default_user_profile",[Abc::class,'default_user_profile']);
Route::get("/default",[Abc::class,'default']);

Route::get("/email_box",[Abc::class,'email_box']);
Route::get("/forgot",[Abc::class,'forgot']);
Route::get("/home_1",[Abc::class,'home_1']);
Route::get("/home_2",[Abc::class,'home_2']);
Route::get("/home_3",[Abc::class,'home_3']);
Route::get("/home_4",[Abc::class,'home_4']);
Route::get("/home_5",[Abc::class,'home_5']);
Route::get("/home_6",[Abc::class,'home_6']);



Route::get("/password",[Abc::class,'password']);
Route::get("/payment/{id}",[Abc::class,'payment']);
Route::get("/popup_chat",[Abc::class,'popup_chat']);
Route::get("/price",[Abc::class,'price']);



Route::get("/service",[Abc::class,'service']);
Route::get("/shop_1",[Abc::class,'shop_1']);
Route::get("/shop_2",[Abc::class,'shop_2']);
Route::get("/shop_3",[Abc::class,'shop_3']);
Route::get("/single_product_2",[Abc::class,'single_product_2']);
Route::get("/single_product_3",[Abc::class,'single_product_3']);
Route::get("/single_product",[Abc::class,'single_product']);
Route::get("/social",[Abc::class,'social']);
Route::get("/todo",[Abc::class,'todo']);
Route::get("/user_profile",[Abc::class,'user_profile']);


// ==========================Mobile view =========================

Route::get("/aprex/notes/{id}",[Aprex::class,'notes']);
Route::post("/aprex/save_notes",[Aprex::class,'save_notes']);
Route::get("/aprex/chat/{id}",[Aprex::class,'chat']);
Route::post("/aprex/send_message",[Aprex::class,'send_message']);
Route::get("/aprex/video_player_mobile/{id}",[Aprex::class,'video_player_mobile']);


Route::get("/aprex",[Aprex::class,'login']);
Route::get("/aprex/index",[Aprex::class,'index']);

Route::get("/aprex/register",[Aprex::class,'register']);
Route::post("/aprex/register",[Aprex::class,'user_register']);

Route::get("/aprex/login",[Aprex::class,'login']);
Route::post("/aprex/login",[Aprex::class,'user_login']);

Route::get("/aprex/logout",[Aprex::class,'logout']);



Route::get("/aprex/default_course_details/{id}",[Aprex::class,'default_course_details']);

Route::get("/aprex/all_quiz",[Aprex::class,'all_quiz']);

Route::get("/aprex/course_quizes",[Aprex::class,'course_quizes']);
Route::get("/aprex/recruiter_quizes",[Aprex::class,'recruiter_quizes']);


Route::get("/aprex/take_quiz/{id}",[Aprex::class,'take_quiz']);

Route::post("/aprex/quiz_submit/{id}",[Aprex::class,'quiz_submit']);

Route::get("/aprex/view_score/{id}",[Aprex::class,'view_score']);

Route::get("/aprex/all_results",[Aprex::class,'all_results']);

Route::get("/aprex/add_profile",[Aprex::class,'add_profile_view']);
Route::post("/aprex/add_profile",[Aprex::class,'add_profile']);

Route::get("/aprex/message/{id}",[Aprex::class,'message']);
Route::post("/aprex/send_message",[Aprex::class,'send_message']);
Route::post("/aprex/send_message2",[Aprex::class,'send_message2']);

Route::post("/aprex/save_notes",[Aprex::class,'save_notes']);
Route::get("/aprex/default_live_stream/{id}/{tab}",[Aprex::class,'default_live_stream']);
Route::get("/aprex/default_live_stream/{id}/{tab}/{vedio}",[Aprex::class,'default_live_stream']);

Route::get("/aprex/single_course_test/{id}/{tab}",[Aprex::class,'single_course_test']);

Route::get("/aprex/qna",[Aprex::class,'qna_view']);
Route::post("/aprex/qna",[Aprex::class,'qna']);

Route::get("/aprex/jobs",[Aprex::class,'jobs']);
Route::post("/aprex/apply_job",[Aprex::class,'apply_job']);

Route::get("/aprex/internships",[Aprex::class,'internships']);
Route::post("/aprex/apply_internship",[Aprex::class,'apply_internship']);

Route::get("/aprex/code",[Aprex::class,'code']);
Route::get("/aprex/project",[Aprex::class,'project']);
Route::get("/aprex/prog/{prog}",[Aprex::class,'prog']);

Route::get("/aprex/sitemap",[Aprex::class,'sitemap']);

Route::post("/aprex/start_course",[Aprex::class,'start_course']);

Route::get("/aprex/all_courses",[Aprex::class,'all_courses']);

Route::get("/aprex/take_assesment/{course}/{section}/{video}",[Aprex::class,'take_assesment']);

Route::post("/aprex/assesment_submit/{course}/{section}/{video}",[Aprex::class,'assesment_submit']);
Route::get("/aprex/take_test/{course_id}/{id}",[Aprex::class,'take_test']);
Route::post("/aprex/test_submit/{id}",[Aprex::class,'test_submit']);
Route::get("/aprex/view_test_score/{id}/{course_id}",[Aprex::class,'view_test_score']);
Route::get("/aprex/start_project/{id}",[Aprex::class,'start_project']);
Route::get("/aprex/start_internship/{id}",[Aprex::class,'start_internship']);

Route::get("/aprex/lab/{subject}/{id}",[Aprex::class,'lab']);
Route::get("/aprex/ebook/{id}",[Aprex::class,'ebook']);
Route::get("/aprex/assesment_result/{id}",[Aprex::class,'assesment_result']);

Route::get("/aprex/about",[Aprex::class,'about']);
Route::get("/aprex/account_information",[Aprex::class,'account_information']);
Route::get("/aprex/author_profile",[Aprex::class,'author_profile']);
Route::get("/aprex/blog_sidebar",[Aprex::class,'blog_sidebar']);
Route::get("/aprex/blog_single",[Aprex::class,'blog_single']);
Route::get("/aprex/blog",[Aprex::class,'blog']);
Route::get("/aprex/cart",[Aprex::class,'cart']);
Route::get("/aprex/checkout",[Aprex::class,'checkout']);
Route::get("/aprex/coming_soon",[Aprex::class,'coming_soon']);
Route::get("/aprex/contact_information",[Aprex::class,'contact_information']);

Route::get("/aprex/contact_two",[Aprex::class,'contact_two']);
Route::get("/aprex/contact",[Aprex::class,'contact']);
Route::get("/aprex/course_details_2",[Aprex::class,'course_details_2']);
Route::get("/aprex/course_details",[Aprex::class,'course_details']);
Route::get("/aprex/courses_grid_1",[Aprex::class,'courses_grid_1']);
Route::get("/aprex/courses_grid_2",[Aprex::class,'courses_grid_2']);
Route::get("/aprex/courses_grid_3",[Aprex::class,'courses_grid_3']);

Route::get("/aprex/default_analytics",[Aprex::class,'default_analytics']);
Route::get("/aprex/default_author_profile",[Aprex::class,'default_author_profile']);
Route::get("/aprex/default_categories",[Aprex::class,'default_categories']);

Route::get("/aprex/default_channel",[Aprex::class,'default_channel']);
Route::get("/aprex/default_course_details_2",[Aprex::class,'default_course_details_2']);


Route::get("/aprex/default_follower",[Aprex::class,'default_follower']);

Route::get("/aprex/default_search",[Aprex::class,'default_search']);
Route::get("/aprex/default_settings",[Aprex::class,'default_settings']);
Route::get("/aprex/default_test",[Aprex::class,'default_test']);
Route::get("/aprex/default_user_profile",[Aprex::class,'default_user_profile']);
Route::get("/aprex/default",[Aprex::class,'default']);

Route::get("/aprex/email_box",[Aprex::class,'email_box']);
Route::get("/aprex/forgot",[Aprex::class,'forgot']);
Route::get("/aprex/home_1",[Aprex::class,'home_1']);
Route::get("/aprex/home_2",[Aprex::class,'home_2']);
Route::get("/aprex/home_3",[Aprex::class,'home_3']);
Route::get("/aprex/home_4",[Aprex::class,'home_4']);
Route::get("/aprex/home_5",[Aprex::class,'home_5']);
Route::get("/aprex/home_6",[Aprex::class,'home_6']);



Route::get("/aprex/password",[Aprex::class,'password']);
Route::get("/aprex/payment",[Aprex::class,'payment']);
Route::get("/aprex/popup_chat",[Aprex::class,'popup_chat']);
Route::get("/aprex/price",[Aprex::class,'price']);



Route::get("/aprex/service",[Aprex::class,'service']);
Route::get("/aprex/shop_1",[Aprex::class,'shop_1']);
Route::get("/aprex/shop_2",[Aprex::class,'shop_2']);
Route::get("/aprex/shop_3",[Aprex::class,'shop_3']);
Route::get("/aprex/single_product_2",[Aprex::class,'single_product_2']);
Route::get("/aprex/single_product_3",[Aprex::class,'single_product_3']);
Route::get("/aprex/single_product",[Aprex::class,'single_product']);
Route::get("/aprex/social",[Aprex::class,'social']);
Route::get("/aprex/todo",[Aprex::class,'todo']);
Route::get("/aprex/user_profile",[Aprex::class,'user_profile']);

Route::get("/aprex/search_questions",[Aprex::class,'search_questions']);
Route::get("/aprex/qna_single/{id}",[Aprex::class,'qna_single']);
// =================================

// ===================================== som ==============================================
Route::get("/createStudentSubscription",[Abc::class,'createStudentSubscription']);
Route::get("/admin/subscriptions",[Abc::class,'subscriptions']);
Route::get("/forums",[Abc::class,'forums']);
Route::get("/add_forum",[Abc::class,'add_forum']);
Route::post("/create_forum",[Abc::class,'create_forum']);
Route::get("/view_forum/{question_id}",[Abc::class,'view_forum']);
Route::get("/answer_forum/{question_id}",[Abc::class,'answer_forum']);
Route::post("/create_forum_answer",[Abc::class,'create_forum_answer']);
Route::post("/create_student_refferal",[Abc::class,'create_student_refferal']);
Route::get("/view_certificate/{course_id}/{test_id}",[Abc::class,'view_certificate']);


Route::get("/aprex/createStudentSubscription",[Aprex::class,'createStudentSubscription']);
Route::get("/aprex/admin/subscriptions",[Aprex::class,'subscriptions']);
Route::get("/aprex/forums",[Aprex::class,'forums']);
Route::get("/aprex/add_forum",[Aprex::class,'add_forum']);
Route::post("/aprex/create_forum",[Aprex::class,'create_forum']);
Route::get("/aprex/view_forum/{question_id}",[Aprex::class,'view_forum']);
Route::get("/aprex/answer_forum/{question_id}",[Aprex::class,'answer_forum']);
Route::post("/aprex/create_forum_answer",[Aprex::class,'create_forum_answer']);
Route::post("/aprex/create_student_refferal",[Aprex::class,'create_student_refferal']);
Route::get("/aprex/view_certificate/{course_id}/{test_id}",[Aprex::class,'view_certificate']);

Route::get("/aprex/change_password",[Aprex::class,'change_password_view']);
Route::post("/aprex/change_password",[Aprex::class,'change_password']);

// ============testing =================
Route::get("/trail",[Aprex::class,'trail']);
Route::get("/search",[Aprex::class,'search']);
// ==========

Route::get("/admin/trainers",[Admin::class,'trainers']);
Route::get("/admin/lab/{lab_id}",[Admin::class,'lab']);


// ======================== video features  ====================================

Route::get("/markers",[Abc::class,'markers']);
Route::get("/markers_single/{id}",[Abc::class,'markers_single']);

Route::get("/markers_last",[Abc::class,'markers_last']);


Route::post("/save_markers",[Abc::class,'save_markers']);

Route::get("/video_with_watermark",[Abc::class,'video_with_watermark']);

Route::get("/video_features",[Abc::class,'video_features']);


Route::get("/video_play_back_all",[Abc::class,'video_play_back_all']);
Route::get("/video_play_back/{id}",[Abc::class,'video_play_back']);
Route::post("/save_video_timestamp",[Abc::class,'save_video_timestamp']);
Route::get("/retrieve_last_video_played/{course_id}",[Abc::class,'retrieve_last_video_played']);
Route::post("/update_video_status",[Abc::class,'update_video_status']);


Route::get("/video_start_end",[Abc::class,'video_start_end']);



// ===================video encryption===========================

Route::get("/video_encryption",[Abc::class,'video_encryption']);

Route::get("/video_encryption_1/{unique_video_name}",[Abc::class,'video_encryption_1']);



Route::get('/video/key/{key}', function ($key) {
    // return Storage::disk('secrets')->download($key);


    $keyRecord = Video_hls_secret::where('file_name', $key)->first();
    if ($keyRecord) {
        // Return the key content with appropriate headers
        return response()->stream(function () use ($keyRecord) {
            echo $keyRecord->contents;
        }, 200, [
            'Content-Type' => 'application/vnd.apple.keynote',
            'Content-Disposition' => 'attachment; filename="' . $key . '"',
        ]);
    }

    // Handle cases where the key does not exist in the database
    abort(404);


   })->name('video.key');

Route::get('/video/playlist/{playlist}', function ($playlist) {
    // $user = User::where('id', '=', $playlist)->first();
    if(session('rexkod_user_id')){
        return FFMpeg::dynamicHLSPlaylist()
        ->fromDisk('public')
        ->open("videos/{$playlist}")
        ->setKeyUrlResolver(function ($key) {
        return route('video.key', ['key' => $key]);
        })
        ->setMediaUrlResolver(function ($mediaFilename) {
        return Storage::disk('public')->url("videos/{$mediaFilename}");
        })
        ->setPlaylistUrlResolver(function ($playlist) {
        return route('video.playlist', ['playlist' => $playlist]);
        });
    }else{
        return redirect('/');
    }

   })->name('video.playlist');



//    Route::get("/upload_video_file",[Abc::class,'get_video_playlist'])->name('video.playlist');

   Route::get("/upload_video_file",[Abc::class,'upload_video_file_view']);
   Route::post("/upload_video_file/{tab}",[Abc::class,'upload_video_file']);



// ======ebook========
Route::get("/admin/all_ebooks",[Admin::class,'all_ebooks']);
Route::get("/admin/create_ebook",[Admin::class,'create_ebook_view']);
Route::post("/admin/create_ebook",[Admin::class,'create_ebook']);
Route::get("/admin/view_modules/{ebook_id}",[Admin::class,'view_modules']);
Route::get("/admin/add_section/{module_id}",[Admin::class,'add_section_view']);
Route::post("/admin/add_section/{module_id}",[Admin::class,'add_section']);
Route::get("/admin/add_elements/{section_id}",[Admin::class,'add_elements_view']);
Route::post("/admin/add_elements/{section_id}",[Admin::class,'add_elements']);
Route::get("/admin/preview_ebook/{ebook_id}",[Admin::class,'preview_ebook']);


//    ========================== project_reports ======================

Route::get("/admin/project_reports",[Admin::class,'project_reports']);
Route::get("/admin/create_project_reports",[Admin::class,'create_project_reports_view']);
Route::post("/admin/create_project_report",[Admin::class,'create_project_report']);
Route::get("/admin/project_report_modules/{project_report_id}",[Admin::class,'project_report_modules']);
Route::get("/admin/preview_project_report/{project_report_id}",[Admin::class,'preview_project_report']);
Route::get("/admin/add_project_report_elements/{project_report_id}",[Admin::class,'add_project_report_elements_view']);
Route::post("/admin/add_project_report_elements/{project_report_id}",[Admin::class,'add_project_report_elements']);


//    ========================== use_cases ======================

Route::get("/admin/use_cases",[Admin::class,'use_cases']);
Route::get("/admin/create_use_case",[Admin::class,'create_use_case_view']);
Route::post("/admin/create_use_case",[Admin::class,'create_use_case']);
Route::get("/admin/use_case_modules/{use_case_id}",[Admin::class,'use_case_modules']);
Route::get("/admin/preview_use_case/{use_case_id}",[Admin::class,'preview_use_case']);
Route::get("/admin/add_use_case_elements/{use_case_id}",[Admin::class,'add_use_case_elements_view']);
Route::post("/admin/add_use_case_elements/{use_case_id}",[Admin::class,'add_use_case_elements']);



//    ========================== school students ======================

Route::post("/connect_parent",[Abc::class,'connect_parent']);
Route::get("/all_subjects",[Abc::class,'all_subjects']);
Route::get("/subject_live_stream/{subject_id}/{tab_id}",[Abc::class,'subject_live_stream']);
Route::post("/save_video_timestamp_school",[Abc::class,'save_video_timestamp_school']);
// Route::get("/retrieve_last_video_played/{course_id}",[Abc::class,'retrieve_last_video_played']);
Route::post("/update_video_status_school",[Abc::class,'update_video_status_school']);
Route::get("/take_assesment_school/{course}/{section}/{video}",[Abc::class,'take_assesment_school']);
Route::post("/assesment_submit_school/{course}/{section}/{video}",[Abc::class,'assesment_submit_school']);

Route::get("/assesment_result_school/{id}",[Abc::class,'assesment_result_school']);
Route::get("/take_school_test/{subject_id}/{id}",[Abc::class,'take_school_test']);
Route::post("/school_test_submit/{id}",[Abc::class,'school_test_submit']);
Route::get("/view_school_test_score/{id}/{subject_id}",[Abc::class,'view_school_test_score']);
Route::get("/view_subject_certificate/{subject_id}/{test_id}",[Abc::class,'view_subject_certificate']);
Route::get("/view_school_project/{id}",[Abc::class,'view_school_project']);

Route::get("/start_school_project/{id}/{lab}",[Abc::class,'start_school_project']);
Route::get("/update_school_project_task_status/{id}",[Abc::class,'update_school_project_task_status']);
Route::get("/continue_school_project_task/{id}/{lab}",[Abc::class,'continue_school_project_task']);
Route::post("/save_school_notes",[Abc::class,'save_school_notes']);

Route::get("/school_qna",[Abc::class,'school_qna_view']);
Route::post("/school_qna",[Abc::class,'school_qna']);

Route::get("/search_school_questions",[Abc::class,'search_school_questions']);
Route::get("/school_qna_single/{id}",[Abc::class,'school_qna_single']);
Route::post("/school_send_message",[Abc::class,'school_send_message']);

Route::get("/school_forums",[Abc::class,'school_forums']);
Route::post("/school_create_forum",[Abc::class,'school_create_forum']);
Route::get("/school_search_forum_questions",[Abc::class,'school_search_forum_questions']);
Route::get("/view_forum/{question_id}",[Abc::class,'view_forum']);
Route::get("/view_school_forum/{question_id}",[Abc::class,'view_school_forum']);
Route::get("/add_school_forum",[Abc::class,'add_school_forum']);
Route::get("/answer_school_forum/{question_id}",[Abc::class,'answer_school_forum']);
Route::post("/create_school_forum_answer",[Abc::class,'create_school_forum_answer']);
Route::post("/create_school_forum",[Abc::class,'create_school_forum']);


// ===================admin---school ==================


// ===================sub admin---school ==================

Route::post("/sub_admin/add_school_elements",[Admin::class,'add_school_elements']);
Route::get("/sub_admin/add_student",[Admin::class,'add_student_view']);
Route::POST("/sub_admin/add_student",[Admin::class,'add_student']);
Route::get("/sub_admin/all_students",[Admin::class,'all_students']);
Route::get("/sub_admin/all_teachers",[Admin::class,'all_teachers']);
Route::get("/sub_admin/add_teacher",[Admin::class,'add_teacher_view']);
Route::POST("/sub_admin/add_teacher",[Admin::class,'add_teacher']);
Route::get("/admin/getSubjects/{class_id}",[Admin::class,'getSubjects']);

// ========admin--class-subject-chapter-video========
Route::get("/admin/add_chapters",[Admin::class,'add_chapters_view']);
Route::post("/admin/add_chapters",[Admin::class,'add_chapters']);
Route::get("/admin/add_chapter_videos",[Admin::class,'add_chapter_videos_view']);
Route::post("/admin/add_chapter_videos",[Admin::class,'add_chapter_videos']);
Route::get("/admin/get_chapters",[Admin::class,'get_chapters']);
Route::get("/admin/get_subjects",[Admin::class,'get_subjects']);
Route::get("/admin/get_chapter_videos",[Admin::class,'get_chapter_videos']);
Route::get("/admin/school_courses",[Admin::class,'school_courses']);
Route::get("/admin/add_school_subject",[Admin::class,'add_school_subject_view']);
Route::post("/admin/add_school_subject",[Admin::class,'add_school_subject']);
Route::get("/admin/schools",[Admin::class,'schools']);
Route::get("/admin/add_school",[Admin::class,'add_school_view']);
Route::get("/admin/school_assesments",[Admin::class,'school_assesments']);
Route::get("/admin/create_school_assesments",[Admin::class,'create_school_assesments_view']);
Route::post("/admin/create_school_assesments",[Admin::class,'create_school_assesments']);
Route::get("/admin/view_school_assesments/{id}",[Admin::class,'view_school_assesments']);
Route::get("/admin/school_tests",[Admin::class,'school_tests']);
Route::get("/admin/add_school_questions",[Admin::class,'add_school_questions_view']);
Route::post("/admin/add_school_questions",[Admin::class,'add_school_questions']);
Route::get("/admin/create_school_test",[Admin::class,'create_school_test_view']);
Route::post("/admin/create_school_test",[Admin::class,'create_school_test']);
Route::get("/admin/add_questions_to_test_view/{test_id}",[Admin::class,'add_questions_to_test_view']);
Route::get("/admin/add_questions_to_test/{test_id}/{que_id}",[Admin::class,'add_questions_to_test']);
Route::get("/admin/delete_question_from_test/{test_id}/{que_id}",[Admin::class,'delete_question_from_test']);
Route::get("/admin/school_test_results/{id}",[Admin::class,'school_test_results']);
Route::get("/admin/school_test_details/{id}",[Admin::class,'school_test_details']);
Route::get("/admin/school_test_master",[Admin::class,'school_test_master']);

Route::get("/admin/create_school_projects",[Admin::class,'create_school_projects_view']);
Route::post("/admin/create_school_projects",[Admin::class,'create_school_projects']);
Route::get("/admin/school_mini_projects",[Admin::class,'school_mini_projects']);
Route::get("/admin/create_school_project_task",[Admin::class,'create_school_project_task_view']);
Route::post("/admin/create_school_project_task",[Admin::class,'create_school_project_task']);


// =====================parent========================
Route::get("/parents/index",[Parents::class,'index']);
Route::get("/parents/change_password",[Parents::class,'change_password_view']);
Route::get("/parents/student_enrolled_courses/{student_id}",[Parents::class,'student_enrolled_courses']);
Route::get("/parent/test_results/{course_id}/{student_id}",[Parents::class,'test_results']);
Route::get("/parents/assessments/{student_id}",[Parents::class,'assessments']);
Route::get("/parents/tests/{student_id}",[Parents::class,'tests']);



