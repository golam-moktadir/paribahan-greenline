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



    public function create()
    {
        $cities = collect([
            ['city_id' => 1, 'city_name' => 'New York'],
            ['city_id' => 2, 'city_name' => 'Los Angeles'],
            ['city_id' => 3, 'city_name' => 'Chicago'],
            ['city_id' => 4, 'city_name' => 'Houston'],
            ['city_id' => 5, 'city_name' => 'Phoenix'],
        ])->map(function ($city) {
            return (object) $city;
        });

        $employees = collect([
            ['employee_id' => 1, 'employee_name' => 'New York'],
            ['employee_id' => 2, 'employee_name' => 'Los Angeles'],
            ['employee_id' => 3, 'employee_name' => 'Chicago'],
            ['employee_id' => 4, 'employee_name' => 'Houston'],
            ['employee_id' => 5, 'employee_name' => 'Phoenix'],
        ])->map(function ($employee) {
            return (object) $employee;
        });
        

        $booths = collect([
            ['booth_id' => 1, 'booth_name' => 'Booth A'],
            ['booth_id' => 2, 'booth_name' => 'Booth B'],
            ['booth_id' => 3, 'booth_name' => 'Booth C'],
            ['booth_id' => 4, 'booth_name' => 'Booth D'],
            ['booth_id' => 5, 'booth_name' => 'Booth E'],
        ])->map(function ($booth) {
            return (object) $booth;
        });
        

        return view("dev.create", compact("cities","employees", "booths"));
    }


}
