<div style="overflow: hidden">
<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace" style="background: #fffeee">
        <tr>
            <td id="hoadoninfo">
                <? if($this->mylibs->checkRole('pgrbnhapradio')):?>
                <span style="display: inline-block;">
                <input type="radio" name="pgtype" value="nhap"  id="nhapradio">
                <label for="nhapradio">Nhập</label>
                    </span>
                <? endif;?>
                <? if($this->mylibs->checkRole('pgrbxuatradio')):?>
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
                <span id="nhapoption" style="display: none">
                  <? if($this->mylibs->checkRole('pgrbnhapkho')):?>
                    <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="nhapkho" id="nhapkhoradio">
                    <label for="nhapkhoradio">Nhập kho</label>
                    </span>
                    <? endif;?>
                    <? if($this->mylibs->checkRole('pgrbthuhoi')):?>
                        <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="thuhoi" id="thuhoiradio">
                    <label for="thuhoiradio">Thu hồi</label>
                    </span>
                    <? endif;?>
                </span>
                <span id="xuatoption" style="display: none">
                   <? if($this->mylibs->checkRole('pgrbxuatkho')):?>
                     <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="xuatkho" id="xuatkhoradio">
                    <label for="xuatkhoradio">Xuất kho</label>
                    </span>
                   <? endif;?>
                    <? if ($this->mylibs->checkRole('pgrbcuahang')): ?>
                    <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="cuahang" id="cuahangradio">
                    <label for="cuahangradio">Cửa hàng</label>
                    </span>
                    <? endif; ?>
                    <? if ($this->mylibs->checkRole('pgrbkhachhang')): ?>
                    <span style="display: inline-block;">
                        <input type="radio" name="pgtypexuat" value="khachhang"  id="khachhangradio">
                    <label for="khachhangradio">Đối tác</label>
                     </span>
                    <? endif; ?>
                    <? if ($this->mylibs->checkRole('pgrbkhachle')): ?>
                    <span style="display: inline-block;">
                    <input type="radio" name="pgtypexuat" value="khachle"  id="khachleradio">
                    <label for="khachleradio">Khách lẻ</label>
                     </span>
                    <? endif; ?>
                </span>
                    <div id="targetoption" style="display: none">
                        <div class="field_select" id="pgfromspan">
                        <select name="pgfrom" style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển">

                        </select>
                        </div>
                        <i class="fa fa-plane fa-2x" style="float:left"></i>
                        <div class="field_select" id="pgtospan">

                        <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận">

                        </select>

                            </div>
                    </div>
                          <input type="hidden" name="pgtotmp">
                          <input type="hidden" name="pgfromtmp">
            </td>
        </tr>
        <tr >
            <td >
                <label>Thời hạn</label>
                <input type="text" name='pghanthanhtoan' placeholder="Thời hạn thanh toán hóa đơn">
            </td>
            <td id="xuatoptiondichvu" >
                 <span style="display: inline-block;">
                    <input type="radio" name="pgtypedichvu" value="dichvu" id="dichvuradio">
                    <label for="dichvuradio">Dịch vụ</label>
                 </span>
                 <span style="display: inline-block;">
                    <input type="radio" name="pgtypedichvu" value="hanghoa" id="hanghoaradio" checked>
                    <label for="hanghoaradio">Hàng hóa</label>
                 </span>
                 <span style="display: inline-block;">
                    <input type="radio" name="pgtypedichvu" value="suachua" id="suachuaradio">
                    <label for="suachuaradio">Sửa chữa</label>
                 </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>Thông tin thiết bị: mã <b id="icode"></b>, tên thiết bị: <b id="iname"></b>, loại: <b id="itype"></b>, tồn kho <b id="icount"></b></div>
            </td>
        </tr>
        <tr >
            <td colspan="2">
                <label style="width:10%">Mã vạch</label>
                <input  tabindex="4" onblur="blursninput(this.value)" type="text" name="pgseries" style="width:25%;display: inline-block" placeholder="Series/IMEI">
                <label style="width:5%">Mã TB</label>
                <input class="inputchitiethoadon" tabindex="5" type="text" onblur="getThietbi(this.value,true)" name="pgthietbicode" style="width:12%;display: inline-block" placeholder="Mã TB">
                <label style="width:5%">Giá</label>
                <input  tabindex="6"  type="text" onblur="" name="pgprice" style="width:15%;display: inline-block" placeholder="Giá">
                <label style="width:5%">S/Lg</label>
                <input  tabindex="7" type="text" name="pgcount" style="width:10%;display: inline-block" placeholder="Số lượng" value="1">

                <input type="hidden" name="pgthietbi_id" >
             </td>
            </tr>
        <tr>
            <td colspan="2">
                <label  style="width:10%">Màu</label>
                <select  class="inputchitiethoadon" tabindex="8" name="pgcolor" style="width:10%;display: inline-block" >
                    <option value="0">Màu </option>
                </select>
                <label  style="width:10%">Nước SX</label>
                <select class="inputchitiethoadon" tabindex="9" name="pgcountry" style="width:10%;display: inline-block" >
                    <option value="0">Nước sx</option>
                </select>
                <label  style="width:10%">Năm SX</label>
                <select class="inputchitiethoadon" tabindex="10"  name="pgyear" style="width:10%;display: inline-block" >
                    <option value="0">Năm sx</option>
                </select>
                </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="idhoadon" value="">
                <input type="hidden" name="idchitiethoadon" value="">
                <span class="btn btn-follow"><input  tabindex="10" type="button" value="Lưu" onclick="save()"> </span>

                <span class="btn btn-small"><input type="button" value="Load" onclick="loadinout(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>

        </tr>
        </table>
    <table style="background: #fff3f4">
        <tr>
            <td id="thanhtoanbox" style="width:40%">
                <div>
                <label style="width: 50%">Tổng giá trị hóa đơn: </label> <b id="pgsumprice" style="text-align: right">0</b><br>
                <label style="width: 50%">Số tiền còn lại: </label> <b id="pgsumremain"  style="text-align: right">0</b><br>
                </div>
                <div>
                <label style="width: 50%">Thanh toán: </label>    <br>
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
    <div>
        <input type="checkbox" name="showchuathanhtoan" id="showchuathanhtoan" checked="checked" onchange="loadinout(1)">
        <label for="showchuathanhtoan">Chỉ Hóa đơn chưa thanh toán </label>
    </div>
    <div id="list_hoadon"></div>
</fieldset>
</div>
<script>
    function typexuatcheck(type){
        $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"></select>');
        $("#pgfromspan").html(' <select name="pgfrom"  style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển"></select>');
        if(type == 'khachhang'){
            getStore('from','role');
            getCustomer();
            $("#targetoption").show();
        }
        else if(type == 'cuahang'){
            getStore('from','cuahang');
            getStore('to','cuahang');
            $("#xuatoption").show();
            $("#targetoption").show();
        }
        else if(type == 'xuatkho'){
//            $("#pgfromspan").html('<label style="width:40%">Kho Tổng</label> <select name="pgfrom"  style="width: 40%;display: none" data-placeholder="Nơi chuyển"></select>');
            getStore('from','kho');
            getStore('to','cuahang');
            $("#xuatoption").show();
            $("#targetoption").show();
        }
		else{
            $("#pgtospan").html(' <input type="text" name="pgto"  style="width: 90%;display: inline-block" placeholder="Tên khách hàng" value="">');
            getStore('from','role');
			$("input[name=pgto]").val($('input[name=pgtotmp]').val());
            $("#xuatoption").show();
            $("#targetoption").show();
		}
    }
    function typenhapcheck(type){
        $("#pgtospan").html(' <select name="pgto"  style="width: 40%;display: inline-block" data-placeholder="Nơi nhận"></select>');
        $("#pgfromspan").html(' <select name="pgfrom"  style="width: 40%;display: inline-block" data-placeholder="Nơi chuyển"></select>');
        if(type=='nhapkho'){
            getStore('to','kho');
            getProvider();
        }
        else if(type =='thuhoi'){
            getStore('to','kho');
            getStore('from','cuahang');

        }
    }
    function typecheck(type,xuattype){
       if(type == 'nhap'){

            $("#xuatoption").hide();
            $("#targetoption").show();
            $("#nhapoption").show();
           $("#nhapoption label").removeClass("checked");
           $("input[value="+xuattype+"]").prop('checked', true);
           $("label[for="+xuattype+"radio]").addClass("checked");
            typenhapcheck(xuattype);
            enableinput();
        }
        else{
            $("#nhapoption").hide();
            $("#xuatoption").show();
//            $("#xuatoptiondichvu").show();
            $("#targetoption").hide();

                if(xuattype == "cuahang"){
                    $("#xuatoption label").removeClass("checked");
                    $("input[value=cuahang]").prop('checked', true);
                    $("label[for=cuahangradio]").addClass("checked");
                    typexuatcheck("cuahang");
                }

                else if(xuattype == "xuatkho"){
                    $("#xuatoption label").removeClass("checked");
                    $("input[value=xuatkho]").prop('checked', true);
                    $("label[for=xuatkhoradio]").addClass("checked");
                    typexuatcheck("xuatkho");
                }
				else if(xuattype == "khachle"){
					$("#xuatoption label").removeClass("checked");
                    $("input[value=khachle]").prop('checked', true);
                    $("label[for=khachleradio]").addClass("checked");
                    typexuatcheck("khachle");
				}
                else {
                    $("#xuatoption label").removeClass("checked");
                    $("input[value=khachhang]").prop('checked', true);
                    $("label[for=khachhangradio]").addClass("checked");
                    typexuatcheck("khachhang");
                }
            disableinput();
        }
    }
    $(function () {
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
        $("input[name=pghanthanhtoan]").val(formatdatejs(nextweek()));
        $('#pghour').mask('99:99:99');
        $('#pgdate').mask('9999/99/99');
        $('input[name=pghanthanhtoan]').mask('9999/99/99');
        $("input[name=pgprice]").autoNumeric({aSep:' ',aPad: false});
        $("input[name=pgthanhtoan]").autoNumeric({aSep:' ',aPad: false});
        loadinout(1);
       $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy/mm/dd"
        });
        $( "input[name=pghanthanhtoan]" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy/mm/dd"
        });




        $("input[name=pgtype]").click(function(){
            typecheck($(this).val(),"");
//            if($("input[name=pgtype]:checked").val()=='nhap')
//            $("input[name=pgmahoadon]").val("N");
//                else
//                $("input[name=pgmahoadon]").val("X");

        });
        $("input[name=pgtypexuat]").click(function(){
            if($("input[name=pgtype]:checked").val()=='nhap')

                typenhapcheck($(this).val());
            else
                typexuatcheck($(this).val())
        });
    });
    function save() {
        var pgcode     = $("input[name=pgmahoadon]").val().trim();

        var pgdate     = $("input[name=pgdate]").val();
        var pghour     = $("input[name=pghour]").val();
        var pghanthanhtoan     = $("input[name=pghanthanhtoan]").val();
//        if(pgcode == ""){
//            alert("Vui lòng nhập mã hóa đơn");
//            return false;
//        }
        if(pgdate != "" && pghour !=""){
            pgdate = pgdate+" "+pghour;
        }
        else{
            alert("Vui lòng nhập ngày và giờ");
            return false;
        }
        var pgtype= $("input[name=pgtype]:checked").val();

       // if(pgtype == "xuat") {
        var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
     //   }
     //   else{
            //var pgtypexuat = "";
      //  }
        var pgtypedichvu = $('input[name=pgtypedichvu]:checked').val();
        var pgfrom = $('select[name=pgfrom]').val();
        if (pgtypexuat != 'khachle')
			var pgto = $("select[name=pgto]").val();
			else
			var pgto = $("input[name=pgto]").val();
        var idhoadon = $("input[name=idhoadon]").val();

        if(pgfrom == null || pgto == null ){
            alert("Chưa có thông tin cửa hàng");
            return;
        }

        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/save/inout",
            data: "pgcode=" + pgcode
                + "&pgdate=" + pgdate
                + "&pghanthanhtoan=" + pghanthanhtoan
                + "&pgtypedichvu=" + pgtypedichvu
                + "&pgtype=" + pgtype
                + "&pgxuattype=" + pgtypexuat
                + "&pgfrom=" + pgfrom
                + "&pgto=" + pgto
                + "&edit=" + idhoadon,
            success: function (msg) {
                if (msg == 0) {
                    alert("Lưu đơn hàng bị lỗi, xin kiểm tra lại thông tin");
                }
                else if(msg =='r1' || msg =='r2' || msg =='r0'){
                    alert("Bạn không có quyền đối với loại đơn hàng này. Vui lòng liên hệ quản trị viên để biết thông tin.");
                }

                else if(parseInt(msg) > 0){
                   // console.log(msg);

                    if(idhoadon.trim() == "") $("input[name=idhoadon]").val(msg);
                   // console.log($("input[name=idhoadon]").val());
                    loadinout(1);
                    var pgseries     = $("input[name=pgseries]").val().trim();
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
                    if( (pgtypexuat =='thuhoi' || pgtype=='xuat') && (pgcount < 0 || pgcount > parseInt($("#icount").html())) ) {
                        alert("Số lượng không đúng hoặc vượt quá tồn kho.");
                        return;
                    }

//        console.log(pgfrom);

                    if(pgto == -1 || pgfrom == -1 || pgto== "" || pgfrom == ""){
                        alert("Vui lòng nhập nơi gửi và nơi nhận");
                        return false;
                    }
                    if (idhoadon.trim() !="" && pgseries != "" && pgthietbi_id.trim() != "" && pgcount > 0) {
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
                                    alert("Lưu chi tiết đơn hàng bị lỗi, xin kiểm tra lại thông tin.");

                                }
                                else if(msg==-1){
                                    alert("S/n này đã có trong đơn hàng");
                                }
                                else if(msg==-11){
                                    alert("S/n này đã có trong đơn hàng");
                                }
                                else{
                                    $("input[name=pgseries]").val("");
                                    loadinout(1);
                                    loadinout_details(1,idhoadon);
                                    clearinputdetails();
                                    loadSumPrice(idhoadon,$("input[name=pgtype]:checked").val());
                                    //$("input[name=idhoadon]").val(idhoadon);
                                    edithoadon(idhoadon);
                                }


                            }
                        });
                    }
                    else {
                        alert("Đã lưu đơn hàng mà không có chi tiết đơn hàng.");
                    }
                }
                else{
                    alert("Lưu đơn hàng bị lỗi, xin kiểm tra lại thông tin");
                }
            }
        });


    }
    function loadinout(page) {
        $("#list_hoadonitem").html("");
        addloadgif("#loadstatus");
        $("#list_hoadon").load("<?=base_url()?>admin/getHoaDon/" + page+"/"+$("input[name=showchuathanhtoan]").prop("checked"), function () {
            removeloadgif("#loadstatus");
//            myclear();
        });
    }
    function loadmoneytransfer(page,pginout_id) {
        addloadgif("#loadstatus");
        $("#list_transfer").load("<?=base_url()?>admin/loadview/v_moneytransfer/" + page+"/"+pginout_id, function () {
            removeloadgif("#loadstatus");
        });
    }
    function loadinout_details(page,parent) {
        if(parent == 0){
            parent = $("input[name=idhoadon]").val();
        }
        addloadgif("#loadstatus");
        $("#list_hoadonitem").load("<?=base_url()?>admin/loadview/v_inout/" + page+"/"+parent, function () {
            removeloadgif("#loadstatus");
        });
    }
    function myclear() {
        $("input[type=text]:not(.pagination input)").val("");
        $("input[type=hidden]").val("");
        $("#hoadoninfo input[type=radio]").prop('disabled', false);
        enableinput();
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
        $("input[name=pghanthanhtoan]").val(formatdatejs(nextweek()));
    }
    function nextweek(){
        var today = new Date();
        var nextweek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
        return nextweek;
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
                    $("input[name=pghanthanhtoan]").val(formatDate(province.pghanthanhtoan));
                   // console.log($("input[value="+province.pgtype+"]"));
                    $("label").removeClass("checked");
                    $("input[value="+province.pgtype+"]").prop('checked', true);
                    $("input[value="+province.pgtypedichvu+"]").prop('checked', true);
                    $("label[for="+province.pgtype+"radio]").addClass("checked");
                    $("label[for="+province.pgtypedichvu+"radio]").addClass("checked");
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
                //    var pgfrom     = $('select[name=pgfrom]').chosen().val();

                //    var pgtype= $("input[name=pgtype]:checked").val();
                //    var pgtypexuat= $("input[name=pgtypexuat]:checked").val();
                //    if(pgtypexuat != 'khachle')
                //     var pgto =   $('select[name=pgto]').chosen().val();
                //    else var pgto =  $('input[name=pgto]').val();
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

    });
    function getStore(target,typestore){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jsGetStore/"+typestore,
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var userstoreid = <?=(($this->session->userdata("pgstore_id")>0)?$this->session->userdata("pgstore_id"):0)?>;
                    var province = eval(msg);
                    if(userstoreid == 0 || typestore=='kho')
                        var option = "<option value='0'>Chọn cửa hàng</option>";
                    else var option = "";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                    });
                    $("select[name=pg"+target+"]").html(option);
                    $("select[name=pg"+target+"]").chosen({width:"100%"});
                    if(userstoreid>0 && typestore != 'kho')
                        $("select[name=pg"+target+"]").val(userstoreid);
                    if($("input[name=pg"+target+"tmp]").val()!="")
                    $("select[name=pg"+target+"]").val($("input[name=pg"+target+"tmp]").val()).trigger("chosen:updated");
//                    if($("input[name=pgtypexuat]:checked").val()!='xuatkho' || target =='to'){
                   // $("select[name=pg"+target+"]").chosen({width:"100%"});
                    $("select[name=pg"+target+"]").trigger("chosen:updated");
//                    }




                }
            }
        });
    }
    function getProvider(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadTradecustomer",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.tradeid+"'>"+store.pglname+" "+store.pgfname+"<? if($this->session->userdata("pgstore_id")==0):?> ("+store.pglong_name+")<? endif;?></option>";
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
            url: "<?=base_url()?>admin/jxloadTradecustomer",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.tradeid+"'>"+store.pglname+" "+store.pgfname+"<? if($this->session->userdata("pgstore_id")==0):?>  ("+store.pglong_name+")<? endif;?></option>";
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
        if(id.trim()=="") return;
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
        var pgtypexuat = $("input[name=pgtypexuat]:checked").val();
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadcode/chitietthietbi/" + id+"/"+pgtypexuat,
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
                    var pgfrom     = $('select[name=pgfrom]').val();
                    var pgto     = $("select[name=pgto]").val();
                    var pgcount = $("input[name=pgcount]").val();

                   // var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
                    var pginout_id =  $("input[name=idhoadon]").val();
                  //  console.log(pgtype);
                    if(pgtype=='xuat'){
                        checkXuat(id,pgtypexuat,pgfrom,pgto,pginout_id);
                       // if(pgtypexuat!='xuatkho')
                            gettonkho(id,pgfrom,false);
                    }
                    else{
                        if(pgtypexuat!='thuhoi')
                        gettonkho(id,pgto,false);
                        else
                            gettonkho(id,pgfrom,false);
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

    function formatdatejs(dt) {

        var day = dt.getDate();
        var month = dt.getMonth()+1;
        var year = dt.getFullYear();

        // the above dt.get...() functions return a single digit
        // so I prepend the zero here when needed
        if (day < 10)
            day = '0' + day;

        if (month < 10)
            month = '0' + month;


        return year + "/" + month + "/" + day;
    }
     function disableinput(){
        $(".inputchitiethoadon").prop('disabled', 'disabled');
     }
    function enableinput(){
        $(".inputchitiethoadon").prop('disabled', false);

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
        if(val.trim()==""){
            return;
        }
        disableinput();
        getThietbiFromSn(val.trim());
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
                    case "-11":  alert("Hàng không có trong kho");
                        $("input[name=pgseries]").val("");
                        break;
                    case "1": break;
                    default :
//                        if(xuattype=='xuatkho'){
//                            if(parseInt(msg)>0){
//                                var currkho = ($('select[name=pgfrom]').val());
//                                if(currkho == null || currkho == -1 || currkho == msg || $("input[name=idhoadon]").val() ==''){
//                                $('select[name=pgfrom]').val(msg);
//                                $('select[name=pgfrom]').trigger("chosen:updated");
//                                gettonkho(sn,msg,false);
//                                }
//                                else{
//                                    alert("Hai sản phẩm cùng 1 đơn hàng phải cùng 1 kho.");
//                                }
//                            }
//                        }
                        break;
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
    var pgsumprice = $("#pgsumremain").html().replace(/,/g,'');
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
    if(parseInt(pgthanhtoan) <=0 || pgthanhtoan.trim() == ""){
        alert("Nhập số tiền thanh toán");
        return;
    }
    var pgtypexuat =  $("input[name=pgtypexuat]:checked").val();
    var storeid = 0;
    var userid = 0;
    var storeidall = 0;
    switch(pgtypexuat){
        case 'nhapkho': storeid = $("select[name=pgto]").val();
            userid  = $("select[name=pgfrom]").val();
            break;
        case 'thuhoi': storeid = $("select[name=pgto]").val();
            storeidall = $("select[name=pgfrom]").val();
            break;
        case 'xuatkho': storeid = $("select[name=pgfrom]").val();
            storeidall = $("select[name=pgto]").val();
            break;
        case 'khachhang': storeid = $("select[name=pgfrom]").val();
            userid  = $("select[name=pgto]").val();
            break;
        case 'khachle': storeid = $("select[name=pgfrom]").val();
            break;
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/save/moneytransfer",
        data:"pginout_id="+pginout_id+
         //    "&pgsumprice="+pgsumprice+
             "&pgamount="+pgthanhtoan+
             "&pginfo="+pginfo+
            "&pgdate=" +  (Math.round(new Date().getTime()/1000))+
             "&pgtype="+pgtypethanhtoan +
             "&pgstore_id="+storeid +
             "&pgstore_idall="+storeidall +
             "&pguser_id="+userid,
        success: function (msg) {
            if(msg=='r1' || msg=='r0'){
                alert("Bạn không có quyền đối với thao tác này. Vui lòng liên hệ quản trị viên để biết thông tin.");
            }
            loadmoneytransfer(1,pginout_id);
            loadSumPrice(pginout_id,pgtypethanhtoan);
            loadinout(1);
            $("#list_hoadonitem").html("");
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
function printinout(id){
    window.open("<?=base_url()?>admin/printinout/"+id);
}
</script>

