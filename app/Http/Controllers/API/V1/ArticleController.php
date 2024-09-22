<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Get All Article
    public function index()
    {
        // Get The Latest Articles
        $articles = Article::latest('publish_date')->get();

        if ($articles->isEmpty()) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Article Empty.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'List Articles',
            'data' => $articles->map(function($article) {
                return [
                    'title' => $article->title,
                    'content' => $article->content,
                    'publish_date' => $article->publish_date
                ];
            })
        ], Response::HTTP_OK);
    }

    // Store Article
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        try {
            $article = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'publish_date' => Carbon::create($request->publish_date)->toDateString()
            ]);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Store Article Success.',
                'data' => $article
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Store Article Error : ' . $e->getMessage());

            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Store Article Failed!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
