<div id="commentbox">
    <div id="commentform">
        <? if ($this->session->userdata("dausername")): ?>
            <? if ($this->session->userdata("daavatar") != ""): ?>
                <img src="/thumbnails/<?= $this->session->userdata("daavatar") ?>">
            <? endif; ?>
            <p>

                <b><?= $this->session->userdata("dausername") ?></b> hãy chia sẽ đánh giá của bạn về
                                                                     địa điểm này..
                <input type="hidden" name="commentname"
                       value="<?= $this->session->userdata("dausername") ?>">
                <input type="hidden" name="commentemail"
                       value="<?= $this->session->userdata("daemail") ?>">
                <input type="hidden" name="commenttel"
                       value="<?= $this->session->userdata("damobi") ?>">
                <input type="hidden" name="commentavatar"
                       value="<?= $this->session->userdata("daavatar") ?>">


        <? else: ?>
            <p class="smalltext8"><i class="fa fa-exclamation-triangle"></i> Bạn chưa <a
                    href="/login">ĐĂNG
                                  NHẬP</a>, vui lòng nhập các thông tin yêu cầu để bình luận.<br>Những thông tin về email và số điện thoại sẽ được giữ bí mật.<br>
            <input type="text" name="commentname" placeholder="Họ Tên hoặc nickname ">
            <input type="text" name="commentemail" placeholder="Email">
            <input type="text" name="commenttel" placeholder="Số điện thoại ">
            <input type="hidden" name="commentavatar" value="">

        <? endif; ?>

        <textarea placeholder="Bình luận của bạn " name="dacontent"></textarea>
        <input type="button" value="Gửi" onclick="savecomment()">
        <span id="commentloading"></span>
        </p>
    </div>
    <div id="commentcontent"></div>

</div>
<script>
loadcomment(1);
function loadcomment(page) {
    addloadgif("commentloading");
    $("#commentcontent").load("<?=base_url()?>main/loadcomment/<?=$oCurrentPlace->id?>/" + page,removeloadgif("#commentloading"));
}
function savecomment() {
    var daserviceplace_id = <?=$oCurrentPlace->id?>;
    var dacontent = $("textarea[name=dacontent]").val();
    var daname = $("input[name=commentname]").val();
    var daemail = $("input[name=commentemail]").val();
    var datel = $("input[name=commenttel]").val();
    var daavatar = $("input[name=commentavatar]").val();

    if (dacontent != "" && daname != "") {
        $("textarea[name=dacontent]").val("");
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/savecomment",
            data: "daserviceplace_id=" + daserviceplace_id +
                  "&dacontent=" + encodeURIComponent(dacontent) +
                  "&daname=" + encodeURIComponent(daname) +
                  "&daemail=" + encodeURIComponent(daemail) +
                  "&datel=" + encodeURIComponent(datel) +
                  "&daavatar=" + encodeURIComponent(daavatar),
            success: function (msg) {
                if (msg == 0) {
                    alert("Gửi bình luận thất bại, vui lòng thử lại.");
                }
                else {
                    $("textarea[name=dacontent]").val("");
                }
                loadcomment(1);
            }
        });
    }
    else {
        alert("Vui lòng nhập đủ các thông tin yêu cầu.");
    }
}
function deletecomment(id) {
    if (confirm("Xác nhận xoá comment?")) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/delcomment/" + id,
            success: function (msg) {
                if (msg == 0) {
                    alert("Xóa bình luận thất bại, vui lòng thử lại.");
                }
                loadcomment(1);
            }
        });
    }
}
</script>