<fieldset>
    <legend>Thông tin</legend>
    <input type="text" name="dalong_name" placeholder="Tên đầy đủ">
    <input type="text" id="daurl" name="daurl" placeholder="Seo URL">
    <input type="text" id="daorder" name="daorder" placeholder="Thứ tự">
    <textarea name="dainfo" placeholder="Thông tin"></textarea>
    <label> Hiển thị trang chủ </label><input type="checkbox" name="dashowhome" >
    <br>
    <input type="hidden" name="edit" value="">
    <input type="hidden" name="currpage" value="1">
    <input type="button" value="Lưu" onclick="saveProvince()">
    <input type="button" value="Load" onclick="loadProvince(1)">
    <input type="button" value="Xóa nhập liệu" onclick="provinceclear()">
    <div id="loadstatus" style="float:right;"></div>
</fieldset>
<fieldset>
    <legend>Danh sách Nhóm dịch vụ</legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function(){
        $('input[name=dalong_name]').friendurl({id : 'daurl'});
        loadProvince(1);
    });
    function saveProvince() {
       // alert($("input[name=dashowhome]").prop('checked'));

        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var dainfo = $("textarea[name=dainfo]").val();
        var edit = $("input[name=edit]").val();
        var daorder = $("input[name=daorder]").val();
        var dashowhome = (($("input[name=dashowhome]").prop('checked'))?1:0);

        if (dalong_name.trim() != "" && daurl.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveservicegroup",
                data: "dalong_name=" + dalong_name
                    + "&daurl=" + daurl
                    + "&dainfo=" + dainfo
                    + "&dashowhome=" + dashowhome
                    + "&daorder=" + daorder
                    + "&edit=" + edit,
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
        $("#list_province").load("<?=base_url()?>admin/loadservicegroup/"+page,function (){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function provinceclear(){
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("textarea[name=dainfo]").val("");
        $("input[name=dashowhome]").prop('checked',false);
        $("input[name=edit]").val("");
        $("input[name=daorder]").val("");
    }
    function editProvince(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditservicegroup/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daorder]").val(province.daorder);
                    $("input[name=daurl]").val(province.daurl);
                    $("textarea[name=dainfo]").val(province.dainfo);
                    $("input[name=dashowhome]").prop('checked',((province.dashowhome==1)?true:false));
                }
            }
        });
    }
    function hideprovince(id, status,taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideservicegroup/" + id + "/" + status,
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