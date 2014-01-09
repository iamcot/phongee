<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pgstore_id" style="width:30%">

        <select name="pgstore_id"  style="width:80%;display: inline-block" data-placeholder="Cửa hàng">
            <option value="all">Tất cả</option>
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
<!--    <div class="field_select" id="pgtype" style="width:20%">-->
<!---->
<!--        <select name="pgtype"  style="width:80%;display: inline-block" data-placeholder="Gửi/rút">-->
<!--            <option value="all" selected="selected">Tất cả gửi/rút</option>-->
<!--            <option value="xuat">Tiền rút</option>-->
<!--            <option value="nhap">Tiền gửi</option>-->
<!--        </select>-->
<!---->
<!--    </div>-->
    <label>Từ ngày </label>
    <input type="text" name="pgdatefrom" id="pgdatefrom" placeholder="Từ ngày" style="width:15%" value="<?=date("Y-m-d", strtotime("-1 months"));?>">
    <label>Đến ngày </label>
    <input type="text" name="pgdateto" id="pgdateto" placeholder="Đến ngày" style="width:15%" value="<?=date("Y-m-d", strtotime("+1 day"));?>">
    <div class="btn btn-small">
        <input type="button" value="Xem" onclick="viewreport()">
    </div>

</fieldset>
<fieldset>
    <legend>Báo cáo</legend>
    <div id="list"></div>
</fieldset>
<script>
function viewreport(){
    $("#list").load("<?=base_url()?>admin/reporttienquy?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
    "&pgtype="+$("select[name=pgtype]").chosen().val()+
    "&pgdatefrom="+$("input[name=pgdatefrom]").val()+
    "&pgdateto="+$("input[name=pgdateto]").val()
    );
}
$(function(){
    $("input").customInput();

    $( "#pgdatefrom" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
    $( "#pgdateto" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd"
    });
    $('select[name=pgstore_id]').chosen({width:"100%"});
    $('select[name=pgtype]').chosen({width:"100%"});

});
</script>