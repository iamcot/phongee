<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tbody style="font-weight: normal">
        <tr>
            <td>
                <label>Series No.</label>
                <input type="text" name="pgcode" placeholder="Số series sản phẩm" ondblclick="this.value=''"></td>
            </td>
            <td>
                <label>Mã SP</label>
                <input type="text" name="pgthietbicode" placeholder="Mã Sản phẩm" style="width: 50%"
                       onblur="getThietbi(this.value)">
                <label style="width:10%">ID SP</label>
                <input type="text" name="pgthietbi_id" placeholder="ID SP" style="width: 15%">
            </td>

        </tr>
        <tr>
            <td>
                <label>Tên SP</label>
                <input type="text" name="pglongname" placeholder="Tên sản phẩm">
            </td>
            <td>
                <label style="">Nhóm SP</label>

                <div class="field_select" id="pgstore_id" style="width:75%;display: inline-block;float:none;">
                    <select name="pgnhomthietbi_id">
                        <option value="0">Chọn nhóm Sản phẩm</option>
                        <? foreach ($aNhomthietbi as $store): ?>
                            <option value="<?= $store->id ?>"><?= $store->pglong_name ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label>Giá lẻ</label>
                <input type="text" name="pgprice" placeholder="Giá lẻ" style="width:28%">
                <label>Giá sỉ</label>
                <input type="text" name="pgprice_old" placeholder="Giá sỉ" style="width:28%">
            <td>
                <label>Đơn vị tính</label>
                <input type="text" name="pgdvt" placeholder="Đơn vị tính" value="cái">
            </td>
        </tr>

        <tr>
            <td>
                <label>Hình ảnh</label>
                <input type="text" name="pgpic" placeholder="Hình ảnh đại diện" readonly=true>
                <input id="picupload" type="file" name="files[]" data-url="<?= base_url() ?>admin/calljupload" multiple>

                <div id="pgavatardemo"></div>
            </td>
        </tr>

        </tbody>
        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>
                <input type="text" style="width:20%" name="pgkeyword" placeholder="Từ khóa" ondblclick="this.value=''">
                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>

                <span style="display: inline-block;float: left;">
                <input type="checkbox" name="checkdelinput" id="notclear">
                <label for="notclear" style="width: 200px !important;">Không xóa dữ liệu</label>
                    </span>

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
    $("input").customInput();
    $("input[name=pgprice]").autoNumeric({aSep: ' ', aPad: false});
    $("input[name=pgprice_old]").autoNumeric({aSep: ' ', aPad: false});
    $('select[name=pgnhomthietbi_id]').chosen({width: "100%"});
    $('select[name=pgnhomthietbi_id]').trigger("chosen:updated");
    $("input[name=pgseries]").focus();
});

function save() {
    var pglongname = $("input[name=pglongname]").val().trim();
    var pgcode = $("input[name=pgcode]").val().trim();
    var pgpic = $("input[name=pgpic]").val();
    var pgprice = $("input[name=pgprice]").val().replace(/ /g, '');
    var pgprice_old = $("input[name=pgprice_old]").val().replace(/ /g, '');
    var pgthietbi_id = $("input[name=pgthietbi_id]").val().trim();
    var pgthietbi_code = $("input[name=pgthietbicode]").val().trim();
    var pgdvt = $("input[name=pgdvt]").val().trim();
    var pgnhomthietbi_id = $("select[name=pgnhomthietbi_id]").val();

    var edit = $("input[name=edit]").val();
    if (pgthietbi_id == "" || pgthietbi_id <= 0) {
//            alert("Chưa có thông tin thiết bị ");
//            return false;
    }

    if (pglongname.trim() != "" && pgcode.trim() != "") {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/save/chitietthietbi",
            data: "pglong_name=" + pglongname
                + "&pgcode=" + pgcode
                + "&pgpic=" + pgpic
                + "&pgthietbi_id=" + pgthietbi_id
                + "&pgthietbi_code=" + pgthietbi_code
                + "&pgprice=" + pgprice
                + "&pgprice_old=" + pgprice_old
                + "&pgdvt=" + pgdvt
                + "&pgnhomthietbi_id=" + pgnhomthietbi_id

                + "&edit=" + edit,
            error: function () {
                alert("Có lỗi khi lưu, vui lòng xóa các ô nhập liệu và thử lại.");
            },
            success: function (msg) {
                switch (msg) {
                    case "0":
                        alert("Không thể lưu");
                        load($("input[name=currpage]").val());
                        if (!$("input[name=checkdelinput]").prop("checked"))
                            myclear();
                        break;
                    case "-30":
                        alert("Không tạo mới sản phẩm được");
                        break;
                    default :
                        load($("input[name=currpage]").val());
                        addsavegif("#loadstatus");
                        if (!$("input[name=checkdelinput]").prop("checked"))
                            myclear();
                        else {
                            $("input[name=edit]").val("");
                            $("input[name=pgcode]").val("");

                        }
                        break;
                }
                $("input[name=pgseries]").focus();
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
        url: "<?=base_url()?>admin/load/chitietthietbi/" + page + "/keyword",
        data: "key=" + $("input[name=pgkeyword]").val(),
        success: function (msg) {
            $("#list_province").html(msg);
            removeloadgif("#loadstatus");
            $("input[name=currpage]").val(page);
        }
    });
    <!--        $("#list_province").load("-->
    <?//=base_url()?><!--admin/load/chitietthietbi/" + page+"/keyword?key="+$("input[name=pgkeyword]").val(), function () {-->
    <!--            removeloadgif("#loadstatus");-->
    <!--        });-->
    <!--        $("input[name=currpage]").val(page);-->
}
function myclear() {
    $("input[name=pglongname]").val("");
    $("input[name=pgcode]").val("");
    $("input[name=pgpic]").val("");
    $("input[name=pgthietbi_id]").val("");
    $("input[name=pgthietbicode]").val("");
    $("input[name=pgprice]").val("");
    $("input[name=pgprice_old]").val("");
    $("input[name=edit]").val("");
    $("#pgavatardemo").html('');


}
function edit(id) {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadedit/chitietthietbi/" + id,
        success: function (msg) {
            if (msg == "0") alert('<?=lang("NO_DATA")?>');
            else {
                var province = eval(msg);
                $("input[name=pglongname]").val(province.pglong_name);
                $("input[name=pgcode]").val(province.pgcode);

                $("input[name=pgpic]").val(province.pgpic);
                $("input[name=pgprice]").val(province.pgprice);
                $("input[name=pgprice_old]").val(province.pgprice_old);
                $("input[name=edit]").val(province.id);
                $("input[name=pgdvt]").val(province.pgdvt);
                $("input[name=pgthietbi_id]").val(province.pgthietbi_id);
                $("input[name=pgthietbicode]").val(province.pgthietbi_code);
//                    $("select[name=pgnhomthietbi_id]").val(province.pgnhomthietbi_id);

//                    getthietbiselect(province.pgthietbi_id,province.pgyear,province.pgcolor,province.pgcountry);
                if (province.pgpic != "")
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgpic + '">');
            }
        }
    });
}
function hide(id, status, taga) {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/hide/chitietthietbi/" + id + "/" + status,
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
    if ($("[placeholder]").size() > 0) {
        $.Placeholder.init();
    }
//        CKEDITOR.replace( '.textare1' );
    $('.ckeditor').ckeditor({
        language: 'vi',
        height: 80,
        toolbarGroups: [
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'links' },
            { name: 'insert' },
            '/',
            { name: 'styles' },
            { name: 'colors' }

        ]

    });

    $('#picupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $('input[name=pgpic]').val(file.name);
                $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + file.name + '">')

            });
        }
    });
});

function getThietbi(id) {
    if (id != "") {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") {
                    <!--                    alert('-->
                    <?//=lang("NO_DATA")?><!--');-->
                    $("input[name=pgthietbi_id]").val("");
                }
                else {
                    var province = eval(msg);
                    $("input[name=pglongname]").val(province.pglong_name);
                    $("input[name=pgpic]").val(province.pgpic);
                    $("input[name=pgprice]").val(province.pgprice);
                    $("input[name=pgdvt]").val(province.pgdvt);
                    $("input[name=pgprice_old]").val(province.pgprice_old);
                    $("input[name=pgthietbi_id]").val(province.id);

                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgpic + '">');
                }
            }
        });
    }

}

</script>

