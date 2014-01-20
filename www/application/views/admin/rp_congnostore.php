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
                <td>Tổng nhập</td>
                <td>Nợ nhập</td>
                <td>Tổng xuất</td>
                <td>Nợ xuất</td>
                <td>Tiền nhập </td>
                <td>Tiền xuất</td>
            </tr>
        </thead>
        <tbody>
            <? $i=1;

            foreach($aReport as $report):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td ><?=$report->pglong_name?></td>
                    <td><?=number_format($report->sumnhap,0,'.',',')?></td>
                    <td><?=number_format($report->sumnhap - $report->tranhap,0,'.',',')?></td>
                    <td><?=number_format($report->sumxuat,0,'.',',')?></td>
                    <td><?=number_format($report->sumxuat - $report->traxuat,0,'.',',')?></td>
                    <td><?=number_format($report->tiennhap,0,'.',',')?> </td>
                    <td><?=number_format($report->tienxuat,0,'.',',')?></td>
                </tr>
        <?

                $i++;endforeach;?>

        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo.
<? endif;?>
    </center>