<h3 style="text-align: center">BÁO CÁO TIỀN QUỸ <?
    if($pgstore_id == 'all') echo ' TOÀN HỆ THỐNG ';
    else echo $aStore[$pgstore_id]->pglong_name;
    ?> <?=(($pgdatefrom!='')?'TỪ '.date('d/m/Y',strtotime($pgdatefrom)):'')?> <?=(($pgdateto!='')?'ĐẾN '.date('d/m/Y',strtotime($pgdateto)):'')?> </h3>
<center>
<?
$aMoneyType = $this->config->item('aMoneyType');

?>
    <table style="width: 80%"  class="tblist">
        <thead>
        <tr>
            <td >Ngày</td>
            <td style="text-align: right">Dư có</td>
            <td style="text-align: right">Dư nợ</td>
            <td style="text-align: right">Ghi chú</td>
        </tr>
        </thead>
        <tbody>
        <tr style="background: #fff3f4"><td>Dư đầu kỳ:</td><td colspan="3"> <b><?=number_format($dudauky,0,'.',',')?></b></td></tr>

     <?  $co=0;$no=0; if($aReport!=null):

    ?>
    <? $i=1; foreach($aReport as $report):
                if(($report->inoutxuattype=='xuatkho' || $report->inoutxuattype=='cuahang') && $pgstore_id=='all') continue;
                ?>
                <tr class="<?=(($i%2==0))?'odd':''?>">
                    <td ><?=date("d/m/Y H:i",$report->pgdate)?></td>
                    <td style="text-align: right"><?=(($report->moneyin>0)?'+':'')?><?=(($report->moneyin>0)?number_format($report->moneyin,0,'.',',').' ('.$aMoneyType[$report->pgmoneytype][2].') ':'')?></td>
                    <td style="text-align: right"><?=(($report->moneyout<0)?number_format($report->moneyout,0,'.',',').' ('.$aMoneyType[$report->pgmoneytype][2].') ':'')?></td>
                    <td style="text-align: right"><?=$report->pginfo?></td>
                </tr>
        <?
                if($pgmoneytype=='all'){
                    $co+=$report->moneyin * $report->pgmoneyrate;
                    $no+=$report->moneyout * $report->pgmoneyrate;
                }
                else{
                    $co+=$report->moneyin ;
                    $no+=$report->moneyout ;
                }

                $i++;endforeach;?>
     <? endif;
     if($pgmoneytype == 'all') $pgmoneytype = 'tm';
     ?>
        <tr style="background: #fffeee;border-top: 2px solid #ddd;"><td>Tổng trong kỳ</td><td style="text-align: right"><?=number_format($co,0,'.',',').'('.$aMoneyType[$pgmoneytype][2].')'?> </td><td style="text-align: right"><?=number_format($no,0,'.',',').' ('.$aMoneyType[$pgmoneytype][2].')'?></td><td></td></tr>
        <tr style="background: #fff3f4"><td>Dư cuối kỳ</td><td><b><?=number_format(($dudauky+$co+$no),0,'.',',')?></b></td><td></td><td></td></tr>
        </tbody>
    </table>

    </center>