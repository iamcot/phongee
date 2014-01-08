<? if (isset($province)): ?>
    <table class="tblist">
        <thead>
        <tr><td>ID</td><td>Mã hóa đơn </td><td>Ngày</td><td>Loại</td><td></td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): ?>
               <tr class="<?=(($i%2==1))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:edithoadon(<?=$row->id?>)"><?=$row->pgcode?></a></td><td><?=date("d/m/Y H:i",$row->pgdate)?></td><td><?=$row->pgtype?></td><td style="text-align:right"><a href="javascript:hideinout(<?=$row->id?>,<?=$row->pgdeleted?>)"><?=($row->pgdeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
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
            loadinout(page);
        },
        current_page: <?=$page?>
    });
    </script>
        <? endif;?>
<? endif;