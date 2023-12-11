@extends('layouts.contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    @include('Admin.Components.datatable-css')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
    <section id="basic-datatable">
        <button type="button" class="btn btn-relief-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
            <span>إضافة</span>
            <i data-feather="plus" class="me-25"></i>
        </button>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-head-custom table-checkable" id="dtTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الصورة</th>
                                    <th>المحرر</th>
                                    <th>العنوان</th>
                                    <th>النص</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>النشاط</th>
                                </tr>
                            </thead>
                            <tbody id="add-row">
                                @foreach ($articles as $article)
                                    <tr id="sid{{ $article->id }}">
                                        <td><span class="badge rounded-pill badge-light-primary">{{ $article->id }}</span>
                                        </td>
                                        <td><img src="{{ $article->image }}" style="width:100px;height:100px;"
                                            alt="article image"></td>
                                        <td>{{ $article->editor?->name }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->text }}</td>
                                        <td>
                                            @include('Admin.Components.change-status-button', [
                                                'item' => $article,
                                            ])
                                        </td>
                                        <td><span
                                                class="badge rounded-pill badge-light-secondary">{{ $article->created_at }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm" type="button" data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-bs-toggle="tooltip"
                                                data-bs-animation="false" data-bs-original-title="تعديل" title="تعديل"
                                                id="edit-button" data-id="{{ $article->id }}">
                                                <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                                    height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </button>
                                            @include('Admin.Components.delete-button', [
                                                'item' => $article,
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

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content pt-0" id="addForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">إضافة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach (Config::get('translatable.locales') as $locale)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : null }}"
                                                id="{{ $locale }}-tab-add" data-bs-toggle="tab"
                                                href="#{{ $locale }}-add" aria-controls="{{ $locale }}-add"
                                                role="tab" aria-selected="true"><i data-feather="flag"></i>
                                                {{ Str::upper($locale) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach (Config::get('translatable.locales') as $locale)
                                        <div class="tab-pane {{ $loop->first ? 'active' : null }}"
                                            id="{{ $locale }}-add" aria-labelledby="{{ $locale }}-tab-add"
                                            role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label class="form-label">العنوان</label>
                                                        <input type="text" id="title_{{ $locale }}"
                                                            class="form-control" name="{{ $locale }}[title]"
                                                            placeholder="أدخل العنوان" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label class="form-label">النص</label>
                                                        <textarea class="form-control" id="text_{{ $locale }}" name="{{ $locale }}[text]" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">المحررين</label>
                                                <select class="select2 form-control" name="editor_id">
                                                    <option value="" disabled>أختر المحرر</option>
                                                    @foreach ($editors as $editor)
                                                        <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">الصورة</label>
                                                <input type="file" class="form-control" id="image" name="image" />
                                            </div>
                                            <img id="show_image" src="#" style="display:none;width:150px;height:150px;"
                                                alt="article image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-relief-secondary" data-bs-dismiss="modal">
                            <span>إلغاء</span>
                            <i data-feather="x"></i>
                        </button>
                        <button type="submit" class="btn btn-relief-primary submitFrom">
                            <span>حفظ</span>
                            <i data-feather="check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content pt-0" id="editForm">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">تعديل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach (Config::get('translatable.locales') as $locale)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : null }}"
                                                id="{{ $locale }}-tab-edit" data-bs-toggle="tab"
                                                href="#{{ $locale }}-edit"
                                                aria-controls="{{ $locale }}-edit" role="tab"
                                                aria-selected="true"><i data-feather="flag"></i>
                                                {{ Str::upper($locale) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach (Config::get('translatable.locales') as $locale)
                                        <div class="tab-pane {{ $loop->first ? 'active' : null }}"
                                            id="{{ $locale }}-edit" aria-labelledby="{{ $locale }}-tab-edit"
                                            role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label class="form-label">العنوان</label>
                                                        <input type="text" id="title_{{ $locale }}"
                                                            class="form-control" name="{{ $locale }}[title]"
                                                            placeholder="أدخل العنوان" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-1">
                                                        <label class="form-label">النص</label>
                                                        <textarea class="form-control" id="text_{{ $locale }}" name="{{ $locale }}[text]" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">المحررين</label>
                                                <select class="select2 form-control" name="editor_id">
                                                    <option value="" disabled>أختر المحرر</option>
                                                    @foreach ($editors as $editor)
                                                        <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label">الصورة</label>
                                                <input type="file" class="form-control" id="image_edit" name="image" />
                                            </div>
                                            <img id="show_image_edit" src="#" style="width:150px;height:150px;"
                                                alt="article image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-relief-secondary" data-bs-dismiss="modal">
                            <span>إلغاء</span>
                            <i data-feather="x"></i>
                        </button>
                        <button type="submit" class="btn btn-relief-primary submitFrom">
                            <span>تعديل</span>
                            <i data-feather="check"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('vendor-script')
    @include('Admin.Components.datatable-js')
@endsection

@section('page-script')
    <script>
        $(".select2").select2();

        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                document.getElementById("show_image").style.display = "block";
                show_image.src = URL.createObjectURL(file)
            }
        }

        image_edit.onchange = evt => {
            const [file] = image_edit.files
            if (file) {
                document.getElementById("show_image_edit").style.display = "block";
                show_image_edit.src = URL.createObjectURL(file)
            }
        }

        let editButton;
        $("#editModal").on("hidden.bs.modal", function() {
            $("#show_image_edit").attr('src', '#');
			document.getElementById("image_edit").value = "";
            $("[name='editor_id']").select2().val('').trigger("change");
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent()
                });
            });

            var locales = @json($locales);
            locales.forEach(async (locale) => {
                $(`[name='${locale}[title]']`).val('');
                $(`[name='${locale}[text]']`).val('');
            });
        });

        $(document).on("click", "#edit-button", function() {
            editButton = $(this).data('id');
        });

        $('#editModal').on('shown.bs.modal', function() {
            $.ajax({
                url: '{{ $findRoute }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: editButton
                },
                success: function(response, textStatus, xhr) {
                    $("[name='id']").val(response.data.id);
                    $("#show_image_edit").attr('src', response.data.image);
                    $("[name='editor_id']").select2().val(response.data.editor_id).trigger("change");
                    $('.select2').each(function() {
                        $(this).select2({
                            dropdownParent: $(this).parent()
                        });
                    });

                    var locales = @json($locales);
                    locales.forEach(async (locale) => {
                        $(`[name='${locale}[title]']`).val(response.data[locale]
                            .title);
                        $(`[name='${locale}[text]']`).val(response.data[locale].text);
                    });
                },
                error: function(response) {
                    alert(response.data);
                }
            });
        });

        $(document).on('submit', '#addForm', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ $addRoute }}',
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#listError').empty();
                    $("#alertError").hide();
                    $("#alertSuccess").hide();
                    $(".submitFrom span").html('جاري الإرسال');
                    $('.submitFrom').prop('disabled', true);
                },
                success: function(response, textStatus, xhr) {
                    $('#addModal').modal('hide');
                    $("#show_image").attr('style', 'display:none');
                    $("[name='editor_id']").select2().val('').trigger("change");
                    $('.select2').each(function() {
                        $(this).select2({
                            dropdownParent: $(this).parent()
                        });
                    });

                    var locales = @json($locales);
                    locales.forEach(async (locale) => {
                        $(`[name='${locale}[title]']`).val('');
                        $(`[name='${locale}[text]']`).val('');
                    });

                    if (xhr.status == 201) {

                        $('#add-row').prepend(`
                            <tr id="sid${response.data.id}">
                                <td><span class="badge rounded-pill badge-light-primary">${response.data.id}</span></td>
                                <td><img src="${response.data.image}" alt="article image" style="width:100px;height:100px;"></td>
                                <td>${response.data.editor.name}</td>
                                <td>${response.data.title}</td>
                                <td>${response.data.text}</td>
                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="form-check form-switch form-check-primary">
                                            <input type="checkbox" class="form-check-input" name="changeStatus"
                                                id="${response.data.id}" checked="checked" />
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill badge-light-secondary">${response.data.created_at}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-bs-toggle="tooltip" data-bs-animation="false"
                                        data-bs-original-title="تعديل" title="تعديل" id="edit-button"
                                        data-id="${response.data.id}">
                                        <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                            </path>
                                        </svg>
                                    </button>
                                    <a href="javascript:;" class="btnDelete" id=${response.data.id}
                                        data-bs-toggle="tooltip" data-bs-animation="false"
                                        data-bs-original-title="حذف">
                                        <svg style="margin:12px;" xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        `);

                        $("#alertError").hide();
                        $("#alertSuccess").show();
                        $('#successMessage').html(response["message"]);
                    } else {
                        $("#alertSuccess").hide();
                        $("#alertError").show();
                        $('#errorMessage').html(response["message"]);
                    }

                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                },
                error: function(response) {
                    $('#addModal').modal('hide');

                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك',
                            'لا يمكنك القيام بهذه العملية', 'error');
                    } else {
                        $("#alertError").show();

                        if (response.status == 500) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(response.responseJSON
                                .message));
                            ul.appendChild(li);
                        }

                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(errors[error]));
                            ul.appendChild(li);
                        }
                    }
                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                }
            });
        });

        $(document).on('submit', '#editForm', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ $editRoute }}',
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#listError').empty();
                    $("#alertError").hide();
                    $("#alertSuccess").hide();
                    $(".submitFrom span").html('جاري الإرسال');
                    $('.submitFrom').prop('disabled', true);
                },
                success: function(response, textStatus, xhr) {
                    $('#editModal').modal('hide');
                    $('#sid' + response.data.id).find("td").eq(1).html(
                        `<img src="${response.data.image}" alt="article image" style="width:100px;height:100px;">`
                    );
                    $('#sid' + response.data.id).find("td").eq(2).html(response.data.editor.name);
                    $('#sid' + response.data.id).find("td").eq(3).html(response.data.title);
                    $('#sid' + response.data.id).find("td").eq(4).html(response.data.text);

                    if (xhr.status == 200) {
                        $("#alertError").hide();
                        $("#alertSuccess").show();
                        $('#successMessage').html(response["message"]);
                    } else {
                        $("#alertSuccess").hide();
                        $("#alertError").show();
                        $('#errorMessage').html(response["message"]);
                    }

                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                },
                error: function(response) {
                    $('#editModal').modal('hide');

                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك',
                            'لا يمكنك القيام بهذه العملية', 'error');
                    } else {
                        $("#alertError").show();

                        if (response.status == 500) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(response.responseJSON
                                .message));
                            ul.appendChild(li);
                        }

                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            var ul = document.getElementById("listError");
                            var li = document.createElement("li");
                            li.appendChild(document.createTextNode(errors[error]));
                            ul.appendChild(li);
                        }
                    }
                    $("html, body").animate({
                        scrollTop: 0
                    }, {
                        duration: 1500,
                    });
                    $(".submitFrom span").html('حفظ');
                    $('.submitFrom').prop('disabled', false);
                }
            });
        });
    </script>

    @include('Admin.Components.change-status')
    @include('Admin.Components.ajax-delete')
@endsection
