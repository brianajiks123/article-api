<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'message' => 'List Articles',
            'data' => Article::latest()->get()
        ]);
    }
}
