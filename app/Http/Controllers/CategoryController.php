<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function showAllCategories()
    {
       $catlist = Category::all();

       return view('categories')->with('catlist',$catlist);
    }
}
