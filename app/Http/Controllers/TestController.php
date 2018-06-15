<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function getUserAt()
    {
        $user = ['admin','cyt','aaa'];

        return response()->json($user);
    }
}
