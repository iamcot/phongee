<? if($aService != null):?>
    <? foreach($aService as $oCurrentPlace):?>
        <li class="serviceitem">
            <div class="placeleft">
                <div class="placepic"><img src="<?= base_url() . 'thumbnails/' . $oCurrentPlace->dapic ?>"></div>
                <div class="placeinfo">
                    <ul>
                        <li><h4><a href="<?=$this->mylibs->makePlaceUrl($oCurrentPlace)?>"><i class="fa fa-home"></i> <?= $oCurrentPlace->dalong_name ?></a></h4></li>
                        <li><i class="fa fa-map-marker"></i> <span><?= $oCurrentPlace->daaddr.', '.$oCurrentPlace->streetprefix.' '.$oCurrentPlace->streetname.', '.$oCurrentPlace->wardprefix.' '.$oCurrentPlace->wardname.', '.$oCurrentPlace->districtprefix.' '.$oCurrentPlace->districtname.', '.$oCurrentPlace->provinceprefix.' '.$oCurrentPlace->provincename; ?></span></li>
                        <? if ($oCurrentPlace->datel != ""): ?>
                            <li><i class="fa fa-phone-square"></i> <span><?= $oCurrentPlace->datel ?></span>
                            </li><? endif; ?>
                        <? if ($oCurrentPlace->dawebsite != ""): ?>
                            <li><i class="fa fa-cloud"></i> <span><?= $oCurrentPlace->dawebsite ?></span>
                            </li><? endif; ?>
                        <? if ($oCurrentPlace->daemail != ""): ?>
                            <li><i class="fa fa-envelope"></i> <span><?= $oCurrentPlace->daemail ?></span>
                            </li><? endif; ?>
                        <li><i class="fa fa-rocket"></i> <span>Lượt xem: <b><?= $oCurrentPlace->daview ?></b></span>
                            <!--<i class="fa fa-thumbs-up"></i>  <span>Like: <b><?=$oCurrentPlace->dalike?></b></span>-->
                        </li>
                    </ul>
                </div>
            </div>
            <div class="placemap"><?= $oCurrentPlace->damap ?></div>
        </li>
    <? endforeach; endif;?>