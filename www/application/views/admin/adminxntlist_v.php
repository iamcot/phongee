<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pgstore_id" style="width:18%">

        <select name="pgstore_id"  style="width:80%;display: inline-block" data-placeholder="Cửa hàng" multiple>
<!--            <option value="all" selected="selected">Tất cả</option>-->
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pguser_id" style="width:18%">

        <select name="pguser_id"  style="width:100%;display: inline-block" data-placeholder="Đối tượng" multiple>
            <option value="all" selected="selected">Tất cả đối tượng</option>
            <? foreach($aCustom as $user):?>
                <option value="<?=$user['tradeid']?>"><?=$user['pglname'].' '.$user['pgfname']?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgtype" style="width:10%">

        <select name="pgtype"  style="width:100%;display: inline-block" data-placeholder="Xuất/nhập ">
            <option value="all">All X/N</option>
            <option value="xuat">Xuất</option>
            <option value="nhap">Nhập</option>
        </select>

    </div>
    <input type="text" name="pgdatefrom" id="pgdatefrom" placeholder="Từ ngày" style="width:12%" value="<?=date("Y-m-d", strtotime("-1 months"));?>">
    <input type="text" name="pgdateto" id="pgdateto" placeholder="Đến ngày" style="width:12%" value="<?=date("Y-m-d",strtotime("+1 day"));?>">
    <input type="text" name="pgseries" placeholder="S/N Thiết bị" style="width:10%;display: inline-block">
    <div class="btn btn-small">
        <input type="button" value="Xem" onclick="viewreport()">
    </div>
    <div class="btn btn-small">
        <input type="button" value="In" onclick="printreport()">
    </div>
    <div class="clearfix"></div>
    <div id="checkfield">
        <?
        if($this->mylibs->isTongKho($this->session->userdata("pgrole"))):?>
         <span style="display: inline-block;">
        <input type="checkbox" name="showalltongkho" id="showalltongkho" checked="checked">
        <label for="showalltongkho">Chỉ giao dịch cửa hàng</label>
            </span>
        <?endif;?>
         <span style="display: inline-block;">
        <input type="checkbox" name="pgname" id="pgname" checked="checked">
        <label for="pgname">Tên thiết bị</label>
            </span>
         <span style="display: inline-block;">
        <input type="checkbox" name="pgcode" id="pgcode" checked="checked">
        <label for="pgcode">Mã thiết bị</label>
            </span>
         <span style="display: inline-block;">
        <input type="checkbox" name="pgprice" id="pgprice" checked="checked">
        <label for="pgprice">Giá</label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pgcreateuser" id="pgcreateuser" checked="checked">
        <label for="pgcreateuser">Người tạo</label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pgyear" id="pgyear">
        <label for="pgyear">Năm sx </label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pgcountry" id="pgcountry">
        <label for="pgcountry">Nước sx </label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pgcolor" id="pgcolor">
        <label for="pgcolor">Màu</label>
            </span>

    </div>

</fieldset>
<fieldset>
    <legend>Báo cáo</legend>
    <div id="list"></div>
</fieldset>
<script>
function viewreport(){
    addloadgif("#list");
    $("#list").load("<?=base_url()?>admin/reportxnt?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
    "&pguser_id="+$("select[name=pguser_id]").chosen().val()+
    "&pgtype="+$("select[name=pgtype]").chosen().val()+
    "&pgdatefrom="+$("input[name=pgdatefrom]").val()+
    "&pgdateto="+$("input[name=pgdateto]").val()+
    "&pgname="+$("input[name=pgname]").prop("checked")+
    "&pgcode="+$("input[name=pgcode]").prop("checked")+
    "&pgprice="+$("input[name=pgprice]").prop("checked") +
    "&pgcountry="+$("input[name=pgcountry]").prop("checked") +
    "&pgcolor="+$("input[name=pgcolor]").prop("checked") +
    "&pgseries="+$("input[name=pgseries]").val() +
    "&pgyear="+$("input[name=pgyear]").prop("checked")+
    "&showalltongkho="+$("input[name=showalltongkho]").prop("checked")+
        "&print=0"
    );
}
function printreport(){
    window.open("<?=base_url()?>admin/reportxnt?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
        "&pguser_id="+$("select[name=pguser_id]").chosen().val()+
        "&pgtype="+$("select[name=pgtype]").chosen().val()+
        "&pgdatefrom="+$("input[name=pgdatefrom]").val()+
        "&pgdateto="+$("input[name=pgdateto]").val()+
        "&pgname="+$("input[name=pgname]").prop("checked")+
        "&pgcode="+$("input[name=pgcode]").prop("checked")+
        "&pgprice="+$("input[name=pgprice]").prop("checked") +
        "&pgcountry="+$("input[name=pgcountry]").prop("checked") +
        "&pgcolor="+$("input[name=pgcolor]").prop("checked") +
        "&pgseries="+$("input[name=pgseries]").val() +
        "&pgyear="+$("input[name=pgyear]").prop("checked")+
        "&showalltongkho="+$("input[name=showalltongkho]").prop("checked")+
        "&print=1");
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
    $('select[name=pguser_id]').chosen({width:"100%"});
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
//                if(userstoreid > 0)
                    var option = "";
//                else
//                    var option = "<option value='all' selected='selected'>Tất cả</option>";

                $.each(province, function (index, store){
                    option += "<option value='"+store.id+"'>"+store.pglong_name+"</option>";
                });
                $("select[name=pgstore_id]").html(option);
                $('select[name=pgstore_id]').chosen({width:"90%"});
                if(userstoreid>0) $("select[name=pgstore_id]").val(userstoreid);
                $('select[name=pgstore_id]').trigger("chosen:updated");



            }
        }
    });
}
</script>