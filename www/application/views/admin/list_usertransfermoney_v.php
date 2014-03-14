<style>
    table {
        width: 100%;
    }

    td {
        padding: 3px;
    }
</style>
<div id="list">
    <? if ($aMoney != null): ?>
        <h4>Giao dịch tiền </h4>
        <table class="tblist">
            <thead>
            <tr>
                <td>Thời gian</td>
                <td>Số tiền</td>
                <td>Cửa hàng</td>
                <td>Loại</td>
                <td>Cửa hàng/Đối tác</td>
                <td>Ghi chú</td>
            </tr>
            </thead>
            <tbody>
            <?
            $moneyType = $this->config->item("aMoneyType");
            $i = 1;
            foreach ($aMoney as $money):?>
                <tr class="<?= (($i % 2 == 1)) ? 'odd' : '' ?>">
                    <td><?= date("d/m/Y", $money->pgdate) ?></td>
                    <td><?= number_format($money->pgamount, 0, '.', ',') ?>
                        (<?= $moneyType[$money->pgmoneytype][1] ?>)
                    </td>
                    <td><?= (($money->pgstore_id>0)?$aStore[$money->pgstore_id]['pglong_name']:'') ?></td>
                    <td><?= $money->pgtype ?></td>
                    <td><?= ((isset($money->pguser_id) && $money->pguser_id > 0) ? $aCustom[$money->pguser_id]['pgfname'] : $aStore[$money->pgstore_idall]['pglong_name']) ?></td>
                    <td><?= $money->pginfo ?></td>
                </tr>
                <? $i++;endforeach; ?>
            </tbody>
        </table>
    <? if ($sumpage > 1): ?>
        <div class="pagination">
            <a href="#" class="first" data-action="first">&laquo;</a>
            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
            <input type="text" readonly="readonly" data-max-page="<?= $sumpage ?>"/>
            <a href="#" class="next" data-action="next">&rsaquo;</a>
            <a href="#" class="last" data-action="last">&raquo;</a>
        </div>
        <script>
    $('.pagination').jqPagination({
        paged: function (page) {
            getDetailsMoney(<?=$store_id?>, '<?=$type?>', page);
        },
        current_page: <?=$page?>
    });
    </script>
    <? endif; ?>
        <?else:?>
        <p>Chưa có thông tin giao dịch</p>
    <? endif; ?>
</div>