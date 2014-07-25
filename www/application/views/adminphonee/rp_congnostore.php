<head>
    <meta charset="UTF-8">
</head>
<h3 style="text-align: center">BÁO CÁO CÔNG NỢ CỬA HÀNG NGÀY <?=date('d/m/Y')?> </h3>
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
                <td >Cửa hàng</td>
                <td>Tổng nhập hàng</td>
                <td>Tổng xuất hàng </td>
                <td>Tiền nhập </td>
                <td>Tiền xuất</td>
            </tr>
        </thead>
        <tbody>
            <? $i=1;

            foreach($aReport as $report):?>
                <? if($this->session->userdata("pgrole")=='ketoan'):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td rowspan="2"><?=$report->pglong_name?></td>
                    <td><a href="javascript:getDetails(<?=$report->id?>,'nhap',1)"><?=number_format($report->sumnhap,0,'.',',')?><a/></td>
                    <td><a href="javascript:getDetails(<?=$report->id?>,'xuat',1)"><?=number_format($report->sumxuat,0,'.',',')?><a/></td>
                    <td><a href="javascript:getDetailsMoney(<?=$report->id?>,'nhap',1)"><?=number_format($report->tiennhap+$report->traxuat,0,'.',',')?><a/> </td>
                    <td><a href="javascript:getDetailsMoney(<?=$report->id?>,'xuat',1)"><?=number_format($report->tienxuat+$report->tranhap,0,'.',',')?><a/></td>
                </tr>
                <tr>
                    <td colspan="4">
                        Tổng nợ: <b><?=number_format(($report->sumnhap - $report->sumxuat + ($report->tiennhap+$report->traxuat) - ($report->tienxuat+$report->tranhap) ),0,'.',',')?></b>
                    </td>
                </tr>
                    <?else:?>
                    <tr class="<?=(($i%2==1))?'odd':''?>">
                        <td rowspan="2"><?=$report->pglong_name?></td>
                        <td><a href="javascript:getDetails(<?=$report->id?>,'xuat',1)"><?=number_format($report->sumxuat,0,'.',',')?><a/></td>
                        <td><a href="javascript:getDetails(<?=$report->id?>,'nhap',1)"><?=number_format($report->sumnhap,0,'.',',')?><a/></td>
                        <td><a href="javascript:getDetailsMoney(<?=$report->id?>,'nhap',1)"><?=number_format($report->tiennhap+$report->tranhap,0,'.',',')?><a/> </td>
                        <td><a href="javascript:getDetailsMoney(<?=$report->id?>,'xuat',1)"><?=number_format($report->tienxuat+$report->traxuat,0,'.',',')?><a/></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            Tổng nợ: <b><?=number_format(($report->sumxuat - $report->sumnhap + ($report->tiennhap+$report->tranhap) - ($report->tienxuat+$report->traxuat) ),0,'.',',')?></b>
                        </td>
                    </tr>
                    <? endif;?>
        <?

                $i+=2;endforeach;?>

        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>