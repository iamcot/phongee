<div id="articlebox">
    <div id="leftside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i> <?= $oCurrentDistrict->daprefix ?> <?= $oCurrentDistrict->dalong_name ?>
                , <?= $oCurrentProvince->daprefix ?> <?= $oCurrentProvince->dalong_name ?></div>
            <div class="articlecontent">
                <? if ($oCurrentDistrict->dainfo != ""): ?>
                    <div class="articleinfo">
                        <?= $oCurrentDistrict->dainfo ?>
                    </div>
                <? endif; ?>
                <div class="articlemap <?= (($oCurrentDistrict->dainfo == "") ? 'width100' : 'width60') ?>">
                    <?= $oCurrentDistrict->damap ?>
                </div>
            </div>
        </div>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i> Phường/Xã trong <?= $oCurrentDistrict->daprefix ?> <?= $oCurrentDistrict->dalong_name ?>
            </div>
            <div class="articlecontent licolor">

                <? if(isset($aWard)):?>
                    <ul >
                        <? foreach($aWard as $dist):?>
                            <li class="width20"><a href="<?=$sCurrentTree.$dist['daurl']?>"><i class="fa fa-caret-right"></i> <?=$dist['dalong_name']?></a></li>
                        <? endforeach;?>
                    </ul>
                <? endif;?>
            </div>
        </div>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i> Các tuyến đường phố
                trong <?= $oCurrentDistrict->daprefix ?> <?= $oCurrentDistrict->dalong_name ?></div>
            <div class="articlecontent licolor">
                <? if(isset($aStreet) && count($aStreet)>0):?>
                    <ul >
                        <? foreach($aStreet as $dist):?>
                            <li class="width20"><a href="<?=$sCurrentTree.$dist->wardurl.'/'.$dist->daurl?>"><i class="fa fa-caret-right"></i> <?=$dist->dalong_name?></a></li>
                        <? endforeach;?>
                    </ul>
                <? endif;?>
            </div>
        </div>
    </div>
    <div id="rightside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-book"></i> Dịch vụ tại <?= $oCurrentDistrict->daprefix ?> <?= $oCurrentDistrict->dalong_name ?></div>
            <div class="articlecontent" id="accordion">
                <? if (isset($aServiceTree) && count($aServiceTree) > 0): ?>
                    <? foreach ($aServiceTree as $aServiceGroup): ?>

                            <? if (isset($aServiceGroup[1]) && count($aServiceGroup[1]) > 0): ?>
                            <h3><?= $aServiceGroup[0] ?></h3>
                            <div>
                                <ul>
                                    <? foreach ($aServiceGroup[1] as $oService): ?>
                                        <li><a href="<?= $sCurrentTreeForService.$oService->id.'-'.$oService->daurl.'.htm' ?>"><i class="fa fa-caret-right"></i>  <?= $oService->dalong_name ?> (<?=$oService->numplace?>)</a></li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                            <? endif; ?>

                    <? endforeach; ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var icons = {
            header: "ui-icon-circle-arrow-e",
            activeHeader: "ui-icon-circle-arrow-s"
        };
        $("#accordion").accordion({
            icons: icons,
            heightStyle: "content"
        });

        });
</script>