<? if (count($aHotDealList) > 0): ?>
    <ul>
        <? foreach ($aHotDealList as $deal): ?>
            <li>
                <div style="overflow: hidden;">
                    <div style="position: relative;">
                        <a href="<?= base_url() . $deal->provinceurl . '/' . $deal->districturl . '/' . $deal->wardurl . '/' . $deal->streeturl . '/' . $deal->placeurl . '-' . $deal->placeid . '.html' . '?dealinfo=' . $deal->id ?>"
                           class="h-listtopdeal-link">
                            <div class="h-listtopdeal-address" >
                                <b><?= $deal->placename ?></b><br><?= $deal->daaddr . ', ' . $deal->streetname . ', ' . $deal->wardname . ', ' . $deal->districtname . ', ' . $deal->provincename ?>
                            </div>
                            <img class="imgdealtop4"
                                 src="<?=((isset($bIsPromoDeal) &&  $bIsPromoDeal == 1)?(base_url().'main/makethumb/?f='.$deal->dapic.'&w=500&h=200'):(base_url().'thumbnails/'.$deal->dapic)) ?>"
                                 width="100%" alt="">

                        </a>
                        <span class="dt-hightlight-saleoff" style="top:0;right: 5px;">
                <span style="position: relative">
                    <img src="/sale_promotion.png" width="30px" height="30px">
                    <span class="dt-sale-bbb" style="top:-5px">
                        <?= (($deal->datype == "percent") ? ($deal->daamount) : number_format(ceil($deal->daamount / $deal->daoldprice * 100), 0)) ?>
                        <span style="font-size: .8em"> %</span>
                    </span>
                </span>
            </span>
                    </div>
                    <div class="h-listtopdeal-title">
                        <a href="<?= base_url() . $deal->provinceurl . '/' . $deal->districturl . '/' . $deal->wardurl . '/' . $deal->streeturl . '/' . $deal->placeurl . '-' . $deal->placeid . '.html' . '?dealinfo=' . $deal->id ?>">
                            <strong><?= $deal->dalong_name ?> -
                                Giảm <?= (($deal->datype == "percent") ? ($deal->daamount) : number_format(ceil($deal->daamount / $deal->daoldprice * 100), 0)) ?>
                                %</strong></a>
                    </div>
                    <div class="h-listtopdeal-info">
                        <div class="h-listtopdeal-info-left">
                            <div>
                                <div class="colorred">
                                    <? if ($deal->datype == "percent")
                                        echo 'Giảm trên tổng hoá đơn';
                                    else echo 'Giá: ' . number_format(($deal->daoldprice - $deal->daamount), 0, ',', '.') . ' đ';
                                    ?>
                                </div>
                            </div>
                            <div style="color: #666">

                                <a class="" title="Danh sách nhận <?= $this->lang->line('dealname') ?>"
                                   href=""><i class="fa fa-user"></i>
                                    <b><?=$deal->numusersubmit?></b> người đã đăng ký
                                </a>
                            </div>
                        </div>
                        <div class="boxgetdeal">
                            <a href="<?= base_url() . $deal->provinceurl . '/' . $deal->districturl . '/' . $deal->wardurl . '/' . $deal->streeturl . '/' . $deal->placeurl . '-' . $deal->placeid . '.html' . '?dealinfo=' . $deal->id ?>">
                                Nhận <?= $this->lang->line('dealname') ?></a>
                        </div>
                    </div>
                </div>
            </li>
        <? endforeach; ?>
    </ul>

<? endif; ?>