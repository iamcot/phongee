<? if (isset($province)): ?>
    <table  class="tblist">
        <thead>
        <tr><td>ID</td><td>Thiết bị</td><td>Số series</td><td>Giá hiện tại</td><td></td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): ?>
               <tr class="<?=(($i%2==1))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:edit(<?=$row->id?>)"><?=$row->pglong_name?></a></td><td><?=$row->pgcode?></td><td><?=$row->pgprice?></td><td style="text-align:right"><a href="javascript:hide(<?=$row->id?>,<?=$row->pgdeleted?>)"><?=($row->pgdeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
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