<div id="tabs">
    <ul>
        <li><a href="<?=base_url()?>admin/listpageuser">Danh sách thành viên</a></li>
        <li><a href="<?=base_url()?>admin/listpage/store">Danh sách cửa hàng</a></li>
        <li><a href="<?=base_url()?>admin/listpage/role">Phân quyền </a></li>
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