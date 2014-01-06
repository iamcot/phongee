<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <input type="text" name="pgfname" placeholder="Tên"></td>
            <td>
                <input type="text" name="pglname" placeholder="Họ và tên đệm">
            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgusername" placeholder="Tên tài khoản">
            </td>
            <td>
                <input type="text" name="pgpassword" placeholder="Mật khẩu">
            </td>
        </tr>
        <tr>
            <td id="selectrole">

                <select name="pgrole" data-placeholder="Quyền hạn"  >
                    <? foreach($this->config->item('aRole') as $k=>$v):?>
                    <option value="<?=$k?>"><?=$v?></option>
                    <? endforeach;?>
                </select>

            </td>
            <td>
                <input type="text" name="pgmobi" placeholder="Điện thoại">
            </td>
        </tr>
        <tr>
            <td><input type="text" name="pgemail" placeholder="Email"></td>
            <td>
                <select name="pgstore_id">
                    <option value="0">Tất cả cửa hàng</option>
                    <? foreach($aStore as $store):?>
                    <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
                    <? endforeach;?>
                </select>
            </td>

        </tr>
        <tr>
            <td><input type="text" name="pgavatar" placeholder="Ảnh đại diện">
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
            </td>
            <td rowspan="2" id="pgavatardemo">

            </td>
        </tr>

        <tr>
            <td><input type="text" name="pgaddr" placeholder="Địa chỉ"></td>

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
    });
    function save() {
        var pgfname     = $("input[name=pgfname]").val();
        var pglname     = $("input[name=pglname]").val();
        var pgusername  = $("input[name=pgusername]").val();
        var pgpassword  = $("input[name=pgpassword]").val();
        var pgmobi      = $("input[name=pgmobi]").val();
        var pgemail     = $("input[name=pgemail]").val();
        var pgaddr      = $("input[name=pgaddr]").val();
        var pgavatar    = $("input[name=pgavatar]").val();
        var pgrole      = $("select[name=pgrole]").val();
        var pgstore_id      = $("select[name=pgstore_id]").val();

        var edit = $("input[name=edit]").val();

        if (pgfname.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/user",
                data: "pgfname=" + pgfname
                    + "&pglname=" + pglname
                    + "&pgusername=" + pgusername
                    + "&pgpassword=" + pgpassword
                    + "&pgmobi=" + pgmobi
                    + "&pgemail=" + pgemail
                    + "&pgaddr=" + pgaddr
                    + "&pgavatar=" + pgavatar
                    + "&pgrole=" + pgrole
                    + "&pgstore_id=" + pgstore_id

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
        $("#list_province").load("<?=base_url()?>admin/load/user/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pgfname]").val("");
        $("input[name=pglname]").val("");
        $("input[name=pgusername]").val("");
        $("input[name=pgpassword]").val("");
        $("input[name=pgmobi]").val("");
        $("input[name=pgemail]").val("");
        $("input[name=pgaddr]").val("");
        $("input[name=pgavatar]").val("");
        $("input[name=edit]").val("");
        $("select[name=pgstore_id]").val("0");
        $("#pgavatardemo").html('');


    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/user/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgfname]").val(province.pgfname);
                    $("input[name=pglname]").val(province.pglname);
                    $("input[name=pgusername]").val(province.pgusername);
                    $("input[name=pgmobi]").val(province.pgmobi);
                    $("input[name=pgemail]").val(province.pgemail);
                    $("input[name=pgaddr]").val(province.pgaddr);
                    $("input[name=pgavatar]").val(province.pgavatar);
                    $("input[name=edit]").val(province.id);
                    $("select[name=pgrole]").val(province.pgrole);
                    $("select[name=pgstore_id]").val(province.pgstore_id);

                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgavatar + '">');
                }
            }
        });
    }
    function hide(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/user/" + id + "/" + status,
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
        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
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