<? if (isset($province)): ?>
    <table style="text-align: right" class="tblist">
        <thead>
        <tr><td>ID</td><td>Ngày</td><td>Thanh toán </td><td>Mã HĐ</td><td>Loại</td><td>Ghi chú</td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): $inout_id = $row->pginout_id;?>
               <tr class="<?=(($i%2==1))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>">
                   <td><?=$row->id?></td>
                   <td><?=date("d/m/Y H:i:s",($row->pgdate))?></td>
                   <td ><a href="javascript:edithistory(<?=$row->id?>)"><?=number_format($row->pgamount,0,'.',' ')?></a></td>
                   <td><?=$row->pginout_id?></td>
                   <td><?=$row->pgtype?></td>
                    <td><?=$row->pginfo?></td>
            </tr>
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