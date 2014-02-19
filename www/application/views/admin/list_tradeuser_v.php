<? if($aUser!=null):?>
    <h3>Các tài khoản giao dịch của thành viên này </h3>
    <table>
        <thead>
        <tr>
            <td>Trade ID</td>
            <td>User ID</td>
            <td>Tên cửa hàng </td>
        </tr>
        </thead>
        <tbody>
        <?foreach($aUser as $user):?>
            <tr>
                <td><?=$user->id?></td>
                <td><?=$user->pguser_id?></td>
                <td><?=$user->pglong_name?> </td>
            </tr>
        <? endforeach;?>
        </tbody>
    </table>
    <? else:?>
    <p>Chưa có tài khoản giao dịch nào của thành viên này </p>
<? endif;?>