<fieldset>
    <legend>Thông tin</legend>
    <select name="daservicegroup_id" onchange="loadProvince(1)">
        <? foreach($servicegroup as $serv):?>
            <option value="<?=$serv->id?>"><?=$serv->dalong_name?></option>
        <? endforeach;?>
    </select>
    <input type="text" name="dalong_name" placeholder="Tên đầy đủ">
    <input type="text" id="daurl" name="daurl" placeholder="Seo URL">
    <textarea name="dainfo" placeholder="Thông tin"></textarea>
    <input type="hidden" name="edit" value="">
    <input type="hidden" name="currpage" value="1">
    <input type="button" value="Lưu" onclick="saveProvince()">
    <input type="button" value="Load" onclick="loadProvince(1)">
    <input type="button" value="Xóa nhập liệu" onclick="provinceclear()">
    <div id="loadstatus" style="float:right;"></div>
</fieldset>
<fieldset>
    <legend>Danh sách Dịch vụ</legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function(){
        $('input[name=dalong_name]').friendurl({id : 'daurl'});
        loadProvince(1);
    });
    function saveProvince() {
        var daservicegroup_id =  $("select[name=daservicegroup_id]").val();
        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var dainfo = $("textarea[name=dainfo]").val();
        var edit = $("input[name=edit]").val();

        if (dalong_name.trim() != "" && daurl.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveserviceitem",
                data: "dalong_name=" + dalong_name
                    + "&daurl=" + daurl
                    + "&dainfo=" + dainfo
                    + "&edit=" + edit
                    + "&daservicegroup_id=" + daservicegroup_id,
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
        $("#list_province").load("<?=base_url()?>admin/loadservice_item/"+$("select[name=daservicegroup_id]").val()+"/"+page,function (){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function provinceclear(){
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("textarea[name=dainfo]").val("");
        $("input[name=edit]").val("");
    }
    function editProvince(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditserviceitem/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daurl]").val(province.daurl);
                    $("textarea[name=dainfo]").val(province.dainfo);
                }
            }
        });
    }
    function hideprovince(id, status) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideserviceitem/" + id + "/" + status,
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