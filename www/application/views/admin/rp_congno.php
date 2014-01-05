<h3 style="text-align: center">BÁO CÁO CÔNG NỢ NGÀY <?=date('d/m/Y')?> </h3>
<center>
<? if($aReport!=null):?>
    <table style="width: 90%"  class="tblist">
        <thead>
            <tr>
                <td >Tên đối tượng</td>
                <td >Nhóm</td>
                <td style="text-align: right">Tổng nhận</td>
                <td style="text-align: right">Khách nợ</td>
                <td style="text-align: right">Tổng trả</td>
                <td style="text-align: right">Shop nợ</td>
            </tr>
        </thead>
        <tbody>
            <? $i=1;
                $sumkhachno = 0;
                $sumshopno = 0;
            foreach($aReport as $report):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td ><?=$report->pglname.' '.$report->pgfname?></td>
                    <td ><?=$report->pgrole?></td>
                    <td style="text-align: right"><?=number_format($report->sumduocnhan ,0,'.',',')?></td>
                    <td style="text-align: right"><?=number_format($report->sumduocnhan -$report->danhan ,0,'.',',')?></td>
                    <td style="text-align: right"><?=number_format($report->sumphaitra ,0,'.',',')?></td>
                    <td style="text-align: right"><?=number_format($report->sumphaitra - $report->datra ,0,'.',',')?></td>
                </tr>
        <?
                $sumkhachno +=  ($report->sumduocnhan -$report->danhan);
                $sumshopno += ($report->sumphaitra - $report->datra);
                $i++;endforeach;?>
            <tr class="odd" style="border-top: 2px solid #ddd;">
                <td >Tổng nợ</td>
                <td ></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"><b><?=number_format($sumkhachno ,0,'.',',')?></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"><b><?=number_format($sumshopno ,0,'.',',')?></td>
            </tr>
        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>