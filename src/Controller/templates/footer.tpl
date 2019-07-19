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

    {/literal}
</script>
</body>
</html>