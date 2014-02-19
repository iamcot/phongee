<fieldset>
    <legend>Thông tin</legend>
    <table id="inputserviceplace">
        <tr>
            <td>
                <label>Tên</label>
                <input type="text" name="pgfname" placeholder="Tên"></td>
            <td>
                <label>Họ</label>
                <input type="text" name="pglname" placeholder="Họ và tên đệm">
            </td>
        </tr>
        <tr>
            <td>
                <label>Tài khoản</label>
                <input type="text" name="pgusername" placeholder="Tên tài khoản">
            </td>
            <td>
                <label>Mật khẩu</label>
                <input type="text" name="pgpassword" placeholder="Mật khẩu">
            </td>
        </tr>
        <tr>
            <td id="selectrole">
                <label>Nhóm</label>
                <select name="pgrole" data-placeholder="Quyền hạn" >
                    <?
                    $aRoleOrder = $this->config->item("aRoleOrder");
                    foreach($this->config->item('aRole') as $k=>$v):
                        if($aRoleOrder[$this->session->userdata("pgrole")] >= $aRoleOrder[$k] || $this->session->userdata("pgrole") == 'admin'):?>
                    <option value="<?=$k?>"><?=$v?></option>
                    <? endif;?>
                    <? endforeach;?>
                </select>

            </td>
            <td>
                <label>Điện thoại</label>
                <input type="text" name="pgmobi" placeholder="Điện thoại">
            </td>
        </tr>
        <tr>
            <td>
                <label>e-mail</label>
                <input type="text" name="pgemail" placeholder="Email"></td>
            <td>
                <label>Cửa hàng</label>
                <select name="pgstore_id" >
                    <option value="0">Tất cả cửa hàng</option>
                    <? foreach($aStore as $store):?>
                        <? if ($this->session->userdata("pgstore_id") == $store->id || $aRoleOrder[$this->session->userdata('pgrole')]>=3):?>
                    <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
                            <? endif;?>
                    <? endforeach;?>
                </select>
            </td>

        </tr>
        <tr>
            <td>
                <label>Hình ảnh</label>
                <input type="text" name="pgavatar" placeholder="Ảnh đại diện">
                <input id="picupload"  type="file" name="files[]" data-url="<?=base_url()?>admin/calljupload" multiple>
            </td>
            <td rowspan="2" id="pgavatardemo">

            </td>
        </tr>

        <tr>
            <td>
                <label>Địa chỉ</label>
                <input type="text" name="pgaddr" placeholder="Địa chỉ"></td>

        </tr>
        <tr>
            <td colspan="2"><input type="hidden" name="edit" value="">
                <input type="hidden" name="currpage" value="1">
                <span class="btn btn-small"><input type="button" value="Lưu" onclick="save()"> </span>
                <span class="btn btn-small"><input type="button" value="Load" onclick="load(1)"> </span>
                <span class="btn btn-small"><input type="button" value="Xóa nhập liệu" onclick="myclear()"> </span>

                <div id="loadstatus" style="float:right;"></div>
            </td>
        </tr>
    </table>


</fieldset>
<fieldset>
    <legend>Tài khoản giao dịch cửa hàng</legend>
    <div class="field_select"  style="width:10%">
    <label>ID thành viên </label>
    <input type="text" name="pguser_id" placeholder="ID">

        </div>

    <div class="field_select"  style="width:20%">
        <label>Cửa hàng giao dịch </label>
        <select name="pgtradestore_id" >
            <?
            foreach($aStore as $store):?>
                <? if ($this->session->userdata("pgstore_id") == $store->id || $aRoleOrder[$this->session->userdata('pgrole')]>=3 ):?>
                    <option value="<?=$store->id?>"><?=$store->pglong_name?></option>
                <? endif;?>
            <? endforeach;?>
        </select>
    </div>

    <span class="btn btn-small"><input type="button" value="Lưu" onclick="savetradeuser()"> </span>
    <span class="btn btn-small"><input type="button" value="Load" onclick="loadtradeuser()"> </span>
    <div class="clear"></div>
    <div  id="listtradeuser"></div>
</fieldset>
<fieldset>
    <legend>Danh sách thành viên </legend>
    <div>
        <span style="display: inline-block;">
        <input type="checkbox" name="pglstaff" id="pglstaff" checked="checked">
        <label for="pglstaff">Nhân viên</label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pglprovider" id="pglprovider" checked="checked">
        <label for="pglprovider">Nhà cung cấp</label>
            </span>
        <span style="display: inline-block;">
        <input type="checkbox" name="pglcustom" id="pglcustom" checked="checked">
        <label for="pglcustom">Khách hàng</label>
            </span>

        <span style="display: inline-block;width:25%">
        <input type="text" name="pglkeyword" placeholder="Từ khóa" style="display: inline-block;height: 28px;" ondblclick="this.value=''">
            </span>
    </div>
    <div id="list_province"></div>
</fieldset>
<script>
    $(function () {
        $("input").customInput();
        load(1);
    });
    function savetradeuser(){
        var pgstore_id      = $("select[name=pgtradestore_id]").val();
        var pguser_id     = $("input[name=pguser_id]").val();
        if (pguser_id.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/tradeuser",
                data: "pgstore_id=" + pgstore_id
                          + "&pguser_id=" + pguser_id,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadtradeuser();
                            break;
                        case "tu1":
                            alert("Đã có tài khoản giao dịch của thành viên này tại cửa hàng ");
                            loadtradeuser();
                            break;
                        default :
                            loadtradeuser();
                            addsavegif("#loadstatus");
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập dữ liệu");
        }
    }
    function loadtradeuser(){
        if($("input[name=pguser_id]").val().trim()==""){
            alert("Chưa chọn thành viên");
            return;
        }
        addloadgif("#loadstatus");
        $("#listtradeuser").load("<?=base_url()?>admin/loadtraduser/"+$("input[name=pguser_id]").val(), function () {
            removeloadgif("#loadstatus");
        });
    }
    function save() {
        var pgfname     = $("input[name=pgfname]").val();
        var pglname     = $("input[name=pglname]").val();
        var pgusername  = $("input[name=pgusername]").val();
        var pgpassword  = $("input[name=pgpassword]").val();
        var pgmobi      = $("input[name=pgmobi]").val();
        var pgemail     = $("input[name=pgemail]").val();
        var pgaddr      = $("input[name=pgaddr]").val();
        var pgavatar    = $("input[name=pgavatar]").val();
        var pgrole      = $("select[name=pgrole]").val();
        var pgstore_id      = $("select[name=pgstore_id]").val();

        var edit = $("input[name=edit]").val();

        if (pgfname.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/save/user",
                data: "pgfname=" + pgfname
                    + "&pglname=" + pglname
                    + "&pgusername=" + pgusername
                    + "&pgpassword=" + pgpassword
                    + "&pgmobi=" + pgmobi
                    + "&pgemail=" + pgemail
                    + "&pgaddr=" + pgaddr
                    + "&pgavatar=" + pgavatar
                    + "&pgrole=" + pgrole
                    + "&pgstore_id=" + pgstore_id

                    + "&edit=" + edit,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            load($("input[name=currpage]").val());
                            myclear();
                            break;

                        default :
                            load($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            myclear();
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập dữ liệu");
        }
    }
    function load(page) {
        addloadgif("#loadstatus");
        $("#list_province").load("<?=base_url()?>admin/load/user/" + page+"/"+$("#pglstaff").prop("checked")+"-"+$("#pglprovider").prop("checked")+"-"+$("#pglcustom").prop("checked")+"-"+$("input[name=pglkeyword]").val(), function () {
            removeloadgif("#loadstatus");
        });
        $("input[name=currpage]").val(page);
    }
    function myclear() {
        $("input[name=pgfname]").val("");
        $("input[name=pglname]").val("");
        $("input[name=pgusername]").val("");
        $("input[name=pgpassword]").val("");
        $("input[name=pgmobi]").val("");
        $("input[name=pgemail]").val("");
        $("input[name=pgaddr]").val("");
        $("input[name=pgavatar]").val("");
        $("input[name=edit]").val("");
        $("select[name=pgstore_id]").val("0");
        $("#pgavatardemo").html('');


    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadedit/user/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=pgfname]").val(province.pgfname);
                    $("input[name=pglname]").val(province.pglname);
                    $("input[name=pgusername]").val(province.pgusername);
                    $("input[name=pgmobi]").val(province.pgmobi);
                    $("input[name=pgemail]").val(province.pgemail);
                    $("input[name=pgaddr]").val(province.pgaddr);
                    $("input[name=pgavatar]").val(province.pgavatar);
                    $("input[name=edit]").val(province.id);
                    $("input[name=pguser_id]").val(province.id);
                    $("select[name=pgrole]").val(province.pgrole);
                    $("select[name=pgstore_id]").val(province.pgstore_id);
                    loadtradeuser();
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/' + province.pgavatar + '">');
                }
            }
        });
    }
    function hide(id, status, taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hide/user/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    load($("input[name=currpage]").val());
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
    $(function () {
        if($("[placeholder]").size() > 0) {
            $.Placeholder.init();
        }
        $('#picupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result, function (index, file) {
                    $('input[name=pgavatar]').val(file.name);
                    $("#pgavatardemo").html('<img src="<?=base_url()?>thumbnails/'+file.name+'">')

                });
            }
        });

    });

</script>