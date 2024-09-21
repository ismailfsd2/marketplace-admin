<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends InitController
{
    public function index()
    {
        $this->data['page_title'] = "Dashboard";

        return view('dashboard', $this->data);

    }
}
