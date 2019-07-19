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

    $(function () {
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='addRecord']").validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                inputUserName: "required",
                inputEmail: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true
                },
                inputMessage: "required",
                inputCAPTCHA: "required",

            },
            // Specify validation error messages
            messages: {
                inputUserName: "Введите ваше имя",
                inputEmail: "Введите правильный email",
                inputMessage: "Напишите нам пару слов",
                inputCAPTCHA: "Введите текст с картинки",
            },
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
    {/literal}
</script>
</body>
</html>