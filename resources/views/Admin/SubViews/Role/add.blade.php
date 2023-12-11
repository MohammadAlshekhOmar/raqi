@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('content')

    <div class="row breadcrumbs-top mb-2">
        <div class="col-12">
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cp') }}">الرئيسية</a>
                    </li>
                    @if (isset($menu))
                        <li class="breadcrumb-item"><a href="{{ $menu_link }}">{{ $menu }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active">{{ $page }}
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form class="add-new-record modal-content pt-0" id="frmSubmit">
                @csrf
                <input type="hidden" name="guard_name" value="admin">
                <div class="modal-header" style="display:grid;">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="row">
                        <div class="mb-4">
                            <label class="form-label">الأسم</label>
                            <input type="text" class="form-control" name="name" placeholder="أدخل الأسم" />
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($permissions as $group => $permission)
                            <hr>
                            <h2 class="mb-2">{{ $group }}</h2>
                            @foreach ($permission as $perm)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                        <input class="form-check-input" type="checkbox" value="{{ $perm->id }}"
                                            name="permissions[]" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $perm->name_ar }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="padding:10px;display:flex;flex-direction:row-reverse;">
                    <button type="submit" class="btn btn-relief-primary submitFrom">
                        <span>حفظ</span>
                        <i data-feather="check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-script')
    @include('Admin.Components.ajax-add')
@endsection
