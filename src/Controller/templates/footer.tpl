<script type="text/javascript">
    {literal}
    $(document).ready(function () {
        $.get("/view", function (data) {
            $("#recordsTable").html(data);
        });
    });
    {/literal}
</script>
</body>
</html>