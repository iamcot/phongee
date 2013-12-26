<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <input type="text" name="pglongname" placeholder="Tên thiết bị"></td>
            <td>
                <input type="text" name="pgcode" placeholder="Mã thiết bị">
            </td>
        </tr>
        <tr>
            <td>
                <select name="pgnhomthietbi_id">
                    <option value="0">Chọn nhóm thiết bị</option>
                    <? foreach($aNhomthietbi as $store):?>
                        <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
                    <? endforeach;?>
                </select>
            </td>
            <td rowspan="3" style="vertical-align: top">
                <input type="text" name="pgpic" placeholder="Hình ảnh đại diện" readonly=true>
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
                <div id="pgavatardemo"></div>
            </td>
        </tr>
        <tr>
            <td>
                <label>Giá hiện tại</label>
                <input type="text" name="pgprice" placeholder="Giá hiện tại">
                <label>Giá cũ</label>
                <input type="text" name="pgprice_old" placeholder="Giá cũ">
            </td>

        </tr>
        <tr>
            <td><input type="text" name="pgshort_info" placeholder="Thông tin ngắn"></td>

        </tr>
        <tr>
            <td colspan="2" >
                <label>Thông tin sản phẩm</label>
                <textarea name="pglong_info" class="ckeditor"></textarea>
                <label>Thông tin kỹ thuật</label>
                <textarea name="pgtech_info" class="ckeditor"></textarea>
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
        var pglongname     = $("input[name=pglongname]").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgpic  = $("input[name=pgpic]").val();
        var pgprice  = $("input[name=pgprice]").val();
        var pgprice_old      = $("input[name=pgprice_old]").val();
        var pgshort_info     = $("input[name=pgshort_info]").val();
        var pglong_info      = $("textarea[name=pglong_info]").val();
        var pgtech_info    = $("textarea[name=pgtech_info]").val();
        var pgnhomthietbi_id      = $("select[name=pgnhomthietbi_id]").val();

        var edit = $("input[name=edit]").val();

        if (pglongname.trim() != "" && pgcode.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/thietbi",
                data: "pglong_name=" + pglongname
                    + "&pgcode=" + pgcode
                    + "&pgpic=" + pgpic
                    + "&pgnhomthietbi_id=" + pgnhomthietbi_id
                    + "&pgprice=" + pgprice
                    + "&pgprice_old=" + pgprice_old
                    + "&pgshort_info=" + pgshort_info
                    + "&pglong_info=" + encodeURIComponent(pglong_info)
                    + "&pgtech_info=" + encodeURIComponent(pgtech_info)

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
        $("#list_province").load("<?=base_url()?>admin/load/thietbi/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pglongname]").val("");
        $("input[name=pgcode]").val("");
        $("input[name=pgpic]").val("");
        $("select[name=pgnhomthietbi_id]").val("");
        $("input[name=pgprice]").val("");
        $("input[name=pgprice_old]").val("");
        $("input[name=pgshort_info]").val("");
        $("textarea[name=pglong_info]").val("");
        $("input[name=edit]").val("");
        $("textarea[name=pgtech_info]").val("");
        $("#pgavatardemo").html('');


    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pglongname]").val(province.pglong_name);
                    $("input[name=pgcode]").val(province.pgcode);
                    $("input[name=pgpic]").val(province.pgpic);
                    $("input[name=pgprice]").val(province.pgprice);
                    $("input[name=pgprice_old]").val(province.pgprice_old);
                    $("input[name=pgshort_info]").val(province.pgshort_info);
                    $("textarea[name=pglong_info]").val(province.pglong_info);
                    $("textarea[name=pgtech_info]").val(province.pgtech_info);
                    $("input[name=edit]").val(province.id);
                    $("select[name=pgnhomthietbi_id]").val(province.pgnhomthietbi_id);

                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgpic + '">');
                }
            }
        });
    }
    function hide(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/thietbi/" + id + "/" + status,
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
        $( '.ckeditor' ).ckeditor();
        $('#picupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('input[name=pgpic]').val(file.name);
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });
    });
</script>