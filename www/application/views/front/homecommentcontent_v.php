<? if (count($aComment) > 0): ?>
    <ul>
        <? foreach ($aComment as $comment): ?>
             <li><? if($comment->dapic!=""):?>
                     <img src="/thumbnails/<?=$comment->dapic?>">
                     <? else:?>
                     <i class="fa fa-tag fa-2x"></i>
                 <? endif;?>
                 <div class="commenttext">
                 <b class="colorgreen">
                     <? if($comment->dauser_id > 0):?><a href="/user/<?=$comment->dauser_id?>">
                     <?=$comment->daname?></a>
                    <? else:?>
                     <?=$comment->daname?>
            <? endif;?>
            </b> <span class="content"> <?=$comment->cmcontent?> </span><br>
                 <div>Tại: <a href="<?=$this->mylibs->makePlaceUrl($comment)?>"><?=$comment->dalong_name?></a></div>
                 <div class="smalltext6 colorgray" style="text-align: left"><i class="fa fa-calendar"></i> <?=date("H:i d/m/Y",strtotime($comment->cmcreate))?>
                 </div>
             </div></li>
        <? endforeach; ?>
        <li>
            <? if(!isset($sCat)):?>
            <div class="pagination">
                <a href="#" class="first" data-action="first">&laquo;</a>
                <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                <input type="text" readonly="readonly" data-max-page="<?=$sumpage?>" />
                <a href="#" class="next" data-action="next">&rsaquo;</a>
                <a href="#" class="last" data-action="last">&raquo;</a>
            </div>
            <? endif;?>
        </li>
    </ul>
<? else: ?>
    <p>Chưa có bình luận nào cho điểm dịch vụ này.</p>
<? endif; ?>
<script>
$(function(){
    $('.pagination').jqPagination({
        paged: function(page) {
            loadcomment(page);
        },
        current_page: <?=$page?>,
        page_string		: 'Trang {current_page} / {max_page}'
    });
});
</script>