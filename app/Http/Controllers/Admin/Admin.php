<?php

namespace App\Http\Controllers\Admin;

use App\Organisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Admin extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $organisations = Organisation::where('role', '>', 0)
            ->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.organisation.index')->with('organisations', $organisations);
    }
}