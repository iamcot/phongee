<? if (isset($newslist)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>Tiêu đề </td><td>Seo url </td><td>Sửa cuối </td><td>Xem </td><td>Bình</td><td>Thích </td><td></td></tr>
        </thead>
        <? $i=1; foreach ($newslist as $row): ?>
               <tr class="<?=(($i%2==1))?'odd':''?> <?=($row->dadeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td>
                   <td><a href="javascript:editnews(<?=$row->id?>)"><?=$row->dalong_name?></a></td>
                   <td><?=$row->daurl.'-'.$row->id.'.html'?></td>
                   <td><?=date("d/m/Y H:i",strtotime($row->daedit))?></td>
                   <td><?=$row->daview?></td>
                   <td><?=$row->dacomment?></td>
                   <td><?=$row->dalike?></td>
                   <td style="text-align:right"><a href="javascript:hidenews(<?=$row->id?>,<?=$row->dadeleted?>)"><?=($row->dadeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
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
            loadnews(page);
        },
        current_page: 1
    });
    </script>
<? endif;