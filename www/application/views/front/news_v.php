<div id="leftside" class="<? if ($oNews == null && $sType != $this->config->item('suggest')) echo 'width100' ?>">
    <div class="articlebox ">


            <? if ($oNews != null && $cattype == ""): ?>
                <div class="cattitle"><i
                        class="fa fa-info-circle"></i>
                    <? if ($oNews != null): ?><?= $oNews->dalong_name ?>
                        <div>
                <span style="font-size:.7em;"><i
                        class="fa fa-calendar"></i>
                    <?= date("h:i d/m/Y", strtotime($oNews->dacreate)) ?>

                </span>
                <span style="font-size:.7em;padding-left: 10px;"><i class="fa fa-rocket"></i>
                    <span>Lượt xem: <b><?= $oNews->daview ?></b></span> </span>
                        </div>

                </div>
                <? endif; ?>
        <div class="articlecontent">
                <ul>

                    <li>
                        <i style="font-size:.8em;padding: 10px 15px;"><?= $oNews->dacontent_short ?></i>
                    </li>
                    <? if ($oNews->dapic != ""): ?>
                        <li style="margin:15px auto 15px;text-align: center"><img
                                src="<?= base_url() . 'images/' . $oNews->dapic ?>"
                                style="max-width:80%">
                        </li>
                    <? endif; ?>
                    <li style="text-align: justify;line-height: 1.5em;"><?= $oNews->dacontent ?></li>
                </ul>
        </div>
            <? else: ?>
                <? if ($sType == "help"): ?>

                        <div class="cattitle"><i class="fa fa-folder"></i></div>
                        <div class="articlecontent newsfolder">
                            <? if (count($aCat) > 0): ?>
                                <ul>
                                    <? $currentcat = "";
                                    $i = 0;
                                    foreach ($aCat as $key => $cat):?>
                                        <li>
                                            <i class="fa fa-caret-down"></i> <?= $this->lang->line($key) ?></li>
                                        <li>
                                            <ul>
                                                <? foreach ($cat as $item): ?>
                                                    <li>
                                                        <i class="fa fa-caret-right"></i>
                                                        <a href="/help/<?=$oCurrentProvince->daurl?>/<?= $item->daurl . '-' . $item->id . '.html' ?>"><?= $item->dalong_name ?></a>
                                                    </li>
                                                <? endforeach; ?>
                                            </ul>
                                        </li>
                                        <? $i++; endforeach; ?>
                                </ul>
                            <? endif; ?>
                        </div>
                    <? elseif ($sType == $this->config->item('suggest')): ?>
        <div class="articlecontent suggestcat">
            <ul id="suggestcontent">
                <? if(count($aCat)>0):?>
                    <? foreach ($aCat as $cat):
                        foreach ($cat as $item):?>
                        <li>
                            <? if ($item->dapic != ""): ?>
                                <img src="<?= base_url() ?>thumbnails/<?= $item->dapic ?>" >

                            <? endif?>
                            <ul>
                                <li><a href="/<?=$sType?>/<?=$oCurrentProvince->daurl?>/<?= $item->daurl . '-' . $item->id . '.html' ?>"><?= $item->dalong_name ?></a></li>
                                <li class="smalltext9"><i><?=$item->dacontent_short?></i></li>
                                <li class="smalltext8"><i class="fa fa-calendar"></i> <?= date("H:i d/m/Y", strtotime($item->dacreate)) ?></li>
                            </ul>
                        </li>

                    <? endforeach;?>
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
                        loadsuggest(page);
                    },
                    page_string		: 'Trang {current_page} / {max_page}',
                    current_page: <?=$crrpage?>
                });
                function loadsuggest(page) {
                    console.log($(location).attr('href'));
                    $("#suggestcontent").load("?page=" + page);
                }

            </script>
                <? endforeach; ?>
                    <? else:?>
                    <p>Chưa có thông tin trong mục này.</p>
                        <? endif;?>
                </ul>
            </div>
                <? else: ?>

                    <? if (count($aCat) > 0): ?>
                        <? $currentcat = "";
                        $i = 0;
                        foreach ($aCat as $key => $cat):?>
                            <div class="cattitle"><i class="fa fa-file-text"></i> <?= $this->lang->line($key) ?></div>
                            <div class="articlecontent newscat">
                                <ul>
                                    <? foreach ($cat as $item): ?>
                                        <li>
                                            <? if ($item->dapic != ""): ?>
                                                <img
                                                    src="<?= base_url() ?>thumbnails/<?= $item->dapic ?>"
                                                    style="width:50px">

                                            <? endif?>
                                            <ul>
                                                <li><a href="/news/<?=$oCurrentProvince->daurl?>/<?= $item->daurl . '-' . $item->id . '.html' ?>"><?= $item->dalong_name ?></a></li>
                                                <li class="smalltext8"><i class="fa fa-calendar"></i> <?= date("H:i d/m/Y", strtotime($item->dacreate)) ?></li>
                                            </ul>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                        <? endforeach;?>

                    <? endif;?>
                <? endif; ?>
            <? endif; ?>

    </div>
    <? if($showcomment):?>
    <div class="articlebox">
        <div class="cattitle"><i class="fa fa-comments-o"></i> Bình luận</div>
        <div class="articlecontent">

        </div>
    </div>
    <? endif;?>
</div>
<? if($oNews != null || $sType == $this->config->item('suggest')):?>
<div id="rightside">
    <? if ($sType == "help"): ?>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-folder"></i></div>
            <div class="articlecontent newsfolder">
                <? if (count($aCat) > 0): ?>
                    <ul>
                        <? $currentcat = "";
                        $i = 0;
                        foreach ($aCat as $key => $cat):?>
                            <li>
                                <i class="fa fa-caret-down"></i> <?= $this->lang->line($key) ?></li>
                            <li>
                                <ul>
                                    <? foreach ($cat as $item): ?>
                                        <li>
                                            <i class="fa fa-caret-right"></i>
                                            <a href="/help/<?=$oCurrentProvince->daurl?>/<?= $item->daurl . '-' . $item->id . '.html' ?>"><?= $item->dalong_name ?></a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </li>
                            <? $i++; endforeach; ?>
                    </ul>
                <? endif; ?>
            </div>
        </div>
        <? elseif($sType == $this->config->item('suggest')):?>
    <div class="articlebox">
        <div class="cattitle"><i class="fa fa-folder"></i></div>
        <div class="articlecontent newssuggestcat">
            <ul>
            <? foreach($this->config->item('aNewsSuggest') as $k=>$v):?>
                <li>

                    <a href="/<?=$sType?>/<?=$oCurrentProvince->daurl?>/<?=$k?>"><i class="fa fa-<?=$v[1]?>"></i> <?= $v[0] ?></a>
                </li>
            <? endforeach;?>
            </ul>
            </div>
        </div>
    <? else: ?>
        <div class="articlebox">
            <? if (count($aCat) > 0): ?>
            <? $currentcat = "";
            $i = 0;
            foreach ($aCat as $key => $cat):?>
            <div class="cattitle"><i class="fa fa-file-text"></i> <?= $this->lang->line($key) ?></div>
            <div class="articlecontent newscat">
                <ul>
                    <? foreach ($cat as $item): ?>
                        <li>
                            <? if ($item->dapic != ""): ?>
                                <img
                                    src="<?= base_url() ?>thumbnails/<?= $item->dapic ?>"
                                    style="width:50px">

                            <? endif?>
                            <ul>
                                <li><a href="/<?=$sType?>/<?=$oCurrentProvince->daurl?>/<?= $item->daurl . '-' . $item->id . '.html' ?>"><?= $item->dalong_name ?></a></li>
                                <li class="smalltext8"><i class="fa fa-calendar"></i> <?= date("H:i d/m/Y", strtotime($item->dacreate)) ?></li>
                            </ul>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
            <? endforeach;?>
        </div>
          <? endif;?>
    <? endif; ?>
</div>
           <? endif;?>

