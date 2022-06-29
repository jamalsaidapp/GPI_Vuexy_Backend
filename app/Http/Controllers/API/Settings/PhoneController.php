<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function index()
    {
        return Phone::withTrashed()->get();
    }
}
