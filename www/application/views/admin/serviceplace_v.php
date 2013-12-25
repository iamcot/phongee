<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <select name="daprovince_id" onchange="loadDistrict(0)">
                    <? foreach ($province as $prov): ?>
                        <option value="<?= $prov->id ?>"><?= $prov->dalong_name ?></option>
                    <? endforeach; ?>
                </select>
            </td>
            <td>
                <select name="dadistrict_id" onchange="loadWard(0)">
                    <option value="0">Chọn Quận/Huyện</option>
                    <? foreach ($district as $dist): ?>
                        <option value="<?= $dist->id ?>"><?= $dist->dalong_name ?></option>
                    <? endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><select name="daward_id" onchange="loadStreet(0)">
                    <option value="0">Chọn Phường/Xã</option>
                    <option value="-1">Tạo Phường/Xã mới</option>
                </select>
                <div id="createward"  style="display: none">
                    <input name="newwardprefix" type="text" value="Phường">
                    <input name="newwardname" type="text" placeholder="Tên Phường">
                    <input name="newwardurl" id="newwardurl" type="text" placeholder="seo url">
                    <input type="button" value="Lưu" onclick="savenewward()">
                </div>
            </td>
            <td><select name="dastreet_id" onchange="selectStreet()" >
                    <option value="0">Chọn Đường/Phố</option>
                    <option value="-1">Tạo Đường/phố mới</option>
                </select>
                <div id="createstreet" style="display: none">
                    <input name="newstreetprefix" type="text" value="Đường">
                    <input name="newstreetname" type="text"  placeholder="Tên Đường">
                    <input name="newstreeturl" id="newstreeturl" type="text"   placeholder="seo url">
                    <input type="button" value="Lưu" onclick="savenewstreet()">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <select name="daservicegroup_id" onchange="loadService(0)">
                    <option value="0">Chọn Nhóm dịch vụ</option>
                    <? foreach ($servicegroup as $serv): ?>
                        <option value="<?= $serv->id ?>"><?= $serv->dalong_name ?></option>
                    <? endforeach; ?>
                </select>
            </td>
            <td>
                <select name="daserviceitem_id" onchange="">
                    <option value="0">Chọn Dịch vụ</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>Tên đầy đủ</label>
                <input type="text" name="dalong_name" placeholder="Tên đầy đủ" title="Tên đầy đủ"></td>
        </tr>
        <tr>
            <td>
                <label>Seo URL</label>
                <input id="daurl" type="text" name="daurl" placeholder="Seo URL" title="Seo URL"></td>
            <td>
                <label>Số nhà</label>
                <input type="text" name="daaddr" placeholder="Số nhà" title="Số nhà"></td>
        </tr>
        <tr>
            <td>
                <label>Tel</label>
                <input type="text" name="datel" placeholder="Tel" title="Tel"></td>
            <td>
                <label>Email</label>
                <input type="text" name="daemail" placeholder="Email" title="Email"></td>
        </tr>
        <tr>
            <td> <label>Hình đại diện</label>
                <input type="text" name="dapic" placeholder="Hình đại diện" title="Hình đại diện">
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
            </td>
            <td id="dapicdemo" rowspan="2" style="padding: 10px 10px 10px 20px"></td>
        </tr>
        <tr>
            <td><label>Website</label>
                <input type="text" name="dawebsite" placeholder="Website" title="Website">

            </td>
        </tr>
        <tr>
            <td>
                <label>Bản đồ</label>
                <textarea name="damap" placeholder="Bản đồ" title="Bản đồ"></textarea>
                    <table class="mapoption">
                        <tr><td>Dài</td><td><input type="text" name="mapw"  value="<?=$this->config->item("mapw")?>" class="idinput"></td>
                            <td>Cao</td><td> <input type="text" name="maph"   value="<?=$this->config->item("maph")?>" class="idinput"></td>
                            <td>Zoom</td><td><input type="text" name="mapz"   value="<?=$this->config->item("mapz")?>" class="idinput"></td></tr>
                        <tr><td>lat</td><td><input type="text" name="maplat" class="idinput"></td>
                            <td>lng</td><td><input type="text" name="maplng" class="idinput"></td>
                            <td colspan="2" style="text-align: right">
                                <input type="button" value="Load" onclick="loadmap()">
                                <input type="button" value="F5" onclick="reloadmap()">
                            </td></tr>
                    </table>
            </td>
            <td id="damapdemo" style="padding: 10px 10px 10px 20px"></td>
        </tr>
        <tr>
            <td colspan="2">
                <div>
                    <input type="button" value="Tắt/Mở Upload hình ảnh" onclick="$('#serviceplaceuploadmorepic').toggle()"> <span id="serviceplaceuploadmorepicstatus"></span>
                    <div id="serviceplaceuploadmorepic" style="display: none;min-height: 100px;border:1px solid #356635;margin:5px;">
                        <input id="serviceplaceuploadmorepicbut"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
                         <table id="serviceplaceuploadmorepicshow" style="display: block;width:99%;">

                         </table>

                    </div>
                </div>
                <label>Thông tin</label>
                <textarea class="ckeditor" name="dainfo" placeholder="Thông tin" title="Thông tin"></textarea></td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <input type="button" value="Lưu" onclick="saveProvince()">
                <input type="button" value="Load" onclick="loadProvince(1)">
                <input type="button" value="Xóa input" onclick="provinceclear()">
                <input type="button" value="Xóa tất cả" onclick="clearall()">

            </td>
            <td>
                <input type="button" value="Thêm ảnh" onclick="morepic()">
                <input type="button" value="Thêm tin" onclick="morenews()">
                <input type="button" value="Thêm deal" onclick="moredeal()">
                <div id="loadstatus" style="float:right;"></div>
            </td>
        </tr>

    </table>
</fieldset>
<fieldset>
    <legend>Danh sách Dịch vụ</legend>
    <div id="list_province"></div>
</fieldset>
<script>

    function morepic(){
        var id = $("input[name=edit]").val();
        if(id == "") {
            alert("Chưa có dịch vụ, xin hãy chọn 1 dịch vụ trước.");
            return;
        }
        $("input[name=picdaserviceplace_id]").val(id);
        $( "#tabs" ).tabs( "option", "active", 3 );
    }
    function moredeal(){

        var id = $("input[name=edit]").val();
        if(id == "") {
            alert("Chưa có dịch vụ, xin hãy chọn 1 dịch vụ trước.");
            return;
        }
        if(!confirm("Thao tác này sẽ chuyển sang trang mới, những dữ liệu chưa lưu sẽ bị mất!\nXác nhận chuyển trang?"))
            return;
        location.href = "<?=base_url()?>admin/deal/"+id;
    }
    function morenews(){
        var id = $("input[name=edit]").val();
        if(id == "") {
            alert("Chưa có dịch vụ, xin hãy chọn 1 dịch vụ trước.");
            return;
        }

        $("input[name=datype]").filter('[value=service]').prop('checked', true);
        $("input[name=newsdaserviceplace_id]").val(id);
        $("#newsforhome").hide();
        $("#newsforservice").show();
        $( "#tabs" ).tabs( "option", "active", 4 );
        loadnews(1);
    }
    function saveProvince() {
        var daservicegroup_id = $("select[name=daservicegroup_id]").val();
        var daservice_id = $("select[name=daserviceitem_id]").val();
        var daprovince_id = $("select[name=daprovince_id]").val();
        var dadistrict_id = $("select[name=dadistrict_id]").val();
        var daward_id = $("select[name=daward_id]").val();
        var dastreet_id = $("select[name=dastreet_id]").val();
        var dapic = $("input[name=dapic]").val();
        var datel = $("input[name=datel]").val();
        var dawebsite = $("input[name=dawebsite]").val();
        var daemail = $("input[name=daemail]").val();
        var daaddr = $("input[name=daaddr]").val();
        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var dalat = $("input[name=maplat]").val();
        var dalng = $("input[name=maplng]").val();
        var dainfo = $("textarea[name=dainfo]").val();
        var damap = $("textarea[name=damap]").val();
        var edit = $("input[name=edit]").val();

        if(daservicegroup_id == 0 || daservice_id == 0){
            alert("Vui lòng chọn dịch vụ");
            return;
        }
        if ( daward_id == 0 || daward_id == -1 ||  dastreet_id == 0||  dastreet_id == -1 ) {
            alert("Chưa chọn phường hoặc đường?");
                return;
        }
        else if(dadistrict_id == 0){
            alert("Vui lòng nhập Quận/Huyện.");
            return;
        }

        if (dalong_name.trim() != "" && daurl.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveserviceplace",
                data: "dalong_name=" + dalong_name
                    + "&daurl=" + daurl
                    + "&dainfo=" + encodeURIComponent(dainfo)
                    + "&edit=" + edit
                    + "&daservicegroup_id=" + daservicegroup_id
                    + "&daservice_id=" + daservice_id
                    + "&daprovince_id=" + daprovince_id
                    + "&dadistrict_id=" + dadistrict_id
                    + "&daward_id=" + daward_id
                    + "&dastreet_id=" + dastreet_id
                    + "&dapic=" + dapic
                    + "&datel=" + datel
                    + "&dalat=" + dalat
                    + "&dalng=" + dalng
                    + "&dawebsite=" + dawebsite
                    + "&daemail=" + daemail
                    + "&daaddr=" + daaddr
                    + "&damap=" + encodeURIComponent(damap),
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadProvince($("input[name=currpage]").val());
                            provinceclear();
                            break;
                        case "1":
                            loadProvince($("input[name=currpage]").val());
                            addsavegif();
                            provinceclear();
                            break;
                        default :
                            alert("Lỗi lưu - không xác định.")
                            loadProvince($("input[name=currpage]").val());
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập tối thiểu Tên đầy đủ và Seo URL");
        }
    }
    function loadProvince(page) {
        addloadgif("#loadstatus");
        $("#list_province").load("<?=base_url()?>admin/loadserviceplace/"
            + $("select[name=daprovince_id]").val() + "/"
            + $("select[name=dadistrict_id]").val() + "/"
            + $("select[name=daward_id]").val() + "/"
            + $("select[name=dastreet_id]").val() + "/"
            + $("select[name=daservicegroup_id]").val() + "/"
            + $("select[name=daserviceitem_id]").val()  + "/" + page, function(){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function loadDistrict(id) {
        addloadgif("#loadstatus");
        $("select[name=dadistrict_id]").load("<?=base_url()?>admin/loadselectdist/" + $("select[name=daprovince_id]").val()+"/"+id,function (){removeloadgif("#loadstatus");});

    }
    function loadWard(id) {
        addloadgif("#loadstatus");
        $("select[name=daward_id]").load("<?=base_url()?>admin/loadselectward/" + $("select[name=dadistrict_id]").val()+"/"+id,function (){removeloadgif("#loadstatus");});
    }
    function selectStreet(){
        if($("select[name=dastreet_id]").val() == -1){
            $("#createstreet").show("");
        }
        else{
            $("#createstreet").hide("");
        }
    }
    function loadStreet(id) {
        if($("select[name=daward_id]").val() == -1){
            $("#createward").show("");
        }   else{
            $("#createward").hide("");
        addloadgif("#loadstatus");
        $("select[name=dastreet_id]").load("<?=base_url()?>admin/loadselectstreet/" + $("select[name=daward_id]").val()+"/"+id,function (){removeloadgif("#loadstatus");});
        }
    }
    function loadService(id) {
        addloadgif("#loadstatus");
        $("select[name=daserviceitem_id]").load("<?=base_url()?>admin/loadselectserviceitem/" + $("select[name=daservicegroup_id]").val()+"/"+id,function (){removeloadgif("#loadstatus");});
    }
    function provinceclear() {
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("textarea[name=dainfo]").val("");
        $("input[name=edit]").val("");
        $("input[name=dapic]").val("");
        $("input[name=datel]").val("");
        $("input[name=dawebsite]").val("");
        $("input[name=daemail]").val("");
        $("input[name=daaddr]").val("");
        $("input[name=maplat]").val("");
        $("input[name=maplng]").val("");
        $("textarea[name=damap]").val("");
        $("#dapicdemo").html("");
    }
    function clearall(){
         provinceclear();
        $("select[name=daward_id]").html('<option value="0">Chọn Phường/Xã</option>');
        $("select[name=dastreet_id]").html('<option value="0">Chọn Đường/Phố</option>');
        $("select[name=daserviceitem_id]").html('<option value="0">Chọn Dịch vụ</option>');
        $("select[name=daservicegroup_id]").val(0);
        $("select[name=dadistrict_id]").val(0)
        $("#damapdemo").html('');
    }
    function editProvince(id) {
//        $("select[name=daprovince_id]").val(3);
        addloadgif("#loadstatus");
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditserviceplace/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daurl]").val(province.daurl);
                    $("select[name=daservicegroup_id]").val(province.daservicegroup_id);
                    $("select[name=daserviceitem_id]").load("<?=base_url()?>admin/loadselectserviceitem/" + $("select[name=daservicegroup_id]").val()+"/"+ province.daservice_id);
                    $("select[name=daprovince_id]").val(province.daprovince_id);
                    $("select[name=dadistrict_id]").load("<?=base_url()?>admin/loadselectdist/" + $("select[name=daprovince_id]").val()+"/"+province.dadistrict_id, function(){
                        $("select[name=daward_id]").load("<?=base_url()?>admin/loadselectward/" + $("select[name=dadistrict_id]").val()+"/"+province.daward_id,function(){
                            $("select[name=dastreet_id]").load("<?=base_url()?>admin/loadselectstreet/" + $("select[name=daward_id]").val()+"/"+province.dastreet_id, function(){removeloadgif("#loadstatus");});
                        });
                    });
                    $("input[name=dapic]").val(province.dapic);
                    $("input[name=datel]").val(province.datel);
                    $("input[name=dawebsite]").val(province.dawebsite);
                    $("input[name=daemail]").val(province.daemail);
                    $("input[name=daaddr]").val(province.daaddr);
                    $("input[name=maplat]").val(province.dalat);
                    $("input[name=maplng]").val(province.dalng);
                    $("textarea[name=dainfo]").val(province.dainfo);
                    $("textarea[name=damap]").val(province.damap);
                    $("#dapicdemo").html('<img src="<?=base_url()?>thumbnails/'+province.dapic+'">');
                    $("#damapdemo").html(province.damap);
                }
            }
        });
    }
    function hideprovince(id, status) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideserviceplace/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    loadProvince($("input[name=currpage]").val());
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
    $(function () {
        $('input[name=dalong_name]').friendurl({id : 'daurl'});
        $('input[name=newwardname]').friendurl({id : 'newwardurl'});
        $('input[name=newstreetname]').friendurl({id : 'newstreeturl'});
        $( '.ckeditor' ).ckeditor();
        $('#picupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('input[name=dapic]').val(file.name);
                    $("#dapicdemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });
        $('#serviceplaceuploadmorepicbut').fileupload({
            dataType: 'json',
            start: function () {
                console.log("start");
                addloadgif("#serviceplaceuploadmorepicstatus");
            },
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $("#serviceplaceuploadmorepicshow").append('' +
                                              '<tr style="width:100%">' +
                                              '<td style="width:70%;">' +
                                              '[<a href="javascript:spdelpic(\'' + file.name + '\')">Xóa</a>]' +
                                              '<input onclick="this.select()" datype="new" type="text" value="/images/' + file.name + '" readonly=true >' +
                                              '<td><img src="<?=base_url()?>thumbnails/' + file.name + '"></td>' +
                                              '</tr>' +
                                              '');

                });
                removeloadgif("#serviceplaceuploadmorepicstatus");
            }
        });

    });
    function spdelpic(filename) {
        var deldb = 0;
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/delfile/" + filename + "/" + deldb,
            success: function (msg) {
                if (msg == 1) {
                    $("input[value=\"/images/" + filename + "\"]").parent().parent().remove();
                }
                else {
                    alert("Không thể xóa file, xin hãy kiểm tra lại");
                }
            }
        });
    }
function savenewward(){

        var dadistrict_id =  $("select[name=dadistrict_id]").val();
        var daprovince_id =  $("select[name=daprovince_id]").val();
        var dalong_name = $("input[name=newwardname]").val();
        var daurl = $("input[name=newwardurl]").val();
        var daprefix = $("input[name=newwardprefix]").val();
        if (dalong_name.trim() != "" && daurl.trim() != "" && dadistrict_id > 0) {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveplaceward",
                data: "dalong_name=" + dalong_name
                    + "&daurl=" + daurl
                    + "&dadistrict_id=" + dadistrict_id
                    + "&daprefix=" + daprefix
                    + "&daprovince_id=" + daprovince_id,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadWard(0);
                            break;
                        default :
                            $("input[name=newwardname]").val("");
                            $("input[name=newwardurl]").val("");
                            $("#createward").hide();
                            $("select[name=daward_id]").html(msg);
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập tối thiểu Tên đầy đủ, Seo URL va chọn Quận/Huyện");
        }

}
function savenewstreet(){
    var dadistrict_id =  $("select[name=dadistrict_id]").val();
    var daprovince_id =  $("select[name=daprovince_id]").val();
    var daward_id =  $("select[name=daward_id]").val();
    var dalong_name = $("input[name=newstreetname]").val();
    var daurl = $("input[name=newstreeturl]").val();
    var daprefix = $("input[name=newstreetprefix]").val();
    if (dalong_name.trim() != "" && daurl.trim() != "" && dadistrict_id > 0 && daward_id > 0) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/saveplacestreet",
            data: "dalong_name=" + dalong_name
                + "&daurl=" + daurl
                + "&dadistrict_id=" + dadistrict_id
                + "&daprefix=" + daprefix
                + "&daward_id=" + daward_id
                + "&daprovince_id=" + daprovince_id,
            success: function (msg) {
                switch (msg) {
                    case "0":
                        alert("Không thể lưu");
                        loadStreet(0);
                        break;
                    default :
                        $("input[name=newstreetname]").val("");
                        $("input[name=newstreeturl]").val("");
                        $("#createstreet").hide();
                        $("select[name=dastreet_id]").html(msg);

                        break;
                }

            }
        });
    }
    else {
        alert("Vui lòng nhập tối thiểu Tên đầy đủ, Seo URL va chọn Quận/Huyện, Phường/Xã");
    }
}
</script>