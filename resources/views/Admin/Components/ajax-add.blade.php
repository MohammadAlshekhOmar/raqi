<script>
    $(document).ready(function() {
        $("#frmSubmit").on("submit", function(event) {
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
                    if (xhr.status == 201) {
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
                    $("#alertError").show();

                    if (response.status == 401 || response.status == 403) {
                        fireMessage('حسناً', 'غير مصرح بك',
                            'لا يمكنك القيام بهذه العملية', 'error');
                    } else {
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
    });
</script>
