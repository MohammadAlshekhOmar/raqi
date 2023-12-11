@extends('layouts.contentLayoutMaster')

@section('title', $page)

@section('vendor-style')
    <link href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}" rel="stylesheet">
@endsection

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
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">الأسم</label>
                                <input type="text" class="form-control" name="name" placeholder="أدخل الأسم"
                                    value="{{ $user->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="text" name="email" class="form-control dt-email"
                                    placeholder="أدخل البريد الإلكتروني" value="{{ $user->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">رقم الهاتف المحمول</label>
                                <input type="number" name="phone" class="form-control"
                                    placeholder="أدخل رقم الهاتف المحمول" value="{{ $user->phone }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">الصورة</label>
                                <input type="file" class="form-control" id="image" name="image" />
                            </div>
                            <img id="show_image" src="{{ $user->image }}" style="width:200px;height:200px;margin:20px;"
                                alt="user image" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">تاريخ الميلاد</label>
                                <input type="date" name="birthday" class="form-control" value="{{ $user->birthday }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label class="form-label">الجنس</label>
                                <select class="form-control" name="gender">
                                    <option value="" disabled>تحديد الجنس</option>
                                    <option {{ $user->gender == App\Enums\GenderEnum::Male->value ? 'selected' : null }}
                                        value="{{ App\Enums\GenderEnum::Male->value }}">ذكر</option>
                                    <option {{ $user->gender == App\Enums\GenderEnum::Female->value ? 'selected' : null }}
                                        value="{{ App\Enums\GenderEnum::Female->value }}">انثى</option>
                                </select>
                            </div>
                        </div>
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

    <script src="{{ asset(mix('js/scripts/forms/form-repeater.js')) }}"></script>

    <script>
        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                show_image.src = URL.createObjectURL(file)
            }
        }
    </script>

    @include('Admin.Components.ajax-edit')
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/repeater/jquery.repeater.min.js')) }}"></script>
@endsection
