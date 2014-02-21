<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />
    <title><?= $title ?></title>
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/ckeditor/skins/moono/editor.css">
<!-- main JS libs -->
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/libs/modernizr.min.js"></script>
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/libs/jquery-1.10.2.min.js"></script>
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/libs/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/libs/bootstrap.min.js"></script>

<!-- Style CSS -->
    <link href="<?= base_url() ?>src/chubby-stacks-css/css/bootstrap.css" media="screen" rel="stylesheet">
    <link href="<?= base_url() ?>src/chubby-stacks-css/style.css" media="screen" rel="stylesheet">

<!-- General Scripts -->
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/general.js"></script>

<!--[if lt IE 9]><script src="<?= base_url() ?>src/chubby-stacks-css/js/respond.min.js"></script><![endif]-->
<!--[if gte IE 9]>
    <style type="text/css">
        .gradient {filter: none !important;}
    </style>
<![endif]-->
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/jquery.powerful-placeholder.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/smoothness/jquery-ui-1.10.3.custom.css">
<!--    <script src="--><?//= base_url() ?><!--src/jquery.min.js"></script>-->
    <script src="<?= base_url() ?>src/jquery-ui-min.js"></script>
    <script src="<?= base_url() ?>src/mylib.js"></script>
    <script src="<?= base_url() ?>src/jquery.jqpagination.min.js"></script>
    <script src="<?= base_url() ?>src/jupload/vendor/jquery.ui.widget.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.iframe-transport.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.fileupload.js"></script>

    <script src="<?= base_url() ?>src/ckeditor/ckeditor.js"></script>
    <script src="<?= base_url() ?>src/ckeditor/adapters/jquery.js"></script>
    <script src="<?= base_url() ?>src/jquery.maskedinput.min.js"></script>
    <script src="<?= base_url() ?>src/jquery.friendurl.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>src/chubby-stacks-css/css/chosen.css">
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/chosen.jquery.min.js" type="text/javascript"></script>
<!--    <script src="--><?//= base_url() ?><!--src/chubby-stacks-css/js/nicEdit.js"></script>-->
    <script src="<?= base_url() ?>src/chubby-stacks-css/js/jquery.customInput.js"></script>
    <link media="screen" type="text/css" rel="stylesheet" href="<?= base_url() ?>src/style.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/font-awesome/css/font-awesome.css">
<!--    <script src="--><?//= base_url() ?><!--src/chubby-stacks-css/js/jquery-ui.multidatespicker.js"></script>-->
    <script src="<?= base_url() ?>src/autoNumeric.js"></script>
</head>

<body>
<div id="allpage">
    <header>
        <div class="wrap">
            <h2><a href="<?=base_url()?>" class="logo"></a> - Trang quản trị</h2>
            <div class="headeruser">
                <? if ($this->session->userdata('pguser_id')): ?>
                    <? if($this->session->userdata('pgavatar')!="") echo '<img class="navavatar" src="'.base_url().'thumbnails/'.$this->session->userdata('pgavatar').'">';?>
                    <?= $this->session->userdata('pglname') . ' ' . $this->session->userdata('pgfname') ?> | <a
                        href="<?= base_url() ?>">Trang chủ</a> | <a href="<?= base_url() ?>login/logout">Đăng xuất</a>
                <? else: ?>
                    <a href="<?= base_url() ?>login">Đăng nhập</a>
                <? endif; ?>
            </div>
        </div>

    </header>
<!--    <div class="nav">-->
        <div class="wrap">
            <ul class="menu clearfix gradient">
                <li><a href="<?= base_url() ?>admin/"
                       class="<?= (($cat == 'admin') ? 'select' : '') ?>">Tổng quan</a></li>
                <? if ($this->mylibs->checkRole('pgrainout')>0): ?>
                    <li><a href="<?= base_url() ?>admin/inout"
                           class="<?= (($cat == 'inout') ? 'select' : '') ?>">Xuất/Nhập</a></li>
                <? endif ?>
                <? if ($this->mylibs->checkRole('pgrareport')>0): ?>
                    <li><a href="<?= base_url() ?>admin/report"
                           class="<?= (($cat == 'report') ? 'select' : '') ?>">Báo cáo</a></li>
                <? endif ?>
                <? if ($this->mylibs->checkRole('pgrathietbi')>0): ?>
                    <li><a href="<?= base_url() ?>admin/thietbi"
                           class="<?= (($cat == 'thietbi') ? 'select' : '') ?>">Thiết bị</a></li>
                <? endif ?>
                <? if ($this->mylibs->checkRole('pgrauser')>0): ?>
                    <li><a href="<?= base_url() ?>admin/user"
                           class="<?= (($cat == 'user') ? 'select' : '') ?>">Người dùng</a></li>
                <? endif ?>
            </ul>

        </div>
<!--    </div>-->
    <div id="content">
        <div class="wrap">
            <?= (isset($body) ? $body : "") ?>
        </div>
    </div>
    <input type="hidden" name="base_url" id="base_url" value="<?=base_url()?>">
    <div style="clear: both;"></div>
    <footer>
        <div class="wrap">
            <p>Copyright &copy 2013.</p>
        </div>
    </footer>
</div>
</body>
</html>
