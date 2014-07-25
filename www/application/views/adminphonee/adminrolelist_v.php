<fieldset>
    <legend>Thông tin</legend>
    <div id="rolenotif"></div>
        <table id="tablerole" >
            <thead>
            <tr>
                <td class="">Tên TV</td>
                <td class="">Mã TV</td>
                <td></td>
                <? foreach($this->config->item('aRoleName') as $role):?>
                    <td><?=$this->lang->line($role)?></td>
                <? endforeach;?>
            </tr>
            </thead>
            <tbody id="listrole">

            </tbody>
        </table>


</fieldset>

<script>
$(function(){
   load();
});
function load(){
    $("#listrole").load("<?=base_url()?>admin/loadstaffrole");
}
function save1role(userid,rolename,select){
    $("#rolenotif").html("");
    $.ajax({
        type:"get",
        url: "<?=base_url()?>admin/save1role/"+userid+"/"+rolename+"/"+select.value,
        success:function(msg){
            if(msg==1) msg = 'Thành công';
            else msg = 'Thất bại';
            $("#rolenotif").html(msg);
        }
    });
}
function setdefault(userid){
    $("#rolenotif").html("");
    $.ajax({
        type:"get",
        url: "<?=base_url()?>admin/savedefault/"+userid,
        success:function(msg){
            if(msg==1) msg = 'Thành công';
            else msg = 'Thất bại';
            $("#rolenotif").html(msg);
            load();
        }
    });
}
</script>