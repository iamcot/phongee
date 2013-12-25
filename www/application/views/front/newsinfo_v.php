<h2><?=$oNews->dalong_name?></h2>
<ul>
    <li style="font-size:.8em;padding: 10px 15px 5px;"><i class="fa fa-calendar"></i>
        Đăng ngày: <?= date("h:i d/m/Y", strtotime($oNews->dacreate)) ?>
    </li>
    <li style="font-size:.8em;padding: 5px 15px;"><i class="fa fa-rocket"></i>
        <span>Lượt xem: <b><?= $oNews->daview ?></b></li>
    <li><i style="font-size:.8em;padding: 10px 15px;"><?=$oNews->dacontent_short?></i></li>
    <? if ($oNews->dapic != ""): ?>
        <li style="margin:15px auto 15px;text-align: center"><img
                src="<?= base_url() . 'images/' . $oNews->dapic ?>" style="max-width:80%">
        </li>
    <? endif; ?>
    <li style="text-align: justify;line-height: 1.5em;"><?=$oNews->dacontent?></li>
</ul>