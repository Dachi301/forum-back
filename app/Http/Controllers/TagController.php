<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index () {
        $tags = Tag::all();

        return response()->json($tags);
    }
}
