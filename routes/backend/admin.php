<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TestController;
use App\Http\Controllers\Backend\SkillController;
use App\Http\Controllers\Backend\CurrencyController;
use App\Http\Controllers\Backend\SitesettingsController;
use App\Http\Controllers\Backend\SpskillController;
use App\Http\Controllers\Backend\ServiceproviderController;
use App\Http\Controllers\Backend\AdsController;
/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/administrator/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('test', [TestController::class, 'index'])->name('test');


Route::group(['namespace' => 'Skill'], function () {
	Route::get('skill', [SkillController::class, 'index'])->name('skill');           
	Route::get('skill/create', [SkillController::class, 'create'])->name('skill.create');

	Route::post('skill/create', [SkillController::class, 'store'])->name('skill.store');

	Route::get('skill/edit/{id}', [SkillController::class, 'edit'])->name('skill.edit');

	Route::delete('skill/destroy/{id}', [SkillController::class, 'destroy'])->name('skill.destroy');
});


Route::group(['namespace' => 'Currency'], function () {
	Route::get('currency', [CurrencyController::class, 'index'])->name('currency');           
	Route::get('currency/create', [CurrencyController::class, 'create'])->name('currency.create');

	Route::post('currency/create', [CurrencyController::class, 'store'])->name('currency.store');

	Route::get('currency/edit/{id}', [CurrencyController::class, 'edit'])->name('currency.edit');

	Route::delete('currency/destroy/{id}', [CurrencyController::class, 'destroy'])->name('currency.destroy');
});


Route::group(['namespace' => 'Sitesettings'], function () {	
	Route::get('sitesettings/create', [SitesettingsController::class, 'create'])->name('sitesettings.create');

	Route::post('sitesettings/create', [SitesettingsController::class, 'store'])->name('sitesettings.store');	
});

Route::group(['namespace' => 'Spskill'], function () {
	Route::get('spskill', [SpskillController::class, 'index'])->name('spskill');           
	Route::get('spskill/create/{userid}', [SpskillController::class, 'create'])->name('spskill.create');

	Route::post('spskill/store', [SpskillController::class, 'store'])->name('spskill.store');

	Route::get('spskill/edit/{id}', [SpskillController::class, 'edit'])->name('spskill.edit');

	Route::delete('spskill/destroy/{id}', [SpskillController::class, 'destroy'])->name('spskill.destroy');
	
	Route::get('spskill/spremainingSkill', [SpskillController::class, 'spremainingSkill'])->name('spskill.spremainingSkill');
});

Route::group(['namespace' => 'Serviceprovider'], function () {

	Route::get('serviceprovider', [ServiceproviderController::class, 'index'])->name('serviceprovider');           
	Route::get('serviceprovider/create', [ServiceproviderController::class, 'create'])->name('serviceprovider.create');

	Route::post('serviceprovider/create', [ServiceproviderController::class, 'store'])->name('serviceprovider.store');

	Route::get('serviceprovider/edit/{id}', [ServiceproviderController::class, 'edit'])->name('serviceprovider.edit');

	Route::delete('serviceprovider/destroy/{id}', [ServiceproviderController::class, 'destroy'])->name('serviceprovider.destroy');
	
});

Route::group(['namespace' => 'Ads'], function () {

	Route::get('ads', [AdsController::class, 'index'])->name('ads');           
	Route::get('ads/create', [AdsController::class, 'create'])->name('ads.create');

	Route::post('ads/create', [AdsController::class, 'store'])->name('ads.store');

	Route::get('ads/edit/{id}', [AdsController::class, 'edit'])->name('ads.edit');

	Route::delete('ads/destroy/{id}', [AdsController::class, 'destroy'])->name('ads.destroy');
	
});