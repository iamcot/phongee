<div style="overflow: hidden">
<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace" style="width:70%">
        <tr>
            <td id="hoadoninfo">
                <? if($this->mylibs->checkRole('pgrbnhaptien')):?>
                <span style="display: inline-block;float: left;">
                <input type="radio" name="pgtype" value="nhap"  id="nhapradio">
                <label for="nhapradio">Nhập tiền</label>
                    </span>
                <? endif;?>
                <? if($this->mylibs->checkRole('pgrbxuattien')):?>
                 <span style="display: inline-block;;float: left;">
                <input type="radio" name="pgtype" value="xuat"  id="xuatradio">
                <label for="xuatradio">Rút tiền</label>
                 </span>
                <? endif;?>
                <div id="pguseriddiv" style="display: block;clear:both;">
                    <select name="pguser_id" style="width: 100%;display: inline-block" data-placeholder="Thành viên">

                    </select>
                </div>
                <br>
                <div id="pgstoreiddiv" style="display: block;clear:both;">
                    <select name="pgstore_id" style="width: 100%;display: inline-block" data-placeholder="Cửa hàng">

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
                <label>Số tiền</label>
                <input tabindex="4" type="text" name="pgamount"  placeholder="Số tiền" style="width:70%;display:inline-block">
                <br><br>
                <textarea tabindex="5" name="pginfo" placeholder="Ghi chú" style="width:100%;display:block"></textarea>

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

<fieldset >
    <legend>Lịch sử gần đây</legend>
    <div id="list_hoadon"></div>
</fieldset>
</div>
<script>
    $(function () {
        $('#pghour').mask('99:99:99');
        $('#pgdate').mask('9999-99-99');
        $("input[name=pgamount]").autoNumeric({aSep:' ',aPad: false});

       $("input").customInput();
        $( "#pgdate" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });

    });
    $(function () {
        getStore();
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
        var pguser_id      = $("select[name=pguser_id]").val();

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
        else if(parseInt(remainprice) == 0){
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
                    + "&pginfo=" + pginfo
                    + "&pgtype=" + pgtype
                    + "&pguser_id=" + pguser_id
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
        $("select[name=pgstore_id]").prop("disabled",false);
        $("select[name=pguser_id]").prop("disabled",false);
        $('select[name=pgstore_id]').val(0).trigger("chosen:updated");
        $('select[name=pguser_id]').val(0).trigger("chosen:updated");


    }
    function loadSumPrice(inout_code){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadsuminoutfromcode/" + inout_code,
            success: function (msg) {
               if(msg!= -1){
                   var price = eval(msg);
                   $("input[name=pgsumprice]").val(price.sum);
                   $("input[name=pgsumremain]").val(price.remain);
                   $("input[name=pginout_id]").val(price.id);
//                $("input[name=pgtypethanhtoan]").val(price.type);
                   $("label").removeClass("checked");
                   $("#"+price.type+"radio").prop('checked', true);
                   $("label[for="+price.type+"radio]").addClass("checked");
                   $("input[name=pgdate]").val(mygetdate());
                   $("input[name=pghour]").val(mygettime());
                   $("select[name=pgstore_id]").prop("disabled",true);
                   $("select[name=pguser_id]").prop("disabled",true);
                   $('select[name=pgstore_id]').val(0).trigger("chosen:updated");
                   $('select[name=pguser_id]').val(0).trigger("chosen:updated");
                   $("textarea[name=pginfo]").val("Thanh toán hóa đơn #"+inout_code);               }
                else{
                   alert("Không có đơn hàng này");
                   $("input[name=pginout_code]").val("");
               }

            }
        });
    }
    function getStore(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jsGetStore",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "<option value='0'>Cửa hàng </option>";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                    });
                        $("select[name=pgstore_id]").html(option);
                        $('select[name=pgstore_id]').chosen({width:"90%"});
                        $('select[name=pgstore_id]').trigger("chosen:updated");

                }
            }
        });
    }
    function getUser(){
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/jxloadcustomer",
            success: function (msg) {
                if (msg == "") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    var option = "<option value='0'>Đối tượng</option>";
                    $.each(province, function (index, store){
                        option += "<option value='"+store.id+"'>"+store.pglname+" "+store.pgfname+"</option>";
                    });
                        $("select[name=pguser_id]").html(option);
                        $('select[name=pguser_id]').chosen({width:"90%"});
                        $('select[name=pguser_id]').trigger("chosen:updated");

                }
            }
        });
    }
</script>

