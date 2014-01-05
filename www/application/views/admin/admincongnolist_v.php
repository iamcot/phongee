<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pguser_id" style="width:60%">

        <select name="pguser_id"  style="width:80%;display: inline-block" data-placeholder="Đối tượng" multiple>
            <option value="all" selected="selected">Tất cả đối tượng</option>
            <? foreach($aUser as $user):?>
                <option value="<?=$user->id?>"><?=$user->pglname.' '.$user->pgfname?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgtype" style="width:20%">

        <select name="pgtype"  style="width:80%;display: inline-block" data-placeholder="Nợ/Có ">
            <option value="all">Tất cả Nợ/Có</option>
            <option value="no">Nợ</option>
            <option value="co">Có</option>
        </select>

    </div>
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
    $("#list").load("<?=base_url()?>admin/reportcongno?pguser_id="+$("select[name=pguser_id]").chosen().val()+
    "&pgtype="+$("select[name=pgtype]").chosen().val()
    );
}
$(function(){
    $("input").customInput();

    $('select[name=pguser_id]').chosen({width:"100%"});
    $('select[name=pgtype]').chosen({width:"100%"});

});
</script>