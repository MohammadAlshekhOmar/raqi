@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    @include('Admin.Components.datatable-css')
@endsection

@section('content')
    <section id="basic-datatable">
        <a href="{{ route('admin.users.showAdd') }}" class="btn btn-relief-primary mb-2">
            إضافة
            <i data-feather="plus" class="me-25"></i></a>
        <a href="{{ route('admin.users.export') }}" class="btn btn-relief-primary mb-2">
            تصدير
            <i data-feather="download" class="me-25"></i></a>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody id="add-row">
                                @foreach ($users as $user)
                                    <tr id="sid{{ $user->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $user->id }}</span>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @include('Admin.Components.change-status-button', [
                                                'item' => $user,
                                            ])
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $user->created_at }}</span>
                                        </td>
                                        <td>
                                            @include('Admin.Components.show-button', [
                                                'item' => $user,
                                                'table' => 'users',
                                            ])
                                            @include('Admin.Components.edit-button', [
                                                'item' => $user,
                                                'table' => 'users',
                                            ])
                                            @include('Admin.Components.delete-button', [
                                                'item' => $user,
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
    @include('Admin.Components.change-status')
    @include('Admin.Components.ajax-delete')
@endsection
