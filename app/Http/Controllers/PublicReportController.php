<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Bureau;

class PublicReportController extends Controller
{
    public function create()
    {
        // 1. Fetch all categories and bureaus from the database
        $categories = Category::all();
        $bureaus = Bureau::all();

        // 2. Send them to a view (which we will create next)
        return view('reports.create', [
            'categories' => $categories,
            'bureaus' => $bureaus
        ]);
    }
}