<? if (isset($aNews) && count($aNews) > 0): ?>
    <ul>
        <? foreach ($aNews as $news): ?>
            <li class="listblock">
                <div class="">
                    <? if ($news->dapic != ""): ?>
                        <div class="placepic"><img
                                src="<?= base_url() . 'thumbnails/' . $news->dapic ?>">
                        </div>
                    <? endif; ?>
                    <div class="placeinfo" style="padding-top:15px">
                        <ul>
                            <li><a href="?newsinfo=<?= $news->id ?>"><h4><i
                                            class="fa fa-file-text"></i> <?= $news->dalong_name ?>
                                    </h4></a></li>
                            <li><i class="fa fa-info-circle"></i> <span><?= $news->dacontent_short ?></span></li>
                            <li><i class="fa fa-calendar"></i>
                                <span><?= date("h:i d/m/Y", strtotime($news->dacreate)) ?></span>
                            </li>

                            <li><i class="fa fa-rocket"></i>
                                <span>Lượt xem: <b><?= $news->daview ?></b></span>
                                <!--<i class="fa fa-thumbs-up"></i>  <span>Like: <b><?=$news->dalike?></b></span>-->
                            </li>
                        </ul>
                    </div>
                </div>


            </li>
        <? endforeach; ?>
    </ul>
<? endif; ?>