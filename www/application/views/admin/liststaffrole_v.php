<? if($aStaffRole != null):?>
    <? $roletype = $this->config->item('roletype');?>
    <? $i=0;foreach($aStaffRole as $staff): ?>
        <tr class="<?=(($i%2==0))?'odd':''?>">
            <td class=""><?=$staff['pgusername']?></td>
            <td class=""><?=$staff['userid']?></td>
            <td><button style="width: 100px;height: 24px;font-size: .8em" onclick="setdefault(<?=$staff['userid']?>)">Mặc định </button></td>
            <? $k=0;foreach($this->config->item('aRoleName') as $role): ?>
            <td>
                <select onchange="save1role(<?=$staff['userid']?>,'<?=$role?>',this)">
                    <option value="-1">KT</option>

                <? foreach($roletype as $r):?>
                    <option value="<?=$r[0]?>" <? if($r[0]==$staff[$role]) echo 'selected' ?>><?=$r[1]?></option>
                    <? endforeach; ?>
                </select>
               </td>
            <? $k++; endforeach;?>
        </tr>
        <? $i++;endforeach;?>
<? else:?>
<p>Không có dữ liệu </p>
<? endif;?>