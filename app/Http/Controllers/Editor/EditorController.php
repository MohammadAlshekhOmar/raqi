<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Editor\EditorRequestEdit;
use App\Services\EditorService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Helpers\MyHelper;

class EditorController extends Controller
{
    public function showEdit(Request $request, EditorService $editorService)
    {
        $page = 'تعديل مدير';
        $editRoute = route('editor.editors.edit');

        $editor = $editorService->find($request->id);
        return view('Editor.SubViews.Editor.edit', [
            'editor' => $editor,
            'page' => $page,
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
