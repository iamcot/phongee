<div id="tabs">
    <ul>
        <li><a href="<?=base_url()?>admin/listpagerp/xnt">Xuất Nhập Tồn</a></li>
        <li><a href="<?=base_url()?>admin/listpagerp/tonkho">Tồn kho</a></li>
        <li><a href="<?=base_url()?>admin/listpagerp/tienquy">Tiền quỹ</a></li>
        <li><a href="<?=base_url()?>admin/listpagerp/congno">Công nợ</a></li>
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