@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    @include('Admin.Components.datatable-css')
@endsection

@section('content')
    <section id="basic-datatable">
        <a href="{{ route('admin.editors.showAdd') }}" class="btn btn-relief-primary mb-2">
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
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($editors as $editor)
                                    <tr id="sid{{ $editor->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $editor->id }}</span>
                                        </td>
                                        <td>{{ $editor->name }}</td>
                                        <td>{{ $editor->email }}</td>
                                        <td>{{ $editor->phone }}</td>
                                        <td>
                                            @if ($editor->roles()?->count())
                                                {{ $editor->roles()?->first()?->name }}
                                            @else
                                                لا يوجد
                                            @endif
                                        </td>
                                        <td>
                                            @include('Admin.Components.change-status-button', [
                                                'item' => $editor,
                                            ])
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $editor->created_at }}</span>
                                        </td>
                                        <td>
                                            @include('Admin.Components.edit-button', [
                                                'item' => $editor,
                                                'table' => 'editors',
                                            ])
                                            @include('Admin.Components.delete-button', [
                                                'item' => $editor
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
