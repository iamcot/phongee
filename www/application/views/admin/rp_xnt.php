<head>
    <meta charset="UTF-8">
</head>
<h3 style="text-align: center">BÁO CÁO XUẤT NHẬP TỒN <?=(($pgdatefrom!='')?'TỪ '.date('d/m/Y',strtotime($pgdatefrom)):'')?> <?=(($pgdateto!='')?'ĐẾN '.date('d/m/Y',strtotime($pgdateto)):'')?></h3>
<? if($aReport!=null):?>
<? $aStorelist = array();
foreach($pgstore_id as $store){
    if($store == 'all'){
        $aStorelist = array('all'=>array(
            'key' => 'all',
            "name" => 'Tất cả các cửa hàng',
            "val" => array(),
        ));
        break;
    }
    else{
        $aStorelist[$store] =  array(
            'key' => $store,
            "name"=>$aStore[$store]->pglong_name,
            "val"=>array());
    }
}
?>
<?  $aTable = array();
    foreach($aReport as $row){
        if(isset($aStorelist['all'])){
            $aStorelist['all']['val'][] = $row;
        }
        else{
            if($row->inouttype=='xuat' && isset($aStorelist[$row->inoutfrom]))
                $aStorelist[$row->inoutfrom]['val'][] = $row;
            if($row->pgxuattype!='khachhang' && isset($aStorelist[$row->inoutto]))
                $aStorelist[$row->inoutto]['val'][] = $row;
        }
    }?>
<?
 $col = 9;
    ?>
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
        <table style="width: 100%;"   <? if($print == 1):?>border=1<? endif;?> class="tblist">
    <thead>
    <tr>
        <td>#</td>
<!--        <td>Xuất-Nhập</td>-->
        <td>Từ</td>
        <td>Đến</td>
        <td>Mã ĐH </td>
        <td>S/N</td>
        <td>Slg</td>
        <td style="text-align: right">Giá</td>
        <td>Ngày</td>
    <? if($pgcreateuser=='true'): $col++;?><td>Người tạo</td><? endif;?>
        <? if($pgname=='true'): $col++;?><td>Tên TB</td><? endif;?>
        <? if($pgcode=='true'): $col++;?><td>Mã TB</td><? endif;?>
        <? if($pgcolor=='true'): $col++;?><td>Màu</td><? endif;?>
        <? if($pgcountry=='true'): $col++;?><td>Nước SX</td><? endif;?>
        <? if($pgyear=='true'): $col++;?><td>Năm SX</td><? endif;?>
        <td style="text-align: right">Tổng tiền</td>
    </tr>
    </thead>
    <tbody>
<?
    foreach ($aStorelist as $store): ?>
        <tr style="background: lightskyblue;font-weight: 700">
            <td colspan="<?=$col?>"><?= $store['name'] ?></td>
        </tr>
        <? $i=1; foreach ($store['val'] as $row): ?>
            <? if($pgtype=='all' || $pgtype == '' || $store['name']=='all'  ||
                ($pgtype == 'nhap' && $row->inoutto == $store['key']) || ($pgtype == 'xuat' && $row->inoutfrom == $store['key'])):?>
            <tr class="<?=(($i%2==0))?'odd':''?>" >
                <td><?=$i?></td>
<!--                <td>--><?//=$row->inouttype?><!--</td>-->
                <td><? if($row->pgxuattype=='nhapkho'):?>
                        <?=$aProvider[$row->inoutfrom]->pgfname?>
                <?else:?>
                        <?=$aStore[$row->inoutfrom]->pglong_name?>
                <? endif;?></td>
                <td><?
                    if ($row->pgxuattype == 'khachhang')
                        echo $aProvider[$row->inoutto]->pgfname;
                    else if ($row->pgxuattype == 'khachle')
                        echo $row->inoutto;
                    else
                        echo $aStore[$row->inoutto]->pglong_name;


                     ?></td>
                <td><?=$row->inoutcode?></td>
                <td><?=$row->pgseries?></td>
                <td><?=$row->pgcount?></td>
                <td style="text-align: right"><?=number_format($row->pgprice,0,'.',',')?></td>
                <td><?=date('d/m/Y',$row->inoutdate)?></td>
                <? if($pgcreateuser=='true'): $col++;?><td><?=$row->pglname.' '.$row->pgfname?></td><? endif;?>
                <? if($pgname=='true'): $col++;?><td><?=$row->thietbiname?></td><? endif;?>
                <? if($pgcode=='true'): $col++;?><td><?=$row->pgthietbi_code?></td><? endif;?>
                <? if($pgcolor=='true'): $col++;?><td><?=$row->pgcolor?></td><? endif;?>
                <? if($pgcountry=='true'): $col++;?><td><?=$row->pgcountry?></td><? endif;?>
                <? if($pgyear=='true'): $col++;?><td><?=$row->pgyear?></td><? endif;?>
                <td  style="text-align: right"><?=number_format(($row->saleprice*$row->pgcount),0,'.',',')?> <? if ($row->pgsaleamount > 0): echo "(- ".number_format($row->pgsaleamount, 0, '.', ',');
                        if ($row->pgsaleunit == 'abs'): echo 'đ';
                        else: echo '%'; endif; echo ')'; endif; ?></td>
            </tr>
        <? $i++;?>
            <? endif; endforeach; ?>
    <? endforeach; ?>
</tbody></table>
<? else:?>
    <center>Chưa có dữ liệu để báo cáo.</center>
<? endif;?>