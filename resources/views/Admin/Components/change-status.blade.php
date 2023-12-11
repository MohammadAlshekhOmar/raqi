<script>
    $(document).on('change', 'input[type=checkbox][name=changeStatus]', function() {
        if (!$(this).is(':checked')) {
            $(this).removeAttr('checked');
        } else {
            $(this).attr('checked', 'checked');
        }

        var restore = "{{ App\Enums\DeleteActionEnum::RESTORE_DELETE->value }}";
        var soft = "{{ App\Enums\DeleteActionEnum::SOFT_DELETE->value }}";

        currentId = $(this).attr('id');
        operation = $(this).is(':checked') === true ? restore : soft

        $.ajax({
            url: '{{ $deleteRoute }}',
            type: 'DELETE',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                model: '{{ $model }}',
                id: currentId,
                operation: operation,
                withTrashed: 1
            },
            success: function(response, textStatus, xhr) {
                if (xhr.status == 200) {
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
            },
            error: function(response) {
                if (response.status == 401 || response.status == 403) {
                    fireMessage('حسناً', 'غير مصرح بك', 'لا يمكنك القيام بهذه العملية',
                        'error');
                }
            }
        });
    });
</script>
