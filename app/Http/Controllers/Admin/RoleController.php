<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(RoleService $roleService)
    {
        $roles = $roleService->all('editor');
        $title = __('locale.roles');
        $model = 'Role';
        $deleteRoute = route('admin.roles.delete');

        return view('Admin.SubViews.Role.index', [
            'roles' => $roles,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function showAdd()
    {
        $page = 'إضافة دور';
        $menu = __('locale.roles');
        $menu_link = route('admin.roles.index');
        $addRoute = route('admin.roles.add');

        $permissions = Permission::where('guard_name', 'editor')->get();
        $permissions = $permissions->groupBy('group');

        return view('Admin.SubViews.Role.add', [
            'permissions' => $permissions,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link,
            'addRoute' => $addRoute,
        ]);
    }

    public function add(RoleRequest $request, RoleService $roleService)
    {
        $role = $roleService->add($request->all());
        if ($role) {
            return MyHelper::responseJSON('تم الإضافة بنجاح', 201, $role);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }

    public function showEdit(Request $request, RoleService $roleService)
    {
        $page = 'تعديل دور';
        $menu = __('locale.roles');
        $menu_link = route('admin.roles.index');
        $editRoute = route('admin.roles.edit');

        $permissions = Permission::where('guard_name', 'editor')->get();
        $permissions = $permissions->groupBy('group');

        $role = $roleService->find($request->id);
        return view('Admin.SubViews.Role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link,
            'editRoute' => $editRoute,
        ]);
    }

    public function edit(RoleRequest $request, RoleService $roleService)
    {
        $role = $roleService->edit($request->all());
        if ($role) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $role);
        } else {
            return MyHelper::responseJSON('لا يمكن حذف الصلاحيات الخاصة بالصلاحيات والأدوار لأنك الأدمن الرئيسي الوحيد هنا', 500);
        }
    }

    public function delete(Request $request, RoleService $roleService)
    {
        $role = $roleService->delete($request->id);
        if ($role) {
            return MyHelper::responseJSON('تم الحذف بنجاح', 200);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
