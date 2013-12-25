<? if (isset($serviceplace)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>Tiêu đề</td><td>SEO URL</td>
            <td>Bắt đầu</td><td>Kết thúc</td>
            <td>Giá cũ</td><td>Giảm</td><td>Đăng ký</td>
            <td>Xem</td><td>Bình luận</td><td>Thích</td>
            <td></td>
        </tr>
        </thead>
        <? $i=1; foreach ($serviceplace as $row): ?>
               <tr class="<?=(($i%2==0))?'odd':''?> <?=($row->dadeleted==0?'':'trdelete')?>" id="tr<?=$row->id?>">
                   <td ><?=$row->id?></td>
                   <td><a href="javascript:editProvince(<?=$row->id?>)"><?=$row->dalong_name?></a></td>
                   <td><?=$row->daurl?></td>
                   <td><?=date("d/m/Y H:i",$row->dafrom)?></td><td><?=date("d/m/Y H:i",$row->dato)?></td>cũ
                   <td style="text-align: center"><?=$row->daoldprice?></td>
                   <td style="text-align: center"><?=$row->daamount?> (<?=(($row->datype=="percent")?"%":"đ")?>)</td>
                   <td style="text-align: center"></td>
                   <td style="text-align: center"><?=$row->daview?></td>
                   <td style="text-align: center"><?=$row->dacomment?></td>
                   <td style="text-align: center"><?=$row->dalike?></td>
                   <td style="text-align:right"><a href="javascript:hideprovince(<?=$row->id?>,<?=$row->dadeleted?>)"><?=($row->dadeleted==0?'[Ẩn]':'[Hiện]')?></a></td></tr>
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
            loadlistdeal(page);
        },
        current_page: $("input[name=currpage]").val()
    });
    </script>
<? endif;