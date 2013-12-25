<? if(isset($aPics) && count($aPics)>0):?>
    <ul id="placepics">
        <? foreach($aPics as $pic):?>
            <li>
                <img src="<?=base_url()?>main/makethumb/?f=<?=$pic->dapic?>&w=600&h=auto">
                <i class="fa fa-quote-left"></i> <?=$pic->dacaption?> <i class="fa fa-quote-right"></i>
                <br>
                <br>
            </li>
        <? endforeach;?>
    </ul>
<? endif;?>