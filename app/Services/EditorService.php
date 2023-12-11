<?php

namespace App\Services;

use App\Models\Editor;
use Illuminate\Support\Facades\DB;

class EditorService
{
    public function all()
    {
        return Editor::withTrashed()->get();
    }

    public function find($id)
    {
        return Editor::withTrashed()->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        $editor = Editor::create($request);
        $editor->addMedia($request['image'])->toMediaCollection('Editor');
        $editor->assignRole($request['role_id']);
        DB::commit();
        return $editor;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $editor = Editor::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $editor->clearMediaCollection('Editor');
            $editor->addMedia($request['image'])->toMediaCollection('Editor');
        }

        if (!isset($request['password'])) {
            unset($request['password']);
        }
        
        $editor->update($request);
        if (isset($request['role_id'])) {
            $editor->roles()->detach();
            $editor->assignRole($request['role_id']);
        }
        DB::commit();
        return $editor;
    }
}
