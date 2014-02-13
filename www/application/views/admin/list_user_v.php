<? if (isset($province)): ?>
    <table  class="tblist">
        <thead>
        <tr><td>ID</td><td>Họ Tên</td><td>Tài khoản</td><td>Quyền</td><td></td></tr>
        </thead>
        <?
        $pgrluser = $this->mylibs->checkRole('pgrluser');
        $aRoleOrder = $this->config->item("aRoleOrder");
        $i=1; foreach ($province as $row):
        if($aRoleOrder[$this->session->userdata("pgrole")] > $aRoleOrder[$row->pgrole] || $this->session->userdata("pgrole") == 'admin'|| $this->session->userdata("pguser_id") == $row->id):
            ?>
               <tr class="<?=(($i%2==1))?'odd':''?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>"><td><?=$row->id?></td><td><a href="javascript:edit(<?=$row->id?>)"><?=$row->pglname.' '.$row->pgfname?></a></td><td><?=$row->pgusername?></td><td><?=$row->pgrole?></td>
                   <td style="text-align:right">
                       <? if($pgrluser>=4):?>
                       <a href="javascript:hide(<?=$row->id?>,<?=$row->pgdeleted?>)"><?=($row->pgdeleted==0?'[Ẩn]':'[Hiện]')?></a>
                        <? endif;?>
            </td></tr>
        <? endif;$i++; endforeach; ?>
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