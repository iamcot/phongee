<div style="overflow: hidden">
<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace" style="width:60%;display: block;float:left;">
        <tr>
            <td id="hoadoninfo">
                <div id="pgstoreiddiv" style="display: block;clear:both;">
                    <select name="pgstore_id" style="width: 100%;display: inline-block" data-placeholder="Cửa hàng">

                    </select>
                </div>
                <br>
                <? if($this->mylibs->checkRole('pgrbnhaptien')):?>
                <span style="display: inline-block;float: left;margin-right: 20px;">
                <input type="radio" name="pgtype" value="nhap"  id="nhapradio">
                <label for="nhapradio">Nhập tiền</label>
                    </span>
                <? endif;?>
                <? if($this->mylibs->checkRole('pgrbxuattien')):?>
                 <span style="display: inline-block;;float: left;">
                <input type="radio" name="pgtype" value="xuat"  id="xuatradio">
                <label for="xuatradio">Xuất tiền</label>
                 </span>
                <? endif;?>
                <div id="pgstoreiddivall" style="display: block;clear:both;">
                    <select name="pgstore_idall" style="width: 100%;display: inline-block" data-placeholder="Cửa hàng">

                    </select>
                </div>
                <br>
                <div id="pgmoneytypediv" style="display: block;clear:both;">
                    <select name="pgmoneytype" style="width: 100%;display: inline-block" data-placeholder="Loại tiền" onchange="changemoneytype(this.value)">
                        <? foreach($this->config->item('aMoneyType') as $moneytype):?>
                            <option value="<?=$moneytype[0].'|'.$moneytype[3]?>"><?=$moneytype[1]?></option>
                        <? endforeach;?>
                    </select>
                </div>
                <br>
                <div id="pguseriddiv" style="display: block;clear:both;">
                    <select name="pguser_id" style="width: 100%;display: inline-block" data-placeholder="Thành viên" onchange="getUserInout(this.value)">

                    </select>
                </div>
                <br>

                <div class="clear"> </div>
                <div>
                    <label>Mã hóa đơn</label>
                    <input tabindex="1" type="text" name="pginout_code" style="width:50%;display:inline-block" placeholder="Mã hóa đơn" onblur="loadSumPrice(this.value)">
                    <input type="hidden" name="pginout_id">
                </div>
                <br>
                <div>
                    <label>Tổng giá trị</label>
                    <input  type="text" name="pgsumprice" style="width:25%;display:inline-block" placeholder="Tổng giá trị hóa đơn" disabled="disabled">
                <label>Cần thanh toán</label>
                <input  type="text" name="pgsumremain" style="width:25%;display:inline-block" placeholder="Số tiền cần thanh toán" disabled="disabled">
                </div>
                <br>
                <div>
                    <label>Ngày</label>
                    <input  tabindex="2" type="text" id="pgdate" name="pgdate" style="width:25%;display: inline-block" placeholder="Ngày">
                    <label>Giờ</label>
                    <input  tabindex="3" type="text" id="pghour" name="pghour" style="width:25%;display: inline-block" placeholder="Giờ:phút:giây">
                </div>
                <br>
                <div>
                    <label>Số tiền</label>
                    <input tabindex="4" type="text" name="pgamount"  placeholder="Số tiền" style="width:25%;display:inline-block">

                    <label>Tỉ giá </label>
                    <input tabindex="5" type="text" name="pgmoneyrate"  placeholder="Tỉ giá " style="width:25%;display:inline-block" value="1">
                </div>
               <br><br>
                <textarea tabindex="6" name="pginfo" placeholder="Ghi chú" style="width:100%;display:block"></textarea>

        </tr>
        <tr >
            <td>
                <input type="hidden" name="edit" >

                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Load" onclick="loadmoneytransfer(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>
            </td>
        </tr>
        </table>
     <table style="width:35%;display: block;float:right;" id="inoutuser">

     </table>
    <div style="clear: both;display: block"></div>
    <input type="hidden" name="ajaxload" value="0">
<fieldset >
    <legend>Lịch sử gần đây</legend>
    <div id="list_hoadon"></div>
</fieldset>
</div>
<script>

    $(function () {
        $('#pghour').mask('99:99:99');
        $('#pgdate').mask('9999/99/99');
        $("input[name=pgamount]").autoNumeric({aSep:' ',aPad: false});
        $('select[name=pgmoneytype]').chosen({width:"90%"});
        $('select[name=pgmoneytype]').trigger("chosen:updated");
       $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy/mm/dd"
        });
        $("input[name=pginout_code]").bind('paste', function(event) {
            var _this = this;

          //  $(_this).val(val);
            // Short pause to wait for paste to complete
            setTimeout( function() {
                var val = $(_this).val().trim();
                if(val.length >= 8)
                    loadSumPrice(val);
            }, 100);
        });
    });
    $(function () {
        getStore('role');
        getStore('all');
        getUser();
        loadmoneytransfer(1,0);
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
    });
    function save() {
        var pginout_id     = $("input[name=pginout_id]").val();
        var pgdate     = $("input[name=pgdate]").val();
        var pghour  = $("input[name=pghour]").val();
        var pgamount  = $("input[name=pgamount]").val().replace(/ /g,'');
        var pginfo      = $("textarea[name=pginfo]").val();
        var pgstore_id      = $("select[name=pgstore_id]").val();
        var pgstore_idall      = $("select[name=pgstore_idall]").val();
        var pguser_id      = $("select[name=pguser_id]").val();
        var arrmoney      = $("select[name=pgmoneytype]").val().split("|");
        var pgmoneytype = arrmoney[0];
        var pgmoneyrate = $("input[name=pgmoneyrate]").val();

        var pgtype      = $("input[name=pgtype]:checked").val();

        var edit = $("input[name=edit]").val();
        var sumprice = $("input[name=pgsumprice]").val().replace(/ /g,'');
        var remainprice = $("input[name=pgsumremain]").val().replace(/ /g,'');

        if(pgtype != 'nhap' && pgtype != 'xuat'){
            alert("Chưa chọn rút/gửi tiền mặt");
            return false;
        }
        if(parseInt(remainprice)  >0 && parseInt(pgamount) > parseInt(remainprice)){
            if(confirm("Thanh toán toàn bộ đơn hàng")){
                pgamount = remainprice;
            }
            else{
                $("input[name=pgamount]").val("");
                return false;
            }
        }
        else if(parseInt(remainprice) == 0 && edit==""){
            alert("Đơn hàng không cần thanh toán nữa");
            return false;
        }
        if(pgdate != "" && pghour !=""){
            pgdate = pgdate+" "+pghour;
            pgdate = Math.round(new Date(pgdate).getTime()/1000);
        }
        else{
            alert("Vui lòng nhập ngày và giờ");
            return false;
        }
        if (pgamount.trim() != "" && pginfo.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/moneytransfer",
                data: "pginout_id=" + pginout_id
                    + "&pgdate=" + pgdate
                    + "&pgamount=" + pgamount
                    + "&pgstore_id=" + pgstore_id
                    + "&pgstore_idall=" + pgstore_idall
                    + "&pginfo=" + encodeURIComponent(pginfo)
                    + "&pgtype=" + pgtype
                    + "&pguser_id=" + pguser_id
                    + "&pgmoneytype=" + pgmoneytype
                    + "&pgmoneyrate=" + pgmoneyrate
                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadmoneytransfer(1,0);
                            myclear();
                            break;

                        default :
                            loadmoneytransfer(1,0);
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
    function loadmoneytransfer(page,inout_id) {
        addloadgif("#loadstatus");
        $("#list_hoadon").load("<?=base_url()?>admin/loadview/v_moneytransfer/" + page, function () {
            removeloadgif("#loadstatus");
        });

    }
    function myclear() {
        $("input[name=pginout_id]").val("");
        $("input[name=pginout_code]").val("");
        $("input[name=pgamount]").val("");
        $("textarea[name=pginfo]").val("");
        $("input[name=pgsumprice]").val("");
        $("input[name=pgsumremain]").val("");
        $("input[name=pgdate]").val(mygetdate());
        $("input[name=pghour]").val(mygettime());
        $("input[name=edit]").val("");
        $("select[name=pgstore_id]").prop("disabled",false).trigger("chosen:updated");
        $("select[name=pguser_id]").prop("disabled",false).trigger("chosen:updated");
        $("select[name=pgstore_idall]").prop("disabled",false).trigger("chosen:updated");

        $('select[name=pgstore_id]').val(0).trigger("chosen:updated");
        $('select[name=pgstore_idall]').val(0).trigger("chosen:updated");
        $('select[name=pguser_id]').val(0).trigger("chosen:updated");


    }
    function getInoutcode(code){
        $("input[name=pginout_code]").val(code);
        loadSumPrice(code);
    }
    function loadSumPrice(inout_code){
        if($("input[name=ajaxload]").val()=="1") return;
        $("input[name=ajaxload]").val("1");
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadsuminoutfromcode/" + inout_code,
            success: function (msg) {
               if(msg!= -1){
                   var price = eval(msg);

                   var sessstoreid = <?=$this->session->userdata("pgstore_id")?>;
                   $("label").removeClass("checked");
                   var typemoney = '';
                   if(price.type == 'nhap') typemoney = 'xuat';
                   else typemoney = 'nhap';

                   switch(price.pgxuattype){
                       case 'nhapkho':
//                           if(sessstoreid > 0 && sessstoreid != price.pgto){
//                               alert("Đơn hàng không thuộc cửa hàng bạn quản lý");
//                               return;
//                           }
                           $("select[name=pgstore_id]").val(price.pgto).trigger("chosen:updated");
                           $("select[name=pguser_id]").val(price.pgfrom).trigger("chosen:updated");
                           break;
                       case 'thuhoi':
//                           if(sessstoreid > 0 && sessstoreid != price.pgfrom && sessstoreid != price.pgto ){
//                               alert("Đơn hàng không thuộc cửa hàng bạn quản lý");
//                               return;
//                           }
                           <? if($this->session->userdata('pgrole')=='ketoan'):?>
                           $("select[name=pgstore_id]").val(price.pgfrom).trigger("chosen:updated");
                           $("select[name=pgstore_idall]").val(price.pgto).trigger("chosen:updated");
                           if(price.type == 'nhap') typemoney = 'nhap';
                           else typemoney = 'xuat';
                           <? else:?>
                           $("select[name=pgstore_id]").val(price.pgto).trigger("chosen:updated");
                           $("select[name=pgstore_idall]").val(price.pgfrom).trigger("chosen:updated");
                           <? endif;?>
                           break;
                       case 'xuatkho':
//                           if(sessstoreid > 0 && sessstoreid != price.pgto && sessstoreid != price.pgfrom){
//                               alert("Đơn hàng không thuộc cửa hàng bạn quản lý");
//                               return;
//                           }
                           <? if($this->session->userdata('pgrole')=='ketoan'):?>
                           $("select[name=pgstore_id]").chosen().val(price.pgto).trigger("chosen:updated");
                           $("select[name=pgstore_idall]").chosen().val(price.pgfrom).trigger("chosen:updated");
                           if(price.type == 'nhap') typemoney = 'nhap';
                           else typemoney = 'xuat';
                           <? else:?>
                           $("select[name=pgstore_id]").chosen().val(price.pgfrom).trigger("chosen:updated");
                           $("select[name=pgstore_idall]").chosen().val(price.pgto).trigger("chosen:updated");
                           <? endif;?>
                           break;
                       case 'cuahang':
                           break;
                       case 'khachhang':
//                           if(sessstoreid > 0 && sessstoreid != price.pgfrom){
//                               alert("Đơn hàng không thuộc cửa hàng bạn quản lý");
//                               return;
//                           }
                           $("select[name=pgstore_id]").val(price.pgfrom).trigger("chosen:updated");
                           $("select[name=pguser_id]").val(price.pgto).trigger("chosen:updated");
                           break;
                       case 'khachle':
//                           if(sessstoreid > 0 && sessstoreid != price.pgfrom){
//                               alert("Đơn hàng không thuộc cửa hàng bạn quản lý");
//                               return;
//                           }
                           $("select[name=pgstore_id]").val(price.pgfrom).trigger("chosen:updated");
                           break;
                       default:
                           alert("Hóa đơn không đúng");
                           myclear();
                           return;
                           break;
                   }

                   $("#"+typemoney+"radio").prop('checked', true);
                   $("label[for="+typemoney+"radio]").addClass("checked");

                   $("input[name=pgsumprice]").val(price.sum);
                   $("input[name=pgsumremain]").val(price.remain);
                   $("input[name=pginout_id]").val(price.id);
//                $("input[name=pgtypethanhtoan]").val(price.type);

                   $("input[name=pgdate]").val(mygetdate());
                   $("input[name=pghour]").val(mygettime());
                   $("select[name=pgstore_id]").prop("disabled",true).trigger("chosen:updated");
                   $("select[name=pgstore_idall]").prop("disabled",true).trigger("chosen:updated");
                   $("select[name=pguser_id]").prop("disabled",true).trigger("chosen:updated");
                 //  $('select[name=pgstore_id]').val(0).trigger("chosen:updated");
                 //  $('select[name=pguser_id]').val(0).trigger("chosen:updated");
                   $("textarea[name=pginfo]").val("Thanh toán hóa đơn #"+inout_code);
                   $("input[name=ajaxload]").val("0");
               }
                else{
                   alert("Không có đơn hàng này trong cửa hàng của bạn.");
                   myclear();
                   $("input[name=pginout_code]").val("");
                   $("input[name=ajaxload]").val("0");
                   return;
               }

            }
        });
    }
    function getStore(type){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jsGetStore/"+type,
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var userstoreid = <?=(($this->session->userdata("pgstore_id")>0)?$this->session->userdata("pgstore_id"):0)?>;
                    var province = eval(msg);
                    var option = "<option value='0'>Chọn cửa hàng</option>";
                    $.each(province, function (index, store) {
                        option += "<option value='" + store.id + "'>" + store.pglong_name + "</option>";
                    });
                    if (type == 'role') type = "";//
                    $("select[name=pgstore_id" + type + "]").html(option);
                    $('select[name=pgstore_id' + type + ']').chosen({width: "90%"});
                    if (userstoreid > 0 && type!='all')
                        $("select[name=pgstore_id" + type + "]").chosen().val(userstoreid);
                    $('select[name=pgstore_id' + type + ']').trigger("chosen:updated");

                }
            }
        });
    }
    function getUser(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadTradecustomer",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "<option value='0'>Đối tượng </option>";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.tradeid+"'>"+store.pglname+" "+store.pgfname+"<? if($this->session->userdata("pgstore_id")==0):?>  ("+store.pglong_name+")<? endif;?></option>";
                    });
                        $("select[name=pguser_id]").html(option);
                        $('select[name=pguser_id]').chosen({width:"90%"});
                        $('select[name=pguser_id]').trigger("chosen:updated");

                }
            }
        });
    }
function getUserInout(id){
    $("#inoutuser").html("");
    $.ajax({
        type:"post",
        url:"<?=base_url()?>admin/getHoaDon/1/false/"+id,
        success:function(msg){
           // var inouttr = "Không có thông tin giao dịch.";
//            if(msg!=""){
//            var inout = eval(msg);
//            inouttr = "<thead><tr><td>Mã HD </td><td>Ngày </td><td>Tổng tiền</td></tr></thead>";
//            var i = 0;
//            $.each(inout, function (index, io){
//                inouttr += "<tr "+((i%2==0)?'class="odd"':'')+"><td>"+io.inoutcode+"</td><td>"+myformatdate(io.inoutdate)+"</td><td>"+((io.sumphaitra>0)?io.sumphaitra:io.sumduocnhan)+"</td></tr>";
//                i++;
//            });
//            }
            $("#inoutuser").html(msg);
        }
    });
}
function changemoneytype(val){
    var arrmoney      = val.split("|");
    $("input[name=pgmoneyrate]").val(arrmoney[1]);
}
function printbl(id){
    window.open("<?=base_url()?>admin/printmoney/"+id);
}
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/moneytransfer/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgamount]").val(province.pgamount);
                    $("textarea[name=pginfo]").val(province.pginfo);
                    $("input[name=edit]").val(province.id);
                    $("input[name=pgmoneyrate]").val(province.pgmoneyrate);
                    $("input[name=pgdate]").val(formatDate(province.pgdate));
                    $("input[name=pghour]").val(formatTime(province.pgdate));
                    $("input[name=pginout_code]").val(province.pginout_id);

                    $("select[name=pgstore_id]").chosen().val(province.pgstore_id).trigger("chosen:updated");
                    $("select[name=pgstore_idall]").chosen().val(province.pgstore_idall).trigger("chosen:updated");
                    $("select[name=pguser_id]").chosen().val(province.pguser_id).trigger("chosen:updated");
                    $("select[name=pgmoneytype]").chosen().val(""+province.pgmoneytype+"|"+province.pgmoneyrateorg).trigger("chosen:updated");

                    $("label[for=xuatradio]").removeClass("checked");
                    $("label[for=nhapradio]").removeClass("checked");
                    $("input[value="+province.pgtype+"]").prop('checked', true);
                    $("label[for="+province.pgtype+"radio]").addClass("checked");



                }
            }
        });
    }
function del(id){
    if(confirm("Có chắc là muốn xóa giao dịch này?")){
        $.ajax({
            type:"post",
            url:"<?=base_url()?>admin/delmoney/"+id,
            success:function(msg){
                if(msg!="1"){
                    alert("Xóa  thất bại! ");
                }
                loadmoneytransfer(1);
            }
        });
    }
}
</script>

