<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index()
    {
        return view('site.home.index');
    }

	public function admin()
	{
		return view('admin.home.index');
	}
}
