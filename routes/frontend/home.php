<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;

use App\Http\Controllers\Frontend\User\SpskillController;
use App\Http\Controllers\Frontend\User\SpavailabilityController;
use App\Http\Controllers\Frontend\User\PhotogallaryController;
use App\Http\Controllers\Frontend\UserdetailsController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\User\MessageController;
use App\Http\Controllers\Frontend\User\FeedbackController;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/search', [HomeController::class, 'search'])->name('search'); // vue route
Route::get('/about-us', [HomeController::class, 'about'])->name('about'); // vue route
Route::get('/service', [HomeController::class, 'service'])->name('service'); // vue route

Route::get('/getAdsBanner/{page}/{position}', [HomeController::class, 'getAdsBanner'])->name('getbanner'); // vue route

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');

//User Details Routing
Route::get('profile/removeConfirmationCode', [ProfileController::class, 'removeConfirmationCode'])->name('profile.removeConfirmationCode');
Route::get('profile/{slug}', [UserdetailsController::class, 'index'])->name('profile.slug');
Route::get('feedback/ajaxfeedback/{slug}', [FeedbackController::class, 'ajaxfeedback'])->name('feedback.ajaxfeedback');

Route::get('/users', 'HomeController@users')->name('users');


Route::get('/notification', [HomeController::class, 'notification'])->name('notification');

//End of User Details Routing

//Route::get('ajax-pagination','AccountController@index')->name('ajax.pagination');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', [AccountController::class, 'index'])->name('account');
       
        Route::get('ajax-pagination', [AccountController::class, 'index'])->name('ajax.pagination');
        

        /*
         * User skill Specific
         */

        Route::get('spskill', [SpskillController::class, 'index'])->name('spskill');
        Route::get('spskill/create', [SpskillController::class, 'create'])->name('spskill.create');
        Route::get('spskill/edit/{id}', [SpskillController::class, 'create'])->name('spskill.edit');
        
        
        Route::post('spskill/create', [SpskillController::class, 'store'])->name('spskill.store');
        Route::post('spskill/delete/{id}', [SpskillController::class, 'delete'])->name('spskill.delete');

        Route::get('feedbacks', [UserdetailsController::class, 'feedbacks'])->name('feedbacks');

        Route::get('availability/create', [SpavailabilityController::class, 'create'])->name('availability.create');

        Route::post('availability/create', [SpavailabilityController::class, 'store'])->name('availability.create');
        

        // Photo Gallery Routing
        Route::get('photogallary', [PhotogallaryController::class, 'index'])->name('photogallary');
        Route::get('photogallary/create', [PhotogallaryController::class, 'create'])->name('photogallary.create');
        Route::get('photogallary/edit/{id}', [PhotogallaryController::class, 'create'])->name('photogallary.edit');
        Route::post('photogallary/create', [PhotogallaryController::class, 'store'])->name('photogallary.store');
        Route::post('photogallary/delete/{id}', [PhotogallaryController::class, 'delete'])->name('photogallary.delete');

        // End of Photo Gallery Routing

        //Feedback
        Route::get('feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::get('feedback/{slug}', [FeedbackController::class, 'create'])->name('feedback');
        Route::post('feedback/create', [FeedbackController::class, 'store'])->name('feedback.store');
        //End feedback

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        
        Route::patch('profile/AjaxValidation', [ProfileController::class, 'AjaxValidation'])->name('profile.AjaxValidation');

        Route::post('profile/checkSlug', [ProfileController::class, 'checkSlug'])->name('profile.checkSlug');

        Route::post('profile/switchuser', [ProfileController::class, 'switchuser'])->name('profile.switchuser'); /// cuatom by bindiya

        Route::get('/AddToFav/{user_id}', [ProfileController::class, 'AddToFav'])->name('profile.AddToFav');
        
        Route::post('/favsp', [ProfileController::class, 'favsp'])->name('profile.favsp');

        Route::get('/getUsers', 'MessageController@getUsers')->name('getUsers');
        Route::get('/SearchUsers/{search}', 'MessageController@SearchUsers')->name('SearchUsers');
        
        Route::get('/inbox', 'MessageController@private')->name('inbox');
        // Route::get('messages', 'MessageController@fetchMessages');
        // Route::post('messages', 'MessageController@sendMessage');

        Route::get('/private-messages/{user}', 'MessageController@privateMessages')->name('privateMessages');
        
        Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage')->name('privateMessages.store');

        Route::get('/private-messages-count/{user2}/{for_user}', 'MessageController@countPrivateMessage')->name('privateMessages.count');
        
        Route::get('/private-messages-read/{user2}/{for_user}', 'MessageController@ReadPrivateMessage')->name('privateMessages.read');
        
        Route::get('/clearchat/{for_user}','MessageController@ClearPrivateMessage')->name('privateMessages.clear');
       
        Route::post('/sendQuickMessage/{user}', 'MessageController@sendQuickMessage')->name('sendQuickMessage.store');
        Route::get('message/download/{id}', 'MessageController@download')->name('message.download');
    });
});
