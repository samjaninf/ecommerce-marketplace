<?php namespace Koolbeans\Http\Controllers\Admin;

use Koolbeans\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
