<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();

        return response()->json($classes);
    }
}