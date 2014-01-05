<h3 style="text-align: center">BÁO CÁO TIỀN QUỸ <?=(($pgdatefrom!='')?'TỪ '.date('d/m/Y',strtotime($pgdatefrom)):'')?> <?=(($pgdateto!='')?'ĐẾN '.date('d/m/Y',strtotime($pgdateto)):'')?> </h3>
<center>
<? if($aReport!=null):?>
    <table style="width: 80%"  class="tblist">
        <thead>
            <tr>
                <td >Ngày</td>
                <td style="text-align: right">Dư có</td>
                <td style="text-align: right">Dư nợ</td>
                <td >Ghi chú</td>
            </tr>
        </thead>
        <tbody>
            <tr class="odd"><td>Dư đầu kỳ:</td><td colspan="3"> <b><?=number_format($dudauky,0,'.',',')?></b></td></tr>
            <? $co=0;$no=0;$i=1; foreach($aReport as $report):?>
                <tr class="<?=(($i%2==0))?'odd':''?>">
                    <td ><?=date("d/m/Y H:i",$report->pgdate)?></td>
                    <td style="text-align: right"><?=(($report->moneyin>0)?'+':'')?><?=(($report->moneyin>0)?number_format($report->moneyin,0,'.',','):'')?></td>
                    <td style="text-align: right"><?=(($report->moneyout<0)?number_format($report->moneyout,0,'.',','):'')?></td>
                    <td ><?=$report->pginfo?></td>
                </tr>
        <?
                $co+=$report->moneyin;
                $no+=$report->moneyout;
                $i++;endforeach;?>
        <tr class="odd" style="border-top: 2px solid #ddd;"><td>Tổng trong kỳ</td><td style="text-align: right"><?=number_format($co,0,'.',',')?></td><td style="text-align: right"><?=number_format($no,0,'.',',')?></td><td></td></tr>
        <tr class="odd"><td>Dư cuối kỳ</td><td><b><?=number_format(($dudauky+$co+$no),0,'.',',')?></b></td><td></td><td></td></tr>
        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>