<fieldset>
    <legend>Lựa chọn</legend>
    <div class="field_select" id="pgstore_id" style="width:20%">
        <select name="pgstore_id"  style="width:70%;display: inline-block" data-placeholder="Cửa hàng">
            <option value="all">Toàn hệ thống</option>
<!--            <option value="cuahang">Tất cả Cửa hàng</option>-->
<!--            <option value="kho">Tổng kho </option>-->
            <? foreach($aStore as $store):?>
                <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgnhomthietbi_id" style="width:20%">
        <select name="pgnhomthietbi_id"  style="width:70%;display: inline-block" data-placeholder="Nhóm Thiết bị" multiple onchange="getthietbiofgroup()">
            <option value="all" selected="selected">Tất cả Nhóm TB</option>
            <? foreach($aNhomThietbi as $thietbi):?>
                <option value="<?=$thietbi->id?>"><?=$thietbi->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgthietbi_id" style="width:20%">
        <select name="pgthietbi_id"  style="width:70%;display: inline-block" data-placeholder="Thiết bị" multiple>
            <option value="all" selected="selected">Tất cả TB</option>
            <? foreach($aThietbi as $thietbi):?>
                <option value="<?=$thietbi->id?>"><?=$thietbi->pglong_name?></option>
            <? endforeach;?>
        </select>

    </div>
    <div class="field_select" id="pgkeyword" style="width:20%">
        <input type="text" name="pgkeyword" ondblclick="this.value=''" placeholder="Lọc từ khóa ">
    </div>
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
function getthietbiofgroup(val){
    var groupid = ($("select[name=pgnhomthietbi_id]").val());
    $.ajax({
        type:"post",
        url:"<?=base_url()?>admin/getThietBiFromGroup",
        data:"group_id="+groupid,
        success: function(msg){
            if(msg !=""){
                var thietbi = eval(msg);
                var option = "<option value='all' selected='selected'>Tất cả thiết bị </option>";
                $.each(thietbi, function (index, itemthietbi){
                    option += "<option value='"+itemthietbi.id+"'>"+itemthietbi.pglong_name+"</option>";
                });
                $("select[name=pgthietbi_id]").html(option);
                $('select[name=pgthietbi_id]').chosen({width:"90%"});
                $('select[name=pgthietbi_id]').trigger("chosen:updated");
            }
        }
    })
}
function viewreport(){
    addloadgif("#list");
    $("#list").load("<?=base_url()?>admin/reporttonkho?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
    "&pgthietbi_id="+$("select[name=pgthietbi_id]").chosen().val()+"&pgnhomthietbi_id="+$("select[name=pgnhomthietbi_id]").chosen().val()+
        "&pgkeyword="+$("input[name=pgkeyword]").val()+"&print=0"
    );
}

function printreport(){
    window.open("<?=base_url()?>admin/reporttonkho?pgstore_id="+$("select[name=pgstore_id]").chosen().val()+
        "&pgthietbi_id="+$("select[name=pgthietbi_id]").chosen().val()+"&pgnhomthietbi_id="+$("select[name=pgnhomthietbi_id]").chosen().val()+
                "&pgkeyword="+$("input[name=pgkeyword]").val()+"&print=1");
}
$(function(){
    $('select[name=pgstore_id]').chosen({width:"90%"});
    $('select[name=pgthietbi_id]').chosen({width:"90%"});
    $('select[name=pgnhomthietbi_id]').chosen({width:"90%"});
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
                    var option = "<option value='all'>Toàn hệ thống</option>" +
                                 "<option value='cuahang'>Tất cả Cửa hàng</option>" +
                                 "<option value='kho'>Tổng kho </option>";
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