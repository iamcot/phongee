<head>
    <meta charset="UTF-8">
</head>
<h3 style="text-align: center">BÁO CÁO TỒN KHO <?
    if($pgstore_id=='all') echo 'TẤT CẢ HỆ THỐNG ';
    else if($pgstore_id=='cuahang') echo 'TẤT CẢ CỬA HÀNG';
    else if($pgstore_id=='kho')
        echo 'KHO HÀNG ';
    else echo $aStore[$pgstore_id]->pglong_name?> NGÀY <?=date('d/m/Y')?> </h3>
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
    <table style="width: 50%;"   <? if($print == 1):?>border=1<? endif;?> class="tblist">
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