<fieldset>
    <legend>Thông tin</legend>
    <input type="text" name="daprefix" placeholder="Tiền tố Tỉnh/Huyện">
    <input type="text" name="dalong_name" placeholder="Tên đầy đủ">
    <input type="text" id="daurl" name="daurl" placeholder="Seo URL">
    <input type="text" name="daorder" placeholder="Thứ tự">
    <textarea name="dainfo" placeholder="Thông tin"></textarea>
    <textarea name="damap" placeholder="Bản đồ"></textarea>
    <table class="mapoption" style="float:left;width:50%">
        <tr><td>Dài</td><td><input type="text" name="mapw"  value="<?=$this->config->item("mapw")?>" class="idinput"></td>
            <td>Cao</td><td> <input type="text" name="maph"   value="<?=$this->config->item("maph")?>" class="idinput"></td>
            <td>Zoom</td><td><input type="text" name="mapz"   value="<?=$this->config->item("mapz")?>" class="idinput"></td></tr>
        <tr><td>lat</td><td><input type="text" name="maplat" class="idinput"></td>
            <td>lng</td><td><input type="text" name="maplng" class="idinput"></td>
            <td colspan="2" style="text-align: center">
                <input type="button" value="Load" onclick="getmaplongname(0,-1,-1,-1)">
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
    <legend>Danh sách Tỉnh</legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function(){
        $('input[name=dalong_name]').friendurl({id : 'daurl'});
       loadProvince(1);
    });
    function saveProvince() {
        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var dainfo = $("textarea[name=dainfo]").val();
        var damap = $("textarea[name=damap]").val();
        var daorder = $("input[name=daorder]").val();
        var edit = $("input[name=edit]").val();
        var daprefix = $("input[name=daprefix]").val();

        if (dalong_name.trim() != "" && daurl.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveprovince",
                data: "dalong_name=" + dalong_name
                          + "&daurl=" + daurl
                          + "&dainfo=" + dainfo
                          + "&damap=" + encodeURIComponent(damap)
                          + "&daorder=" + daorder
                          + "&edit=" + edit
                          + "&daprefix=" + daprefix,
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
                            alert("Lỗi lưu Tỉnh - không xác định.")
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
        $("#list_province").load("<?=base_url()?>admin/loadprovince/"+page,function (){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function provinceclear(){
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("input[name=daorder]").val("");
        $("textarea[name=dainfo]").val("");
        $("textarea[name=damap]").val("");
        $("input[name=edit]").val("");
        $("input[name=daprefix]").val("");
    }
    function editProvince(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditprovince/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daurl]").val(province.daurl);
                    $("input[name=daorder]").val(province.daorder);
                    $("input[name=daprefix]").val(province.daprefix);
                    $("textarea[name=dainfo]").val(province.dainfo);
                    $("textarea[name=damap]").val(province.damap);
                    $("#damapdemo").html(province.damap);

                }
            }
        });
    }
    function hideprovince(id, status,taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideprovince/" + id + "/" + status,
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