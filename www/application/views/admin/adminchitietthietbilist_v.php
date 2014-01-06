<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr><td colspan="2">
            <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
            <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
            <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

            </td>
        </tr>
        <tr>
            <td>
                <input type="text" name="pgthietbicode" placeholder="Mã thiết bị" style="width: 28%;float:left;" onblur="getThietbi(this.value)">
                <input type="text" name="pglongname" placeholder="Tên thiết bị"  style="width: 48%;float:left;">
                <input type="text" name="pgthietbi_id" placeholder="ID thiết bị" style="width: 19%;float:left;">
            </td>
            <td>
                <input type="text" name="pgcode" placeholder="Số series/ID định dạng thiết bị" ondblclick="this.value=''"></td>
            </td>
        </tr>
        <tr>
            <td>
<!--                <input type="text" name="pgcolor" placeholder="Màu">-->
                <select name="pgcolor">
                    <option value="0">Màu </option>
                </select>
            <td>
<!--                <input type="text" name="pgcountry" placeholder="Nước"></td>-->
                    <select name="pgcountry">
                        <option value="0">Nước sản xuất</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td>
<!--                <input type="text" name="pgyear" placeholder="Năm sx" >-->
                <select name="pgyear">
                    <option value="0">Năm sản xuất</option>
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
                <textarea name="pglong_info" class="ckeditor" id="textare1"></textarea>
                <label>Thông tin kỹ thuật</label>
                <textarea name="pgtech_info" class="ckeditor"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>
                <span style="display: inline-block">
                <input type="checkbox" name="checkdelinput" id="notclear">
                <label for="notclear">Không xóa dữ liệu</label>
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
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        $("input[name=pgprice_old]").autoNumeric({aSep:' ',aPad: false});

    });
    function save() {
        var pglongname     = $("input[name=pglongname]").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgpic  = $("input[name=pgpic]").val();
        var pgprice  = $("input[name=pgprice]").val().replace(/ /g,'');
        var pgprice_old      = $("input[name=pgprice_old]").val().replace(/ /g,'');
        var pgshort_info     = $("input[name=pgshort_info]").val();
        var pgcolor    = $("select[name=pgcolor]").val();
        var pgcountry    = $("select[name=pgcountry]").val();
        var pgyear     = $("select[name=pgyear]").val();
        var pglong_info      = $("textarea[name=pglong_info]").val();
        var pgtech_info    = $("textarea[name=pgtech_info]").val();
        var pgthietbi_id      = $("input[name=pgthietbi_id]").val();
        var pgthietbi_code     = $("input[name=pgthietbicode]").val();

        var edit = $("input[name=edit]").val();

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
                    + "&pgcolor=" + pgcolor
                    + "&pgcountry=" + pgcountry
                    + "&pgshort_info=" + pgshort_info
                    + "&pgyear=" + pgyear
                    + "&pglong_info=" + encodeURIComponent(pglong_info)
                    + "&pgtech_info=" + encodeURIComponent(pgtech_info)

                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            load($("input[name=currpage]").val());
                           if(!$("input[name=checkdelinput]").prop("checked"))
                            myclear();
                            break;
                        default :
                            load($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            if(!$("input[name=checkdelinput]").prop("checked"))
                                myclear();
                            else{
                                $("input[name=edit]").val("");
                                $("input[name=pgcode]").val("");

                            }
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
        $("#list_province").load("<?=base_url()?>admin/load/chitietthietbi/" + page, function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pglongname]").val("");
        $("select[name=pgyear]").val("");
        $("select[name=pgcountry]").val("");
        $("select[name=pgcolor]").val("");
        $("input[name=pgcode]").val("");
        $("input[name=pgpic]").val("");
        $("input[name=pgthietbi_id]").val("");
        $("input[name=pgthietbicode]").val("");
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
                    $("input[name=pgshort_info]").val(province.pgshort_info);
                    $("input[name=pgcolor]").val(province.pgcolor);
                    $("input[name=pgcountry]").val(province.pgcountry);
                    $("input[name=pgyear]").val(province.pgyear);
                    $("textarea[name=pglong_info]").val(province.pglong_info);
                    $("textarea[name=pgtech_info]").val(province.pgtech_info);
                    $("input[name=edit]").val(province.id);
                    $("input[name=pgthietbi_id]").val(province.pgthietbi_id);
                    $("input[name=pgthietbicode]").val(province.pgthietbi_code);
                    getthietbiselect(province.pgthietbi_id,province.pgyear,province.pgcolor,province.pgcountry);

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
        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
//        CKEDITOR.replace( '.textare1' );
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
    });
    function getthietbiselect(id,year,color,country) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var array = province.pgyear.split(",");
                    var select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"' "+((year==array[i].trim())?"selected=selected":"")+">"+array[i]+"</option>";
                    }
                    $("select[name=pgyear]").html(select);
                    array = province.pgcolor.split(",");
                    select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"'  "+((color==array[i].trim())?"selected=selected":"")+">"+array[i]+"</option>";
                    }
                    $("select[name=pgcolor]").html(select);
                    array = province.pgcountry.split(",");
                    select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"'  "+((country==array[i].trim())?"selected=selected":"")+">"+array[i]+"</option>";
                    }
                    $("select[name=pgcountry]").html(select);
                }
            }
        });
    }
    function getThietbi(id){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pglongname]").val(province.pglong_name);
                    $("input[name=pgpic]").val(province.pgpic);
                    $("input[name=pgprice]").val(province.pgprice);
                    $("input[name=pgprice_old]").val(province.pgprice_old);
                    $("input[name=pgshort_info]").val(province.pgshort_info);
                    $("textarea[name=pglong_info]").val(province.pglong_info);
                    $("textarea[name=pgtech_info]").val(province.pgtech_info);
                    $("input[name=pgthietbi_id]").val(province.id);
                    var array = province.pgyear.split(",");
                    var select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"'>"+array[i].trim()+"</option>";
                    }
                    $("select[name=pgyear]").html(select);
                    array = province.pgcolor.split(",");
                    select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"'>"+array[i].trim()+"</option>";
                    }
                    $("select[name=pgcolor]").html(select);
                    array = province.pgcountry.split(",");
                    select ="";
                    for(var i=0;i<array.length;i++){
                        select+= "<option value='"+array[i].trim()+"'>"+array[i].trim()+"</option>";
                    }
                    $("select[name=pgcountry]").html(select);


                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgpic + '">');
                }
            }
        });
    }

</script>

