<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function all(ArticleService $articleService)
    {
        $articles = $articleService->all(0);
        if ($articles) {
            $articles = ArticleResource::collection($articles);
            return MyHelper::responseJSON(__('api.articleExists'), 200, $articles);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
