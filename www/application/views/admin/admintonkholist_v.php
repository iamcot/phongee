<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pgstore_id" style="width:40%">
        <select name="pgstore_id"  style="width:70%;display: inline-block" data-placeholder="Cửa hàng">
            <option value="all">Tất cả Cửa hàng</option>
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgthietbi_id" style="width:40%">
        <select name="pgthietbi_id"  style="width:70%;display: inline-block" data-placeholder="Thiết bị" multiple>
            <option value="all" selected="selected">Tất cả TB</option>
            <? foreach($aThietbi as $thietbi):?>
                <option value="<?=$thietbi->id?>"><?=$thietbi->pglong_name?></option>
            <? endforeach;?>
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
    $("#list").load("<?=base_url()?>admin/reporttonkho?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
    "&pgthietbi_id="+$("select[name=pgthietbi_id]").chosen().val()
    );
}
$(function(){
    $('select[name=pgstore_id]').chosen({width:"90%"});
    $('select[name=pgthietbi_id]').chosen({width:"90%"});

});
</script>