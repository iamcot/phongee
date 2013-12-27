<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="nhap"  id="nhapradio">
                <label for="nhapradio">Nhập</label>
                    </span>
                 <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="xuat"  id="xuatradio">
                <label for="xuatradio">Xuất</label>
                 </span>    <br>
                <input tabindex="1" type="text" name="pgmahoadon" style="width:40%;display: inline-block" placeholder="Mã hóa đơn">
                <input  tabindex="2" type="text" id="pgdate" name="pgdate" style="width:40%;display: inline-block" placeholder="Ngày">

            </td>
            <td>
                <span id="xuatoption" style="display: none">
                    <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="cuahang"  id="cuahangradio">
                    <label for="cuahangradio">Cửa hàng</label>
                        </span>
                     <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="khachhang"  id="khachhangradio">
                    <label for="khachhangradio">Khách hàng</label>
                     </span>
                </span>
                    <div id="targetoption" style="display: none">
                        <select name="pgfrom" style="width: 40%;display: inline-block">
                            <option value="-1">Cửa hàng</option>
                        </select>
                        <i class="fa fa-plane fa-2x"></i>
                        <select name="pgto"  style="width: 40%;display: inline-block">
                            <option value="-1">Cửa hàng</option>
                        </select>
                    </div>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input  tabindex="3" type="text" name="pgseries" style="width:20%;display: inline-block" placeholder="Series/IMEI">
                <input  tabindex="4" type="text" onblur="getThietbi(this.value)" name="pgthietbicode" style="width:12%;display: inline-block" placeholder="Mã TB">

                <input type="hidden" name="pgthietbi_id" >
                <input  tabindex="5"  type="text" onblur="console.log(parseInt($(this).val().replace(/ /g,'')))" name="pgprice" style="width:15%;display: inline-block" placeholder="Giá">
                <input  tabindex="6" type="text" name="pgcount" style="width:8%;display: inline-block" placeholder="Số lượng">
                <select  tabindex="7" name="pgcolor" style="width:10%;display: inline-block" >
                    <option value="0">Màu </option>
                </select>
                <select  tabindex="8" name="pgcountry" style="width:10%;display: inline-block" >
                    <option value="0">Nước sx</option>
                </select>
                <select tabindex="9"  name="pgyear" style="width:10%;display: inline-block" >
                    <option value="0">Năm sx</option>
                </select>
                <span class="btn btn-follow"><input  tabindex="10" type="button" value="Lưu" onclick="save()"> </span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">

                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>

        </tr>
    </table>


</fieldset>
<fieldset>
    <legend>Chi tiết hóa đơn</legend>
    <div id="list_hoadonitem"></div>
</fieldset>
<fieldset>
    <legend>Danh sách hóa đơn</legend>
    <div id="list_hoadon"></div>
</fieldset>
<script>
    $(function () {
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        load(1);
        $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $("input[name=pgtype]").click(function(){
//            console.log($(this).val() );
            if($(this).val() == 'nhap'){
                $("#xuatoption").hide();
                $("#targetoption").show();
            }
            else{
                $("#xuatoption").show();
                $("#targetoption").show();
            }
        })
    });
    function save() {
        var pglongname     = $("input[name=pglongname]").val();
        var pgcode     = $("input[name=pgcode]").val();
        var pgpic  = $("input[name=pgpic]").val();
        var pgprice  = $("input[name=pgprice]").val();
        var pgprice_old      = $("input[name=pgprice_old]").val();
        var pgshort_info     = $("input[name=pgshort_info]").val();
        var pgcolor    = $("select[name=pgcolor]").val();
        var pgcountry    = $("select[name=pgcountry]").val();
        var pgyear     = $("select[name=pgyear]").val();
        var pglong_info      = $("textarea[name=pglong_info]").val();
        var pgtech_info    = $("textarea[name=pgtech_info]").val();
        var pgthietbi_id      = $("input[name=pgthietbi_id]").val();

        var edit = $("input[name=edit]").val();

        if (pglongname.trim() != "" && pgcode.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/chitietthietbi",
                data: "pglong_name=" + pglongname
                    + "&pgcode=" + pgcode
                    + "&pgpic=" + pgpic
                    + "&pgthietbi_id=" + pgthietbi_id
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
                        case "1":
                            load($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            if(!$("input[name=checkdelinput]").prop("checked"))
                            myclear();
                            else{
                                $("input[name=edit]").val("");
                                $("input[name=pgcode]").val("");

                            }
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
    function getThietbi(id){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgprice]").val(province.pgprice);
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


                }
            }
        });
    }
</script>

