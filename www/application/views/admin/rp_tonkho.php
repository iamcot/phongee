<head>
    <meta charset="UTF-8">
</head>
<h3 style="text-align: center">TỒN KHO
    <?if($print == -1): echo "THIẾT BỊ TRONG CỬA HÀNG ";
    elseif($pgstore_id=='all'): echo 'TẤT CẢ HỆ THỐNG ';
    elseif($pgstore_id=='cuahang'): echo 'TẤT CẢ CỬA HÀNG';
    elseif($pgstore_id=='kho'): echo 'KHO HÀNG ';
    elseif($pgstore_id>0): echo $aStore[$pgstore_id]->pglong_name." NGÀY ".date('d/m/Y')."";
    endif; ?>
</h3>
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
    <table  style="width:100%" <? if($print == 1):?>border=1<? endif;?> class="tblist">
        <thead>
            <tr>
                <td style="text-align: right;padding-right:15px">Tên thiết bị</td>
                <?if($pgallstore=='false'):?>
                <td style="text-align: left">Số lượng tồn</td>
                <? else:?>
                    <? foreach($aStore as $store):?>
                        <td><?=$store->pglong_name?></td>
                        <? endforeach;?>
                <? endif;?>
            </tr>
        </thead>
        <tbody>
            <? $i=1; foreach($aReport as $report):?>
                <tr class="<?=(($i%2==1))?'odd':''?>">
                    <td style="text-align: right;padding-right:15px"><?=$report['thietbiname']?></td>
                <?if($pgallstore=='false'):?>
                    <td style="text-align: left"><?=$report['tbcount']?></td>
                <? else:?>
                    <? foreach($aStore as $store):?>
                        <td><?=$report['tbcount'.$store->id]?></td>
                    <? endforeach;?>
                <? endif;?>
                </tr>
        <? $i++;endforeach;?>
        </tbody>
    </table>
<? else:?>
    Chưa có dữ liệu để báo cáo. Hoặc cửa hàng không còn hàng gì ^^.
<? endif;?>
    </center>