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
                    <label for="khachhangradio">Đối tác</label>
                     </span>
					 <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="khachle"  id="khachleradio">
                    <label for="khachleradio">Khách lẻ</label>
                     </span>
                </span>
                    <div id="targetoption" style="display: none">
                        <div class="field_select" id="pgfromspan">
                        <select name="pgfrom" style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển">
                            <option value="-1">Cửa hàng</option>
                        </select>
                        </div>
                        <i class="fa fa-plane fa-2x" style="float:left"></i>
                        <div class="field_select" id="pgtospan">

                        <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận">
                            <option value="-1">Cửa hàng</option>
                        </select>

                            </div>
                    </div>
                          <input type="hidden" name="pgtotmp">
                          <input type="hidden" name="pgfromtmp">
            </td>
        </tr>
        <tr >
            <td colspan="2">
                <div>Thông tin thiết bị: mã <b id="icode"></b>, tên thiết bị: <b id="iname"></b>, loại: <b id="itype"></b>, tồn kho <b id="icount"></b></div>
                <input  tabindex="4" onblur="blursninput(this.value)" type="text" name="pgseries" style="width:20%;display: inline-block" placeholder="Series/IMEI">
                <input  tabindex="6"  type="text" onblur="" name="pgprice" style="width:15%;display: inline-block" placeholder="Giá">
                <input  tabindex="7" type="text" name="pgcount" style="width:8%;display: inline-block" placeholder="Số lượng" value="1">
   <span id="inputchitiethoadon">
                <input  tabindex="5" type="text" onblur="getThietbi(this.value,true)" name="pgthietbicode" style="width:12%;display: inline-block" placeholder="Mã TB">

                <input type="hidden" name="pgthietbi_id" >

                <select  tabindex="8" name="pgcolor" style="width:10%;display: inline-block" >
                    <option value="0">Màu </option>
                </select>
                <select  tabindex="9" name="pgcountry" style="width:10%;display: inline-block" >
                    <option value="0">Nước sx</option>
                </select>
                <select tabindex="10"  name="pgyear" style="width:10%;display: inline-block" >
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

                <span class="btn btn-small"><input type="button" value="Load" onclick="loadinout(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>

        </tr>
        <tr>
            <td id="thanhtoanbox" style="width:40%">
                <div>
                <label>Tổng giá trị hóa đơn: </label> <b id="pgsumprice">0</b><br>
                <label>Số tiền còn lại: </label> <b id="pgsumremain">0</b><br>
                </div>
                <div>
                <label>Thanh toán: </label>    <br>
                <input type="hidden" name="pgtypethanhtoan" >
                <input   type="text" name="pgthanhtoan" style="width:80%;display: block" placeholder="Số tiền thanh toán">
                </div>
                <div class="btn btn-small">
                    <input type="button" value="Thanh toán" onclick="savethanhtoan()">
                </div>

            </td>
            <td style="width:59%">
                <b>Lịch sử thanh toán đơn hàng.</b>
                <div id="list_transfer"></div>
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
    function typexuatcheck(type){
        if(type == 'khachhang'){
            getStore('xuat');
            $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"><option value="-1">khách hàng</option></select>');
            getCustomer();
            $("#targetoption").show();
        }
        else if(type == 'cuahang'){
            $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"><option value="-1">Cửa hàng</option></select>');
            $("#pgfromspan").html(' <select name="pgfrom"  style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển"><option value="-1">Cửa hàng</option></select>');
            getStore('xuatcuahang');
            $("#xuatoption").show();
            $("#targetoption").show();

        }
		else{
			$("#pgtospan").html(' <input type="text" name="pgto"  style="width: 90%;display: inline-block" placeholder="Tên khách hàng" value="">');
            getStore('xuat');
			$("input[name=pgto]").val($('input[name=pgtotmp]').val());
            $("#xuatoption").show();
            $("#targetoption").show();
		}
    }
    function typecheck(type,xuattype){
        if(type == 'nhap'){
            $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"><option value="-1">Cửa hàng</option></select>');
            $("#pgfromspan").html(' <select name="pgfrom"  style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển"><option value="-1">Cửa hàng</option></select>');
            getStore('nhap');
            getProvider();
            $("#xuatoption").hide();

            $("#targetoption").show();
            enableinput();

        }
        else{
            $("#xuatoption").show();
            $("#targetoption").hide();
            $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"><option value="-1">Cửa hàng</option></select>');
            $("#pgfromspan").html(' <select name="pgfrom"  style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển"><option value="-1">Cửa hàng</option></select>');
                if(xuattype == "cuahang"){
                    $("#xuatoption label").removeClass("checked");
                    $("input[value=cuahang]").prop('checked', true);
                    $("label[for=cuahangradio]").addClass("checked");
                    typexuatcheck("cuahang");
                }
                else if(xuattype == "khachhang"){
                    $("#xuatoption label").removeClass("checked");
                    $("input[value=khachhang]").prop('checked', true);
                    $("label[for=khachhangradio]").addClass("checked");
                    typexuatcheck("khachhang");
                }
				else{
					$("#xuatoption label").removeClass("checked");
                    $("input[value=khachle]").prop('checked', true);
                    $("label[for=khachleradio]").addClass("checked");
                    typexuatcheck("khachle");
				}
            disableinput();
        }
    }
    $(function () {
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
        $('#pghour').mask('99:99:99');
        $('#pgdate').mask('9999-99-99');
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        $("input[name=pgthanhtoan]").autoNumeric({aSep:' ',aPad: false});
        loadinout(1);
       $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });




        $("input[name=pgtype]").click(function(){
            typecheck($(this).val(),"");
        });
        $("input[name=pgtypexuat]").click(function(){
                typexuatcheck($(this).val())
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

        if(pgtype == "xuat") {
        var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
        }
        else{
            var pgtypexuat = "";
        }
        var pgfrom = $('select[name=pgfrom]').chosen().val();
		if (pgtypexuat != 'khachle')
			var pgto = $("select[name=pgto]").chosen().val();
			else
			var pgto = $("input[name=pgto]").val();
        var idhoadon = $("input[name=idhoadon]").val();

        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/save/inout",
            data: "pgcode=" + pgcode
                      + "&pgdate=" + pgdate
                      + "&pgtype=" + pgtype
                      + "&pgxuattype=" + pgtypexuat
                      + "&pgfrom=" + pgfrom
                      + "&pgto=" + pgto
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

        if(pgtype == "xuat") {
            var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
        }
        else{
            var pgtypexuat = "";
        }
        var pgfrom = $('select[name=pgfrom]').chosen().val();
        if (pgtypexuat != 'khachle')
			var pgto = $("select[name=pgto]").chosen().val();
			else
			var pgto = $("input[name=pgto]").val();
        var idhoadon = $("input[name=idhoadon]").val();

        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/save/inout",
            data: "pgcode=" + pgcode
                + "&pgdate=" + pgdate
                + "&pgtype=" + pgtype
                + "&pgxuattype=" + pgtypexuat
                + "&pgfrom=" + pgfrom
                + "&pgto=" + pgto
                + "&edit=" + idhoadon,
            success: function (msg) {
                if (msg == 0) {
                    alert("Không thể lưu");
                }
                else {
                   // console.log(msg);

                    if(idhoadon.trim() == "") $("input[name=idhoadon]").val(msg);
                   // console.log($("input[name=idhoadon]").val());
                    loadinout(1);
                    var pgseries     = $("input[name=pgseries]").val();
                    var pgthietbi_id     = $("input[name=pgthietbi_id]").val();
                    var pgthietbicode     = $("input[name=pgthietbicode]").val();
                    var pgprice  = $("input[name=pgprice]").val().replace(/ /g,'');
                    var pgcolor    = $("select[name=pgcolor]").val();
                    var pgcountry    = $("select[name=pgcountry]").val();
                    var pgyear     = $("select[name=pgyear]").val();
                  //  var pgfrom     = pgfrom;
	              //  var pgto     = pgto;
                    var pgcount = $("input[name=pgcount]").val();
                    idhoadon = $("input[name=idhoadon]").val();
                    var idchitiethoadon = $("input[name=idchitiethoadon]").val();
                //    console.log(idhoadon+"@"+pgseries+"@"+pgthietbi_id+"@"+pgcount);
                    if(pgtype=='xuat' && (pgcount < 0 || pgcount > parseInt($("#icount").html()))) {
                        alert("Số lượng không đúng hoặc vượt quá tồn kho.");
                        return;
                    }
//        console.log(pgfrom);

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
                                + "&pgthietbi_code=" + pgthietbicode
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
                                    alert("S/n này đã có trong đơn hàng");
                                }
                                else if(msg==-11){
                                    alert("S/n này đã có trong đơn hàng");
                                }
                                else{
                                    $("input[name=pgseries]").val("");
                                    loadinout_details(1,idhoadon);
                                    clearinputdetails();
                                    loadSumPrice(idhoadon,$("input[name=pgtype]:checked").val());
                                }


                            }
                        });
                    }
                    else {
                        alert("Chưa đủ thông tin của chi tiết đơn hàng.");
                    }
                }
            }
        });


    }
    function loadinout(page) {
        addloadgif("#loadstatus");
        $("#list_hoadon").load("<?=base_url()?>admin/load/inout/" + page, function () {
            removeloadgif("#loadstatus");
        });
    }
    function loadmoneytransfer(page,pginout_id) {
        addloadgif("#loadstatus");
        $("#list_transfer").load("<?=base_url()?>admin/load/moneytransfer/" + page+"/"+pginout_id, function () {
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
        enableinput();
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
    }
    function edithoadon(id){

        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/inout/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    myclear();

                    var province = eval(msg);
                    $("input[name=pgmahoadon]").val(province.pgcode);
                    $("input[name=pgdate]").val(formatDate(province.pgdate));
                    $("input[name=pghour]").val(formatTime(province.pgdate));
                    $("input[name=pgtotmp]").val(province.pgto);
                    $("input[name=pgfromtmp]").val(province.pgfrom);
                   // console.log($("input[value="+province.pgtype+"]"));
                    $("label").removeClass("checked");
                    $("input[value="+province.pgtype+"]").prop('checked', true);
                    $("label[for="+province.pgtype+"radio]").addClass("checked");
                    typecheck($("input[value="+province.pgtype+"]:checked").val(),province.pgxuattype);
                    loadSumPrice(id,province.pgtype);
                    $("#hoadoninfo input[type=radio]").prop('disabled', 'disabled');
                    $("input[name=idhoadon]").val(id);
                    loadinout_details(1,id);
                    loadmoneytransfer(1,id);


                }
            }
        });
    }
    function clearinputdetails(){
        $("input[name=pgseries]").val("");
        $("input[name=idchitiethoadon]").val("");
    }
    function editchitiethoadon(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/inout_details/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);


                    getThietbi(province.pgthietbi_code,false);
                    getthietbiselect(province.pgthietbi_id,province.pgyear,province.pgcolor,province.pgcountry);
                    $("input[name=pgseries]").val(province.pgseries);
                    $("input[name=pgthietbicode]").val(province.pgthietbi_code);
                    $("input[name=pgthietbi_id]").val(province.pgthietbi_id);
                    $("input[name=idchitiethoadon]").val(province.id);
                    $("input[name=pgprice]").val(province.pgprice);

                    $("input[name=pgcount]").val(province.pgcount);
                    var pgfrom     = $('select[name=pgfrom]').chosen().val();

                    var pgtype= $("input[name=pgtype]:checked").val();
                    var pgtypexuat= $("input[name=pgtypexuat]:checked").val();
                    if(pgtypexuat != 'khachle')
                     var pgto =   $('select[name=pgto]').chosen().val();
                    else var pgto =  $('input[name=pgto]').val();
                    if(pgtype=='xuat'){

                        gettonkho(province.pgseries,pgfrom,true);
                    }

                    else{
                        gettonkho(province.pgseries,pgto,false);
                    }


                }
            }
        });
    }
    function hidedetails(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/inout_details/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    loadinout_details(1);
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
    function hideinout(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/inout/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    loadinout(1);
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
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
//                        console.log(store);
                        option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                    });
                    if(type =="nhap"){
                        $("select[name=pgto]").html(option);
                        $('select[name=pgto]').chosen({width:"100%"});
                        $('select[name=pgto]').val($("input[name=pgtotmp]").val()).trigger("chosen:updated");

                    }
                    else if(type=="xuat") {
                        $("select[name=pgfrom]").html(option);
                        $('select[name=pgfrom]').chosen({width:"100%"});
                        $('select[name=pgfrom]').val($("input[name=pgfromtmp]").val()).trigger("chosen:updated");

//                        $("select[name=pgto]").html(option);
//                        $('select[name=pgto]').chosen({width:"100%"});
                    }
                    else if(type == "xuatcuahang"){
                        $("select[name=pgfrom]").html(option);
                        $('select[name=pgfrom]').chosen({width:"100%"});
                        $("select[name=pgto]").html(option);
                        $('select[name=pgto]').chosen({width:"100%"});
                        $('select[name=pgfrom]').val($("input[name=pgfromtmp]").val()).trigger("chosen:updated");
                        $('select[name=pgto]').val($("input[name=pgtotmp]").val()).trigger("chosen:updated");

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
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.id+"'>"+store.pgfname+"</option>";
                    });
                        $("select[name=pgfrom]").html(option);
                    $('select[name=pgfrom]').chosen({width:"100%"});
                    $('select[name=pgfrom]').val($("input[name=pgfromtmp]").val()).trigger("chosen:updated");

                }
            }
        });
    }
    function getCustomer(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadcustomer",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.id+"'>"+store.pgfname+"</option>";
                    });
                        $("select[name=pgto]").html(option);
                    $('select[name=pgto]').chosen({width:"100%"});
                    $('select[name=pgto]').val($("input[name=pgtotmp]").val()).trigger("chosen:updated");
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

    function getThietbi(id,custom){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/thietbi/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgthietbi_id]").val(province.id);
                   // console.log(custom);
                    if (custom) {
                        $("input[name=pgprice]").val(province.pgprice);

                        var array = province.pgyear.split(",");
                        var select = "";
                        for (var i = 0; i < array.length; i++) {
                            select += "<option value='" + array[i].trim() + "'>" + array[i].trim() + "</option>";
                        }
                        $("select[name=pgyear]").html(select);
                        array = province.pgcolor.split(",");
                        select = "";
                        for (var i = 0; i < array.length; i++) {
                            select += "<option value='" + array[i].trim() + "'>" + array[i].trim() + "</option>";
                        }
                        $("select[name=pgcolor]").html(select);
                        array = province.pgcountry.split(",");
                        select = "";
                        for (var i = 0; i < array.length; i++) {
                            select += "<option value='" + array[i].trim() + "'>" + array[i].trim() + "</option>";
                        }
                        $("select[name=pgcountry]").html(select);
                        if (province.pgtype != "phukien") {
                            $("input[name=pgcount]").prop('disabled', 'disabled');
                        }
                        else {
                            $("input[name=pgcount]").prop('disabled', false);
                        }
                    }
                    $("#icode").html(province.pgcode);
                    $("#iname").html(province.pglong_name);
                    $("#itype").html(province.pgtype);

                }
            }
        });
    }
    function getThietbiFromSn(id){
        var pgtype= $("input[name=pgtype]:checked").val();
        if(pgtype!= 'nhap' && pgtype!='xuat'){
            alert("Vui lòng chọn nhập hoặc xuất");
            return false;
        }
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/chitietthietbi/" + id+"/"+pgtype,
            success: function (msg) {
                if(msg == -1){
                    alert("S/n của thiết bị này vẫn còn trong hệ thống.");
                    return;
                }
                else if (msg == "0"){
                    if(confirm('S/n này chưa có! hệ thống sẽ tự động thêm mới s/n này vào dữ liệu thiết bị?')){
                        enableinput();
                    }
                    else{
                        $("input[name=pgseries]").val("");
                    }

                }
                else {
                    var pgfrom     = $('select[name=pgfrom]').chosen().val();
                    var pgto     = $("select[name=pgto]").val();
                    var pgcount = $("input[name=pgcount]").val();

                    var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
                    var pginout_id =  $("input[name=idhoadon]").val();
                  //  console.log(pgtype);
                    if(pgtype=='xuat'){
                        checkXuat(id,pgtypexuat,pgfrom,pgto,pginout_id);
                        gettonkho(id,pgfrom,false);
                    }
                    else{
                        gettonkho(id,pgto,false);
                    }

                    var province = eval(msg);
                    $("input[name=pgprice]").val(province.pgprice);
                    $("input[name=pgthietbi_id]").val(province.pgthietbi_id);
                    $("input[name=pgthietbicode]").val(province.pgthietbi_code);
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
                    if(province.thietbitype != "phukien"){
                        $("input[name=pgcount]").prop('disabled', 'disabled');
                    }
                    else{
                        $("input[name=pgcount]").prop('disabled', false);
                    }
                    $("#icode").html(province.pgthietbi_code);
                    $("#iname").html(province.pglong_name);
                    $("#itype").html(province.thietbitype);

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
	function changesn(val){
		if(val.length >= 8)
			blursninput(val);	
	}
	$(document).ready(function() {
    $("input[name=pgseries]").bind('paste', function(event) {
        var _this = this;
        // Short pause to wait for paste to complete
        setTimeout( function() {
            var val = $(_this).val();
            //if(val.length >= 8)
			blursninput(val);	
        }, 100);
    });
});
    function blursninput(val){
        disableinput();
        getThietbiFromSn(val);
        $("input[name=pgcount]").val("1");

    }
    function checkXuat(sn,xuattype,from,to,inout_id){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/checkxuat/" + sn,
            data: "xuattype="+xuattype+"&from="+from+"&to="+to+"&inout_id="+inout_id,
            success: function (msg) {
                switch (msg){
                    case "-1": alert("Sản phẩm đã bán cho khách");
                        $("input[name=pgseries]").val("");
                        break;
                    case "-2":  alert("Sản phẩm đã ở cửa hàng này hoặc đang được chuyển vào");
                        $("input[name=pgseries]").val("");
                        break;
                    case "-3":  alert("Sản phẩm không có ở cửa hàng này hoặc đang được chuyển đi");
                        $("input[name=pgseries]").val("");
                        break;
                    case "-4":  alert("Nơi chuyển và nơi nhận phải khác nhau");
                        $("input[name=pgseries]").val("");
                        break;
                    case "-5":  alert("Chưa chọn nơi chuyển và nơi nhận");
                        $("input[name=pgseries]").val("");
                        break;
                    case "-6":  alert("Đã có sản phẩm này trong đơn hàng");
                        $("input[name=pgseries]").val("");
                        break;
                    case "1": break;
                    default : break;
                }
            }
        });
    }
function loadSumPrice(inout_id,type){
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/jxloadsuminout/" + inout_id,
        success: function (msg) {
            var price = eval(msg);
            $("#pgsumprice").html(price.sum);
            $("#pgsumremain").html(price.remain);
            $("input[name=pgtypethanhtoan]").val(type);

        }
    });
}
function savethanhtoan(){
    var pginout_id = $("input[name=idhoadon]").val();
    var pginout_code = $("input[name=pgmahoadon]").val();
    var pgsumprice = $("#pgsumremain").html().replace(/ /g,'');
    var pgthanhtoan = $("input[name=pgthanhtoan]").val().replace(/ /g,'');
    var pgtypethanhtoan = $("input[name=pgtypethanhtoan]").val();
    var pginfo = 'Thanh toán hóa đơn #'+pginout_code;
    $("input[name=pgthanhtoan]").val("");
    if(pgsumprice == 0){
        alert("Đơn hàng đã thanh toán đủ");
        return;
    }
   if(pginout_id =="") {
       alert("Chưa có thông tin hóa đơn");
       return;
   }
    if(pgtypethanhtoan == ""){
       alert("Chưa chọn nhập hay xuất hàng");
       return;
    }
    if(parseInt(pgthanhtoan) > parseInt(pgsumprice)){
        if(confirm("Giá thanh toán nhiều hơn tổng giá trị, bạn muốn thanh toán hết đơn hàng?")){
            $("input[name=pgthanhtoan]").val(pgsumprice);
            pgthanhtoan = pgsumprice;
        }
        else{
            $("input[name=pgthanhtoan]").val("");
            return;
        }
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/save/moneytransfer",
        data:"pginout_id="+pginout_id+
         //    "&pgsumprice="+pgsumprice+
             "&pgamount="+pgthanhtoan+
             "&pginfo="+pginfo+
            "&pgdate=" +  (Math.round(new Date().getTime()/1000))+
             "&pgtype="+pgtypethanhtoan,
        success: function (msg) {
            loadmoneytransfer(1,pginout_id);
            loadSumPrice(pginout_id,pgtypethanhtoan);

        }
    });
}
function gettonkho(sn,from,fromedit){
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/jxgettonkho/"+sn+"/"+from,
        success: function (msg) {
            if(fromedit){
                msg = parseInt(msg)+parseInt($("input[name=pgcount]").val());
            }
            $("#icount").html(msg);
        }
    });
}
</script>

