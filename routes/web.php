<?php

namespace App\Http\Controllers;

use App\Http\Controllers\guest_controller\ProfileGuest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('guest.home');
// });

Route::get('/', 'GuestController@index');
Route::post('guest/category', 'GuestController@courseCategories');

Route::get('/store', 'GuestController@store');
Route::get('/about', 'GuestController@about');
Route::get('/blog', 'GuestController@blog');

//COURSE GUEST
Route::get('course', 'guest_controller\CourseGuest@index');
Route::get('course/search', 'guest_controller\CourseGuest@SearchCourse');
Route::post('course/category', 'guest_controller\CourseGuest@getFilterByKat');
Route::get('course/info/testing', 'guest_controller\CourseGuest@infoCourse');
Route::get('course/info/{any}', 'guest_controller\CourseGuest@infoCourse');
Route::post('course/detail/addkomen', 'guest_controller\CourseGuest@addkomen');
//END COURSE GUEST

//EVENT GUEST
Route::get('event', 'guest_controller\EventGuest@index');
Route::get('event/search', 'guest_controller\EventGuest@searchEvent');
Route::get('event/detail', 'guest_controller\EventGuest@detailEvent');
Route::get('event/detail/{any}', 'guest_controller\EventGuest@detailEvent');
//END EVENT GUEST

//EBOOK GUEST
Route::get('ebooks', 'guest_controller\EbookGuest@index');
// Route::get('ebooks/detail', 'guest_controller\EbookGuest@detailEbook');
Route::get('ebooks/detail/{any}', 'guest_controller\EbookGuest@detailEbook');
Route::get('ebooks/view/{any}', 'guest_controller\EbookGuest@view_my_book');
//END EBOOK GUEST

//AUTH
Route::get('login', 'AuthController@login');
Route::post('login/authentication', 'AuthController@login_authentication');
Route::get('register', 'AuthController@register');
Route::post('register/store', 'AuthController@store');
Route::get('logout', 'AuthController@logout');
//END AUTH

//FORGOT PASS
Route::get('forgot-password', 'AuthController@forgot_password');
Route::post('forgotPassword', 'AuthController@forgot_password_send');
Route::get('reset-password', 'AuthController@forgot_password_reset');
Route::post('resetPassword', 'AuthController@resetPassword');
//END FORGOT PASS

//VERIFICATION ACCOUNT
Route::get('verification/confirm', 'AuthController@verifAccount');

//VERIFICATION SERTIF
Route::get('verifikasi/{id}', 'guest_controller\SertificateGuest@verifSertif');

// 1 Admin
Route::middleware(['usersession:1'])->group(function () {

    Route::get('blogs', 'BlogController@index');
    Route::post('blogs/store', 'BlogController@store');
    Route::post('blogs/update', 'BlogController@update');
    Route::post('blogs/delete', 'BlogController@delete');

    Route::get('ebook', 'EbookController@index');
    Route::post('ebook/store', 'EbookController@store');
    Route::post('ebook/update', 'EbookController@update');
    Route::post('ebook/delete', 'EbookController@delete');

    Route::get('promo', 'PromoController@index');
    Route::post('promo/store', 'PromoController@store');
    Route::post('promo/update', 'PromoController@update');
    Route::post('promo/delete', 'PromoController@delete');

    Route::get('category', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::post('category/update', 'CategoryController@update');
    Route::post('category/delete', 'CategoryController@delete');

    Route::get('user', 'UserController@index');
    Route::post('user/store', 'UserController@store');
    Route::post('user/update', 'UserController@update');
    Route::post('user/delete', 'UserController@delete');
    Route::post('user/import', 'UserController@importFile');

    Route::get('instructor', 'InstructorController@index');
    Route::post('instructor/accept', 'InstructorController@accept');
    Route::post('instructor/decline', 'InstructorController@decline');

    Route::get('redeem-code/', 'RedeemCodeController@index');
    Route::post('redeem-code/submit', 'RedeemCodeController@submit');
    Route::get('redeem-code/excell/{id}', 'RedeemCodeController@gen_excell');

    // Koperasi Controller
    Route::get('bentuk', 'KoperasiController@index_bentuk');
    Route::post('bentuk/store', 'KoperasiController@store_bentuk');
    Route::post('bentuk/update', 'KoperasiController@update_bentuk');
    Route::post('bentuk/delete', 'KoperasiController@delete_bentuk');

    Route::get('jenis', 'KoperasiController@');
    Route::get('jenis/store', 'KoperasiController@');
    Route::get('jenis/update', 'KoperasiController@');
    Route::get('jenis/delete', 'KoperasiController@');

    Route::get('kelompok', 'KoperasiController@');
    Route::get('kelompok/store', 'KoperasiController@');
    Route::get('kelompok/update', 'KoperasiController@');
    Route::get('kelompok/delete', 'KoperasiController@');

    Route::get('masalah', 'KoperasiController@');
    Route::get('masalah/store', 'KoperasiController@');
    Route::get('masalah/update', 'KoperasiController@');
    Route::get('masalah/delete', 'KoperasiController@');

    Route::get('sektor', 'KoperasiController@');
    Route::get('sektor/store', 'KoperasiController@');
    Route::get('sektor/update', 'KoperasiController@');
    Route::get('sektor/delete', 'KoperasiController@');
});

//2 INSTRUKTUR
Route::middleware(['usersession:2'])->group(function () {
    // Route::get('profile','guest_controller\ProfileGuest@index');
});

// 3 USER
Route::middleware(['usersession:3,2,1'])->group(function () {
    //COURSE
    Route::get('course/detail/{any}', 'guest_controller\CourseGuest@detailCourse');
    Route::post('course/item/mapping', 'guest_controller\CourseGuest@getMappingCourse');
    Route::post('course/item', 'guest_controller\CourseGuest@getDetailItemCourse');
    Route::post('course/quiz/evaluation', 'guest_controller\CourseGuest@QuizEvaluation');
    //END COURSE
    
    //FINAL EXAM
    Route::get('course/final-exam/{id}/{code}', 'guest_controller\CourseGuest@finalExam');
    Route::post('/course/final-exam/evaluation/', 'guest_controller\CourseGuest@FinalExamEvaliation');
    Route::post('/course/final-exam/validasi-code', 'guest_controller\CourseGuest@ValidasiCode');
    //END FINAL EXAM

    // PROFILE
    Route::get('profile', [ProfileGuest::class, 'profile']);
    Route::get('/profile/overview', [ProfileGuest::class, 'overview']);
    Route::get('profile/myebook', [ProfileGuest::class, 'ebook']);
    Route::get('profile/academic', [ProfileGuest::class, 'academic']);
    Route::get('profile/document', [ProfileGuest::class, 'document']);
    Route::get('profile/mycourses', [ProfileGuest::class, 'mycourses']);
    Route::get('profile/myevents', [ProfileGuest::class, 'myevents']);
    Route::get('profile/myvoucher', 'guest_controller\ProfileGuest@vouchers');
    Route::post('profile/update', [ProfileGuest::class, 'update_profile']);
    Route::get('profile/mysertificate', [ProfileGuest::class, 'mysertificate']);
    Route::post('/profile/academic/change', [ProfileGuest::class, 'academic_change']);
    Route::post('/profile/document/change', [ProfileGuest::class, 'doc_up']);
    Route::post('/update-sertif', [ProfileGuest::class, 'update_sertif']);
    Route::get('apply_instructor', 'InstructorController@apply_instructor');
    // END PROFILE

    // VOUCHER
    Route::get('vouchers', 'guest_controller\PromoGuest@index');
    Route::post('voucher/store', 'guest_controller\PromoGuest@claimedVoucher');

    Route::post('voucher/trial-code', 'RedeemCodeController@redeem_course_using_code');


    //PAYMENT & CART
    Route::get('checkouts', 'guest_controller\CheckoutGuest@index');
    Route::post('checkout', 'guest_controller\CheckoutGuest@index');
    Route::get('add/order', 'guest_controller\CheckoutGuest@addOrder');
    Route::post('purchase', 'guest_controller\CheckoutGuest@purchase');
    Route::get('delete/order', 'guest_controller\CheckoutGuest@deleteOrder');
    Route::post('delete/pay', 'guest_controller\CheckoutGuest@DeleteTrans');
    Route::post('check_payment_status', 'guest_controller\CheckoutGuest@check_status');
    Route::post('get_order_id', 'guest_controller\CheckoutGuest@get_order_id');
    //END PAYMENT & CART

    //API XENDIT
    Route::post('/payment/get', 'guest_controller\CheckoutGuest@get_payment');
    Route::get('check_payment_status/{any}', 'guest_controller\CheckoutGuest@check_payment_status');

    Route::get('/buyback', 'guest_controller\CourseGuest@buyBack');
});

Route::middleware(['usersession:2,1'])->group(function () {
    Route::get('dashboard', 'DashboardController@admin_index');

    Route::get('courses', 'CourseController@index');
    Route::get('courses/add', 'CourseController@add_course');
    Route::get('courses/add_materi/{id}', 'CourseController@add_materi');
    Route::get('courses/delete_materi/{id}', 'CourseController@delete_materi');
    Route::get('courses/add_quiz/{id}/{no_quiz}', 'CourseController@add_quiz')->name('add_quiz');
    Route::get('courses/delete_quiz/{id}', 'CourseController@delete_quiz');
    Route::get('courses/add_question/{id}/{index}', 'CourseController@add_question')->name('add_question');
    Route::get('courses/delete_question/{id}', 'CourseController@delete_question');
    Route::post('courses/store', 'CourseController@store');
    Route::post('courses/edit', 'CourseController@update_course'); // open page update
    Route::get('courses/get/{id}', 'CourseController@deskripsi_get'); // get desc
    Route::get('courses/get_course_item/{id}', 'CourseController@get_course_item'); // get materi / quiz
    Route::post('courses/get_quiz', 'CourseController@send_question'); //send to another page
    Route::post('courses/update', 'CourseController@update'); // update kursus
    Route::post('courses/delete', 'CourseController@delete');
    Route::get('courses/lihat_peserta', 'CourseController@index_lihat_peserta');
    Route::get('courses/laporan_course', 'CourseController@laporan_course');

    Route::get('courses/invite', 'CourseController@invite');
    Route::post('courses/invite_individu', 'CourseController@invite_individu');
    Route::post('courses/invite_batch', 'CourseController@invite_batch');
    
    //Final Exam
    Route::get('courses/add-final', 'FinalExamController@index');
    Route::post('courses/add-final/store', 'FinalExamController@store');
    Route::post('courses/add-final/edit', 'FinalExamController@update_course');
    Route::post('courses/add-final/update', 'FinalExamController@update');
    Route::get('courses/add-final/add_quiz/{id}/{no_quiz}', 'FinalExamController@add_quiz');
    Route::get('courses/add-final/add_question/{id}/{index}', 'CourseController@add_question');
    Route::get('courses/add-final/get_course_item/{id}', 'FinalExamController@get_course_item'); // get materi / quiz
    Route::post('courses/add-final/get_quiz', 'CourseController@send_question'); //send to another page

    Route::get('events', 'EventController@index');
    Route::get('events/get/{id}', 'EventController@deskripsi_get');
    Route::post('events/add', 'EventController@store');
    Route::post('events/update', 'EventController@update');
    Route::post('events/delete', 'EventController@delete');
    Route::get('events/lihat_peserta', 'EventController@index_lihat_peserta');
    Route::get('events/laporan_event', 'EventController@laporan_event');
});
