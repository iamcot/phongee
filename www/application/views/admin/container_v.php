<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />
    <title><?= $title ?></title>
    <link media="screen" type="text/css" rel="stylesheet" href="<?= base_url() ?>src/style.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/ckeditor/skins/moono/editor.css">
    <link type="text/css" rel="stylesheet"
          href="<?= base_url() ?>src/smoothness/jquery-ui-1.10.3.custom.css">
    <script src="<?= base_url() ?>src/jquery.min.js"></script>
    <script src="<?= base_url() ?>src/mylib.js"></script>
    <script src="<?= base_url() ?>src/jquery-ui-min.js"></script>
    <script src="<?= base_url() ?>src/jquery.jqpagination.min.js"></script>
    <script src="<?= base_url() ?>src/jupload/vendor/jquery.ui.widget.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.iframe-transport.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.fileupload.js"></script>
    <script src="<?= base_url() ?>src/ckeditor/ckeditor.js"></script>
    <script src="<?= base_url() ?>src/ckeditor/adapters/jquery.js"></script>
    <script src="<?= base_url() ?>src/jquery.maskedinput.min.js"></script>
    <script src="<?= base_url() ?>src/jquery.friendurl.js"></script>
</head>

<body>
<div id="allpage">
    <header>
        <div class="wrap">
            <h2><a href="<?=base_url()?>" class="logo"></a> - Trang quản trị</h2>
        </div>
    </header>
    <div class="nav">
        <div class="wrap">
            <ul>
                <li><a href="<?= base_url() ?>admin/"
                       class="<?= (($cat == 'admin') ? 'select' : '') ?>">Tổng quan</a></li>
                <? if ($this->mylibs->accessaddresspage()): ?>
                    <li><a href="<?= base_url() ?>admin/inout"
                           class="<?= (($cat == 'inout') ? 'select' : '') ?>">Xuất/Nhập</a></li>
                <? endif ?>
                <? if ($this->mylibs->accessservicepage()): ?>
                    <li><a href="<?= base_url() ?>admin/report"
                           class="<?= (($cat == 'report') ? 'select' : '') ?>">Báo cáo</a></li>
                <? endif ?>
                <? if ($this->mylibs->accessdealpage()): ?>
                    <li><a href="<?= base_url() ?>admin/thietbi"
                           class="<?= (($cat == 'thietbi') ? 'select' : '') ?>">Thiết bị</a></li>
                <? endif ?>
                <? if ($this->mylibs->accessuserpage()): ?>
                    <li><a href="<?= base_url() ?>admin/user"
                           class="<?= (($cat == 'user') ? 'select' : '') ?>">Người dùng</a></li>
                <? endif ?>
            </ul>
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
    </div>
    <div id="content">
        <div class="wrap">
            <?= (isset($body) ? $body : "") ?>
        </div>
    </div>
    <input type="hidden" name="base_url" value="<?=base_url()?>">
    <div style="clear: both;"></div>
    <footer>
        <div class="wrap">
            <p>Copyright &copy 2013.</p>
        </div>
    </footer>
</div>
</body>
</html>