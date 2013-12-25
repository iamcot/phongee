<div id="articlebox">
    <div id="leftside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i>  <?= $oCurrentStreet->daprefix ?> <?= $oCurrentStreet->dalong_name ?>, <?= $oCurrentWard->daprefix ?> <?= $oCurrentWard->dalong_name ?>,
                <?= $oCurrentDistrict->daprefix ?>  <?= $oCurrentDistrict->dalong_name ?>, <?= $oCurrentProvince->daprefix ?> <?= $oCurrentProvince->dalong_name ?></div>
            <div class="articlecontent">
                <? if ($oCurrentStreet->dainfo != ""): ?>
                    <div class="articleinfo">
                        <?= $oCurrentStreet->dainfo ?>
                    </div>
                <? endif; ?>
                <div class="articlemap <?= (($oCurrentStreet->dainfo == "") ? 'width100' : 'width60') ?>">
                    <?= $oCurrentStreet->damap ?>
                </div>
            </div>
        </div>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i>  Các dịch vụ tiêu biểu</div>
            <div class="articlecontent">

            </div>
        </div>


    </div>
    <div id="rightside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-book"></i> Dịch vụ tại <?= $oCurrentStreet->daprefix ?> <?= $oCurrentStreet->dalong_name ?></div>
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