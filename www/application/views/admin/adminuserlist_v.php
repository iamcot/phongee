<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <input type="text" name="dafname" placeholder="Tên"></td>
            <td>
                <input type="text" name="dalname" placeholder="Họ và tên đệm">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="dausername" placeholder="Tên tài khoản">
            </td>
            <td>
                <input type="text" name="dapassword" placeholder="Mật khẩu">
            </td>
        </tr>
        <tr>
            <td>
                <select name="darole">
                    <option value="member">Thành viên</option>
                    <option value="author">Viết bài</option>
                    <option value="admin">Quản trị</option>
                </select>
            </td>
            <td>
                <input type="text" name="damobi" placeholder="Điện thoại">
            </td>
        </tr>
        <tr>
            <td><input type="text" name="daavatar" placeholder="Ảnh đại diện">
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
            </td>
            <td rowspan="3" id="daavatardemo">

            </td>
        </tr>
        <tr>
            <td><input type="text" name="daemail" placeholder="Email"></td>

        </tr>
        <tr>
            <td><input type="text" name="daaddr" placeholder="Địa chỉ"></td>

        </tr>
        <tr>
            <td><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <input type="button" value="Lưu" onclick="saveProvince()">
                <input type="button" value="Load" onclick="loadProvince(1)">
                <input type="button" value="Xóa nhập liệu" onclick="provinceclear()"></td>
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
        loadProvince(1);
    });
    function saveProvince() {
        var dafname     = $("input[name=dafname]").val();
        var dalname     = $("input[name=dalname]").val();
        var dausername  = $("input[name=dausername]").val();
        var dapassword  = $("input[name=dapassword]").val();
        var damobi      = $("input[name=damobi]").val();
        var daemail     = $("input[name=daemail]").val();
        var daaddr      = $("input[name=daaddr]").val();
        var daavatar    = $("input[name=daavatar]").val();
        var darole      = $("select[name=darole]").val();

        var edit = $("input[name=edit]").val();

        if (dausername.trim() != "" && dafname.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveuser",
                data: "dafname=" + dafname
                    + "&dalname=" + dalname
                    + "&dausername=" + dausername
                    + "&dapassword=" + dapassword
                    + "&damobi=" + damobi
                    + "&daemail=" + daemail
                    + "&daaddr=" + daaddr
                    + "&daavatar=" + daavatar
                    + "&darole=" + darole

                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadProvince($("input[name=currpage]").val());
                            provinceclear();
                            break;
                        case "1":
                            loadProvince($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            provinceclear();
                            break;
                        default :
                            alert("Lỗi lưu - không xác định.")
                            loadProvince($("input[name=currpage]").val());
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập tối thiểu Tên đầy đủ và Seo URL");
        }
    }
    function loadProvince(page) {
        addloadgif("#loadstatus");
        $("#list_province").load("<?=base_url()?>admin/loaduser/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function provinceclear() {
        $("input[name=dafname]").val("");
        $("input[name=dalname]").val("");
        $("input[name=dausername]").val("");
        $("input[name=dapassword]").val("");
        $("input[name=damobi]").val("");
        $("input[name=daemail]").val("");
        $("input[name=daaddr]").val("");
        $("input[name=daavatar]").val("");
        $("input[name=edit]").val("");
        $("#daavatardemo").html('');


    }
    function editProvince(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedituser/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dafname]").val(province.dafname);
                    $("input[name=dalname]").val(province.dalname);
                    $("input[name=dausername]").val(province.dausername);
                    $("input[name=damobi]").val(province.damobi);
                    $("input[name=daemail]").val(province.daemail);
                    $("input[name=daaddr]").val(province.daaddr);
                    $("input[name=daavatar]").val(province.daavatar);
                    $("input[name=edit]").val(province.id);
                    $("select[name=darole]").val(province.darole);

                    $("#daavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.daavatar + '">');
                }
            }
        });
    }
    function hideprovince(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideuser/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    loadProvince($("input[name=currpage]").val());
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
                    $('input[name=daavatar]').val(file.name);
                    $("#daavatardemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });
    });
</script>