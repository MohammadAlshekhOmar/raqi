@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    @include('Admin.Components.datatable-css')
@endsection

@section('content')
    <section id="basic-datatable">
        <a href="{{ route('admin.admins.showAdd') }}" class="btn btn-relief-primary mb-2">
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
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr id="sid{{ $admin->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $admin->id }}</span>
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        @if ($admin->id != 1)
                                            <td>
                                                @include('Admin.Components.change-status-button', [
                                                    'item' => $admin,
                                                ])
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $admin->created_at }}</span>
                                        </td>
                                        <td>
                                            @include('Admin.Components.edit-button', [
                                                'item' => $admin,
                                                'table' => 'admins',
                                            ])
                                            @if ($admin->id != 1)
                                                @include('Admin.Components.delete-button', [
                                                    'item' => $admin
                                                ])
                                            @endif
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
