<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\Quiz_master;
use App\Models\Quiz_result;
use App\Models\Student;
use App\Models\Message;
use App\Models\Qna;
use App\Models\Job_detail;
use App\Models\Job_application;
use App\Models\Internship;
use App\Models\Internship_application;
use App\Models\Note;
use App\Models\Enrolled_course;
use App\Models\Assesment;
use App\Models\Section;
use App\Models\Assesment_result;
use App\Models\Mini_project;
use App\Models\Video;
use App\Models\Subscription;
use App\Models\Forum_question;
use App\Models\Forum_answer;
use App\Models\Student_referral;
use App\Models\Internship_task;
use App\Models\Internship_process;
use App\Models\Lab;
use App\Models\Project_task;
use App\Models\Project_process;

use App\Models\Marker;
use App\Models\Video_hls_secret;
use App\Models\Video_play_back;
use App\Models\School_subject;
use App\Models\Chapter_video;
use App\Models\Chapter;
use App\Models\School_assesment;
use App\Models\School_note;
use App\Models\School_video_play_back;
use App\Models\School_assesment_result;
use App\Models\School_test;
use App\Models\School_test_master;
use App\Models\School_student;
use App\Models\School_test_result;
use App\Models\School_mini_project;
use App\Models\School_project_task;
use App\Models\School_project_process;
use App\Models\School_qna;
use App\Models\Teacher;
use App\Models\School_message;
use App\Models\School_forum_question;
use App\Models\School_forum_answer;


use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

class Abc extends Controller
{
    public function about()
    {

        return view('users/about');
    }

    public function index()
    {

        // $course=new Course;
        $result = Course::get();
        // dd($result);
        $enrolled_course = DB::table('course')
            ->join('enrolled_courses', 'course.id', '=', 'enrolled_courses.course_id')
            ->select('course.*', 'enrolled_courses.*')
            ->where('enrolled_courses.student_id', session('rexkod_user_id'))
            ->get();

        // $my_course = Course::where
        // dd($enrolled_course);

        $data = [
            'courses' => $result,
            'enrolled_course' => $enrolled_course,
           ];

        //    dd($data['courses']->course_name);
        return view('users/index', ['data' => $data]);
        // return view('users/index');
    }


    public function user_register(Request $req)
    {

        $auth = new User();

        $result = User::where('email', $req->email)->first();
        if($result) {
            return 'Email already exists';
        } else {

            if($req->has('is_parent')) {
                $auth->name = $req->name;
                $auth->phone = $req->phone;
                $auth->email = $req->email;
                $auth->type = 'parent';
                $auth->password = Hash::make($req->password);

                $length = 6;
                $min = pow(10, $length - 1);
                $max = pow(10, $length) - 1;
                $rand_number = mt_rand($min, $max);
                $auth->parent_code = $rand_number;

                $auth->save();
                $user = User::where('email', $req->email)->first();

                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);

                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);

                return redirect('/parents/index');
            } else {


                $auth->name = $req->name;
                $auth->phone = $req->phone;
                $auth->email = $req->email;
                $auth->type = 'student';
                $auth->password = Hash::make($req->password);

                $auth->save();
                $user = User::where('email', $req->email)->first();

                $student = new Student();
                $student->student_id = $user->id;
                $student->f_name = $req->name;
                $student->phone_no = $req->phone;
                $student->email = $req->email;
                $student->save();


                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_type', $user->type);
                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);

                return redirect('/index');
            }




            // return redirect('/index');
        }

    }


    public function user_login(Request $req)
    {
        if(is_numeric($req->email)) {
            $user = User::where('id', $req->email)->first();
            if($user && $user->type == 'school_student' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_name', $user->name);
                // Session::put('rexkod_user_email', $user->email);
                // Session::put('rexkod_user_phone', $user->phone);
                Session::put('rexkod_user_type', $user->type);

                return redirect('/index');
            } else {
                session()->put('failed', 'Invalid Credentials');
                return redirect('/login');
            }
        } else {


            $user = User::where('email', $req->email)->first();

            if($user && $user->type == 'admin' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('admin', $user);
                Session::put('rexkod_admin_id', $user->id);
                Session::put('rexkod_admin_name', $user->name);
                Session::put('rexkod_admin_email', $user->email);
                Session::put('rexkod_admin_phone', $user->phone);
                Session::put('rexkod_admin_type', $user->type);


                return redirect('/admin/index');


            } elseif($user && $user->type == 'recruiter' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('recruiter', $user);
                Session::put('rexkod_recruiter_id', $user->id);

                Session::put('rexkod_recruiter_name', $user->name);
                // dd(session('rexkod_user_name'));

                return redirect('/recruiter/index');


            } elseif($user && $user->type == 'trainer' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('trainer', $user);
                Session::put('rexkod_trainer_id', $user->id);
                Session::put('rexkod_trainer_name', $user->name);
                Session::put('rexkod_trainer_type', $user->type);

                // dd(session('rexkod_user_name'));

                return redirect('/trainer/index');


            } elseif($user && $user->type == 'student' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);
                Session::put('rexkod_user_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/index');


            } elseif($user && $user->type == 'parent' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);
                Session::put('rexkod_user_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/parents/index');


            } elseif($user && $user->type == 'sub_admin' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_admin_id', $user->id);
                Session::put('rexkod_admin_name', $user->name);
                Session::put('rexkod_admin_email', $user->email);
                Session::put('rexkod_admin_phone', $user->phone);
                Session::put('rexkod_admin_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/admin/index');


            } elseif($user && $user->type == 'teacher' && Hash::check($req->password, $user->password)) {
                // dd($user->type);
                $date = date('Y-m-d H:i:s');
                $req->session()->put('trainer', $user);
                Session::put('rexkod_trainer_id', $user->id);
                Session::put('rexkod_trainer_name', $user->name);
                Session::put('rexkod_trainer_type', $user->type);
                // dd(session('rexkod_user_name'));
                return redirect('/trainer/index');


            } else {
                session()->put('failed', 'Invalid Credentials');
                return redirect('/login');
            }
        }

    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

    public function default_course_details($id)
    {

        $course = Course::where("id", $id)->first();
        $trainer = User::where("id", $course->course_tutor)->first();
        $sections = Section::where("course_id", $id)->get();
        $data = [
            'courses' => $course,
            'sections' => $sections,
            'trainer' => $trainer,
           ];

        return view('users.default_course_details', ['data' => $data]);
    }



    public function account_information()
    {

        return view('users/account_information');
    }
    public function author_profile()
    {

        return view('users/author_profile');
    }

    public function blog_sidebar()
    {

        return view('users/blog_sidebar');
    }
    public function blog_single()
    {

        return view('users/blog_single');
    }
    public function blog()
    {

        return view('users/blog');
    }
    public function cart()
    {

        return view('users/cart');
    }
    public function checkout()
    {

        return view('users/checkout');
    }
    public function coming_soon()
    {

        return view('users/coming_soon');
    }
    public function contact_information()
    {

        return view('users/contact_information');
    }
    public function contact_two()
    {

        return view('users/contact_two');
    }
    public function contact()
    {

        return view('users/contact');
    }
    public function course_details_2()
    {

        return view('users/course_details_2');
    }

    public function course_details()
    {

        return view('users/course_details');
    }
    public function courses_grid_1()
    {

        return view('users/courses_grid_1');
    }
    public function courses_grid_2()
    {

        return view('users/courses_grid_2');
    }
    public function courses_grid_3()
    {

        return view('users/courses_grid_3');
    }
    public function default_analytics()
    {

        return view('users/default_analytics');
    }
    public function default_author_profile()
    {

        return view('users/default_author_profile');
    }
    public function default_categories()
    {

        return view('users/default_categories');
    }
    public function default_channel()
    {

        return view('users/default_channel');
    }
    public function default_course_details_2()
    {

        return view('users/default_course_details_2');
    }


    public function default_follower()
    {

        return view('users/default_follower');
    }

    public function default_search()
    {

        return view('users/default_search');
    }

    public function default_test()
    {

        return view('users/default_test');
    }

    public function default()
    {

        return view('users/default');
    }
    public function email_box()
    {

        return view('users/email_box');
    }
    public function forgot()
    {

        return view('users/forgot');
    }
    public function home_1()
    {

        return view('users/home_1');
    }

    public function home_2()
    {

        return view('users/home_2');
    }
    public function home_3()
    {

        return view('users/home_3');
    }
    public function home_4()
    {

        return view('users/home_4');
    }
    public function home_5()
    {

        return view('users/home_5');
    }
    public function home_6()
    {

        return view('users/home_6');
    }


    public function password()
    {

        return view('users/password');
    }

    public function popup_chat()
    {

        return view('users/popup_chat');
    }
    public function price()
    {

        return view('users/price');
    }

    public function service()
    {

        return view('users/service');
    }
    public function shop_1()
    {

        return view('users/shop_1');
    }

    public function shop_2()
    {

        return view('users/shop_2');
    }
    public function shop_3()
    {

        return view('users/shop_3');
    }
    public function single_product_2()
    {

        return view('users/single_product_2');
    }
    public function single_product_3()
    {

        return view('users/single_product_3');
    }
    public function single_product()
    {

        return view('users/single_product');
    }
    public function social()
    {

        return view('users/social');
    }
    public function todo()
    {

        return view('users/todo');
    }
    public function user_profile()
    {

        return view('users/user_profile');
    }




    public function course_quizes()
    {
        $all_quiz = Quiz::where('created_by', 'admin')->get();
        $data = [
            'all_quiz' => $all_quiz,
           ];
        return view('users/course_quizes', ['data' => $data]);
    }

    public function recruiter_quizes()
    {
        $all_quiz = Quiz::where('created_by', 'recruiter')->get();
        $data = [
            'all_quiz' => $all_quiz,
           ];
        return view('users/recruiter_quizes', ['data' => $data]);
    }


    public function all_quiz()
    {
        // dd(session('rexkod_user_name'));

        $all_quiz = Quiz::get();
        // $subject_id=$all_quiz;
        $data = [
            'all_quiz' => $all_quiz,
           ];
        return view('users/all_quiz', ['data' => $data]);
    }

    public function take_quiz($id)
    {
        $all_quiz = Quiz::where('id', $id)->first();
        // $subject_id=$all_quiz;
        $data = [
            'all_quiz' => $all_quiz,
           ];
        return view('users/take_quiz', ['data' => $data]);
        // return view('users/take_quiz');
    }

    public function quiz_submit(Request $req, $id)
    {
        $result = new Quiz_result();


        $quiz = Quiz::where('id', $id)->first();
        // dd($quiz->questions);
        $all_questions = explode(',', $quiz->questions);
        $count = 1;
        // dd($all_questions);
        // $answer_selected[] = null;
        foreach ($all_questions as $question) {
            $answer_selected[] = $req->{'que_' . $count . '_selected'};
            $count++;
        }
        $new_answer = implode(',', $answer_selected);
        // dd($new_answer);
        $count2 = 1;
        $score = 0;
        foreach ($all_questions as $question) {
            $quiz_master = Quiz_master::where('id', $question)->first();
            $quiz_answer = $quiz_master->answer;
            if($quiz_answer == $req->{'que_' . $count2 . '_selected'}) {
                $score++;
                $count2++;
            }
        }
        $questionsArray = explode(",", $quiz->questions);
        $totalQuestions = count($questionsArray);

        if ($score != 0) {
            $score_percentage = ($score / $totalQuestions) * 100;
        } else {
            $score_percentage = 0;
        }
        // dd($score);
        $result->user_answer =	$new_answer;
        $result->quiz_id = $id;
        $result->questions = $quiz->questions;
        $result->score = $score;
        $result->score_percentage = $score_percentage;
        $result->user_id = session('rexkod_user_id');
        $result->save();
        // return redirect("all_quiz");
        // dd($answer_selected);
        if($result->save()) {
            session()->put('success', "Your Quiz submitted successfully");
            return redirect('view_score/' . $id);
        } else {
            session()->put('failed', 'Your Quiz not submitted, Try again!');
            return redirect()->back();
        }
        // return redirect('view_score/'.$id);
    }

    public function view_score($id)
    {

        $result = Quiz_result::where('quiz_id', $id)
                            ->where('user_id', session('rexkod_user_id'))
                            ->latest()->first();
        // dd($result);
        $data = [
            'result' => $result,
           ];

        return view('users/view_score', ['data' => $data]);
    }
    public function all_results()
    {
        $result = Quiz_result::where('user_id', session('rexkod_user_id'))->get();
        $data = [
            'result' => $result,
           ];

        return view('users/all_results', ['data' => $data]);
    }
    public function add_profile_view()
    {

        return view('users/add_profile');
    }

    public function add_profile(Request $req)
    {
        $student = new Student();

        $student2 = Student::where('student_id', session('rexkod_user_id'))->first();
        // dd($student2);
        if(isset($req->personal_submit)) {

            if (isset($req->same_as_phone)) {
                $same_as_phone = 1;
            } else {
                $same_as_phone = 0;
            }
            // files
            // if (!empty($req->file('student_image'))) {
            //     $extension1 = $req->file('student_image')->extension();

            //         $filename = Str::random(4) . time() . '.' . $extension1;
            //         $student_image = $req->file('student_image')->move(('uploads'), $filename);

            // }else if($student2->student_image){
            //     $student_image=$student2->student_image;
            // } else {
            //     $student_image = 'student_image';
            // }
            // // dd($student_image);
            // $student->student_image= $student_image;


            if (!empty($req->file('address_proof'))) {
                $extension1 = $req->file('address_proof')->extension();

                $filename = Str::random(4) . time() . '.' . $extension1;
                $address_proof = $req->file('address_proof')->move(('uploads'), $filename);

            } elseif($student2->address_proof) {
                $address_proof = $student2->address_proof;
            } else {
                $address_proof = 'address_proof';
            }
            $student->address_proof = $address_proof;
            if (!empty($req->file('identity_proof'))) {
                $extension1 = $req->file('identity_proof')->extension();

                $filename = Str::random(4) . time() . '.' . $extension1;
                $identity_proof = $req->file('identity_proof')->move(('uploads'), $filename);

            } elseif($student2->identity_proof) {
                $identity_proof = $student2->identity_proof;
            } else {
                $identity_proof = 'identity_proof';
            }
            // dd($req->whatsapp_no);
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['f_name' => $req->f_name,
                            'l_name' => $req->l_name,
                            'phone_no' => $req->phone_no,
                            'whatsapp_no' => $req->whatsapp_no,
                            'same_as_phone' => $same_as_phone,
                            'dob' => $req->dob,
                            'gender' => $req->gender,
                            'religion' => $req->religion,
                            'category' => $req->category,
                            'physically' => $req->physically,
                            'aadhar' => $req->aadhar,
                            'address_proof' => $address_proof ,
                            'identity_proof' => $identity_proof ,
                ]);
        } elseif ($req->academic_submit) {

            // dd(implode(',',$req->academic_name));
            $academic_name = implode(',', $req->academic_name);
            $class = implode(',', $req->class);
            $cgpa = implode(',', $req->cgpa);
            $start_date = implode(',', $req->start_date);
            $end_date = implode(',', $req->end_date);
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['academic_name' => $academic_name,
                    'class' => $class,
                    'cgpa' => $cgpa,
                    'start_date' => $start_date,
                    'end_date' => $end_date,


                ]);
        } elseif ($req->family_submit) {
            # code...
            if (!empty($req->file('father_aadhar_doc'))) {
                $extension1 = $req->file('father_aadhar_doc')->extension();

                $filename = Str::random(4) . time() . '.' . $extension1;
                $father_aadhar_doc = $req->file('father_aadhar_doc')->move(('uploads'), $filename);

            } elseif($student2->father_aadhar_doc) {
                $father_aadhar_doc = $student2->father_aadhar_doc;
            } else {
                $father_aadhar_doc = 'father_aadhar_doc';
            }

            if (!empty($req->file('mother_aadhar_doc'))) {
                $extension1 = $req->file('mother_aadhar_doc')->extension();

                $filename = Str::random(4) . time() . '.' . $extension1;
                $mother_aadhar_doc = $req->file('mother_aadhar_doc')->move(('uploads'), $filename);

            } elseif($student2->mother_aadhar_doc) {
                $mother_aadhar_doc = $student2->mother_aadhar_doc;
            } else {
                $mother_aadhar_doc = 'mother_aadhar_doc';
            }
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['siblings' => $req->siblings,
                    'annual_income' => $req->annual_income,

                    'father_name' => $req->father_name,
                    'f_aadhar' => $req->f_aadhar,
                    'f_phone' => $req->f_phone,
                    'f_email_id' => $req->f_email_id,
                    'father_aadhar_doc' => $father_aadhar_doc,

                    'mother_name' => $req->mother_name,
                    'm_aadhar' => $req->m_aadhar,
                    'm_phone' => $req->m_phone,
                    'm_email_id' => $req->m_email_id,
                    'mother_aadhar_doc' => $mother_aadhar_doc,
                    'f_email_id' => $req->f_email_id,

            ]);
        } elseif ($req->address_submit) {
            # code...
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['comm_address' => $req->comm_address,
                    'comm_pin_code' => $req->comm_pin_code,

                    'comm_village' => $req->comm_village,
                    'comm_block' => $req->comm_block,
                    'comm_state' => $req->comm_state,
                    'same_as_comm_address' => $req->same_as_comm_address,

                    'perm_address' => $req->perm_address,
                    'perm_village' => $req->perm_village,
                    'perm_block' => $req->perm_block,
                    'perm_state' => $req->perm_state,
                    'perm_pin_code' => $req->perm_pin_code,
            ]);
        } elseif ($req->bank_submit) {
            # code...
            if (!empty($req->file('passbook_statement'))) {
                $extension1 = $req->file('passbook_statement')->extension();

                $filename = Str::random(4) . time() . '.' . $extension1;
                $passbook_statement = $req->file('passbook_statement')->move(('uploads'), $filename);

            } elseif($student2->passbook_statement) {
                $passbook_statement = $student2->passbook_statement;
            } else {
                $passbook_statement = 'passbook_statement';
            }
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['account_no' => $req->account_no,
                    're_account_no' => $req->re_account_no,

                    'ifsc_code' => $req->ifsc_code,
                    'bank_name' => $req->bank_name,
                    'bank_branch' => $req->bank_branch,
                    'name_as_per_bank' => $req->name_as_per_bank,
                    'passbook_statement' => $passbook_statement,
            ]);
        } elseif ($req->bank_submit) {
            # code...
            Student::where('student_id', session('rexkod_user_id'))
                    ->update(['hobby' => $req->hobby,
                    'achievements' => $req->achievements,

                    'description' => $req->description,
                    'mother_tongue' => $req->mother_tongue,
            ]);
        }

        // $student->student_id= session('rexkod_user_id');
        // $student->f_name= $req->f_name;
        // $student->l_name= $req->l_name;
        // // $student->email= $req->email;
        // $student->phone_no= $req->phone_no;
        // $student->whatsapp_no= $req->whatsapp_no;
        // if (isset($req->same_as_phone)) {
        //     $same_as_phone = 1;
        // } else {
        //     $same_as_phone = 0;
        // }
        // $student->same_as_phone= $same_as_phone;
        // $student->dob= $req->dob;
        // $student->gender= $req->gender;
        // $student->religion= $req->religion;
        // $student->category= $req->category;
        // $student->f_name= $req->physically;
        // $student->f_name= $req->aadhar;

        // // files
        // if (!empty($req->file('address_proof'))) {
        //     $extension1 = $req->file('address_proof')->extension();

        //         $filename = Str::random(4) . time() . '.' . $extension1;
        //         $address_proof = $req->file('address_proof')->move(('uploads'), $filename);

        // } else {
        //     $address_proof = 'address_proof';
        // }
        // $student->address_proof= $address_proof;
        // if (!empty($req->file('identity_proof'))) {
        //     $extension1 = $req->file('identity_proof')->extension();

        //         $filename = Str::random(4) . time() . '.' . $extension1;
        //         $identity_proof = $req->file('identity_proof')->move(('uploads'), $filename);

        // } else {
        //     $identity_proof = 'identity_proof';
        // }
        // $student->identity_proof= $identity_proof;

        // $student->save();

        // $result=Student::where('student_id',session('rexkod_user_id'))->first();

        // $data = [
        //     'result' => $result,
        //    ];

        //    dd($data['result']->l_name);
        return view('users/add_profile');
    }


    // -----------chat----------
    public function message($trainer_id)
    {

        // dd("hgh");
        $trainers = User::where('type', 'trainer')->get();

        $sent_messages = Message::where('sender_id', Session::get('rexkod_user_id'))->where('receiver_id', $trainer_id)->get();
        $received_messages = Message::where('sender_id', $trainer_id)->where('receiver_id', Session::get('rexkod_user_id'))->get();

        $data = [
            'trainers' => $trainers,
            'trainer_id' => $trainer_id,
            'sent_messages' => $sent_messages,
            'received_messages' => $received_messages,
        ];
        return view('users/message', ['data' => $data]);
    }
    public function send_message2(Request $req)
    {
        # code...
        $qna = Qna::where('question', $req->message)->first();
        if($qna) {
            // dd($qna->answer);
            $message = new Message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $qna->question;
            $message->save();

            if($qna->answer) {
                $message = new Message();
                $message->sender_id = $qna->a_created_by;
                $message->receiver_id = Session::get('rexkod_user_id');
                $message->message = $qna->answer;
                $message->save();
            }
        } else {
            $message = new Message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $req->message;
            $message->save();
        }
        // session()->put('success', 'Message sent successfully');

        return redirect('message/' . $req->receiver_id);

    }
    public function send_message(Request $req)
    {
        # code...
        // $message = new Message();

        $qna = Qna::where('question', $req->message)->first();
        if($qna) {
            // dd($qna->answer);
            $message = new Message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $qna->question;
            $message->save();

            if($qna->answer) {
                $message = new Message();
                $message->sender_id = $qna->a_created_by;
                $message->receiver_id = Session::get('rexkod_user_id');
                $message->message = $qna->answer;
                $message->save();
            }
        } else {
            $message = new Message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $req->message;
            $message->save();
        }

        // session()->put('success', 'Message sent successfully');

        return redirect('default_live_stream/' . $req->course_id . '/2');

    }

    public function save_notes(Request $req)
    {
        # code...
        $note = new Note();

        $note->student_id = Session::get('rexkod_user_id');
        $note->course_id = $req->course_id;
        $note->note = $req->note;

        $note->save();
        // session()->put('success', 'Message sent successfully');

        return redirect('default_live_stream/' . $req->course_id . '/1');

    }
    public function default_live_stream($id, $tab_id, $video_id = null)
    {


        $course = Course::where('id', $id)->first();
        $tutor = $course->course_tutor;
        $sent_messages = Message::where('sender_id', Session::get('rexkod_user_id'))->where('receiver_id', $tutor)->get();
        $received_messages = Message::where('sender_id', $tutor)->where('receiver_id', Session::get('rexkod_user_id'))->get();
        $courses = Course::get();

        $Video_play_back = Video_play_back::where('user_id', session('rexkod_user_id'))
        ->where('course_id', $course->id)
        ->latest('updated_at')
        ->first();
        // Now, $video_play_back contains the last updated record with the specified course_id
        if($Video_play_back) {
            $video_details = Video::where('id', $Video_play_back->video_id)->first();
            $timestamp = $Video_play_back->video_time_stamp;
        } else {
            $section = Section::where('course_id', $id)->first();
            $video_details = Video::where('course_id', $id)->where('section_id', $section->id)->first();
            $timestamp = 0;
        }


        $trainer = User::where('id', $tutor)->first();
        $mini_projects = Mini_project::where('course_id', $id)->get();

        $notes = Note::where('student_id', session('rexkod_user_id'))->where('course_id', $id)->get();

        $assesments_result = Assesment_result::where('user_id', session('rexkod_user_id'))->distinct()
        ->pluck('video');
        $assesments_given = Video::whereIn('id', $assesments_result)
        ->select('id', 'video_name') // Adjust the columns you want to select
        ->get();



        // dd($assesments_given);
        $data = [
            // 'trainers' => $trainers,
            'id' => $tab_id,
            'trainer' => $trainer,
            'course' => $course,
            'sent_messages' => $sent_messages,
            'received_messages' => $received_messages,
            'notes' => $notes,
            'mini_projects' => $mini_projects,
            'video_id' => $video_id,
            'assesments_given' => $assesments_given,
        ];
        return view('users/default_live_stream', ['data' => $data,'video_details' => $video_details,'video_timestamp' => $timestamp]);
    }

    public function view_assesment_results($video_id)
    {

        $assesments_result = Assesment_result::where('user_id', session('rexkod_user_id'))
        ->where('video', $video_id)
        ->join('videos', 'videos.id', '=', 'assesment_results.video')
        ->select('assesment_results.*', 'videos.video_name')
        ->get();
        return view('users/view_assesment_results', ['assesments_result' => $assesments_result]);
    }

    public function qna_view()
    {
        # code...
        $courses = Course::get();
        $qna = Qna::where('q_created_by', Session::get('rexkod_user_id'))->get();
        $data = [
            'courses' => $courses,
            'qna' => $qna,
        ];
        // dd($qna);
        return view('users/qna', ['data' => $data]);
    }
    public function qna(Request $req)
    {
        # code...
        $qna = new Qna();

        $qna->course = $req->course;
        $qna->question = $req->question;
        $qna->q_created_by = session('rexkod_user_id');

        $qna->save();
        session()->put('success', "Question Sent");
        return redirect('qna');
    }

    public function jobs()
    {
        # code...
        $all_jobs = Job_detail::get();
        $data = [
            'all_jobs' => $all_jobs,
        ];

        return view('users/jobs', ['data' => $data]);
    }
    public function apply_job(Request $req)
    {
        # code...
        $job_application = new Job_application();
        $job_application->job_id = $req->job_id;
        $job_application->student_id = session('rexkod_user_id');
        // $job_application->save();
        if($job_application->save()) {
            session()->put('success', "Applied successfully !!");
            return redirect('jobs');

        } else {
            session()->put('failed', 'Failed, Try again!');
            return redirect()->back();
        }

        // return redirect('jobs');
    }

    public function internships()
    {
        # code...
        $all_internships = Internship::get();
        $data = [
            'all_internships' => $all_internships,
        ];

        return view('users/internships', ['data' => $data]);
    }
    public function apply_internship(Request $req)
    {
        # code...
        $internship_application = new Internship_application();
        $internship_application->internship_id = $req->internship_id;
        $internship_application->student_id = session('rexkod_user_id');
        $internship_application->save();
        session()->put('success', "Applied");
        return redirect('internships');
    }

    public function default_user_profile()
    {

        $all_internships = Internship_application::where('student_id', session('rexkod_user_id'))->get();
        $all_qna = Qna::where('q_created_by', session('rexkod_user_id'))->get();
        $quiz_result = Quiz_result::where('user_id', session('rexkod_user_id'))->get();
        $all_jobs = Job_application::where('student_id', session('rexkod_user_id'))->get();
        $student_details = Student::where('student_id', session('rexkod_user_id'))->first();
        $courses = Enrolled_course::where('student_id', session('rexkod_user_id'))->get();
        $data = [
            'all_internships' => $all_internships,
            'all_qna' => $all_qna,
            'quiz_result' => $quiz_result,
            'all_jobs' => $all_jobs,
            'student_details' => $student_details,
            'courses' => $courses,
        ];

        // die($courses);
        return view('users/default_user_profile', ['data' => $data]);
    }

    public function code()
    {
        # code...

        return view('users/code');
    }
    public function project()
    {
        # code...

        return view('users/project');
    }

    public function prog($prog)
    {
        # code...
        $data = [
            'prog' => $prog,
        ];

        return view('users/prog', ['data' => $data]);
    }

    public function sitemap()
    {
        # code...

        return view('users/sitemap');
    }
    public function start_course(Request $req)
    {
        # code...
        $course = new Enrolled_course();

        $course->student_id = session('rexkod_user_id');
        $course->course_id = $req->course_id;
        $course->save();
        return redirect('default_live_stream/' . $req->course_id . '/0');
    }

    public function all_courses()
    {
        # code...
        // $courses =Course::get();
        $enrolled_course = DB::table('course')
            ->join('enrolled_courses', 'course.id', '=', 'enrolled_courses.course_id')
            ->select('course.*', 'enrolled_courses.*')
            ->where('enrolled_courses.student_id', session('rexkod_user_id'))
            ->get();
        $data = [
            'enrolled_course' => $enrolled_course,
        ];
        return view('users/all_courses', ['data' => $data]);
    }

    public function take_assesment($course, $section, $video)
    {
        # code...
        // $assesment = Assesment::where('course_id', $course)->where('section_name', $section)->where('video', $video)->get();

        $assesment = Assesment::where('course_id', $course)->where('section_name', $section)->where('video', $video)->inRandomOrder()
        ->take(5)
        ->get();

        $data = [
            'course' => $course,
            'section' => $section,
            'video' => $video,
            'assesment' => $assesment,
        ];
        // dd($assesment);
        return view('users/take_assesment', ['data' => $data]);
    }
    public function assesment_submit(Request $req, $course, $section, $video)
    {
        # code...

        $result = new Assesment_result();
        $result->user_id = session('rexkod_user_id');

        $assesments = Assesment::where('course_id', $course)->where('section_name', $section)->where('video', $video)->get();

        $count = 1;
        $score = 0;
        foreach ($assesments as $assesment) {
            $answer_selected[] = $req->{'que_' . $count . '_selected'};
            if($assesment->answer == $req->{'que_' . $count . '_selected'}) {
                $score++;

            }
            $questions[] = $assesment->id;
            $count++;
        }
        $new_answer = implode(',', $answer_selected);
        $new_questions = implode(',', $questions);
        // dd($new_answer);
        $result->user_answer =	$new_answer;

        $result->score = $score;

        $result->questions = $new_questions;
        $result->course_id = $course;
        $result->section_name = $section;
        $result->video = $video;

        if($result->save()) {
            session()->put('success', "Assesment submitted successfully !!");
            return redirect('assesment_result/' . $result->id);

        } else {
            session()->put('failed', 'Failed, Try again!');
            return redirect()->back();
        }
        // return redirect('assesment_result/'.$result->id);
    }
    public function assesment_result($id)
    {

        $result = Assesment_result::where('id', $id)->first();

        $data = [
            'result' => $result,
           ];
        return view('users/assesment_result', ['data' => $data]);
    }

    public function take_test($course_id, $id)
    {
        $all_quiz = Quiz::where('id', $id)->first();
        // $subject_id=$all_quiz;
        $data = [
            'course_id' => $course_id,
            'all_quiz' => $all_quiz,
           ];
        return view('users/take_test', ['data' => $data]);
        // return view('users/take_quiz');
    }
    // function test_submit($id){
    //     $all_quiz=Quiz::where('id',$id)->first();
    //     // $subject_id=$all_quiz;
    //     $data = [
    //         'all_quiz' => $all_quiz,
    //        ];
    //     return view('users/take_quiz',['data' => $data]);
    //     // return view('users/take_quiz');
    // }
    public function test_submit(Request $req, $id)
    {
        $result = new Quiz_result();


        $quiz = Quiz::where('id', $id)->first();
        // dd($quiz->questions);
        $all_questions = explode(',', $quiz->questions);
        $count = 1;
        // dd($all_questions);
        // $answer_selected[] = null;
        foreach ($all_questions as $question) {
            $answer_selected[] = $req->{'que_' . $count . '_selected'};
            $count++;
        }
        $new_answer = implode(',', $answer_selected);
        // dd($new_answer);
        $count2 = 1;
        $score = 0;
        foreach ($all_questions as $question) {
            $quiz_master = Quiz_master::where('id', $question)->first();
            $quiz_answer = $quiz_master->answer;
            if($quiz_answer == $req->{'que_' . $count2 . '_selected'}) {
                $score++;
                $count2++;
            }
        }
        $questionsArray = explode(",", $quiz->questions);
        $totalQuestions = count($questionsArray);

        if ($score != 0) {
            $score_percentage = ($score / $totalQuestions) * 100;
        } else {
            $score_percentage = 0;
        }
        // dd($score);
        $result->user_answer =	$new_answer;
        $result->quiz_id = $id;
        $result->questions = $quiz->questions;
        $result->score = $score;
        $result->score_percentage = $score_percentage;
        $result->user_id = session('rexkod_user_id');
        $result->save();
        // return redirect("all_quiz");
        // dd($answer_selected);
        // return redirect('default_live_stream/'.$req->course_id . '/0');
        if($result->save()) {
            session()->put('success', "Test submitted successfully !!");
            return redirect('view_test_score/' . $id . '/' . $req->course_id);

        } else {
            session()->put('failed', 'Failed, Try again!');
            return redirect()->back();
        }
        // return redirect('view_test_score/'.$id .'/'.$req->course_id);
    }
    public function view_test_score($id, $course_id)
    {
        $course = Course::where('id', $course_id)->first();
        $result = Quiz_result::where('quiz_id', $id)
                            ->where('user_id', session('rexkod_user_id'))
                            ->latest()->first();
        // dd($result);
        $data = [
            'course' => $course,
            'result' => $result,
           ];

        return view('users/view_test_score', ['data' => $data]);
    }



    public function single_course_test($id, $tab_id)
    {

        // Session::put('rexkod_course_id',$id);

        $course = Course::where('id', $id)->first();
        $tutor = $course->course_tutor;
        $sent_messages = Message::where('sender_id', Session::get('rexkod_user_id'))->where('receiver_id', $tutor)->get();
        $received_messages = Message::where('sender_id', $tutor)->where('receiver_id', Session::get('rexkod_user_id'))->get();
        $courses = Course::get();
        // dd($courses[5]->sections[0]->section_video);
        $trainer = User::where('id', $tutor)->first();
        $mini_projects = Mini_project::where('course_id', $id)->get();

        $notes = Note::where('student_id', session('rexkod_user_id'))->where('course_id', $id)->get();
        // dd($notes);
        $data = [
            // 'trainers' => $trainers,
            'id' => $tab_id,
            'trainer' => $trainer,
            'course' => $course,
            'sent_messages' => $sent_messages,
            'received_messages' => $received_messages,
            'notes' => $notes,
            'mini_projects' => $mini_projects,
        ];
        return view('users/single_course_test', ['data' => $data]);
    }

    public function lab($id)
    {
        $lab = Lab::where("id", $id)->first();

        $data = [
            'lab' => $lab,
           ];
        return view('users.lab', ['data' => $data]);

    }

    public function ebook($id)
    {

        return view('users/ebook');
    }

    // ================================================== som ====================================================
    public function createStudentSubscription()
    {
        $susbcription = new Subscription();
        $susbcription->student_id = Session::get('rexkod_user_id');
        $susbcription->start_date = date('Y-m-d H:i:s');
        $susbcription->created_at = date('Y-m-d H:i:s');
        $susbcription->end_date = \Carbon\Carbon::now()->addYear()->format('Y-m-d H:i:s');
        if($susbcription->save()) {
            session()->put('success', "Your student subscription has been created successfully");
            return redirect('all_courses');

        } else {
            session()->put('failed', 'Your student subscription not created, Try again!');
            return redirect()->back();
        }

    }

    public function subscriptions()
    {
        return view('admin.subscriptions', [
            'subscriptions' => Subscription::get(),
        ]);
    }
    public function forums()
    {
        return view('users.forums', [
            'forum_questions' => Forum_question::get(),
        ]);
    }
    public function add_forum()
    {
        return view('users.add_forum', [
        ]);
    }

    public function create_forum(Request $request)
    {
        $forumQuestion = new Forum_question();
        $forumQuestion->student_id = Session::get('rexkod_user_id');
        $forumQuestion->question = $request->question;
        $forumQuestion->created_at = date('Y-m-d H:i:s');
        if($forumQuestion->save()) {
            session()->put('success', "Your Question submitted successfully");
            return redirect('forums');

        } else {
            session()->put('failed', 'Your Question not submitted, Try again!');
            return redirect()->back();
        }

    }

    public function view_forum($question_id)
    {
        return view('users.view_forum', [
            'forum_question' => Forum_question::where('id', $question_id)->first(),
            'forum_answers' => Forum_answer::where('forum_question_id', $question_id)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function answer_forum($question_id)
    {
        return view('users.answer_forum', [
            'forum_question' => Forum_question::where('id', $question_id)->first(),
        ]);
    }

    public function create_forum_answer(Request $request)
    {
        $forumAnswer = new Forum_answer();
        $forumAnswer->forum_question_id = $request->forum_question_id;
        $forumAnswer->student_id = Session::get('rexkod_user_id');
        $forumAnswer->answer = $request->answer;
        $forumAnswer->created_at = date('Y-m-d H:i:s');
        if($forumAnswer->save()) {
            session()->put('success', "Your answer submitted successfully");
            return redirect("view_forum/" . $request->forum_question_id);

        } else {
            session()->put('failed', 'Your answer not submitted, Try again!');
            return redirect()->back();
        }

    }


    public function create_student_refferal(Request $request)
    {
        // dd($request);
        $student_referral = new Student_referral();
        $student_referral->referred_to = Session::get('rexkod_user_id');
        $student_referral->referred_by = $request->referred_by;
        $student_referral->created_at = date('Y-m-d H:i:s');

        if($student_referral->save()) {
            session()->put('success', "Your student Student referral has been created successfully");
            return redirect('payment/' . session('rexkod_user_id'));

        } else {
            session()->put('failed', 'Your student Student referral not created, Try again!');
            return redirect()->back();
        }

    }






    public function view_certificate($course_id, $test_id)
    {
        // dd($test_id);
        return view('users.view_certificate', [
            'course' => Course::where('id', $course_id)->first(),
            // 'quiz_result' => Quiz_result::where('quiz_id', $test_id)->where('user_id', session('rexkod_user_id'))->latest()->first(),
            'quiz_result' => $test_id,
        ]);
    }


    public function payment($course_id)
    {

        $course = new Enrolled_course();

        $course->student_id = session('rexkod_user_id');
        $course->course_id = $course_id;
        $course->save();

        return view('users.payment', [
            'student_referrals' => Student_referral::where('referred_by', Session::get('rexkod_user_id'))->get(),
        ]);
    }







    //============================== end =======================

    public function search_questions(Request $request)
    {
        $term = $request->input('term');

        $questions = DB::table('qnas')
            ->where('question', 'like', $term . '%')
            ->get();

        if ($questions->count() > 0) {
            foreach ($questions as $question) {
                echo "<p data-id = '" . $question->id . "'>" . $question->question . "</p>";
            }
        } else {
            echo "<p>No matches found</p>";
        }
    }
    public function qna_single($id)
    {
        $qna = Qna::where('id', $id)->first();
        $data = [
            'qna' => $qna,
        ];
        return view('users.qna_single', ['data' => $data]);
    }

    public function search_forum_questions(Request $request)
    {
        $term = $request->input('term');

        $questions = DB::table('forum_questions')
            ->where('question', 'like', $term . '%')
            ->get();

        if ($questions->count() > 0) {
            foreach ($questions as $question) {
                echo "<p data-id = '" . $question->id . "'>" . $question->question . "</p>";
            }
        } else {
            echo "<p>No matches found</p>";
        }
    }
    public function search_courses(Request $request)
    {
        $term = $request->input('term');

        $courses = DB::table('course')
            ->where('course_name', 'like', $term . '%')
            ->get();

        if ($courses->count() > 0) {
            foreach ($courses as $courses) {
                echo "<p data-id = '" . $courses->id . "'>" . $courses->course_name . "</p>";
            }
        } else {
            echo "<p>No matches found</p>";
        }
    }

    public function start_internship($id, $lab_code)
    {
        $internship_task = Internship_task::where('id', $id)->first();
        $internship_process = new Internship_process();
        $internship_process->student_id = session('rexkod_user_id');
        $internship_process->internship_id  = $internship_task->internship_id;
        $internship_process->task_id  = $id;
        $internship_process->status  = 1 ;
        $internship_process->save();
        $data = [
            'internship_task' => $internship_task,
            'code' => $lab_code,
            'internship_process_id' => $internship_process->id,
        ];

        return  view('users.internship_lab', ['data' => $data]);
    }
    public function view_internship($id)
    {
        $internship = Internship::where('id', $id)->first();
        $internship_task = Internship_task::where('internship_id', $id)->get();
        $data = [
            'internship' => $internship,
            'internship_id' => $id,
            'internship_task' => $internship_task,
        ];
        return view('users/view_internship', ['data' => $data]);
    }
    public function update_internship_task_status($id)
    {
        Internship_process::where('id', $id)
                    ->update(['status' => 2]);
        $internship_process = Internship_process::where('id', $id)->first();

        return redirect('view_internship/' . $internship_process->internship_id);
    }
    public function continue_task($id, $lab_code)
    {
        $internship_task = Internship_task::where('id', $id)->first();
        $internship_process = Internship_process::where('student_id', session('rexkod_user_id'))
                                                            ->where('internship_id', $internship_task->internship_id)
                                                            ->where('task_id', $id)->first();
        $data = [
            'internship_task' => $internship_task,
            'code' => $lab_code,
            'internship_process_id' => $internship_process->id,
        ];

        return  view('users.internship_lab', ['data' => $data]);
    }

    public function default_settings()
    {

        return view('users/default_settings');
    }
    public function change_password_view()
    {
        $user = User::where('id', session('rexkod_user_id'))->first();
        $data = [
            'user' => $user,
        ];

        return view('users/change_password', ['data' => $data]);
    }

    public function change_password(Request $req)
    {
        User::where('id', session('rexkod_user_id'))
                    ->update(['name' => $req->name,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                ]);

        $user = User::where('id', session('rexkod_user_id'))->first();

        Session::put('rexkod_user_name', $user->name);
        Session::put('rexkod_user_email', $user->email);

        Student::where('student_id', session('rexkod_user_id'))
        ->update(['f_name' => $user->name,
        'email' => $user->email,
            ]);
        session()->put('success', 'Settings Updated');
        return redirect('/index');
    }

    public function start_project($id, $lab_code)
    {
        $project_task = Project_task::where('id', $id)->first();
        $project_process = new Project_process();
        $project_process->student_id = session('rexkod_user_id');
        $project_process->project_id  = $project_task->project_id;
        $project_process->task_id  = $id;
        $project_process->status  = 1 ;
        $project_process->save();
        $data = [
            'project_task' => $project_task,
            'code' => $lab_code,
            'project_process_id' => $project_process->id,
        ];

        return  view('users.project_lab', ['data' => $data]);
    }
    public function view_project($id)
    {
        # code...
        $project_task = Project_task::where('project_id', $id)->get();
        $mini_project = Mini_project::where('id', $id)->first();
        $data = [
            'project' => $mini_project,
            'project_task' => $project_task,
            'project_id' => $id,
        ];
        return view('users/view_project', ['data' => $data]);
    }

    public function update_project_task_status($id)
    {
        Project_process::where('id', $id)
                    ->update(['status' => 2]);
        $project_process = Project_process::where('id', $id)->first();

        return redirect('view_project/' . $project_process->project_id);
    }
    public function continue_project_task($id, $lab_code)
    {
        $project_task = Project_task::where('id', $id)->first();
        $project_process = Project_process::where('student_id', session('rexkod_user_id'))
                                                            ->where('project_id', $project_task->project_id)
                                                            ->where('task_id', $id)->first();
        $data = [
            'project_task' => $project_task,
            'code' => $lab_code,
            'project_process_id' => $project_process->id,
        ];

        return  view('users.project_lab', ['data' => $data]);
    }




    // ========markers=======
    public function markers()
    {
        $markers = Marker::get();
        return  view('users.markers', ['markers' => $markers]);

    }
    public function markers_single($note_id)
    {
        $markers = Marker::get();
        $marker_single = Marker::where('id', $note_id)->first();
        return  view('users.markers_single', ['markers' => $markers,'marker_single' => $marker_single]);

    }
    public function markers_last()
    {
        $markers = Marker::get();
        $marker_last = Marker::latest()->first();
        return  view('users.markers_last', ['markers' => $markers,'marker_last' => $marker_last]);

    }

    public function save_markers(Request $req)
    {
        $marker = new Marker();
        $marker->video_id = 1;
        $marker->note = $req->note;
        $marker->time = $req->timestamp;
        $marker->user_id = session('rexkod_user_id');

        $marker->save();
        // $markers = Marker::get();
        return $marker;
    }
    public function video_with_watermark(Request $req)
    {
        return  view('users.video_with_watermark');

    }
    public function video_features(Request $req)
    {
        return  view('users.video_features');

    }
    // it will take to the page where the video is hardcoded
    public function video_encryption()
    {
        if(session('rexkod_user_id')) {
            // return  view('users.video_encryption',['unique_video_name' => $unique_video_name]);
            return  view('users.video_encryption');
        } else {
            return redirect('/');
        }

    }

    // after uploading the video file - the video is dynamic in the view- change the path in the view page - both pointing to the same page
    public function video_encryption_1($unique_video_name)
    {
        if(session('rexkod_user_id')) {
            return  view('users.video_encryption', ['unique_video_name' => $unique_video_name]);
        // return  view('users.video_encryption');
        } else {
            return redirect('/');
        }

    }

    public function upload_video_file_view()
    {
        $all_videos_names  = Video_hls_secret::distinct()->pluck('video_name');

        // dd($all_videos_names);

        return view('users.upload_video_file', ['all_videos_names' => $all_videos_names]);
    }


    public function upload_video_file(Request $request)
    {

        set_time_limit(3600);
        try {
            // Get the uploaded video file from the request
            $uploadedVideo = $request->file('video_file');
            $video_name = Str::random(4) . time();
            // dd($filename);
            // $video_name = pathinfo($uploadedVideo->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $uploadedVideo->getClientOriginalName();
            // Read the video data
            // $videoData = file_get_contents($uploadedVideo->getRealPath());
            $uploadedVideo_path = $request->file('video_file')->move(storage_path('uploads'), $file);


            $lowFormat = (new X264('aac'))->setKiloBitrate(500);
            $highFormat = (new X264('aac'))->setKiloBitrate(1000);

            FFMpeg::fromDisk('uploads')
                ->open($file) // Use video data in memory
                ->exportForHLS()
                ->withRotatingEncryptionKey(function ($filename, $contents) use ($video_name) {
                    // You can store encrypted chunks in memory if needed
                    // Storage::disk('public')->put("videos/$filename", $contents);
                    // Storage::disk('secrets')->put("$filename", $contents);
                    DB::table('video_hls_secrets')->insert([
                        'video_name' => $video_name,
                        'file_name' => $filename,
                        'contents' => $contents,
                    ]);
                })
                ->addFormat($lowFormat, function (HLSVideoFilters $filters) {
                    $filters->resize(1280, 720);
                })
                ->addFormat($highFormat)

                ->toDisk('public')
                ->save('videos/' . $video_name . '.m3u8'); // Use a unique name


            // Storage::delete(storage_path('uploads') . '/' . $file);

            if (file_exists($uploadedVideo_path)) {
                unlink($uploadedVideo_path);
            }
            session()->put('success', "Video Added!" . $video_name);
            return redirect('/upload_video_file');
        } catch (Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }


    public function video_play_back_all()
    {
        $all_video = Video::get();
        return view('users.video_play_back_all', ['all_video' => $all_video]);
    }
    public function video_play_back($id)
    {

        $video = Video::where('id', $id)->first();
        $Video_play_back = Video_play_back::where('user_id', session('rexkod_user_id'))
            ->where('video_id', $id)
            ->first();
        if($Video_play_back) {
            $timestamp = $Video_play_back->video_time_stamp;
        } else {
            $timestamp = 0;
        }
        return view('users.video_play_back', ['video' => $video,'timestamp' => $timestamp]);
    }

    public function save_video_timestamp(Request $req)
    {
        $timestamp = Video_play_back::where('user_id', session('rexkod_user_id'))
            ->where('video_id', $req->videoId)
            ->where('course_id', $req->courseId)
            ->first();
        if($timestamp) {
            $timestamp->video_time_stamp = $req->timestamp;
            $timestamp->status = 0;
            // $timestamp->updated_at = Carbon::now();
            $timestamp->save();
        } else {
            $video = new Video_play_back();
            $video->user_id = session('rexkod_user_id');
            $video->course_id  = $req->courseId;
            $video->video_id = $req->videoId;
            $video->video_time_stamp = $req->timestamp;

            $video->save();
        }
        return $timestamp;
    }

    public function retrieve_last_video_played($course_id)
    {
        $Video_play_back = Video_play_back::where('user_id', session('rexkod_user_id'))
        ->where('course_id', $course_id)
        ->latest('updated_at')
        ->first();
        // Now, $video_play_back contains the last updated record with the specified course_id
        if($Video_play_back) {
            $video = Video::where('id', $Video_play_back->video_id)->first();
        } else {
            $section = Section::where('course_id', $course_id)->first();
            $video = Video::where('course_id', $course_id)->where('section_id', $section->id)->first();
        }

        // if($Video_play_back){
        //     $Video_play_back = $Video_play_back;
        // }else{
        //     $Video_play_back = 0;
        // }

        $result = [
            'video_id' => $Video_play_back ? $Video_play_back->video_id : $video->id,
            'course_id' => $course_id,
            'video_src' => $video->video_file,
            'video_time_stamp' => $Video_play_back ? $Video_play_back->video_time_stamp : 0,
        ];
        return $result;
    }


    // if video completes
    public function update_video_status(Request $req)
    {
        $timestamp = Video_play_back::where('user_id', session('rexkod_user_id'))
            ->where('video_id', $req->videoId)
            ->first();
        if($timestamp) {
            $timestamp->video_time_stamp = $req->timestamp;
            // if($req->status == true){
            //     $timestamp->status = 1;
            // }elseif($req->status === false){
            //     $timestamp->status = 0;

            // }
            $timestamp->status = 1;
            // $timestamp->updated_at = Carbon::now();
            $timestamp->save();
        }
        return $timestamp;
        // if($req->status){
        //     return 1 ;
        // }else{
        //     return 0 ;
        // }

    }

    public function video_start_end()
    {


        return view('users.video_start_end');
    }





    //    ========================== school students ======================



    public function all_subjects()
    {

        $student = School_student::where('auth_id', session('rexkod_user_id'))->first();
        $subjects = School_subject::where('class_id', $student->class_id)->get();
        $tests = [];
        foreach ($subjects as $subject) {
            $latestTest = School_test::where('subject_id', $subject->id)
                                    ->latest()
                                    ->first();
            $tests[] = $latestTest;
        }
        // dd($tests);

        return view('school_student.all_subjects', ['subjects' => $subjects,'tests' => $tests]);
    }

    public function subject_live_stream($subject_id, $tab_id)
    {

        $subject = School_subject::where('id', $subject_id)->first();
        $chapters = Chapter::where('subject', $subject_id)->get();
        $videos = Chapter_video::whereHas('chapter', function ($query) use ($subject_id) {
            $query->where('subject', $subject_id);
        })->get();

        $assesments = School_assesment::with('class', 'subject', 'chapter', 'video')->where('subject_id', $subject_id)->get();

        $Video_play_back = School_video_play_back::where('user_id', session('rexkod_user_id'))
        ->where('subject_id', $subject_id)
        ->latest('updated_at')
        ->first();
        // Now, $video_play_back contains the last updated record with the specified course_id
        if($Video_play_back) {
            $video_details = Chapter_video::where('id', $Video_play_back->video_id)->first();
            $timestamp = $Video_play_back->video_time_stamp;

        } else {
            $chapter = Chapter::where('subject', $subject_id)->first();
            $video_details = Chapter_video::where('chapter_id', $chapter->id)->first();
            $timestamp = 0;
        }

        $test = School_test::where('subject_id', $subject_id)
                ->latest()
                ->first();
        $test_result = School_test_result::where('test_id', $test->id)
                ->where('user_id', session('rexkod_user_id'))
                ->latest()
                ->first();

        $mini_projects = School_mini_project::where('subject_id', $subject_id)->get();

        $assesments_result = School_assesment_result::where('user_id', session('rexkod_user_id'))->distinct()
        ->pluck('video_id');
        $assesments_given = Chapter_video::whereIn('id', $assesments_result)
        ->select('id', 'video_name') // Adjust the columns you want to select
        ->get();

        $notes = School_note::where('student_id', session('rexkod_user_id'))->where('subject_id', $subject_id)->get();

        $teacher = Teacher::whereJsonContains('class_and_subject', ['subject_id' => $subject_id])->with('user')->first();
        // dd($teachers);
        $sent_messages = School_message::where('sender_id', Session::get('rexkod_user_id'))->where('receiver_id', $teacher->auth_id)->get();
        $received_messages = School_message::where('sender_id', $teacher->auth_id)->where('receiver_id', Session::get('rexkod_user_id'))->get();

        $data = [
            'subject_id' => $subject_id,
            'subject' => $subject,
            'id' => $tab_id,
            'videos' => $videos,
            'chapters' => $chapters,
            'assesments' => $assesments,
            'mini_projects' => $mini_projects,
            'assesments_given' => $assesments_given,
            'notes' => $notes,
            'teacher' => $teacher,
            'sent_messages' => $sent_messages,
            'received_messages' => $received_messages,
        ];
        return view('school_student/subject_live_stream', ['data' => $data,'video_details' => $video_details,'video_timestamp' => $timestamp,'test' => $test,'test_result' => $test_result]);
    }


    public function save_video_timestamp_school(Request $req)
    {
        $timestamp = School_video_play_back::where('user_id', session('rexkod_user_id'))
            ->where('video_id', $req->videoId)
            ->where('subject_id', $req->subjectId)
            ->first();
        if($timestamp) {
            $timestamp->video_time_stamp = $req->timestamp;
            $timestamp->status = 0;
            // $timestamp->updated_at = Carbon::now();
            $timestamp->save();
        } else {
            $video = new School_video_play_back();
            $video->user_id = session('rexkod_user_id');
            $video->subject_id  = $req->subjectId;
            $video->video_id = $req->videoId;
            $video->video_time_stamp = $req->timestamp;
            $video->save();
        }
        return $timestamp;
    }

    // if video completes
    public function update_video_status_school(Request $req)
    {
        $timestamp = School_video_play_back::where('user_id', session('rexkod_user_id'))
            ->where('video_id', $req->videoId)
            ->first();

        if($timestamp) {
            $timestamp->video_time_stamp = $req->timestamp;
            $timestamp->status = 1;
            // $timestamp->updated_at = Carbon::now();
            $timestamp->save();
        }
        return $timestamp;
    }

    public function take_assesment_school($subject_id, $chapter_id, $video_id)
    {
        # code...
        // $assesment = Assesment::where('subject_id', $subject)->where('section_name', $section)->where('video', $video)->get();

        $assesment = School_assesment::where('subject_id', $subject_id)->where('chapter_id', $chapter_id)->where('video_id', $video_id)->inRandomOrder()
        ->take(5)
        ->get();

        $data = [
            'subject_id' => $subject_id,
            'chapter_id' => $chapter_id,
            'video_id' => $video_id,
            'assesment' => $assesment,
        ];
        // dd($assesment);
        return view('school_student/take_assesment', ['data' => $data]);
    }
    public function assesment_submit_school(Request $req, $subject, $chapter, $video)
    {
        // dd($req->questions);
        $result = new School_assesment_result();
        $result->user_id = session('rexkod_user_id');

        $assesments = School_assesment::where('subject_id', $subject)->where('chapter_id', $chapter)->where('video_id', $video)->get();

        $count = 1;
        $score = 0;
        foreach ($assesments as $assesment) {
            if(in_array($assesment->id, $req->questions)) {
                $answer_selected[] = $req->{'que_' . $count . '_selected'};
                if($assesment->answer == $req->{'que_' . $count . '_selected'}) {
                    $score++;
                }
                $questions[] = $assesment->id;
                $count++;
            }

        }
        $new_answer = implode(',', $answer_selected);
        $new_questions = implode(',', $questions);
        // dd($new_answer);
        $result->user_answer =	$new_answer;

        $result->score = $score;

        $result->questions = $new_questions;
        $result->subject_id = $subject;
        $result->chapter_id = $chapter;
        $result->video_id = $video;

        if($result->save()) {
            session()->put('success', "Assesment submitted successfully !!");
            return redirect('assesment_result_school/' . $result->id);

        } else {
            session()->put('failed', 'Failed, Try again!');
            return redirect()->back();
        }
        // return redirect('assesment_result/'.$result->id);
    }
    public function assesment_result_school($id)
    {

        $result = School_assesment_result::where('id', $id)->first();

        $data = [
            'result' => $result,
           ];
        return view('school_student/assesment_result', ['data' => $data]);
    }


    public function take_school_test($subject_id, $id)
    {

        $all_quiz = School_test::where('id', $id)->first();
        $question_id = explode(',', $all_quiz->questions);
        $total_count = count($question_id);
        // Retrieve all the questions from the testmaster table with matching IDs
        $quiz_masters = School_test_master::whereIn('id', $question_id)->get();

        $data = [
            'subject_id' => $subject_id,
            'all_quiz' => $all_quiz,
           ];
        return view('school_student/take_test', ['data' => $data,'question_id' => $question_id,'total_count' => $total_count,'quiz_masters' => $quiz_masters]);
    }

    public function school_test_submit(Request $req, $id)
    {
        $result = new School_test_result();


        $test = School_test::where('id', $id)->first();
        $all_questions = explode(',', $test->questions);
        $count = 1;

        foreach ($all_questions as $question) {
            $answer_selected[] = $req->{'que_' . $count . '_selected'};
            $count++;
        }
        $new_answer = implode(',', $answer_selected);
        $count2 = 1;
        $score = 0;
        foreach ($all_questions as $question) {
            $test_master = School_test_master::where('id', $question)->first();
            $test_answer = $test_master->answer;
            if($test_answer == $req->{'que_' . $count2 . '_selected'}) {
                $score++;
                $count2++;
            }
        }
        $questionsArray = explode(",", $test->questions);
        $totalQuestions = count($questionsArray);

        if ($score != 0) {
            $score_percentage = ($score / $totalQuestions) * 100;
        } else {
            $score_percentage = 0;
        }
        $result->user_answer =	$new_answer;
        $result->test_id = $id;
        $result->questions = $test->questions;
        $result->score = $score;
        $result->score_percentage = $score_percentage;
        $result->user_id = session('rexkod_user_id');
        $result->save();

        if($result->save()) {
            session()->put('success', "Test submitted successfully !!");
            return redirect('view_school_test_score/' . $id . '/' . $req->subject_id);

        } else {
            session()->put('failed', 'Failed, Try again!');
            return redirect()->back();
        }
        // return redirect('view_test_score/'.$id .'/'.$req->course_id);
    }
    public function view_school_test_score($id, $subject_id)
    {
        $subject = School_subject::where('id', $subject_id)->first();
        $result = School_test_result::where('test_id', $id)
                            ->where('user_id', session('rexkod_user_id'))
                            ->latest()->first();
        $data = [
            'subject' => $subject,
            'result' => $result,
           ];

        return view('school_student/view_test_score', ['data' => $data]);
    }

    public function view_subject_certificate($subject_id, $test_id)
    {
        return view('school_student.view_certificate', [
            'subject' => School_subject::where('id', $subject_id)->first(),
            'test_result' => $test_id,
        ]);
    }

    public function view_school_project($project_id)
    {
        # code...
        $project_task = School_project_task::where('project_id', $project_id)->get();
        $mini_project = School_mini_project::where('id', $project_id)->first();
        $data = [
            'project' => $mini_project,
            'project_task' => $project_task,
            'project_id' => $project_id,
        ];
        return view('school_student/view_project', ['data' => $data]);
    }

    public function start_school_project($id, $lab_code)
    {
        $project_task = School_project_task::where('id', $id)->first();
        $project_process = new School_project_process();
        $project_process->student_id = session('rexkod_user_id');
        $project_process->project_id  = $project_task->project_id;
        $project_process->task_id  = $id;
        $project_process->status  = 1 ;
        $project_process->save();
        $data = [
            'project_task' => $project_task,
            'code' => $lab_code,
            'project_process_id' => $project_process->id,
        ];

        return  view('school_student.project_lab', ['data' => $data]);
    }

    public function update_school_project_task_status($id)
    {
        School_project_process::where('id', $id)
                    ->update(['status' => 2]);
        $project_process = School_project_process::where('id', $id)->first();

        return redirect('view_school_project/' . $project_process->project_id);
    }

    public function continue_school_project_task($id, $lab_code)
    {
        $project_task = School_project_task::where('id', $id)->first();
        $project_process = School_project_process::where('student_id', session('rexkod_user_id'))
                                                            ->where('project_id', $project_task->project_id)
                                                            ->where('task_id', $id)->first();
        $data = [
            'project_task' => $project_task,
            'code' => $lab_code,
            'project_process_id' => $project_process->id,
        ];

        return  view('school_student.project_lab', ['data' => $data]);
    }

    public function save_school_notes(Request $req)
    {
        # code...
        $note = new School_note();

        $note->student_id = Session::get('rexkod_user_id');
        $note->subject_id = $req->subject_id;
        $note->note = $req->note;

        $note->save();
        // session()->put('success', 'Message sent successfully');

        return redirect('subject_live_stream/' . $req->subject_id . '/1');

    }

    public function school_qna_view()
    {
        # code...
        $subjects = School_subject::get();
        $data = [
            'subjects' => $subjects,
        ];
        return view('school_student/qna', ['data' => $data]);
    }
    public function school_qna(Request $req)
    {
        # code...
        $qna = new School_qna();

        $qna->subject_id = $req->subject;
        $qna->question = $req->question;
        $qna->q_created_by = session('rexkod_user_id');

        $qna->save();
        session()->put('success', "Question Sent");
        return redirect('school_qna');
    }


    public function school_qna_single($id)
    {
        $qna = School_qna::where('id', $id)->first();
        $data = [
            'qna' => $qna,
        ];
        return view('school_student.qna_single', ['data' => $data]);
    }
    public function school_send_message(Request $req)
    {
        # code...
        // $message = new Message();

        $qna = School_qna::where('question', $req->message)->first();
        if($qna) {
            // dd($qna->answer);
            $message = new School_message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $qna->question;
            $message->save();

            if($qna->answer) {
                $message = new School_message();
                $message->sender_id = $qna->a_created_by;
                $message->receiver_id = Session::get('rexkod_user_id');
                $message->message = $qna->answer;
                $message->save();
            }
        } else {
            $message = new School_message();
            $message->sender_id = Session::get('rexkod_user_id');
            $message->receiver_id = $req->receiver_id;
            $message->message = $req->message;
            $message->save();
        }

        // session()->put('success', 'Message sent successfully');

        return redirect('subject_live_stream/' . $req->subject_id . '/2');

    }

    public function school_forums()
    {
        return view('school_student.forums', [
            'forum_questions' => School_forum_question::get(),
        ]);
    }

    public function school_create_forum(Request $request)
    {
        $forumQuestion = new School_forum_question();
        $forumQuestion->student_id = Session::get('rexkod_user_id');
        $forumQuestion->question = $request->question;
        $forumQuestion->created_at = date('Y-m-d H:i:s');
        if($forumQuestion->save()) {
            session()->put('success', "Your Question submitted successfully");
            return redirect('school_forums');
        } else {
            session()->put('failed', 'Your Question not submitted, Try again!');
            return redirect()->back();
        }

    }


    public function view_school_forum($question_id)
    {
        return view('school_student.view_forum', [
            'forum_question' => School_forum_question::where('id', $question_id)->first(),
            'forum_answers' => School_forum_answer::where('forum_question_id', $question_id)->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function add_school_forum()
    {
        return view('school_student.add_forum', [
        ]);
    }

    public function create_school_forum(Request $request)
    {
        $forumQuestion = new School_forum_question();
        $forumQuestion->student_id = Session::get('rexkod_user_id');
        $forumQuestion->question = $request->question;
        $forumQuestion->created_at = date('Y-m-d H:i:s');
        if($forumQuestion->save()) {
            session()->put('success', "Your Question submitted successfully");
            return redirect('school_forums');

        } else {
            session()->put('failed', 'Your Question not submitted, Try again!');
            return redirect()->back();
        }

    }
    public function answer_school_forum($question_id)
    {
        return view('school_student.answer_forum', [
            'forum_question' => School_forum_question::where('id', $question_id)->first(),
        ]);
    }
    public function create_school_forum_answer(Request $request)
    {
        $forumAnswer = new School_forum_answer();
        $forumAnswer->forum_question_id = $request->forum_question_id;
        $forumAnswer->student_id = Session::get('rexkod_user_id');
        $forumAnswer->answer = $request->answer;
        $forumAnswer->created_at = date('Y-m-d H:i:s');
        if($forumAnswer->save()) {
            session()->put('success', "Your answer submitted successfully");
            return redirect("view_school_forum/" . $request->forum_question_id);

        } else {
            session()->put('failed', 'Your answer not submitted, Try again!');
            return redirect()->back();
        }

    }




    // ========== apis =============

    public function get_subjects($classId)
    {

        $subjects = School_subject::where('class_id', $classId)->get();

        return $subjects;
    }
    public function login(Request $req)
    {
        if(is_numeric($req->email)) {
            $user = User::where('id', $req->email)->first();
            if($user && $user->type == 'school_student' && Hash::check($req->password, $user->password)) {
                $student = School_student::where('auth_id', $user->id)->first();
                $data = [
                    'student' => $student,
                    'user' => $user,
                ];
                return $data;
            } else {
                return ["msg" => "Invalid email or password"];
            }



        } else {


            $user = User::where('email', $req->email)->first();

            if($user && $user->type == 'admin' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('admin', $user);
                Session::put('rexkod_admin_id', $user->id);
                Session::put('rexkod_admin_name', $user->name);
                Session::put('rexkod_admin_email', $user->email);
                Session::put('rexkod_admin_phone', $user->phone);
                Session::put('rexkod_admin_type', $user->type);


                return redirect('/admin/index');


            } elseif($user && $user->type == 'recruiter' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('recruiter', $user);
                Session::put('rexkod_recruiter_id', $user->id);

                Session::put('rexkod_recruiter_name', $user->name);
                // dd(session('rexkod_user_name'));

                return redirect('/recruiter/index');


            } elseif($user && $user->type == 'trainer' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('trainer', $user);
                Session::put('rexkod_trainer_id', $user->id);
                Session::put('rexkod_trainer_name', $user->name);
                Session::put('rexkod_trainer_type', $user->type);

                // dd(session('rexkod_user_name'));

                return redirect('/trainer/index');


            } elseif($user && $user->type == 'student' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);
                Session::put('rexkod_user_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/index');


            } elseif($user && $user->type == 'parent' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_user_id', $user->id);
                Session::put('rexkod_user_name', $user->name);
                Session::put('rexkod_user_email', $user->email);
                Session::put('rexkod_user_phone', $user->phone);
                Session::put('rexkod_user_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/parents/index');


            } elseif($user && $user->type == 'sub_admin' && Hash::check($req->password, $user->password)) {
                $date = date('Y-m-d H:i:s');
                $req->session()->put('user', $user);
                Session::put('rexkod_admin_id', $user->id);
                Session::put('rexkod_admin_name', $user->name);
                Session::put('rexkod_admin_email', $user->email);
                Session::put('rexkod_admin_phone', $user->phone);
                Session::put('rexkod_admin_type', $user->type);
                // dd(session('rexkod_user_name'));

                return redirect('/admin/index');


            } elseif($user && $user->type == 'teacher' && Hash::check($req->password, $user->password)) {
                // dd($user->type);
                $date = date('Y-m-d H:i:s');
                $req->session()->put('trainer', $user);
                Session::put('rexkod_trainer_id', $user->id);
                Session::put('rexkod_trainer_name', $user->name);
                Session::put('rexkod_trainer_type', $user->type);
                // dd(session('rexkod_user_name'));
                return redirect('/trainer/index');

            } else {
                session()->put('failed', 'Invalid Credentials');
                return redirect('/login');
            }
        }

    }

    //  public function register(Request $req)
    // {

    //     $auth=new User();

    //     $result = User::where('email', $req->email)->first();
    //     if($result) {
    //         return ["msg"=>"Email already exists"];
    //     } else {

    //         if($req->has('is_parent')){
    //             $auth->name = $req->name;
    //             $auth->phone = $req->phone;
    //             $auth->email = $req->email;
    //             $auth->type = 'parent';
    //             $auth->password=Hash::make($req->password);

    //             $length = 6;
    //             $min = pow(10, $length - 1);
    //             $max = pow(10, $length) - 1;
    //             $rand_number = mt_rand($min, $max);
    //             $auth->parent_code = $rand_number;

    //             $auth->save();
    //             $user = User::where('email', $req->email)->first();

    //             $date = date('Y-m-d H:i:s');
    //             $req->session()->put('user', $user);
    //             Session::put('rexkod_user_id', $user->id);

    //             Session::put('rexkod_user_name', $user->name);
    //             Session::put('rexkod_user_email', $user->email);
    //             Session::put('rexkod_user_phone', $user->phone);

    //             return redirect('/parents/index');
    //         }else{


    //         $auth->name = $req->name;
    //         $auth->phone = $req->phone;
    //         $auth->email = $req->email;
    //         $auth->type = 'student';
    //         $auth->password=Hash::make($req->password);

    //         $auth->save();
    //         $user = User::where('email', $req->email)->first();

    //         $student=new Student();
    //         $student->student_id= $user->id;
    //         $student->f_name= $req->name;
    //         $student->phone_no= $req->phone;
    //         $student->email= $req->email;
    //         $student->save();


    //         $date = date('Y-m-d H:i:s');
    //         $req->session()->put('user', $user);
    //         Session::put('rexkod_user_id', $user->id);
    //         Session::put('rexkod_user_type', $user->type);
    //         Session::put('rexkod_user_name', $user->name);
    //         Session::put('rexkod_user_email', $user->email);
    //         Session::put('rexkod_user_phone', $user->phone);

    //         return redirect('/index');
    //         }




    //         // return redirect('/index');
    //     }

    // }

    public function submitSchoolQna(Request $req)
    {
        # code...
        $qna = new School_qna();

        $qna->subject_id = $req->subject;
        $qna->question = $req->question;
        $qna->q_created_by = $req->userId;

        if($qna->save()) {
            return ["msg" => "Question submitted"];
        } else {
            return ["msg" => "Question could not submitted"];
        }
    }

    public function submitSchoolForum(Request $req)
    {
        $forumQuestion = new School_forum_question();
        $forumQuestion->student_id = $req->userId;
        $forumQuestion->question = $req->question;
        $forumQuestion->created_at = date('Y-m-d H:i:s');
        if($forumQuestion->save()) {
            return ["msg" => "Question submitted"];
        } else {
            return ["msg" => "Question could not submitted"];

        }


    }
    public function search_school_questions($data)
    {
        $questions = DB::table('school_qnas')
            ->where('question', 'like', $data . '%')
            ->get();

        return $questions;
    }
    public function get_school_qna_single($qna_id)
    {
        $qna = School_qna::where('id', $qna_id)->first();
        return $qna;
    }

    public function school_search_forum_questions($data)
    {

        $questions = DB::table('school_forum_questions')
            ->where('question', 'like', $data . '%')
            ->get();
        return $questions;

    }

    public function get_school_forum_single($question_id)
    {
        return  [
            'forum_question' => School_forum_question::where('id', $question_id)->first(),
            'forum_answers' => School_forum_answer::where('forum_question_id', $question_id)->with('student')->orderBy('created_at', 'desc')->get(),
        ];
    }

    public function submitSchoolForumAnswer(Request $request,  $question_id)
    {
        $forumAnswer = new School_forum_answer();
        $forumAnswer->forum_question_id = $question_id;
        $forumAnswer->student_id = $request->userId;
        $forumAnswer->answer = $request->answer;
        $forumAnswer->created_at = date('Y-m-d H:i:s');
        if($forumAnswer->save()) {
            return ["msg" => "Answer submitted"];
        } else {
            return ["msg" => "Answer could not submitted"];

        }

    }

    public function connect_parent(Request $req)
    {
        $parent = User::where('parent_code', $req->parentCode)->first();
        if($parent->parent_code) {
            $student = User::where('id', $req->userId)->first();
            $student->parent_id = $parent->id;
            $student->save();
            return ['parent'=>$parent,"msg" => "Parent Connected"];
        }

    }
    public function get_parent($parent_id){
        $parent = User::where('id', $parent_id)->first();
        return $parent;
    }

    public function subject_stream($student_id,$subject_id)
    {

        $subject = School_subject::where('id', $subject_id)->first();
        $chapters = Chapter::where('subject', $subject_id)->get();
        $videos = Chapter_video::whereHas('chapter', function ($query) use ($subject_id) {
            $query->where('subject', $subject_id);
        })->get();

        $assesments = School_assesment::with('class', 'subject', 'chapter', 'video')->where('subject_id', $subject_id)->get();

        $Video_play_back = School_video_play_back::where('user_id', $student_id)
        ->where('subject_id', $subject_id)
        ->latest('updated_at')
        ->first();
        // Now, $video_play_back contains the last updated record with the specified course_id
        if($Video_play_back) {
            $video_details = Chapter_video::where('id', $Video_play_back->video_id)->first();
            $timestamp = $Video_play_back->video_time_stamp;

        } else {
            $chapter = Chapter::where('subject', $subject_id)->first();
            $video_details = Chapter_video::where('chapter_id', $chapter->id)->first();
            $timestamp = 0;
        }

        $test = School_test::where('subject_id', $subject_id)
                ->latest()
                ->first();
        $test_result = School_test_result::where('test_id', $test->id)
                ->where('user_id',$student_id)
                ->latest()
                ->first();

        $mini_projects = School_mini_project::where('subject_id', $subject_id)->get();

        $assesments_result = School_assesment_result::where('user_id', $student_id)->distinct()
        ->pluck('video_id');
        $assesments_given = Chapter_video::whereIn('id', $assesments_result)
        ->select('id', 'video_name') // Adjust the columns you want to select
        ->get();

        $notes = School_note::where('student_id', $student_id)->where('subject_id', $subject_id)->get();

        $teacher = Teacher::whereJsonContains('class_and_subject', ['subject_id' => $subject_id])->with('user')->first();
        // dd($teachers);
        $sent_messages = School_message::where('sender_id', $student_id)->where('receiver_id', $teacher->auth_id)->get();
        $received_messages = School_message::where('sender_id', $teacher->auth_id)->where('receiver_id', $student_id)->get();

        $data = [
            'subject_id' => $subject_id,
            'subject' => $subject,
            // 'id' => $tab_id,
            'videos' => $videos,
            'chapters' => $chapters,
            'assesments' => $assesments,
            'mini_projects' => $mini_projects,
            'assesments_given' => $assesments_given,
            'notes' => $notes,
            'teacher' => $teacher,
            'sent_messages' => $sent_messages,
            'received_messages' => $received_messages,
            'video_details' => $video_details,
            'video_timestamp' => $timestamp,
            'test' => $test,
            'test_result' => $test_result
        ];
        return $data;
    }
}
