<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pguser_id" style="width:35%">

        <select name="pgstore_id"  style="width:80%;display: inline-block" data-placeholder="Cửa hàng" multiple>
            <option value="all" selected="selected">Tất cả cửa hàng</option>
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
<!--    <span style="display: inline-block;width: 15%">-->
<!--      <input type="checkbox" name="hanthanhtoan" id="hanthanhtoan" checked="checked">-->
<!--        <label for="hanthanhtoan">Hạn thanh toán </label>-->
<!---->
<!--    </span>-->
<!--    <span style="display: inline-block;width:15%">-->
<!--      <input type="checkbox" name="khachno" id="khachno" checked="checked">-->
<!--        <label for="khachno">Khách nợ </label>-->
<!---->
<!--    </span>-->
<!--    <span style="display: inline-block;width: 15%">-->
<!--      <input type="checkbox" name="shopno" id="shopno" checked="checked">-->
<!--        <label for="shopno">Shop nợ </label>-->
<!---->
<!--    </span>-->
<!--    <div class="field_select" id="pgtype" style="width:20%">-->
<!---->
<!--        <select name="pgtype"  style="width:80%;display: inline-block" data-placeholder="Nợ/Có ">-->
<!--            <option value="all">Tất cả Nợ/Có</option>-->
<!--            <option value="no">Nợ</option>-->
<!--            <option value="co">Có</option>-->
<!--        </select>-->
<!---->
<!--    </div>-->
    <div class="btn btn-small">
        <input type="button" value="Xem" onclick="viewreport()">

    </div>
    <div class="btn btn-small">
        <input type="button" value="In" onclick="printreport()">

    </div>

</fieldset>
<fieldset>
    <legend>Báo cáo</legend>
    <div id="list"></div>
</fieldset>
<script>
function viewreport(){
    $("#list").load("<?=base_url()?>admin/reportcongnostore?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
        "&print=0"
    );
}
function printreport(){
    window.open("<?=base_url()?>admin/reportcongnostore?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
    "&print=1");
}
$(function(){
    $("input").customInput();

    $('select[name=pgstore_id]').chosen({width:"100%"});
    $('select[name=pgtype]').chosen({width:"100%"});
    $("#dialog").dialog({
        autoOpen:false,
        width:800,
        modal:true,
        title:'Lịch sử giao dịch '
    });

});
function getDetails(userid){
    $("#dialog").load("<?=base_url()?>admin/jsgetStoreTransfer/"+userid,function(){$("#dialog").dialog("open")});

}
</script>
<div id="dialog">

</div>