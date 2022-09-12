<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use App\Models\Document;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // dd(Directory::where('parent', null)->get()->pluck('title')->toArray());
        // dd(Document::find(1)->directory->title, Document::find(1)->directory_id, Document::find(1)->toArray(), Directory::find(1)->toArray());
        return view('welcome', [
            'document' => Document::find(1),
        ]);
    }
}
