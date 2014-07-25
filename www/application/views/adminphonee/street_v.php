<fieldset>
    <legend>Thông tin</legend>
    <select name="daprovince_id" onchange="loadDistrict()">
        <? foreach($province as $prov):?>
            <option value="<?=$prov->id?>"><?=$prov->dalong_name?></option>
        <? endforeach;?>
    </select>
    <select name="dadistrict_id" onchange="loadWard()">
            <option value="0">Chọn Quận </option>
        <? foreach($district as $dist):?>
            <option value="<?=$dist->id?>"><?=$dist->dalong_name?></option>
        <? endforeach;?>
    </select>
    <select name="daward_id">
            <option value="0">Chọn Phường </option>
    </select>
    <input type="text" name="daprefix" placeholder="Tiền tố Đường/Phố" value="Đường">
    <input type="text" name="dalong_name" placeholder="Tên đầy đủ">
    <input type="text" name="daurl" placeholder="Seo URL" id="daurl">
    <textarea name="dainfo" placeholder="Thông tin"></textarea>
    <textarea name="damap" placeholder="Bản đồ"></textarea>
    <table class="mapoption" style="float:left;width:50%">
        <tr><td>Dài</td><td><input type="text" name="mapw"  value="<?=$this->config->item("mapw")?>" class="idinput"></td>
            <td>Cao</td><td> <input type="text" name="maph"   value="<?=$this->config->item("maph")?>" class="idinput"></td>
            <td>Zoom</td><td><input type="text" name="mapz"   value="<?=$this->config->item("mapz")?>" class="idinput"></td></tr>
        <tr><td>lat</td><td><input type="text" name="maplat" class="idinput"></td>
            <td>lng</td><td><input type="text" name="maplng" class="idinput"></td>
            <td colspan="2" style="text-align: center">
                <input type="button" value="Load" onclick="getmaplongname(1,1,1,0)">
                <input type="button" value="F5" onclick="reloadmap()">
            </td></tr>
    </table>
    <div id="damapdemo" style="float:right;width:48%"></div>
    <div style="clear:both"></div>
    <input type="hidden" name="edit" value="">
    <input type="hidden" name="currpage" value="1">
    <input type="button" value="Lưu" onclick="saveProvince()">
    <input type="button" value="Load" onclick="loadProvince(1)">
    <input type="button" value="Xóa nhập liệu" onclick="provinceclear()">
    <div id="loadstatus" style="float:right;"></div>
</fieldset>
<fieldset>
    <legend>Danh sách Tuyến đường </legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function(){
        $('input[name=dalong_name]').friendurl({id : 'daurl'});
        loadProvince(1);
    });
    function saveProvince() {
        var daward_id =  $("select[name=daward_id]").val();
        var daprovince_id =  $("select[name=daprovince_id]").val();
        var dadistrict_id =  $("select[name=dadistrict_id]").val();
        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var dainfo = $("textarea[name=dainfo]").val();
        var damap = $("textarea[name=damap]").val();
        var edit = $("input[name=edit]").val();
        var daprefix = $("input[name=daprefix]").val();

        if (dalong_name.trim() != "" && daurl.trim() != "" && daward_id != 0 && daward_id != null) {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/savestreet",
                data: "dalong_name=" + dalong_name
                          + "&daurl=" + daurl
                          + "&dainfo=" + dainfo
                          + "&damap=" + encodeURIComponent(damap)
                          + "&edit=" + edit
                          + "&daward_id=" + daward_id
                          + "&daprovince_id=" + daprovince_id
                          + "&daprefix=" + daprefix
                          + "&dadistrict_id=" + dadistrict_id,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadProvince($("input[name=currpage]").val());
                            provinceclear();
                            break;
                        case "1":
                            loadProvince($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
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
        $("#list_province").load("<?=base_url()?>admin/loadstreet/"+$("select[name=daward_id]").val()+"/"+page,function (){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function loadDistrict() {
        addloadgif("#loadstatus");
        $("select[name=dadistrict_id]").load("<?=base_url()?>admin/loadselectdist/"+$("select[name=daprovince_id]").val(),function (){removeloadgif("#loadstatus");});
    }
    function loadWard() {
        addloadgif("#loadstatus");
        $("select[name=daward_id]").load("<?=base_url()?>admin/loadselectward/"+$("select[name=dadistrict_id]").val(),function (){removeloadgif("#loadstatus");});
    }
    function provinceclear(){
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("textarea[name=dainfo]").val("");
        $("textarea[name=damap]").val("");
        $("input[name=edit]").val("");
        $("input[name=daprefix]").val("");
    }
    function editProvince(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditstreet/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daurl]").val(province.daurl);
                    $("input[name=daprefix]").val(province.daprefix);
                    $("textarea[name=dainfo]").val(province.dainfo);
                    $("textarea[name=damap]").val(province.damap);
                    $("#damapdemo").html(province.damap)

                    $("textarea[name=daprovince_id]").val(province.daprovince_id);
                    $("textarea[name=dadistrict_id]").val(province.dadistrict_id);
                }
            }
        });
    }
    function hideprovince(id, status) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hidestreet/" + id + "/" + status,
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
</script>