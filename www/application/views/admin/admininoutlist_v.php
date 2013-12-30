<div style="overflow: hidden">
<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td id="hoadoninfo">
                <? if($this->mylibs->checkRole('rsNhapRadio')):?>
                <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="nhap"  id="nhapradio">
                <label for="nhapradio">Nhập</label>
                    </span>
                <? endif;?>
                <? if($this->mylibs->checkRole('rsXuatRadio')):?>
                 <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="xuat"  id="xuatradio">
                <label for="xuatradio">Xuất</label>
                 </span>
                <? endif;?>
                <br>
                <input tabindex="1" type="text" name="pgmahoadon" style="width:40%;display: inline-block" placeholder="Mã hóa đơn">
                <input  tabindex="2" type="text" id="pgdate" name="pgdate" style="width:30%;display: inline-block" placeholder="Ngày">
                <input  tabindex="3" type="text" id="pghour" name="pghour" style="width:25%;display: inline-block" placeholder="Giờ:phút:giây">

            </td>
            <td>

                <span id="xuatoption" style="display: none">
                    <? if ($this->mylibs->checkRole('rsXuatCuaHang')): ?>
                    <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="cuahang" id="cuahangradio">
                    <label for="cuahangradio">Cửa hàng</label>
                    </span>
                    <? endif; ?>
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
                        <span id="pgtospan">
                        <select name="pgto"  style="width: 40%;display: inline-block">
                            <option value="-1">Cửa hàng</option>
                        </select>
                        </span>
                    </div>

            </td>
        </tr>
        <tr >
            <td colspan="2">
                <input  tabindex="3" type="text" name="pgseries" style="width:20%;display: inline-block" placeholder="Series/IMEI">
                <input  tabindex="5"  type="text" onblur="" name="pgprice" style="width:15%;display: inline-block" placeholder="Giá">
   <span id="inputchitiethoadon">
                <input  tabindex="4" type="text" onblur="getThietbi(this.value)" name="pgthietbicode" style="width:12%;display: inline-block" placeholder="Mã TB">

                <input type="hidden" name="pgthietbi_id" >
<!--                <input  tabindex="6" type="text" name="pgcount" style="width:8%;display: inline-block" placeholder="Số lượng">-->
                <select  tabindex="7" name="pgcolor" style="width:10%;display: inline-block" >
                    <option value="0">Màu </option>
                </select>
                <select  tabindex="8" name="pgcountry" style="width:10%;display: inline-block" >
                    <option value="0">Nước sx</option>
                </select>
                <select tabindex="9"  name="pgyear" style="width:10%;display: inline-block" >
                    <option value="0">Năm sx</option>
                </select>
                    </span>
                <span class="btn btn-follow"><input  tabindex="10" type="button" value="Lưu" onclick="save()"> </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="idhoadon" value="">
                <input type="hidden" name="idchitiethoadon" value="">

                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>

        </tr>
    </table>


</fieldset>
<div class="clearfix"></div>
<fieldset style="float:left;width:49%">
    <legend>Chi tiết hóa đơn</legend>
    <div id="list_hoadonitem"></div>
</fieldset>
<fieldset style="float:right;width:49%">
    <legend>Danh sách hóa đơn</legend>
    <div id="list_hoadon"></div>
</fieldset>
</div>
<script>
    $(function () {
        $('#pghour').mask('99:99:99');
        $('#pgdate').mask('9999-99-99');
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        loadinout(1);
       $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
        $("input[name=pgtype]").click(function(){
            if($(this).val() == 'nhap'){
                $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block"><option value="-1">Cửa hàng</option></select>');
                getStore('nhap');
                getProvider();
                $("#xuatoption").hide();
                $("#targetoption").show();
                enableinput();
            }
            else{
                $("#xuatoption").show();
                $("#targetoption").hide();
                disableinput();
            }
        });
        $("input[name=pgtypexuat]").click(function(){
            if($(this).val() == 'khachhang'){
                getStore('xuat');
                $("#pgtospan").html("<input type='text' name='pgto' placeholder='Khách hàng'  style='width: 40%;display: inline-block'>");
                $("#targetoption").show();
            }
            else{
                $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block"><option value="-1">Cửa hàng</option></select>');
                getStore('xuat');
                $("#xuatoption").show();
                $("#targetoption").show();

            }
        });
    });
    function savehoadon(){
        var pgcode     = $("input[name=pgmahoadon]").val();

        var pgdate     = $("input[name=pgdate]").val();
        var pghour     = $("input[name=pghour]").val();
        if(pgcode == ""){
            alert("Vui lòng nhập mã hóa đơn");
            return false;
        }
        if(pgdate != "" && pghour !=""){
            pgdate = pgdate+" "+pghour;
        }
        else{
            alert("Vui lòng nhập ngày và giờ");
            return false;
        }
        var pgtype= $("input[name=pgtype]:checked").val();

        var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
//        var pgseries = $("input[name=pgmahoadon]").val();
//        if(pgseries == ""){
//            alert("Hóa đơn phải có ít nhất một thiết bị");
//            return false;
//        }
        var idhoadon = $("input[name=idhoadon]").val();

        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/save/inout",
            data: "pgcode=" + pgcode
                      + "&pgdate=" + pgdate
                      + "&pgtype=" + pgtype
                      + "&pgxuattype=" + pgtypexuat
                      + "&edit=" + idhoadon,
            success: function (msg) {
                if (msg == 0) {
                    alert("Không thể lưu");
                }
                else {
                    $("input[name=idhoadon]").val(msg);
                    loadinout(1);
                }
                 }
            });

    }
    function save() {
        savehoadon();
        var pgseries     = $("input[name=pgseries]").val();
        var pgthietbi_id     = $("input[name=pgthietbi_id]").val();
        var pgprice  = $("input[name=pgprice]").val().replace(/ /g,'');
        var pgcolor    = $("select[name=pgcolor]").val();
        var pgcountry    = $("select[name=pgcountry]").val();
        var pgyear     = $("select[name=pgyear]").val();
        var pgfrom     = $("select[name=pgfrom]").val();
        var pgto     = $("select[name=pgto]").val();
        var pgcount = $("input[name=pgcount]").val();
        var idhoadon = $("input[name=idhoadon]").val();
        var idchitiethoadon = $("input[name=idchitiethoadon]").val();

        if(pgto == -1 || pgfrom == -1 || pgto== "" || pgfrom == ""){
            alert("Vui lòng nhập nơi gửi và nơi nhận");
            return false;
        }
        if (idhoadon.trim() !="" && pgseries.trim() != "" && pgthietbi_id.trim() != "" && pgcount > 0) {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/inout_details",
                data: "pgseries=" + pgseries
                    + "&pgthietbi_id=" + pgthietbi_id
                    + "&pgprice=" + pgprice
                    + "&pgcolor=" + pgcolor
                    + "&pgcountry=" + pgcountry
                    + "&pgyear=" + pgyear
                    + "&pgfrom=" + pgfrom
                    + "&pgto=" + pgto
                    + "&pgcount=" + pgcount
                    + "&pginout_id=" + idhoadon

                    + "&edit=" + idchitiethoadon,
                success: function (msg) {
                    if(msg=="0"){
                        alert("Lỗi lưu.");

                    }
                    else if(msg==-1){
                        alert("Đã có số S/n trong hóa đơn này..");
                    }
                    else{
                        $("input[name=pgseries]").val("");
                        loadinout_details(1,idhoadon);
                    }


                }
            });
        }
        else {
        //        alert("Cập nhật hóa đơn mà không có chi tiết nào ");
        }
    }
    function loadinout(page) {
        addloadgif("#loadstatus");
        $("#list_hoadon").load("<?=base_url()?>admin/load/inout/" + page, function () {
            removeloadgif("#loadstatus");
        });
    }
    function loadinout_details(page,parent) {
        addloadgif("#loadstatus");
        $("#list_hoadonitem").load("<?=base_url()?>admin/load/inout_details/" + page+"/"+parent, function () {
            removeloadgif("#loadstatus");
        });
    }
    function myclear() {
        $("input[type=text]").val("");
        $("input[type=hidden]").val("");
        $("#hoadoninfo input[type=radio]").prop('disabled', false);

    }
    function edithoadon(id){
        $("#hoadoninfo input[type=radio]").prop('disabled', 'disabled');
        $("input[name=idhoadon]").val(id);
        loadinout_details(1,id);
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/inout/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgmahoadon]").val(province.pgcode);
                    $("input[name=pgdate]").val(formatDate(province.pgdate));
                    $("input[name=pghour]").val(formatTime(province.pgdate));
                   // console.log($("input[value="+province.pgtype+"]"));
                    $("label").removeClass("checked")
                    $("input[value="+province.pgtype+"]").prop('checked', true);
                    $("label[for="+province.pgtype+"radio]").addClass("checked");
                    if($("input[value="+province.pgtype+"]:checked").val() == 'nhap'){
                        $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block"><option value="-1">Cửa hàng</option></select>');
                        getStore('nhap');
                        getProvider();
                        $("#xuatoption").hide();
                        $("#targetoption").show();
                    }
                    else{
                        $("label[for="+province.pgxuattype+"radio]").addClass("checked");
                        $("#xuatoption").show();
                        $("#targetoption").hide();
                    }
                }
            }
        });
    }
    function editchitiethoadon(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/inout_details/" + id,
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
                   // getthietbiselect(province.pgthietbi_id,province.pgyear,province.pgcolor,province.pgcountry);

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
    function getStore(type){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jsGetStore",
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
//                        console.log(store);
                        option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                    });
                    if(type =="nhap"){
                        $("select[name=pgto]").html(option);
                    }
                    else if(type=="xuat") {
                        $("select[name=pgfrom]").html(option);
                        $("select[name=pgto]").html(option);
                    }

                }
            }
        });
    }
    function getProvider(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadnhacungcap",
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
//                        console.log(store);
                        option += "<option value='"+store.id+"'>"+store.pgfname+"</option>";
                    });
                        $("select[name=pgfrom]").html(option);


                }
            }
        });
    }
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
    var formatTime = function(unixTimestamp) {
        var dt = new Date(unixTimestamp * 1000);

        var hours = dt.getHours();
        var minutes = dt.getMinutes();
        var seconds = dt.getSeconds();

        // the above dt.get...() functions return a single digit
        // so I prepend the zero here when needed
        if (hours < 10)
            hours = '0' + hours;

        if (minutes < 10)
            minutes = '0' + minutes;

        if (seconds < 10)
            seconds = '0' + seconds;

        return hours + ":" + minutes + ":" + seconds;
    }
    var formatDate = function(unixTimestamp) {
        var dt = new Date(unixTimestamp * 1000);

        var day = dt.getDate();
        var month = dt.getMonth()+1;
        var year = dt.getFullYear();

        // the above dt.get...() functions return a single digit
        // so I prepend the zero here when needed
        if (day < 10)
            day = '0' + day;

        if (month < 10)
            month = '0' + month;


        return year + "-" + month + "-" + day;
    }
     function disableinput(){
        $("#inputchitiethoadon input").prop('disabled', 'disabled');
        $("#inputchitiethoadon select").prop('disabled', 'disabled');
     }
    function enableinput(){
        $("#inputchitiethoadon input").prop('disabled', false);
        $("#inputchitiethoadon select").prop('disabled', false);

    }
</script>

