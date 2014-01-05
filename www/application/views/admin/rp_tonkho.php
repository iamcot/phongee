<h3 style="text-align: center">BÁO CÁO TỒN KHO <?=(($pgstore_id=='all')?'TẤT CẢ CỬA HÀNG':$aStore[$pgstore_id]->pglong_name)?> NGÀY <?=date('d/m/Y')?> </h3>
<center>
<? if($aReport!=null):?>
    <table style="width: 50%"  class="tblist">
        <thead>
            <tr>
                <td style="text-align: right;padding-right:15px">Tên thiết bị</td>
                <td style="text-align: left">Số lượng tồn</td>
            </tr>
        </thead>
        <tbody>
            <? $i=1; foreach($aReport as $report):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td style="text-align: right;padding-right:15px"><?=$report->thietbiname?></td>
                    <td style="text-align: left"><?=$report->tbcount?></td>
                </tr>
        <? $i++;endforeach;?>
        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>