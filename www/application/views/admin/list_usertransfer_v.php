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
            <td>Mã HĐ </td>
            <td>Thời gian </td>
            <td>S/n  </td>
            <td>Thiết bị  </td>
            <td>Từ </td>
            <td>Đến </td>
            <td>Giá  </td>
            <td>S/lg  </td>
            <td>Tổng </td>
            <td>Hạn thanh toán </td>
        </tr>
        </thead>
        <tbody>
        <? $i=1;foreach($aInout as $money):?>
            <tr class="<?=(($i%2==1))?'odd':''?>">
                <td><?=$money->inoutcode?></td>
                <td><?=date("d/m/Y",$money->inoutdate)?></td>
                <td><?=$money->pgseries?></td>
                <td><?=$money->thietbiname?></td>
                <td><?=(($money->pgxuattype=='nhapkho')?$aCustom[$money->inoutfrom]['pgfname']:$aStore[$money->inoutfrom]['pglong_name'])?></td>
                <td><?=(($money->pgxuattype=='khachhang')?$aCustom[$money->inoutto]['pgfname']:$aStore[$money->inoutto]['pglong_name'])?></td>
                <td><?=number_format($money->pgprice,0,'.',',')?></td>
                <td><?=number_format($money->pgcount,0,'.',',')?></td>
                <td><?=number_format($money->pgprice*$money->pgcount,0,'.',',')?></td>
                <td><?=date("d/m/Y",$money->pghanthanhtoan)?></td>

            </tr>
            <? $i++;endforeach;?>
        </tbody>
    </table>
    <? if($sumpage > 1):?>
        <div class="pagination">
            <a href="#" class="first" data-action="first">&laquo;</a>
            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
            <input type="text" readonly="readonly" data-max-page="<?=$sumpage?>" />
            <a href="#" class="next" data-action="next">&rsaquo;</a>
            <a href="#" class="last" data-action="last">&raquo;</a>
        </div>
        <script>
    $('.pagination').jqPagination({
        paged: function(page) {
            getDetails(<?=$store_id?>,'<?=$type?>',page);
        },
        current_page: <?=$page?>
    });
    </script>
    <? endif;?>

<?endif;?>
    </div>