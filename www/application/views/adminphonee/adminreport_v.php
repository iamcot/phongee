<div id="tabs">
    <ul>
        <? if ($this->mylibs->checkRole('pgrptinout') > 0): ?>
            <li><a href="<?= base_url() ?>admin/listpagerp/xnt">Xuất Nhập Tồn</a></li>
        <? endif ?>
        <? if ($this->mylibs->checkRole('pgrptonkho') > 0): ?>
            <li><a href="<?= base_url() ?>admin/listpagerp/tonkho">Tồn kho</a></li>
        <? endif ?>
        <? if ($this->mylibs->checkRole('pgrpmoney') > 0): ?>
            <li><a href="<?= base_url() ?>admin/listpagerp/tienquy">Tiền quỹ</a></li>
        <? endif ?>
        <? if ($this->mylibs->checkRole('pgrpcongnodoitac') > 0): ?>
            <li><a href="<?= base_url() ?>admin/listpagerp/congno">Công nợ Đối tác </a></li>
        <? endif ?>
        <? if ($this->mylibs->checkRole('pgrpcongnocuahang') > 0): ?>
            <li><a href="<?= base_url() ?>admin/listpagerp/congnostore">Công nợ cửa hàng </a></li>
        <? endif ?>
    </ul>
</div>
<script>
    $(function() {
        $( "#tabs" ).tabs(
            {
                beforeLoad: function( event, ui ) {
                    $(".ui-tabs-panel").empty();
                    ui.jqXHR.error(function() {
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
</script>