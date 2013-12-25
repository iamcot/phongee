<? if (count($aNewDeal)): ?>
    <ul id="sidelistdeal">
        <? foreach($aNewDeal as $deal):?>
            <li><a href="<?=base_url().$deal->provinceurl.'/'.$deal->districturl.'/'.$deal->wardurl.'/'.$deal->streeturl.'/'.$deal->placeurl.'-'.$deal->placeid.'.html'.'?dealinfo='.$deal->id?>">
                    <img src="<?=base_url()?>thumbnails/<?=$deal->dapic?>">
                    <h2><?=$deal->dalong_name?></h2>
                                    <span><i class="fa fa-rocket"></i> <?= $deal->daview ?>
                                        <i class="fa fa-thumbs-up"></i>  <?=$deal->dalike?>
                                        <i class="fa fa-comments"></i>  <?=$deal->dacomment?>
                                        </span>
                </a></li>
        <? endforeach;?>
    </ul>
<? endif; ?>