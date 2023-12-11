<script>
    $(document).on('click', '.btnDelete', function() {
        Swal.fire({
            title: 'هل أنت متأكد من عملية الحذف؟',
            text: 'لن تتمكن من استرجاعه!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم, حذف',
            cancelButtonText: 'لا, إلغاء',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).prop('disabled', true);
                currentId = $(this).attr('id');

                $.ajax({
                    url: '{{ $deleteRoute }}',
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        model: '{{ $model }}',
                        id: currentId,
                        operation: "{{ App\Enums\DeleteActionEnum::FORCE_DELETE->value }}",
                        media: 0,
                        withTrashed: 1
                    },
                    success: function(response, textStatus, xhr) {
                        if (xhr.status == 200) {
                            $('#sid' + currentId).remove();
                            $('#alertError').hide();
                            $('#alertSuccess').show();
                            $('#successMessage').html(response['message']);
                        } else {
                            $('#alertSuccess').hide();
                            $('#alertError').show();
                            $('#errorMessage').html(response['message']);
                        }

                        $('html, body').animate({
                            scrollTop: 0
                        }, {
                            duration: 1500,
                        });

                        fireMessage('حسناً');
                    },
                    error: function(response) {
                        if (response.status == 401 || response.status == 403) {
                            fireMessage('حسناً', 'غير مصرح بك',
                                'لا يمكنك القيام بهذه العملية', 'error');
                        }
                    }
                });
            }
        });
    });
</script>
