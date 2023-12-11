<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditorRequest;
use App\Http\Requests\Admin\EditorRequestEdit;
use App\Services\EditorService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Helpers\MyHelper;

class EditorController extends Controller
{
    public function index(EditorService $editorService)
    {
        $editors = $editorService->all();
        $title = __('locale.editors');
        $model = 'Editor';
        $deleteRoute = route('admin.editors.delete');

        return view('Admin.SubViews.Editor.index', [
            'editors' => $editors,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function showAdd()
    {
        $page = 'إضافة مدير';
        $menu = __('locale.editors');
        $menu_link = route('admin.editors.index');
        $addRoute = route('admin.editors.add');

        return view('Admin.SubViews.Editor.add', [
            'roles' => Role::where('guard_name', 'editor')->get(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link,
            'addRoute' => $addRoute,
        ]);
    }

    public function add(EditorRequest $request, EditorService $editorService)
    {
        $editor = $editorService->add($request->all());
        if($editor) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $editor);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, EditorService $editorService)
    {
        $page = 'تعديل مدير';
        $menu = __('locale.editors');
        $menu_link = route('admin.editors.index');
        $editRoute = route('admin.editors.edit');

        $editor = $editorService->find($request->id);
        return view('Admin.SubViews.Editor.edit', [
            'editor' => $editor,
            'roles' => Role::where('guard_name', 'editor')->get(),
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link,
            'editRoute' => $editRoute,
        ]);
    }

    public function edit(EditorRequestEdit $request, EditorService $editorService)
    {
        $editor = $editorService->edit($request->all());
        if ($editor) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $editor);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
