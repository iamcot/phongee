<fieldset>
    <legend>Thông tin</legend>
        <table id="inputserviceplace" >
            <thead>
            <tr>
                <td>Tên TV</td>
                <td>Mã TV</td>
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
    $.ajax({
        type:"get",
        url: "<?=base_url()?>admin/save1role/"+userid+"/"+rolename+"/"+select.value,
        success:function(msg){
            alert(msg);
        }
    });
}
</script>