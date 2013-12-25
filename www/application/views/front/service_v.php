<div id="articlebox">
    <div id="leftside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-cogs"></i> <?=$sTitle?> tại <?=$currentLevel?></div>
            <? if($aService != null):?>
            <ul class="articlecontent" id="servicelist">


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
                <? endforeach; ?>
            </ul>

            <div class="pagination">
                <a href="#" class="first" data-action="first">&laquo;</a>
                <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                <input type="text" title="Nhập số trang để di chuyển nhanh tới trang" readonly="readonly" data-max-page="<?=$sumpage?>" />
                <a href="#" class="next" data-action="next">&rsaquo;</a>
                <a href="#" class="last" data-action="last">&raquo;</a>
            </div>

            <br>
            <input type="hidden" name="currpage" value="0">

            <script>
                $('.pagination').jqPagination({
                    paged: function(page) {
                        loadProvince(page);
                    },
                    page_string		: 'Trang {current_page} / {max_page}'
                });
                function loadProvince(page) {
                    console.log($(location).attr('href'));
                    $("#servicelist").load("?page=" + page);
                }

            </script>
                <? else:?>
                <p style="margin:15px">Chưa có dữ liệu về dịch vụ này</p>
            <? endif;?>
        </div>

    </div>
    <div id="rightside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-book"></i> Dịch vụ tại <?= $currentobject->daprefix ?> <?= $currentobject->dalong_name ?></div>
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