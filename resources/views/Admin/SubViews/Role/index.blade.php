@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    @include('Admin.Components.datatable-css')
@endsection

@section('content')
    <section id="basic-datatable">
        <a href="{{ route('admin.roles.showAdd') }}" class="btn btn-relief-primary mb-2">
            <span>إضافة</span>
            <i data-feather="plus" class="me-25"></i>
        </a>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأسم</th>
                                    <th>الصلاحيات</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr id="sid{{ $role->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $role->id }}</span>
                                        </td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $permission)
                                                <span
                                                    class="badge rounded-pill badge-light-info">{{ $permission->name_ar }}</span>
                                            @endforeach
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $role->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            @include('Admin.Components.edit-button', [
                                                'item' => $role,
                                                'table' => 'roles',
                                            ])
                                            @include('Admin.Components.delete-button', [
                                                'item' => $role,
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    @include('Admin.Components.datatable-js')
@endsection

@section('page-script')
    @include('Admin.Components.ajax-delete')
@endsection
