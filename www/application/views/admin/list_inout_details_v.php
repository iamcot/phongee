<? if (isset($province)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>S/N Thiet bi</td><td>Mã hóa đơn </td><td>Giá</td><td></td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): ?>
               <tr class="<?=(($i%2==0))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:editchitiethoadon(<?=$row->id?>)"><?=$row->pgseries?></a></td><td><?=$row->pginout_id?></td><td><?=$row->pgprice?></td><td style="text-align:right"><a href="javascript:hide(<?=$row->id?>,<?=$row->pgdeleted?>)"><?=($row->pgdeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
        <? $i++; endforeach; ?>
    </table>
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
            load(page);
        },
        current_page: <?=$page?>
    });
    </script>
<? endif;