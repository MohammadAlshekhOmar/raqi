<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleRequest;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use App\Http\Requests\Admin\EditArticleRequest;
use App\Services\EditorService;

class ArticleController extends Controller
{
    public function index(ArticleService $articleService, EditorService $editorService)
    {
        $articles = $articleService->all();
        $editors = $editorService->all();
        $title = __('locale.articles');
        $model = 'Article';
        $findRoute = route('admin.articles.find');
        $addRoute = route('admin.articles.add');
        $editRoute = route('admin.articles.edit');
        $deleteRoute = route('admin.articles.delete');

        return view('Admin.SubViews.Article.index', [
            'articles' => $articles,
            'editors' => $editors,
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
