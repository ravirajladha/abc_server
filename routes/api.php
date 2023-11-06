<?php

use Illuminate\Http\Request;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("/get_subjects/{classId}",[Abc::class,'get_subjects']);
Route::post("/login",[Abc::class,'login']);
Route::post("/submitSchoolQna",[Abc::class,'submitSchoolQna']);
Route::post("/submitSchoolForum",[Abc::class,'submitSchoolForum']);
Route::get("/search_school_questions/{data}",[Abc::class,'search_school_questions']);
Route::get("/school_search_forum_questions/{data}",[Abc::class,'school_search_forum_questions']);
Route::get("/get_school_qna_single/{qna_id}",[Abc::class,'get_school_qna_single']);
Route::get("/get_school_forum_single/{forum_id}",[Abc::class,'get_school_forum_single']);
Route::post("/submitSchoolForumAnswer/{forum_id}",[Abc::class,'submitSchoolForumAnswer']);
Route::post("/connect_parent",[Abc::class,'connect_parent']);
Route::get("/get_parent/{parent_id}",[Abc::class,'get_parent']);
Route::get("/subject_stream/{student_id}/{subject_id}",[Abc::class,'subject_stream']);





