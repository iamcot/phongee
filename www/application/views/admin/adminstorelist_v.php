<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <input type="text" name="pglong_name" placeholder="Tên cửa hàng">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgcode" placeholder="Mã cửa hàng">
            </td>

        </tr>
        <tr>
            <td>
                <input type="text" name="pgorder" placeholder="Thứ tự">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgaddr" placeholder="Địa chỉ">
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>
        </tr>
    </table>


</fieldset>
<fieldset>
    <legend>Danh sách</legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function () {
        load(1);
        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
    });
    function save() {
        var pglong_name     = $("input[name=pglong_name]").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgorder  = $("input[name=pgorder]").val();
        var pgaddr  = $("input[name=pgaddr]").val();
        var edit = $("input[name=edit]").val();

        if (pglong_name.trim() != "" && pgcode.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/store",
                data: "pglong_name=" + pglong_name
                    + "&pgcode=" + pgcode
                    + "&pgorder=" + pgorder
                    + "&pgaddr=" + pgaddr
                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            load($("input[name=currpage]").val());
                            myclear();
                            break;
                        default :
                            load($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            myclear();
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập dữ liệu");
        }
    }
    function load(page) {
        addloadgif("#loadstatus");
        $("#list_province").load("<?=base_url()?>admin/load/store/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pglong_name]").val("");
        $("input[name=pgcode]").val("");
        $("input[name=pgorder]").val("");
        $("input[name=pgaddr]").val("");
        $("input[name=edit]").val("");


    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/store/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pglong_name]").val(province.pglong_name);
                    $("input[name=pgcode]").val(province.pgcode);
                    $("input[name=pgorder]").val(province.pgorder);
                    $("input[name=pgaddr]").val(province.pgaddr);
                    $("input[name=edit]").val(province.id);
                }
            }
        });
    }
    function hide(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/store/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    load($("input[name=currpage]").val());
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
    $(function () {
        $('#picupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('input[name=pgavatar]').val(file.name);
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });
    });
</script>