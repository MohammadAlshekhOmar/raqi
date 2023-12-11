<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function all($withTrashed = 1)
    {
        if ($withTrashed) {
            return Article::with(['media'])->withTrashed()->get();
        } else {
            return Article::with(['media'])->paginate(8);
        }
    }

    public function getByUser($user_id)
    {
        return Article::with('media')->where('user_id', $user_id)->get();
    }

    public function find($id)
    {
        $article = Article::withTrashed()->with(['media', 'editor'])->find($id);
        $article->ar = [
            'title' => $article->translate('ar')->title,
            'text' => $article->translate('ar')->text
        ];
        $article->en = [
            'title' => $article->translate('en')->title,
            'text' => $article->translate('en')->text
        ];
        $article->image = $article->image;
        return $article;
    }

    public function add($request)
    {
        $article = Article::create($request);
        $article->addMedia($request['image'])->toMediaCollection('Article');
        $article = Article::with(['media', 'editor'])->find($article->id);
        $article->image = $article->image;
        return $article;
    }

    public function edit($request)
    {
        $article = Article::withTrashed()->with(['media'])->find($request['id']);

        DB::beginTransaction();
        if (isset($request['image'])) {
            $article->clearMediaCollection('Article');
            $article->addMedia($request['image'])->toMediaCollection('Article');
        }
        $article->update($request);
        $article = Article::with(['media', 'editor'])->find($article->id);
        $article->image = $article->image;
        DB::commit();
        return $article;
    }
}
