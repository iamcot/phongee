<head>
    <meta charset="UTF-8">
</head>
<h3 style="text-align: center">BÁO CÁO CÔNG NỢ NGÀY <?=date('d/m/Y')?> </h3>
<center>
    <? if($print == 1):?><style>
        table{
            border-collapse: collapse;
        }
        .odd{
            background: #eee;
        }
        .even{
            background: #fff;
        }
        td{
            padding: 3px;
        }
        </style><? endif;?>
<? if($aReport!=null):?>
    <table style="width: 100%;"   <? if($print == 1):?>border=1<? endif;?> class="tblist">
        <thead>
            <tr>
                <td >Tên đối tượng</td>
                <td >Nhóm</td>
                <?if($khachno == 'true'):?><td style="text-align: right">Tổng nhận</td><? endif;?>
                <?if($khachno == 'true'):?><td style="text-align: right">Khách nợ</td><? endif;?>
                <?if($hanthanhtoan == 'true' && $khachno == 'true'):?><td>Hạn trả</td><? endif;?>
                <?if($shopno == 'true'):?><td style="text-align: right">Tổng trả</td><? endif;?>
                <?if($shopno == 'true'):?><td style="text-align: right">Shop nợ</td><? endif;?>
                <?if($hanthanhtoan == 'true' && $shopno == 'true'):?><td>Hạn trả</td><? endif;?>
            </tr>
        </thead>
        <tbody>
            <? $i=1;
                $sumkhachno = 0;
                $sumshopno = 0;
            foreach($aReport as $report):
                 if($report->tiennhap - $report->tienxuat > 0 ){
                $tienkhachno = 0;
                $tienshopno = $report->tiennhap - $report->tienxuat;
            }
            else{
                $tienkhachno = $report->tienxuat - $report->tiennhap;
                $tienshopno = 0;
            }
                if ($report->sumphaitra - $report->datra + $tienshopno  > 0){
                    $numDaystranhap = ($report->hanthanhtoannhap - time()) / 60 / 60 / 24;
                    if($numDaystranhap>7) $classnotra = '';
                    else if($numDaystranhap <= 7 && $numDaystranhap > 3) $classnotra = 'yellow';
                    else if($numDaystranhap <=3 && $numDaystranhap >1) $classnotra = 'orange';
                    else if($numDaystranhap<=1) $classnotra = 'red';
                }
                else $classnotra = '';

                if ($report->sumduocnhan - $report->danhan + $tienkhachno > 0)  {
                    $numDaystraxuat = ($report->hanthanhtoanxuat - time()) / 60 / 60 / 24;
                    if($numDaystraxuat>7) $classnonhan = '';
                    else if($numDaystraxuat <= 7 && $numDaystraxuat > 3) $classnonhan = 'yellow';
                    else if($numDaystraxuat <=3 && $numDaystraxuat >1) $classnonhan = 'orange';
                    else if($numDaystraxuat<=1) $classnonhan = 'red';
                }
                else $classnonhan = '';
                $tmpkhachno = $report->sumduocnhan - $report->danhan + $tienkhachno;
                $tmpshopno =  $report->sumphaitra - $report->datra + $tienshopno;
                $rskhachno = 0;
                $rsshopno = 0;

                if($tmpkhachno > $tmpshopno){
                    $rskhachno = $tmpkhachno - $tmpshopno;
                    $rsshopno = 0;
                }
                else{
                    $rskhachno = 0;
                    $rsshopno = $tmpshopno - $tmpkhachno;
                }

                ?>
                <tr class="<?=(($i%2==1))?'odd':''?>">

                    <td ><?=$report->pglname.' '.$report->pgfname?></td>
                    <td ><?=$report->pgrole?></td>
                    <?if($khachno == 'true'):?><td style="text-align: right"><a href="javascript:getDetails(<?=$report->tradeid?>,'xuat',1)"><?=number_format($report->sumduocnhan ,0,'.',',')?></a></td><? endif;?>
                    <?if($khachno == 'true'):?><td style="text-align: right" class="<?=$classnonhan?>"><a href="javascript:getDetailsMoney(<?=$report->tradeid?>,'nhap',1)"><?=number_format($rskhachno ,0,'.',',')?></a>
                    </td><? endif;?>
                    <?if($hanthanhtoan == 'true' && $khachno == 'true'):?><td><?=((($report->sumduocnhan -$report->danhan)>0 && $report->hanthanhtoanxuat == 9999999999)?date("d/m/Y",$report->hanthanhtoanxuat):'')?></td><? endif;?>
                    <?if($shopno == 'true'):?><td style="text-align: right"><a href="javascript:getDetails(<?=$report->tradeid?>,'nhap',1)"><?=number_format($report->sumphaitra ,0,'.',',')?></a></td><? endif;?>
                    <?if($shopno == 'true'):?><td style="text-align: right"  class="<?=$classnotra?>"><a href="javascript:getDetailsMoney(<?=$report->tradeid?>,'xuat',1)"><?=number_format($rsshopno ,0,'.',',')?></a>
                    </td><? endif;?>
                    <?if($hanthanhtoan == 'true' && $shopno == 'true'):?><td><?=((($report->sumphaitra - $report->datra)>0 && $report->hanthanhtoanxuat == 9999999999)?date("d/m/Y",$report->hanthanhtoannhap):'')?></td><? endif;?>

                </tr>
        <?
                $sumkhachno += $rskhachno;
                $sumshopno += $rsshopno;
                $i++;endforeach;?>
            <tr  style="border-top: 2px solid #ddd;background: #fff3f4">
                <td >Tổng nợ</td>
                <td ></td>
                <?if($khachno == 'true'):?><td style="text-align: right"></td><? endif;?>
                <?if($khachno == 'true'):?><td style="text-align: right"><b><?=number_format($sumkhachno ,0,'.',',')?></td><? endif;?>
                <?if($hanthanhtoan == 'true' && $khachno == 'true'):?><td></td><? endif;?>
                <?if($shopno == 'true'):?><td style="text-align: right"></td><? endif;?>
                <?if($shopno == 'true'):?><td style="text-align: right"><b><?=number_format($sumshopno ,0,'.',',')?></td><? endif;?>
                <?if($hanthanhtoan == 'true' && $shopno == 'true'):?><td></td><? endif;?>
            </tr>
        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>