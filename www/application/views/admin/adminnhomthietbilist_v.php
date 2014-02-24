<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <label>Tên nhóm</label>
                <input type="text" name="pglong_name" placeholder="Tên nhóm thiết bị">
            </td>
        </tr>
        <tr>
            <td>
                <label>Mã nhóm</label>
                <input type="text" name="pgcode" placeholder="Mã nhóm">
            </td>
        </tr>
        <tr>
            <td>
                <label>Thứ tự</label>
                <input type="text" name="pgorder" placeholder="Thứ tự">
            </td>
        </tr>

        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>
                <input type="text" style="width:20%" name="pgkeyword" placeholder="Từ khóa" ondblclick="this.value=''">
                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>

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
        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
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
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/load/nhomthietbi/" + page + "/keyword",
            data: "key=" + $("input[name=pgkeyword]").val(),
            success: function (msg) {
                $("#list_province").html(msg);
                removeloadgif("#loadstatus");
                $("input[name=currpage]").val(page);
            }
        });
<!--        addloadgif("#loadstatus");-->
<!--        $("#list_province").load("--><?//=base_url()?><!--admin/load/nhomthietbi/" + page+"/"+$("input[name=pgkeyword]").val().trim(), function () {-->
<!--            removeloadgif("#loadstatus");-->
<!--        });-->
<!--        $("input[name=currpage]").val(page);-->
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