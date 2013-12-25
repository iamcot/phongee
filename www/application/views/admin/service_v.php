<div id="tabs">
    <ul>
        <li><a href="<?= base_url() ?>admin/serviceplace">Điểm dịch vụ </a></li>
        <li><a href="<?= base_url() ?>admin/servicegroup">Nhóm dịch vụ</a></li>
        <li><a href="<?= base_url() ?>admin/serviceitem">Dịch vụ </a></li>
        <li><a href="#tabs-4">Hình ảnh</a></li>
        <li><a href="#tabs-5">Tin tức</a></li>
    </ul>
    <div id="tabs-4">
        <label>ID Điểm dịch vụ</label>
        <input type="text" name="picdaserviceplace_id" class="idinput">
        <input type="button" value="Load Dịch vụ"
               onclick="tabloadService('pic',0,'picdaserviceplace_id','#picdalong_name','#picprovince','#picservice','#picdapic','#picstatus')">
        <input type="button" value="Load Dịch vụ mới nhất"
               onclick="tabloadService('pic',1,'picdaserviceplace_id','#picdalong_name','#picprovince','#picservice','#picdapic','#picstatus')">
        <input type="button" value="Lưu" onclick="savepic()">
        <input type="button" value="Bỏ qua" onclick="cancel()">
        <span id="picstatus" style="float:right"></span>
        <table>
            <tr>
                <td>
                    <h1 id="picdalong_name"></h1>
                </td>
                <td rowspan="3">
                    <div id="picdapic"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="picprovince"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="picservice"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input id="morepicupload" type="file" name="files[]"
                           data-url="<?= base_url() ?>admin/calljupload"
                           multiple>
                </td>
            </tr>
        </table>

        <table id="piclistimage"></table>
    </div>
    <div id="tabs-5">
        <style>
            #newsforhome,
            #newsforservice {
                margin: 0 0 10px 0;
                padding: 10px;
            }
        </style>
        <label>Tin tức cho Điểm dịch vụ </label>
        <input type="radio" name="datype" value="service" onclick="changenewstype()"
               checked="checked">
        <label>Tin tức cho trang web</label>
        <input type="radio" name="datype" value="home" onclick="changenewstype()">

        <br>

        <div id="newsforhome" style="display: none">
            <select name="newsdaprovince_id">
                <option value="0">Tất cả</option>
                <? foreach($province as $prov):?>
                    <option value="<?=$prov->id?>"><?=$prov->dalong_name?></option>
                <? endforeach;?>
            </select>
            <lable>Chuyên mục</lable>
            <select name="dacats">
                <?
                foreach ($this->config->item("aNewsHelp") as $k => $v) {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
                foreach ($this->config->item("aNewsCat") as $k => $v) {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                }
                foreach ($this->config->item("aNewsSuggest") as $k => $v) {
                    echo '<option value="' . $k . '">' . $v[0] . '</option>';
                }
                ?>
            </select>


        </div>
        <div id="newsforservice">
            <label>ID Điểm dịch vụ</label>
            <input type="text" name="newsdaserviceplace_id" class="idinput">
            <input type="button" value="Load Dịch vụ"
                   onclick="tabloadService('news',0,'newsdaserviceplace_id','#newsservicedalong_name','#newsserviceprovince','#newsservice','#newsservicedapic','#newsstatus')">
            <input type="button" value="Load Dịch vụ mới nhất"
                   onclick="tabloadService('news',1,'newsdaserviceplace_id','#newsservicedalong_name','#newsserviceprovince','#newsservice','#newsservicedapic','#newsstatus')">
            <table>
                <tr>
                    <td>
                        <h1 id="newsservicedalong_name"></h1>
                    </td>
                    <td rowspan="3">
                        <div id="newsservicedapic"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="newsserviceprovince"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="newsservice"></div>
                    </td>
                </tr>

            </table>

            <table id="newslistimage"></table>
        </div>
        <fieldset>
            <table>
                <tr>
                    <td>
                        <label>Tên đầy đủ</label>
                        <input type="text" name="newsdalong_name" placeholder="Tên đầy đủ"
                               title="Tên đầy đủ">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Seo URL</label>
                        <input id="newsdaurl" type="text" name="newsdaurl" placeholder="Seo URL"
                               title="Seo URL">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div style="float:left;width:60%">
                            <label>Hình đại diện</label>
                            <input type="text" name="newsdapic" placeholder="Hình đại diện"
                                   title="Hình đại diện">
                            <input id="newsupload" type="file" name="files[]"
                                   data-url="<?= base_url() ?>admin/calljupload" multiple>
                        </div>
                        <div style="float:right;width:37%" id="newspicdemo">
                    </td>

                </tr>
                <tr>
                    <td>
                        <label>Tóm tắt </label>
                        <textarea name="dacontent_short" placeholder="Tóm tắt"
                                  title="Tóm tắt"></textarea></td>
                </tr>
                <tr>
                    <td>
                        <label>Nội dung </label>
                        <textarea class="ckeditor" name="dacontent" placeholder="Nội dung"
                                  title="Nội dung"></textarea></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="newsedit" value="">
                        <input type="hidden" name="newscurrpage" value="1">
                        <input type="button" value="Lưu" onclick="savenews()">
                        <input type="button" value="Load" onclick="loadnews(1)">
                        <input type="button" value="Xóa input" onclick="newsclearinput()">
                        <span id="newsstatus" style="float:right"></span>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Danh sách bài viết</legend>
            <div id="listnews"></div>
        </fieldset>
    </div>

</div>
<script>
function newsclearinput() {
    $("input[name=newsdalong_name]").val("");
    $("input[name=newsedit]").val("");
    $("input[name=newsdaurl]").val("");

    $("input[name=newsdapic]").val("");
    $("textarea[name=dacontent_short]").val("");
    $("textarea[name=dacontent]").val("");
    $("#newspicdemo").html('');
}
function editnews(id) {
//        $("select[name=daprovince_id]").val(3);
    addloadgif("#newsstatus");
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadeditnews/" + id,
        success: function (msg) {
            if (msg == "0") alert('<?=lang("NO_DATA")?>');
            else {
                var province = eval(msg);
                $("input[name=newsdalong_name]").val(province.dalong_name);
                $("input[name=newsedit]").val(province.id);
                $("input[name=newsdaurl]").val(province.daurl);
                if (province.datype == "service") {
                    $("input[name=datype]").filter('[value=service]').prop('checked', true);

                    $("input[name=newsdaserviceplace_id]").val(province.daserviceplace_id);
                    $("#newsforhome").hide();
                    $("#newsforservice").show();

                }
                else if (province.datype == "home") {
                    $("input[name=datype]").filter('[value=home]').prop('checked', true);

                    $("select[name=dacats]").val(province.dacat);
                    $("select[name=newsdaprovince_id]").val(province.daprovince_id);
                    $("#newsforservice").hide();
                    $("#newsforhome").show();
                }

                $("input[name=newsdapic]").val(province.dapic);
                $("textarea[name=dacontent_short]").val(province.dacontent_short);
                $("textarea[name=dacontent]").val(province.dacontent);
                $("#newspicdemo").html('<img src="<?=base_url()?>thumbnails/' + province.dapic + '">');
                removeloadgif("#newsstatus");
            }
        }
    });
}
function savenews() {
    var type = $("input[name=datype]:checked").val();
    var daserviceplace_id = "";
    var dacat = "";
    var daprovince_id = "";
    if (type == "home") {
        dacat = $("select[name=dacats]").val();
        daprovince_id = $("select[name=newsdaprovince_id]").val();
    }
    else if (type == "service") {
        daserviceplace_id = $("input[name=newsdaserviceplace_id]").val();
        if (daserviceplace_id == "") {
            alert("Chưa có ID Điểm dịch vụ.");
            return;
        }
    }
    var dalong_name = $("input[name=newsdalong_name]").val();
    var daurl = $("input[name=newsdaurl]").val();
    var dapic = $("input[name=newsdapic]").val();
    var edit = $("input[name=newsedit]").val();
    var dacontent_short = $("textarea[name=dacontent_short]").val();
    var dacontent = $("textarea[name=dacontent]").val();

    if (dalong_name.trim() == "" || daurl.trim() == "" || dacontent.trim() == "") {
        alert("Vui lòng nhập đủ các trường.");
        return;
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/savenews",
        data: "dalong_name=" + dalong_name
                  + "&daurl=" + daurl
                  + "&dacontent=" + encodeURIComponent(dacontent)
                  + "&dapic=" + dapic
                  + "&dacontent_short=" + dacontent_short
                  + "&daserviceplace_id=" + daserviceplace_id
                  + "&dacat=" + dacat
                  + "&edit=" + edit
                  + "&daprovince_id=" + daprovince_id
                  + "&datype=" + type,
        success: function (msg) {
            switch (msg) {
                case "0":
                    alert("Không thể lưu");
                    loadnews($("input[name=newscurrpage]").val());
                    //provinceclear();
                    break;
                case "1":
                    addsavegif("newsstatus");
                    removeloadgif("newsstatus");
                    loadnews($("input[name=newscurrpage]").val());
                    newsclearinput();
                    //provinceclear();

                    break;
                default :
                    alert("Lỗi lưu - không xác định.")
                    loadnews($("input[name=newscurrpage]").val());
                    break;
            }
        }
    });
}
function loadnews(page) {
    var type = $("input[name=datype]:checked").val();
    var daserviceplace_id = "";
    var daprovince_id = "";
    if (type == "home") {
        daserviceplace_id = $("select[name=dacats]").val();
        daprovince_id = $("select[name=newsdaprovince_id]").val();
    }
    else if (type == "service") {
        daserviceplace_id = $("input[name=newsdaserviceplace_id]").val();
        if (daserviceplace_id == "") {
            alert("Chưa có ID Điểm dịch vụ.");
            return;
        }
    }
    addloadgif("#newsstatus");
    $("#listnews").load("<?=base_url()?>admin/loadnews/"
                            + type + "/"
                            + daserviceplace_id + "/"
                            + daprovince_id + "/"
        + page, function () {removeloadgif("#newsstatus");});
    $("input[name=newscurrpage]").val(page);
}
function changenewstype() {
    var type = $("input[name=datype]:checked").val();

    console.log(type);
    if (type == "home") {
        $("#newsforservice").hide();
        $("#newsforhome").show();
        loadnews(1);
    }
    else if (type == "service") {
        $("#newsforhome").hide();
        $("#newsforservice").show();
    }
}
//        addloadgif("#loadstatus");
$(function () {
    $('.ckeditor').ckeditor();
    $('input[name=newsdalong_name]').friendurl({id: 'newsdaurl'});
    $('#morepicupload').fileupload({
        dataType: 'json',
        start: function () {
            console.log("start");
            addloadgif("#picstatus");
        },
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $("#piclistimage").append('' +
                                          '<tr>' +
                                          '<td>' +
                                          '[<a href="javascript:delpic(\'' + file.name + '\')">Xóa</a>]' +
                                          '<input datype="new" type="text" value="' + file.name + '" readonly=true >' +
                                          '<textarea datype="new" placeholder="Chú thích"></textarea></td>' +
                                          '<td><img src="<?=base_url()?>thumbnails/' + file.name + '"></td>' +
                                          '</tr>' +
                                          '');

            });
            removeloadgif("#picstatus");
        }
    });
    $('#newsupload').fileupload({
        dataType: 'json',
        start: function () {
            console.log("start");
            addloadgif("#newsstatus");
        },
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $("input[name=newsdapic]").val(file.name);
                $("#newspicdemo").html('<img src="<?=base_url()?>thumbnails/' + file.name + '">');

            });
            removeloadgif("#newsstatus");
        }
    });
});
$(function () {
    $("#tabs").tabs(
        {
            beforeLoad: function (event, ui) {
                for (var i = 1; i <= 3; i++) {
                    $("#ui-tabs-" + i).empty();
                }

                ui.jqXHR.error(function () {
                    ui.panel.html(
                        "<p>Chức năng hiện thời chưa có. Vui lòng liên hệ thang102@gmail.com</p>");
                });
            }
        }
    )
});
/*

 .addClass( "ui-tabs-vertical ui-helper-clearfix" );
 $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
 */
function tabloadService(
    mod, type, namedaserviceplace_id, iddalong_name, idprovince, idservice, iddapic, idstatus) {

    var id = $("input[name=" + namedaserviceplace_id + "]").val();
    if (id == "" && type == 0) {
        alert("Chưa có ID dịch vụ, xin kiểm tra lại.");
        return;
    }
    addloadgif(idstatus);
    if (type == 1) {
        id = 0;
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadeditserviceplace/" + id + "/" + type + "/1",
        success: function (msg) {
            if (msg == "0") {
                alert('<?=lang("NO_DATA")?>');

            }
            else {
                var province = eval(msg);
                $(iddalong_name).html(province.dalong_name);
                $(idprovince).html(province.daaddr + ((province.daaddr != "") ? ", " : "") + province.streetname + ((province.streetname != "") ? ", " : "") +
                                   province.wardname + ((province.wardname != "") ? ", " : "") + province.districtname + ((province.districtname != "") ? ", " : "") + province.provincename);
                $(idservice).html(province.servicegroup + " > " + province.servicename);
                $(iddapic).html("<img src='<?=base_url()?>thumbnails/" + province.dapic + "'>");
                $("input[name=" + namedaserviceplace_id + "]").val(province.id);
                if (mod == "pic") {
                    loadoldpic();
                }
                else if (mod == "news") {
                    loadnews(1);
                }
            }
            removeloadgif(idstatus);
        }
    });
}
function delpic(filename) {
    var cinput = $("input[value=\"" + filename + "\"]");
    var deldb = 0;
    if (cinput.attr("datype") == "old") {
        deldb = 1;
        addloadgif("#picstatus");
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/delfile/" + filename + "/" + deldb,
        success: function (msg) {
            if (msg == 1) {
                $("input[value=\"" + filename + "\"]").parent().parent().remove();
                if (deldb == 1) {
                    removeloadgif("#picstatus");
                }
            }
            else {
                alert("Không thể xóa file, xin hãy kiểm tra lại");
            }
        }
    });
}
function savepic() {
    var id = $("input[name=picdaserviceplace_id]").val();
    if (id == "" || id <= 0) {
        alert("Chưa có ID Điểm dịch vụ");
        return;
    }
    // addloadgif("#picstatus");
    addsavegif("#picstatus");
    updateoldpic();
    var newimg = "";
    var newcaption = "";
    var minput = null;
    var mtext = null;
    $("#piclistimage tr").each(function () {
        minput = ($(this).find("input[datype=new]"));
        if (minput.length > 0) {
            newimg += $(minput).val() + ",";
        }
    });
    $("#piclistimage tr").each(function () {
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
            url: "<?=base_url()?>admin/savemorepic/" + id,
            data: "img=" + newimg + "&caption=" + newcaption,
            success: function (msg) {
                if (msg > 0) {
                    loadoldpic();
                }
                else if (msg == -1) {
                    alert("Điểm dịch vụ không tồn tại");
                }
                else {
                    alert("Thao tác thất bại, xin kiểm tra lại");
                }
                removeloadgif("#picstatus");
            }
        });
    }
    else {
        removeloadgif("#picstatus");
    }

}
function cancel() {
    if (!confirm("Thao tác sẽ xóa hết các hình ảnh mới up lên, bạn chắc chứ?")) {
        return;
    }
    var minput = null;
    $("#piclistimage tr").each(function () {
        minput = $(this).find("input[datype=new]");
        if (minput.length > 0) {
            delpic($(minput).val());
        }
    });
    picclearall();
}
function picclearall() {
    $("#picdalong_name").html("");
    $("#picprovince").html("");
    $("#picservice").html("");
    $("#picdapic").html("");
    $("input[name=picdaserviceplace_id]").val("");
    $("#piclistimage").html("");
}
function loadoldpic() {
    $("#piclistimage").html("");
    var id = $("input[name=picdaserviceplace_id]").val();
    if (id == "" || id <= 0) {
        alert("Chưa có ID Điểm dịch vụ");
        return;
    }
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/loadserviceplacepic/" + id,
        success: function (msg) {
            if (msg == "0") console.log('<?=lang("NO_DATA")?>');
            else {
                var pics = eval(msg);

                $.each(pics, function (index, file) {
                    $("#piclistimage").append('' +
                                              '<tr>' +
                                              '<td>' +
                                              '[<a href="javascript:delpic(\'' + file.dapic + '\')">Xóa</a>]' +
                                              '<input datype="old" type="text" value="' + file.dapic + '" readonly=true >' +
                                              '<textarea datype="old" placeholder="Chú thích">' + file.dacaption + '</textarea></td>' +
                                              '<td><img src="<?=base_url()?>thumbnails/' + file.dapic + '"></td>' +
                                              '</tr>' +
                                              '');

                });
            }
        }
    });
}
function updateoldpic() {
    var mtext = null;
    var oldcaption = "";
    var oldimg = "";
    var id = $("input[name=picdaserviceplace_id]").val();
    if (id == "" || id <= 0) {
        alert("Chưa có ID Điểm dịch vụ");
        return;
    }
    $("#piclistimage tr").each(function () {
        mtext = $(this).find("input[datype=old]");
        if (mtext.length > 0) {
            oldimg += $(mtext).val() + ",";
        }
    });
    $("#piclistimage tr").each(function () {
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
            url: "<?=base_url()?>admin/updateoldpic/" + id,
            data: "img=" + oldimg + "&caption=" + oldcaption,
            success: function (msg) {
                if (msg <= 0)
                    alert("Không thể cập nhật!");
            }
        });
    }
}
function hidenews(id, status) {
    $.ajax({
        type: "post",
        url: "<?=base_url()?>admin/hidenews/" + id + "/" + status,
        success: function (msg) {
            if (msg == "1") {
                loadnews($("input[name=currpage]").val());
            }
            else {
                alert("Thao tác thất bại!");
            }
        }
    });
}
</script>