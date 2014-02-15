<? if($aInout == null):?>
<p>Không có thông tin đơn hàng</p>
<? else:
    $first = $aInout[0];
    ?>
    <head>
        <meta charset="utf-8">
        <title>Hóa đơn <?=$first->inoutcode?></title>
        <style>
            body{
                font-size: 10pt;
            }
            #logo{
                float:left;
                width: 220px;
                height: 30px;
            }
            .clear{
                clear: both;
            }
            #address{
                float:right;
            }
            #title{
                margin-top: 15px;
                text-align: center;
                font-size: 15pt;
                font-weight: 700;
            }
            #date{
                float:right;
            }
            .info{
                clear: both;
            }
            .info span{
                min-width: 150px;
                display: inline-block;
            }
            table{
                width: 100%;
                border-collapse: collapse;
            }
            td{
                border: 1px solid #000;
                padding: 3px 5px;
                vertical-align: top;
            }
            thead td{
                font-weight: bold;
                text-align: center;
            }
            .center{
                text-align: center;
            }
            .left{
                text-align: left;
            }
            .right{
                text-align: right;
            }
            ul{
                list-style: none;
            }
            li{
                display: inline-block;
                width: 30%;
                text-align: center;
                font-weight: bold;
                vertical-align: top;
            }
            div,td{
                line-height: 20px;
            }
        </style>

    </head>
    <body>
    <div id="hoadon">
        <div id="header">
            <div id="logo">
                <img src="data:image/png;base64,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">
            </div>
            <div id="address"></div>
            <div class="clear"></div>
            <div id="title">
                <? if($first->inouttype == 'nhap'): ?>
                    PHIẾU NHẬP KHO
                <? else: ?>
                    PHIẾU XUẤT KHO
                <? endif; ?>

            </div>
            <div class="center"><i>(Mã HĐ: <?=$first->inoutcode?>)</i></div>
            <div id="date">Ngày lập: <?=date("d/m/Y",$first->inoutdate)?></div>
            <div class="info">
                <span>Khách hàng (Buyer):</span>
                <span><? if($first->pgxuattype=='khachhang' || $first->pgxuattype=='nhapkho'):?>
                        <?=$first->userlname.' '.$first->userfname?>
                    <? elseif($first->pgxuattype =='khachle'):?> <?=$first->inoutto ?>
                    <? else:?>
                        <?=$first->storename?>
                    <? endif;?></span>
            </div>
            <div  class="info">
                <span>Địa chỉ (Address):</span>
                <span><? if($first->pgxuattype=='khachhang' || $first->pgxuattype=='nhapkho'):?><?=$first->useraddr?><? endif;?></span>
            </div>
            <div  class="info">
                <span>Số điện thoại (Tel):</span>
                <span><? if($first->pgxuattype=='khachhang' || $first->pgxuattype=='nhapkho'):?><?=$first->usermobi?><? endif;?></span>
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>TÊN HÀNG, DỊCH VỤ <br>(Model)</td>
                            <td>ĐVT</td>
                            <td>SỐ LƯỢNG <br>(Quantity)</td>
                            <td>ĐƠN GIÁ <br>(Unit Price)</td>
                            <td>THÀNH TIỀN <br>(Amount)</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    $sum = 0;
                    $i=1;foreach($aInout as $inout):?>
                        <tr>
                            <td class="center"><?=$i?></td>
                            <td class="left"><?=$inout->thietbiname?>
                            <br>S/N: <?=$inout->pgseries?>
                                <br>
                             Bảo hành: <?=$inout->pgtgbh?>
                            </td>
                            <td class="center"><?=$inout->pgdvt?></td>
                            <td class="center"><?=number_format($inout->pgcount,0,'.',',')?></td>
                            <td class="right"><?=number_format($inout->pgprice,0,'.',',')?></td>
                            <td class="right"><?=number_format(($inout->pgcount * $inout->pgprice),0,'.',',')?></td>
                        </tr>
                    <?
                        $sum+=$inout->pgcount * $inout->pgprice;
                        $i++;endforeach;?>
                    <tr>
                        <td colspan="5" class="center"><b>CỘNG TIỀN HÀNG (Sub Total)</b></td>
                        <td class="right"><b><?=number_format($sum,0,'.',',')?></b></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="center">
                            <b>Số tiền bằng chữ (In Words): <?=$this->mylibs->convert_number_to_words($sum)?> đồng./.</b>
                        </td>
                    </tr>
                    </tbody>

                </table>
                <div>
                    * Tạm xuất hàng chờ kiểm chứng bảo hành, dùng phiếu này để xuất hóa đơn tài chính.
                </div>
                <div>
                    * Giá trên chưa bao gồm thuế GTGT 10%.
                </div>
            </div>
            <ul>
                <li>Người mua hàng</li>
                <li>Người giao hàng</li>
                <li>Người lập phiếu<br><br><br><?=$first->pglname.' '.$first->pgfname?></li>
                </ul>
        </div>

    </div>
    </body>

<? endif;?>