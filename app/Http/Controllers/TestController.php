<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Member;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function dev()
    {
        $items = Member::all();

        return view("test", compact("items"));
    }

}
