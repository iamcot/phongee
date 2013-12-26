<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <input type="text" name="pglong_name" placeholder="Tên mhóm thiết bị">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgcode" placeholder="Mã nhóm">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgorder" placeholder="Thứ tự">
            </td>
        </tr>

        <tr>
            <td><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <input type="button" value="Lưu" onclick="save()">
                <input type="button" value="Load" onclick="load(1)">
                <input type="button" value="Xóa nhập liệu" onclick="myclear()"></td>
            <td>
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
    });
    function save() {
        var pglong_name     = $("input[name=pglong_name]").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgorder  = $("input[name=pgorder]").val();
        var edit = $("input[name=edit]").val();

        if (pglong_name.trim() != "" && pgcode.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/nhomthietbi",
                data: "pglong_name=" + pglong_name
                    + "&pgcode=" + pgcode
                    + "&pgorder=" + pgorder

                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            load($("input[name=currpage]").val());
                            myclear();
                            break;
                        case "1":
                            load($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            myclear();
                            break;
                        default :
                            alert("Lỗi lưu - không xác định.")
                            load($("input[name=currpage]").val());
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
        $("#list_province").load("<?=base_url()?>admin/load/nhomthietbi/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pglong_name]").val("");
        $("input[name=pgcode]").val("");
        $("input[name=pgorder]").val("");
        $("input[name=edit]").val("");
    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/nhomthietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pglong_name]").val(province.pglong_name);
                    $("input[name=pgcode]").val(province.pgcode);
                    $("input[name=pgorder]").val(province.pgorder);
                    $("input[name=edit]").val(province.id);
                }
            }
        });
    }
    function hide(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/nhomthietbi/" + id + "/" + status,
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
</script>