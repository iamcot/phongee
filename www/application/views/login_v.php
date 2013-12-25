<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>src/assets/css/styles.css" />


</head>
<body id="loginbg">
<div id="allpage">
    <div id="formContainer">
        <form id="login" method="post" action="">
            <a href="#" id="flipToRecover" class="flipLink">Forgot?</a>
            <?if(isset($nofi) && $nofi!=""):?><div id="notif"><?=$nofi?></div><?endif;?>
            <input type="text" name="pgusername" id="loginEmail" placeholder="Tài khoản" />
            <input type="password" name="pgpassword" id="loginPass" placeholder="Mật khẩu" />
            <input type="submit" name="login" value="Đăng nhập" />
        </form>
        <form id="recover" method="post" action="">
            <a href="#" id="flipToLogin" class="flipLink">Forgot?</a>
            <input type="text" name="recoverEmail" id="recoverEmail" value="Email" />
            <input type="submit" name="reset" value="Recover" />
        </form>
    </div>

    <footer>
        <h2>Copyright &copy 2013</h2>
    </footer>

    <!-- JavaScript includes -->
    <script src="<?= base_url() ?>src/jquery.min.js"></script>
    <script src="<?= base_url() ?>src/mylib.js"></script>
    <script src="<?= base_url() ?>src/assets/js/script.js"></script>
</div>
</body>
</html>