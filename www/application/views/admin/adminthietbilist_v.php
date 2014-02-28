<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <thead style="font-weight: normal">
        <tr>
            <td id="pgtype">
                <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="thietbi" checked=checked id="thietbiradio">
                <label for="thietbiradio">Thiết bị</label>
                    </span>
                 <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="phukien" id="phukienradio">
                <label for="phukienradio"> Phụ kiện</label>
                    </span>
            </td>
            <td>
                <select name="pgtype_pk" style="display: none">
                    <option value="ban">Phụ kiện bán</option>
                    <option value="suachua">Phụ kiện sửa chữa</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Tên TB *</label>
                <input type="text" name="pglongname" placeholder="Tên thiết bị"></td>
            <td>
                <label>Mã TB *</label>
                <input type="text" name="pgcode" placeholder="Mã thiết bị">
            </td>
        </tr>
        <tr>
            <td id="parent">
                <label style="">Nhóm TB</label>

                <div class="field_select" id="pgstore_id" style="width:75%;display: inline-block;float:none;">
                <select name="pgnhomthietbi_id">
                    <option value="0">Chọn nhóm thiết bị</option>
                    <? foreach($aNhomthietbi as $store):?>
                        <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
                    <? endforeach;?>
                </select>
                </div>

            </td><td>
                <label>Giá</label>
                <input type="text" name="pgprice" placeholder="Giá hiện tại"  style="width:28%" >
                <label>Giá cũ</label>
                <input type="text" name="pgprice_old" placeholder="Giá cũ"  style="width:28%" >
            </td>
        </tr>
        <tr id="pkparent" style="display: none">
            <td>
                <label>Mã TB cha </label>
                <input type="text" name="pkthietbicode" placeholder="Mã thiết bị" style="width: 50%" onblur="getThietbi(this.value)">
                <label style="width: 15%">ID TB cha </label>
                <input type="text" name="pkthietbi_id" placeholder="ID thiết bị" style="width: 10%">
            </td>
             <td>
                 <label>Tên TB cha </label>
                 <input type="text" name="pklongname" placeholder="Tên thiết bị"  >
             </td>
        </tr>
        <tr>
            <td>
                <label>Đơn vị tính</label>
                <input type="text" name="pgdvt" placeholder="Đơn vị tính" value="cái">

            <td>
                <label>Thời gian Bảo hành</label>
                <input type="text" name="pgtgbh" placeholder="Thời gian Bảo hành" value="12 tháng">

            </td>
        </tr>
        <tr>
            <td >
                <label>Nước SX</label>
                <input type="text" name="pgcountry" placeholder="Các nước sản xuất "></td>

            </td>
            <td>
                <label>Năm SX</label>
                <input type="text" name="pgyear" placeholder="Các năm ">
            </td>
        </tr>
        <tr><td colspan="2"><a style="text-decoration: underline" href="javascript:toggleinfo('table#inputserviceplace tbody')">Ẩn hiện Thông tin thêm cho thiết bị </a></td></tr>
        </thead>
        <tbody style="display: none">
        <tr>
            <td>
                <label>Màu sắc</label>
                <input type="text" name="pgcolor" placeholder="Các màu ">
            </td>

            <td rowspan="2" style="vertical-align: top">
                <label>Hình ảnh</label>
                <input type="text" name="pgpic" placeholder="Hình ảnh đại diện" readonly=true>
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
                <div id="pgavatardemo"></div>
            </td>
        </tr>

        <tr>
            <td>
                <label>Thông tin</label>
                <input type="text" name="pgshort_info" placeholder="Thông tin ngắn"></td>
        </tr>
        <tr>
            <td colspan="2" >
                <label>Thông tin sản phẩm</label>
                <textarea name="pglong_info" class="ckeditor"></textarea>
                <label>Thông tin kỹ thuật</label>
                <textarea name="pgtech_info" class="ckeditor"></textarea>
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
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        $("input[name=pgprice_old]").autoNumeric({aSep:' ',aPad: false});
        $('select[name=pgnhomthietbi_id]').chosen({width:"100%"});
        $('select[name=pgnhomthietbi_id]').trigger("chosen:updated");

        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
        load(1);
        $("input").customInput();
    });
    function save() {
        var pglongname     = $("input[name=pglongname]").val();
        var pgtype     = $("input[name=pgtype]:checked").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgpic  = $("input[name=pgpic]").val();
        var pgprice  = $("input[name=pgprice]").val().replace(/ /g,'');
        var pgprice_old      = $("input[name=pgprice_old]").val().replace(/ /g,'');
        var pgshort_info     = $("input[name=pgshort_info]").val();
        var pgcolor     = $("input[name=pgcolor]").val();
        var pgyear     = $("input[name=pgyear]").val();
        var pgcountry     = $("input[name=pgcountry]").val();
        var pglong_info      = $("textarea[name=pglong_info]").val();
        var pgtech_info    = $("textarea[name=pgtech_info]").val();
        var pgtype_pk   = "";
        var pgthietbi_parent = 0;
        var pgdvt     = $("input[name=pgdvt]").val().trim();
        var pgtgbh     = $("input[name=pgtgbh]").val().trim();
        var pgnhomthietbi_id      = $("select[name=pgnhomthietbi_id]").val();

//        console.log($("input[name=pgtype]:checked").val());
        if(pgtype == "phukien"){
            pgthietbi_parent      = $("input[name=pkthietbi_id]").val();
            pgtype_pk = $("select[name=pgtype_pk]").val();
        }

        var edit = $("input[name=edit]").val();

        if (pglongname.trim() != "" && pgcode.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/thietbi",
                data: "pglong_name=" + pglongname
                    + "&pgcode=" + pgcode
                    + "&pgpic=" + pgpic
                    + "&pgnhomthietbi_id=" + pgnhomthietbi_id
                    + "&pgtype_pk=" + pgtype_pk
                    + "&pgtype=" + pgtype
                    + "&pgprice=" + pgprice
                    + "&pgprice_old=" + pgprice_old
                    + "&pgshort_info=" + pgshort_info
                    + "&pgcolor=" + pgcolor
                    + "&pgyear=" + pgyear
                    + "&pgdvt=" + pgdvt
                    + "&pgtgbh=" + pgtgbh
                    + "&pgthietbi_parent=" + pgthietbi_parent
                    + "&pgcountry=" + pgcountry
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
            url: "<?=base_url()?>admin/load/thietbi/" + page + "/keyword",
            data: "key=" + $("input[name=pgkeyword]").val(),
            success: function (msg) {
                $("#list_province").html(msg);
                removeloadgif("#loadstatus");
                $("input[name=currpage]").val(page);
            }
        });
<!--        addloadgif("#loadstatus");-->
<!--        $("#list_province").load("--><?//=base_url()?><!--admin/load/thietbi/" + page+"/"+$("input[name=pgkeyword]").val().trim(), function () {-->
<!--            removeloadgif("#loadstatus");-->
<!--        });-->
<!--        $("input[name=currpage]").val(page);-->
    }
    function myclear() {
        $("input[name=pglongname]").val("");
        $("input[name=pgcode]").val("");
        $("input[name=pgpic]").val("");
        $("input[name=pkthietbi_id]").val("");
        $("select[name=pgnhomthietbi_id]").val(0).trigger("chosen:updated");
        $("input[name=pgprice]").val("");
        $("input[name=pgcolor]").val("");
        $("input[name=pgyear]").val("");
        $("input[name=pgcountry]").val("");
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
                   // $("input[value="+province.pgtype+"]").prop("checked",true);
                    $("input[name=pgcode]").val(province.pgcode);
                    $("input[name=pgcolor]").val(province.pgcolor);
                    $("input[name=pgyear]").val(province.pgyear);
                    $("input[name=pgcountry]").val(province.pgcountry);
                    $("input[name=pgpic]").val(province.pgpic);
                    $("input[name=pgprice]").val(province.pgprice);
                    $("input[name=pgprice_old]").val(province.pgprice_old);
                    $("input[name=pgdvt]").val(province.pgdvt);
                    $("input[name=pgtgbh]").val(province.pgtgbh);
                    $("input[name=pgshort_info]").val(province.pgshort_info);
                    $("textarea[name=pglong_info]").val(province.pglong_info);
                    $("textarea[name=pgtech_info]").val(province.pgtech_info);
                    $("input[name=edit]").val(province.id);

                    $("select[name=pgtype_pk]").val(province.pgtype_pk);

                    $("#pgtype label").removeClass("checked");
                    $("input[value="+province.pgtype+"]").prop('checked', true);
                    $("label[for="+province.pgtype+"radio]").addClass("checked");
                    $("select[name=pgnhomthietbi_id]").val(province.pgnhomthietbi_id).trigger("chosen:updated");

                    if(province.pgtype == 'phukien'){
                        $("input[name=pkthietbi_id]").val(province.pgthietbi_parent);
                        $("select[name=pgtype_pk]").show();
                        $("#pkparent").show();
                    }
                    else{
                        $("select[name=pgtype_pk]").hide();
                        $("#pkparent").hide();

                    }

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
        $( '.ckeditor' ).ckeditor({
            language: 'vi',
            height:80,
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
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });
        $("input[name=pgtype]").click(function(){
//            console.log($(this).val() );
            if($(this).val() == 'phukien'){
                $("select[name=pgtype_pk]").show();
                $("#pkparent").show();
            }
            else{
                $("select[name=pgtype_pk]").hide();
                $("#pkparent").hide();

            }
        })
    });

    function getThietbi(id){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pklongname]").val(province.pglong_name);

                    $("input[name=pkthietbi_id]").val(province.id);
                }
            }
        });
    }
</script>