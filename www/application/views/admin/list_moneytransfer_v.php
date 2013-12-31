<? if (isset($province)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>Thanh toán </td><td>Ngày</td><td>Loại</td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): $inout_id = $row->pginout_id;?>
               <tr class="<?=(($i%2==0))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:edithoadon(<?=$row->id?>)"><?=$row->pgamount?></a></td><td><?=date("d/m/Y H:i:s",strtotime($row->pgcreate))?></td><td><?=$row->pgtype?></td></tr>
        <? $i++; endforeach; ?>
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
            loadmoneytransfer(page,<?=$inout_id?>);
        },
        current_page: <?=$page?>
    });
    </script>
    <? endif;?>
<? endif;