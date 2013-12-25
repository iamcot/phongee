<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/frontstyle.css">
    <link type="text/css" rel="stylesheet"
          href="<?= base_url() ?>src/ckeditor/skins/moono/editor.css">
    <link type="text/css" rel="stylesheet"
          href="<?= base_url() ?>src/smoothness/jquery-ui-1.10.3.custom.css">
    <script src="<?= base_url() ?>src/jquery.min.js"></script>
    <script src="<?= base_url() ?>src/mylib.js"></script>
    <script src="<?= base_url() ?>src/jquery-ui-min.js"></script>
    <script src="<?= base_url() ?>src/jquery.jqpagination.min.js"></script>
    <script src="<?= base_url() ?>src/jupload/vendor/jquery.ui.widget.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.iframe-transport.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.fileupload.js"></script>
    <style>
        .bodycontent_head_inner {
            max-width: 880px;
            margin: 0 auto 0 auto;
            padding: 20px 10px 10px 10px;
            position: relative;
            background: none;
        }

        .btn-facebook:hover, .btn-facebook:active, .btn-facebook.active, .btn-facebook.disabled, .btn-facebook[disabled] {
            color: #c3dbff;
        }

        .btn-facebook, .btn-facebook:hover, .btn-facebook:active, .btn-facebook.disabled, .btn-facebook[disabled] {
            color: #ffffff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
            border-color: #273c6d;
            padding: 10px 20px 7px 50px;
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            background-image: url("http://cdn.designcrowd.com.s3.amazonaws.com/images/icon-facebook.png");
            background-repeat: no-repeat;
            background-position: 0 50%; /*background-size:260px auto;*/
        }

        #fbModal h4 {
            font-family: "museo-sans", Arial, sans-serif;
            letter-spacing: -0.04em;
            font-weight: 700;
            color: #333333;
        }

        label {
            display: inline !important;
            font-size: 13px;
        }

        #fbModal h2 {
            color: #1f8cbe !important;
            font-family: "museo-sans", Arial, sans-serif !important;
            font-size: 23px !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }

        #fbModal .modal-header {
            background: #eaeaea url(//storage.designcrowd.com/common/images/v3/header.png) repeat-x left bottom;
        }

        .contentpanel {
            background-color: White;
            color: #333;
            border: 1px solid #BABABA;
            border-radius: 4px !important;
            -moz-border-radius: 4px !important;
            -webkit-border-radius: 4px !important;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
            -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.15);
            padding: 30px 30px 0 30px;
        }
    </style>
</head>
<body id="loginbg">
<div id="allpage">
    <header>
        <div class="wrap">
            <h2><?= $this->config->item('sitename') . (($this->lang->line("slogan") != "") ? " - " . $this->lang->line("slogan") : '') ?></h2>
        </div>
    </header>
    <div class="nav">
        <div class="wrap">
            <ul>
                <li><a href="<?= base_url() ?>"
                       class="<?= (($cat == 'home') ? 'select' : '') ?>">Trang chủ</a></li>

            </ul>
        </div>
    </div>
    <div id="content">
        <div id="loginpage">
            <div class="wrap">
                <div class="bodycontent_head_inner">

                    <header class="title">
                        <h1>
                            <b>
                                Đăng nhập <?= $this->config->item('sitename') ?>
                            </b></h1>
                    </header>
                    <div id="" class="dc-login">
                        <div class="contentpanel">
                            <br>
                            <? if (isset($nofi)): ?>
                                <div id="nofication"><?= $nofi; ?></div>
                            <? endif; ?>
                            <table style="width:100%">
                                <tbody>
                                <tr valign="top">
                                    <td style="width:380px">
                                        <form action="" method="post">
                                            <table style="width:100%" cellpadding="2">
                                                <tbody>
                                                <tr>
                                                    <td colspan="2">
                                                        <h4>Đăng nhập bằng tài
                                                            khoản <?= $this->config->item('sitename') ?>
                                                            :</h4>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td style="width: 70px">
                                                        Tài khoản
                                                    </td>
                                                    <td>
                                                        <input name="dausername" type="text" id=""
                                                               tabindex="1" class=""
                                                               style="width:80%;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 70px">
                                                        Mật khẩu
                                                    </td>
                                                    <td>
                                                        <input name="dapassword" type="password"
                                                               id="" tabindex="2" class=""
                                                               style="width:80%;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <div style="margin-top: 5px">
                                                            <a id="" tabindex="5"
                                                               href="<?= base_url() ?>login/forgetpassword">Quên
                                                                                                            mật
                                                                                                            khẩu?</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input type="submit" name="submit"
                                                               value="Đăng nhập" id="" tabindex="3"
                                                               style="font-weight:bold;">
                                                    <span style="padding-left: 7px;">
                                                        <input id="" type="checkbox"
                                                               name="daalwayslogin" tabindex="4">
                                                        <label>Luôn đăng nhập</label></span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </td>
                                    <td style="line-height: 1.5">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="vert">
                                                        <em id="loginstatus">Or</em>
                                                    </div>
                                                </td>
                                                <td align="center" style="width: 300px; padding-bottom: 20px; text-align: center;
                padding-left: 50px;">
                                                    <table style="text-align: left">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <h4 style="font-size:1em">
                                                                    Đăng nhập bằng Facebook

                                                                </h4>                 <br>
                                                                <a id="lnkFacebook" href="#"
                                                                   onclick="login()"
                                                                   class="btn btn-facebook"
                                                                   style="width: 210px; height: auto; font-size: 17px; pointer-events: auto;">
                                                                    Connect with Facebook
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>


                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="dc-join">
                                            <p>
                                                Bạn chưa có tài khoản?
                                                <a href="<?= base_url() ?>registration"
                                                   style="text-decoration: underline">
                                                    Đăng ký
                                                </a>
                                                <span>Hoặc liên hệ Quản Trị Viên</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <br>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="wrap">
            <p>Copyright &copy 2013.</p>
        </div>
    </footer>
</div>
</body>
</html>