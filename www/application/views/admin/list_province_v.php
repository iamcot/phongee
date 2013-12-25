<? if (isset($province)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>Tiêu đề</td><td>SEO URL</td><td></td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): ?>
               <tr class="<?=(($i%2==0))?'odd':''?> <?=($row->dadeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:editProvince(<?=$row->id?>)"><?=$row->dalong_name?></a></td><td><?=$row->daurl?></td><td style="text-align:right"><a href="javascript:hideprovince(<?=$row->id?>,<?=$row->dadeleted?>)"><?=($row->dadeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
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
            loadProvince(page);
        },
        current_page: $("input[name=currpage]").val()
    });
    </script>
<? endif;