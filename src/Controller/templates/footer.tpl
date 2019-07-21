<script type="text/javascript">
    {literal}
    $(document).ready(function () {
        $.get("/view", function (data) {
            $("#recordsTable").html(data);
        });
    });

    $(document).on("click", "#pageFirst", function () {
        $.get("/view/0", function (data) {
            $("#recordsTable").html(data);
        });
    });

    $(document).on("click", "#pagePrev", function () {
        $.get("/view/" + ($(this).val() - 1), function (data) {
            $("#recordsTable").html(data);
        });
    });

    $(document).on("click", "#pageNext", function () {
        $.get("/view/" + ($(this).val() - 1), function (data) {
            $("#recordsTable").html(data);
        });
    });

    $(document).on("click", "#pageEnd", function () {
        $.get("/view/" + ($(this).val() - 1), function (data) {
            $("#recordsTable").html(data);
        });
    });

    $('body').on("click", "#captcha", function () {
        $(this).attr('src', '/captcha?' + Math.random());
        $(this).load($(this).attr('src'));
    });

    // $(document).on("focusout", "#inputMessage", function (e) {
    //     var reg = /<(.|\n)*?>/g;
    //     if (reg.test($('#inputMessage').val()) == true) {
    //         alert('HTML Tag are not allowed');
    //     }
    //     e.preventDefault();
    // });

    $.validator.addMethod("validateMessageText", function (value, element) {
        var reg = /<(.|\n)*?>/g;
        return (reg.test(value) !== true);
    }, '');


    $(function () {
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='addRecord']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                inputUserName: {
                    required: true,
                    pattern: /^[a-zA-Z0-9'.\s]{1,64}$/
                },
                inputEmail: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                },
                inputMessage: {
                    required: true,
                    validateMessageText: true
                },
                inputCAPTCHA: {
                    required: true,
                    pattern: /^[a-zA-Z0-9\s]+$/,
                    remote: {
                        url: 'validate-captcha',
                        type: "post",
                        complete: function (data) {
                            /* Additional code to run if the element passes validation */
                            if (data) {
                                var json = $.parseJSON(data.responseText);
                                if (json[0]) {
                                    if (json[0].valid !== "true") {
                                        $('#inputCAPTCHA').val('');
                                        $('#captcha').trigger("click");
                                    }
                                }
                            }
                        }
                    }
                },

            },
            // Specify validation error messages
            messages: {
                inputUserName: {
                    required: "Пожалуйста, введите ваше имя, не более 64 символов",
                    pattern: "Мы не можем принять имя с недопустимыми символами"
                },
                inputEmail: "Просим указать email вида name@domain.com",
                inputMessage: {
                    required: "Напишите нам хоть пару слов",
                    validateMessageText: "HTML тэги в сообщении недопустимы!"
                },
                inputCAPTCHA: {
                    required: "Введите текст с картинки",
                    pattern: "В тексте должны быть только цифры и латинские буквы"
                },
            },
            onkeyup: function (element, event) {
                if (element.name === "inputCAPTCHA") {
                    return false;
                } else {
                    $.validator.defaults.onkeyup.call(this, element, event);
                }
            },
            onfocusout: function (element, event) {
                if (element.name === "inputCAPTCHA") {
                    return false;
                } else {
                    $.validator.defaults.onfocusout.call(this, element, event);
                }
            },
            highlight: function (element, errorClass) {
                $(element).fadeOut(function () {
                    $(element).fadeIn();
                });
            },
            // }
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: $(form).serialize(), // serializes the form's elements.
                    success: function (data) { // reset form, hide it and show Thank you.
                        $(form).trigger('reset');
                        $('#pageFirst').trigger("click");
                        $('#alertBox').show();
                        $("#addBlock").hide();
                    }
                });
            }
        });
    });

    // $(function () {
    //     $("body").on("click", "#refreshimg", function () {
    //         $.post("newsession.php");
    //         $("#captchaimage").load("image_req.php");
    //         return false;
    //     });
    //
    //     $("#captchaform").validate({
    //         rules: {
    //             captcha: {
    //                 required: true,
    //                 remote: "process.php"
    //             }
    //         },
    //         messages: {
    //             captcha: "Correct captcha is required. Click the captcha to generate a new one"
    //         },
    //         submitHandler: function () {
    //             alert("Correct captcha!");
    //         },
    //         success: function (label) {
    //             label.addClass("valid").text("Valid captcha!")
    //         },
    //         onkeyup: false
    //     });
    //
    // });
    {/literal}
</script>
</body>
</html>