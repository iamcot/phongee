<style>
    table{
        width: 100%;
    }
    td{
        padding: 3px;
    }
</style>
<div id="list">
<? if($aInout !=null):?>
    <h4>Giao dịch hàng hóa </h4>
    <table  class="tblist">
        <thead>
        <tr>
            <td>Thời gian </td>
            <td>S/n  </td>
            <td>Thiết bị  </td>
            <td>Từ </td>
            <td>Đến </td>
            <td>Giá  </td>
            <td>S/lg  </td>
            <td>Hạn thanh toán </td>
        </tr>
        </thead>
        <tbody>
        <? $i=1;foreach($aInout as $money):?>
            <tr class="<?=(($i%2==1))?'odd':''?>">
                <td><?=date("d/m/Y",$money->inoutdate)?></td>
                <td><?=$money->pgseries?></td>
                <td><?=$money->thietbiname?></td>
                <td><?=(($money->inouttype=='nhap')?$aCustom[$money->inoutfrom]['pgfname']:$aStore[$money->inoutfrom]['pglong_name'])?></td>
                <td><?=(($money->inouttype=='xuat')?$aCustom[$money->inoutto]['pgfname']:$aStore[$money->inoutto]['pglong_name'])?></td>
                <td><?=number_format($money->pgprice,0,'.',',')?></td>
                <td><?=number_format($money->pgcount,0,'.',',')?></td>
                <td><?=date("d/m/Y",$money->pghanthanhtoan)?></td>

            </tr>
            <? $i++;endforeach;?>
        </tbody>
    </table>
    <br><br>
<?endif;?>
<? if($aMoney !=null):?>
    <h4>Giao dịch tiền </h4>
    <table class="tblist">
        <thead>
        <tr>
            <td>Thời gian </td>
            <td>Số tiền  </td>
            <td>Loại  </td>
            <td>Ghi chú </td>
        </tr>
        </thead>
        <tbody>
            <? $i=1;foreach($aMoney as $money):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td><?=date("d/m/Y",$money->pgdate)?></td>
                    <td><?=number_format($money->pgamount,0,'.',',')?>  </td>
                    <td><?=$money->pgtype?></td>
                    <td><?=$money->pginfo?></td>
                </tr>
        <? $i++;endforeach;?>
        </tbody>
    </table>
<?endif;?>
    </div>