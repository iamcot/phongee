<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pgstore_id" style="width:20%">

        <select name="pgstore_id"  style="width:80%;display: inline-block" data-placeholder="Cửa hàng">
            <option value="all">Tất cả</option>
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgmoneytypediv" style="width:20%">
        <select name="pgmoneytype" style="width: 80%;display: inline-block" data-placeholder="Loại tiền">
                <option value='all'>Tất cả loại tiền </option>
            <? foreach($this->config->item('aMoneyType') as $moneytype):?>
                <option value="<?=$moneytype[0]?>"><?=$moneytype[1]?></option>
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
    "&pgmoneytype="+$("select[name=pgmoneytype]").chosen().val()+
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
    $('select[name=pgmoneytype]').chosen({width:"100%"});
    <? if($this->session->userdata("pgstore_id")>0):?>
    getStore();
    <? endif;?>
});
function getStore(){
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/jsGetStore",
        success: function (msg) {
            if (msg == "") alert('<?=lang("NO_DATA")?>');
            else {
                var userstoreid = <?=(($this->session->userdata("pgstore_id")>0)?$this->session->userdata("pgstore_id"):0)?>;
                var province = eval(msg);
                if(userstoreid > 0)
                    var option = "";
                else
                    var option = "<option value='all'>Tất cả</option>";

                $.each(province, function (index, store){
                    option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                });
                $("select[name=pgstore_id]").html(option);
                $('select[name=pgstore_id]').chosen({width:"90%"});
                $('select[name=pgstore_id]').trigger("chosen:updated");
                if(userstoreid>0) $("select[name=pgstore_id]").val(userstoreid);

            }
        }
    });
}
</script>