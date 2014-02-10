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
        </table>


</fieldset>

<script>
</script>