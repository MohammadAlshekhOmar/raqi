<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Editor\ArticleRequest;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Http\Requests\Editor\EditArticleRequest;

class ArticleController extends Controller
{
    public function index(ArticleService $articleService)
    {
        $articles = $articleService->all(auth('editor')->user()->id);
        $title = __('locale.articles');
        $model = 'Article';
        $findRoute = route('editor.articles.find');
        $addRoute = route('editor.articles.add');
        $editRoute = route('editor.articles.edit');
        $deleteRoute = route('editor.articles.delete');

        return view('Editor.SubViews.Article.index', [
            'articles' => $articles,
            'title' => $title,
            'model' => $model,
            'findRoute' => $findRoute,
            'addRoute' => $addRoute,
            'editRoute' => $editRoute,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function find(Request $request, ArticleService $articleService)
    {
        $article = $articleService->find($request->id);
        if ($article) {
            return MyHelper::responseJSON('تم جلب المعلومات بنجاح', 200, $article);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function add(ArticleRequest $request, ArticleService $articleService)
    {
        $article = $articleService->add($request->all());
        if ($article) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $article);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function edit(EditArticleRequest $request, ArticleService $articleService)
    {
        $article = $articleService->edit($request->all());
        if ($article) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $article);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
