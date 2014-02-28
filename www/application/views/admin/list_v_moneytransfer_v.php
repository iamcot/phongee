<? if (isset($province)):
    $amoneytype = $this->config->item('aMoneyType');
    ?>
    <table style="text-align: right" class="tblist">
        <thead>
        <tr><td>ID</td><td></td><td>Ngày</td><td>CH Nguồn</td><td>CH đích</td><td>Đối tượng </td></td><td>Thanh toán </td><td>Loại tiền</td><td>Mã HĐ</td><td>Loại</td><td>Ghi chú</td></tr>
        </thead>
        <? $i=1; foreach ($province as $row): $inout_id = $row->pginout_id;?>
               <tr class="<?=(($i%2==1))?'odd':'even'?> <?=($row->pgdeleted==0?'':'trdelete')?>"
                   id="tr<?=$row->id?>">
                   <td><?=$row->id?>

                   </td>
                   <td><? if($row->inoutcode==''):?><a href="javascript:printbl(<?=$row->id?>)"><i class="fa fa-print"></i></a><? endif;?></td>
                   <td><?=date("d/m/Y H:i",($row->pgdate))?></td>
                   <td><?=(($row->storename!="")?$row->storename:"Tổng kho")?></td>
                   <td><?=$row->storenameall?></td>
                   <td><?=(($row->username)?$row->username:"Tổng kho")?></td>
                   <td ><a href="javascript:edithistory(<?=$row->id?>)"><?=number_format($row->pgamount,0,'.',',')?></a></td>
                   <td><?=$amoneytype[$row->pgmoneytype][1]?></td>
                   <td><?=$row->inoutcode?></td>
                   <td><?=(($row->pginout_id ==0)?(($row->pgtype=='nhap')?'Nhập Tiền':'Xuất Tiền'):'Thanh toán')?></td>
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