<? if (isset($aDeal) && count($aDeal) > 0): ?>
    <ul >
    <? foreach ($aDeal as $deal): ?>
        <li class="listblock">
            <div class="placeleft">
                <div class="placepic"><img src="<?= base_url() . 'thumbnails/' . $deal->dapic ?>">
                </div>
                <div class="placeinfo">
                    <ul>
                        <li><a href="?dealinfo=<?=$deal->id?>"><h4><i class="fa fa-tag"></i> <?= $deal->dalong_name ?></h4></a></li>
                        <li><i class="fa fa-home"></i>
                            <span><?= $oCurrentPlace->dalong_name ?></span></li>
                            <li><i class="fa fa-calendar"></i>
                            <span><?= date("d/m/Y",$deal->dafrom).' - '.date("d/m/Y",$deal->dato) ?></span>
                            </li>

                        <li><i class="fa fa-rocket"></i>
                            <span>Lượt xem: <b><?= $deal->daview ?></b></span>
                        <li><i class="fa fa-user"></i>
                            <span>Đăng ký: <b><?= $deal->numusersubmit ?></b></span>
                            <!--<i class="fa fa-thumbs-up"></i>  <span>Like: <b><?=$oCurrentPlace->dalike?></b></span>-->
                        </li>
                    </ul>
                </div>
                </div>
                <div class="placemap">
                    <div id="dealinfo">
                        <h4>Thông tin</h4>
                        <ul>
                            <li><i class="fa fa-tag"></i>
                                <span><b class="colorred">- <?=number_format($deal->daamount,0,',','.')?></b> <span style="font-size: .8em"><?=(($deal->datype=="percent")?"%":"đ")?></span></span>
                            </li>
                            <li><i class="fa fa-dollar"></i>
                                <span><b class="colorred"><?=(($deal->datype=="percent")?number_format($deal->daoldprice * (100- $deal->daamount)/100,0,',','.'):number_format(($deal->daoldprice - $deal->daamount),0,',','.'))?></b> <span style="font-size: .8em">đ</span> </span>
                            </li>
                            <li><i class="fa fa-strikethrough"></i>
                                <span style="text-decoration: line-through;font-size:.8em"><?=number_format($deal->daoldprice,0,',','.')?> đ </span>
                            </li>
                        </ul>
                    </div>
                    <div id="dealstatus">
                        <h4>Trạng thái</h4>
                        <div class="boxgetdeal">
                            <a href="?dealinfo=<?=$deal->id?>">
                                Nhận</a>
                        </div>
                    </div>
                </div>


        </li>
        <? endforeach;?>
    </ul>
<? endif; ?>