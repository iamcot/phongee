<h1>Tổng quan về hệ thống</h1>
<p></p>
<p>Các chức năng cần thêm, vui lòng liên hệ <a
        href="mailto:thang102@gmail.com">thang102@gmail.com</a></p>
<p>Back-end chỉ mới có các module cơ bản để có thể nhập và kiểm soát dữ liệu. Chưa có các chức năng
   tiện ích, tối ưu,
   kiểm tra trùng v.v..
</p>
<div id="tabs">
    <ul>
        <li><a href="#tab-1">Tổng quan hệ thống</a></li>
        <li><a href="#tab-2">Top Menu</a></li>

    </ul>

    <div id="tab-1">
    </div>
    <div id="tab-2">
        <fieldset>
            <legend>Danh sách các link top menu</legend>
            <label>URL</label> <input type="text" name="toplinkurl">
            <label>Title</label> <input type="text" name="toplinktitle">
            <input type="button" value="Save" onclick="saveToplink()">

            <div id="listtoplink"></div>
        </fieldset>
        <fieldset>
            <legend>Banner</legend>
            <input id="bannerupload" type="file" name="files[]"
                   data-url="<?= base_url() ?>admin/calljupload"
                   multiple>
            <input type="button" value="Lưu" onclick="savebanner()">
            <input type="button" value="Bỏ qua" onclick="cancelbanner()">

            <div id="bannerloadstatus" style="float:right"></div>
            <table id="bannerlist">

            </table>
        </fieldset>
    </div>
</div>
<script>
function saveToplink() {
    var url = $("input[name=toplinkurl]").val();
    var title = $("input[name=toplinktitle]").val();
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/saveconfig",
        data: "daname=toplink&davalue=" + url + "&dacomment=" + title,
        success: function (msg) {
            loadtoplink();
        }
    });
}
function loadtoplink() {
    $("#listtoplink").html("");
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadconfig",
        data: "daname=toplink",
        success: function (msg) {
            var toplinks = eval(msg);

            $.each(toplinks, function (index, file) {
                $("#listtoplink").append("<div style='padding:5px;border:1px solid #aaa;'>Title: " + file.dacomment + " - URL: " + file.davalue + " [<a href='javascript:deltoplink(" + file.id + ")'>Xóa</a>]");
            } );
        }
    });
}
function deltoplink(id){
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/deltoplink",
        data: "id="+id,
        success: function (msg) {
            loadtoplink();
        }
    });
}

$(function () {
    loadtoplink();
    loadoldbanner();
    $("#tabs").tabs();
    $('#bannerupload').fileupload({
        dataType: 'json',
        start: function () {
            console.log("start");
            addloadgif("#bannerloadstatus");
        },
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $("#bannerlist").append('' +
                                        '<tr>' +
                                        '<td>' +
                                        '[<a href="javascript:delpic(\'' + file.name + '\')">Xóa</a>]' +
                                        '<input datype="new" type="text" value="' + file.name + '" readonly=true >' +
                                        '<textarea datype="new" placeholder="Chú thích"></textarea></td>' +
                                        '<td><img src="<?=base_url()?>thumbnails/' + file.name + '"></td>' +
                                        '</tr>' +
                                        '');

            });
            removeloadgif("#bannerloadstatus");
        }
    });
});
function savebanner() {
    var id = $("input[name=picdaserviceplace_id]").val();
    if (id == "" || id <= 0) {
        alert("Chưa có ID Điểm dịch vụ");
        return;
    }
    // addloadgif("#picstatus");
    addsavegif("#bannerloadstatus");
    updateoldbanner();
    var newimg = "";
    var newcaption = "";
    var minput = null;
    var mtext = null;
    $("#bannerlist tr").each(function () {
        minput = ($(this).find("input[datype=new]"));
        if (minput.length > 0) {
            newimg += $(minput).val() + ",";
        }
    });
    $("#bannerlist tr").each(function () {
        mtext = ($(this).find("textarea[datype=new]"));
        if (mtext.length > 0) {
            newcaption += $(mtext).val() + ",";
        }
    });
    // console.log(newimg);
    // console.log(newcaption);
    if (newimg != "") {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/savebanner/",
            data: "img=" + newimg + "&caption=" + newcaption,
            success: function (msg) {
                if (msg > 0) {
                    loadoldbanner();
                }
                else if (msg == -1) {
                    alert("Điểm dịch vụ không tồn tại");
                }
                else {
                    alert("Thao tác thất bại, xin kiểm tra lại");
                }
                removeloadgif("#bannerloadstatus");
            }
        });
    }
    else {
        removeloadgif("#bannerloadstatus");
    }

}
function cancelbanner() {
    if (!confirm("Thao tác sẽ xóa hết các hình ảnh mới up lên, bạn chắc chứ?")) {
        return;
    }
    var minput = null;
    $("#bannerlist tr").each(function () {
        minput = $(this).find("input[datype=new]");
        if (minput.length > 0) {
            delpic($(minput).val());
        }
    });
    $("#bannerlist").html("");
}
function loadoldbanner() {
    $("#bannerlist").html("");

    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadbanner/",
        success: function (msg) {
            if (msg == "0") console.log('<?=lang("NO_DATA")?>');
            else {
                var pics = eval(msg);

                $.each(pics, function (index, file) {
                    $("#bannerlist").append('' +
                                            '<tr>' +
                                            '<td>' +
                                            '[<a href="javascript:delpic(\'' + file.davalue + '\')">Xóa</a>]' +
                                            '<input datype="old" type="text" value="' + file.davalue + '" readonly=true >' +
                                            '<textarea datype="old" placeholder="Chú thích">' + file.dacomment + '</textarea></td>' +
                                            '<td><img src="<?=base_url()?>thumbnails/' + file.davalue + '"></td>' +
                                            '</tr>' +
                                            '');

                });
            }
        }
    });
}
function updateoldbanner() {
    var mtext = null;
    var oldcaption = "";
    var oldimg = "";
    $("#bannerlist tr").each(function () {
        mtext = $(this).find("input[datype=old]");
        if (mtext.length > 0) {
            oldimg += $(mtext).val() + ",";
        }
    });
    $("#bannerlist tr").each(function () {
        mtext = $(this).find("textarea[datype=old]");
        if (mtext.length > 0) {
            oldcaption += $(mtext).val() + ",";
        }
    });
    // console.log(oldimg);
    //  console.log(oldcaption);
    if (oldimg != "") {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/updateoldbanner/",
            data: "img=" + oldimg + "&caption=" + oldcaption,
            success: function (msg) {
                if (msg <= 0)
                    alert("Không thể cập nhật!");
            }
        });
    }
}
function delpic(filename) {
    var cinput = $("input[value=\"" + filename + "\"]");
    var deldb = 0;
    if (cinput.attr("datype") == "old") {
        deldb = 1;
        // addloadgif("#picstatus");
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/delbanner/" + filename + "/" + deldb,
        success: function (msg) {
            if (msg == 1) {
                $("input[value=\"" + filename + "\"]").parent().parent().remove();
                if (deldb == 1) {
                    // removeloadgif("#picstatus");
                }
            }
            else {
                alert("Không thể xóa file, xin hãy kiểm tra lại");
            }
        }
    });
}
</script>