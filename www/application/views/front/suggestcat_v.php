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
<? endif;?>