<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
/**
 * Class DashboardController.
 */
class TestController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {	

    	Breadcrumbs::for('admin.test', function ($trail) {
		    $trail->push(__('strings.new.skill'), route('admin.test'));
		});
        return view('backend.dashboard');
    }
}
