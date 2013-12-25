<? if (isset($sHotDealList) && $sHotDealList != ""): ?>
    <div class="articlebox">
        <div class="cattitle"><?=$this->lang->line('dealname')?> HOT <i class="icon icon-hot"></i></div>
        <div class="articlecontent homedealhot" id="">
            <?=$sHotDealList?>
        </div>
    </div>
<? endif; ?>
<? if (isset($catsdeal)): ?>
    <? foreach ($catsdeal as $catdeal): ?>
        <? if($catdeal[2] != ""):?>
        <div class="articlebox">
            <div class="cattitle"><a href="?s=<?=$catdeal[1]?>"><?=$catdeal[0]?></a></div>
            <div class="articlecontent homecatdeal" id="">
                <?=$catdeal[2]?>
            </div>
        </div>
         <? endif;?>
    <? endforeach; ?>
<? endif; ?>
<div id="articlebox">
    <div id="leftside">
        <div class="articlebox">
            <div class="cattitle"><i class="icon icon-hot"></i>  Địa chỉ được quan tâm</div>
            <div class="articlecontent">
                <? if(count($sServicePlace_hot)>0):?>
                    <ul class="bxslider">
                        <? foreach($sServicePlace_hot as $place):?>
                            <li>
                                <a href="<?=$this->mylibs->makePlaceUrl($place)?>">
                                <img src="<?=base_url()?>main/makethumb/?f=<?=$place->dapic?>&w=320&h=200"
                                     title="<?=$place->dalong_name.'<br>'.$place->streetname.', '.$place->wardname.', '.$place->districtname?>">

                                </a>
                            </li>
                        <? endforeach;?>
                    </ul>
                <? endif;?>
            </div>
        </div>
        <div class="articlebox newssuggest">
            <div class="cattitle ">
                <div class="titletext"><i class="fa fa-question-circle"></i> Gợi ý dịch vụ</div>
                <ul>
                    <? foreach($this->config->item("aNewsSuggest") as $k=>$v){
                        echo '<li id="suggestbutton'.$k.'" class="'.(($k==$sSuggestRandom)?'select':'').'"><a href="javascript:changenewsuggest(\''.$k.'\')"><i class="fa fa-'.$v[1].'"></i> '.$v[0].'</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="articlecontent">
                <? foreach($this->config->item("aNewsSuggest") as $k=>$v):?>
                    <div class="suggesttab" id="suggest<?=$k?>" style="<?=(($k==$sSuggestRandom)?'':'display:none')?>">
                        <? if(!isset($aNewsSuggest[$k]) || count($aNewsSuggest[$k])==0):?>
                            <p>Chưa có thông tin cho mục này. </p>
                        <? else:?>
                            <img src="/thumbnails/<?=$aNewsSuggest[$k][0]->dapic?>">
                            <div class="contenttext">
                                <h4><a href="/goi-y-dia-chi/<?=$oCurrentProvince->daurl.'/'.$aNewsSuggest[$k][0]->daurl.'-'.$aNewsSuggest[$k][0]->id.'.html'?>"><?=$aNewsSuggest[$k][0]->dalong_name?></a></h4>
                                <ul>
                                <li><div><?=$aNewsSuggest[$k][0]->dacontent_short?></div> </li>

                                <? $i=0;
                                    foreach($aNewsSuggest[$k] as $row){
                                    if($i==0){
                                        $i++;
                                        continue;
                                    }
                                    echo '<li><a href="/goi-y-dia-chi/'.$oCurrentProvince->daurl.'/'.$row->daurl.'-'.$row->id.'.html'.'"><i class="fa fa-info-circle"></i> '.$row->dalong_name.'</a></li>';
                                    $i++;
                                }?>
                                </ul>

                            </div>
                        <? endif;?>
                    </div>
                <? endforeach;?>
            </div>
        </div>
        <div class="articlebox">
            <div class="cattitle"><i class="icon icon-new"></i> Địa chỉ mới</div>
            <div class="articlecontent">
                <? if(count($sServicePlace_new)>0):?>
                    <ul class="bxslider">
                        <? foreach($sServicePlace_new as $place):?>
                            <li>
                                <a href="<?=$this->mylibs->makePlaceUrl($place)?>">
                                    <img src="<?=base_url()?>main/makethumb/?f=<?=$place->dapic?>&w=320&h=200"
                                         title="<?=$place->dalong_name.'<br>'.$place->streetname.', '.$place->wardname.', '.$place->districtname?>">
                                </a>
                            </li>
                        <? endforeach;?>
                    </ul>
                <? endif;?>
            </div>
        </div>
        <? if(count($aPopularService)>0):?>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-heart"></i> Dịch vụ phổ biến</div>
            <div class="articlecontent popularservice">
                <ul>
                <? foreach($aPopularService as $service):?>
                    <li><a href="/<?=$service->provinceurl.'/'.$service->daservice_id.'-'.$service->serviceurl.'.htm'?>"><?=$service->servicename?> <i class="colorgray">(<?=$service->numserviceplace?>)</i></a></li>
                <? endforeach;?>
                </ul>
            </div>
        </div>
        <? endif;?>
    </div>
    <div id="rightside">
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-map-marker"></i> Quận/Huyện</div>
            <div class="articlecontent licolor">
                <? //var_dump($aDistrict);?>
                <? if(isset($aDistrict)):?>
                <ul >
                    <? foreach($aDistrict as $dist):?>
                        <li><a href="<?=$sCurrentTree.$dist['daurl']?>"><i class="fa fa-caret-right"></i> <?=$dist['dalong_name']?></a></li>
                    <? endforeach;?>
                </ul>
                <? endif;?>
            </div>
        </div>
        <div class="articlebox">
            <div class="cattitle"><i class="fa fa-comments-o"></i> Đánh giá mới</div>
            <div class="articlecontent" id="commentcontent">
                <?=$sComment?>
            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function(){
 $(".bxslider").bxSlider({
     captions: true,
     auto: true,
     autoControls: false,
     minSlides: 2,
     maxSlides: 2,
     slideWidth: 320,
     slideMargin: 10
 });
});
function changenewsuggest(cat){
    $(".suggesttab").hide();
    $("#suggest"+cat).show();
    $('.newssuggest').find("li[id^='suggestbutton']").removeClass('select');
    $("#suggestbutton"+cat).addClass("select");
}
</script>