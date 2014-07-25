<div id="tabs">
    <ul>
        <li><a href="<?=base_url()?>admin/street">Đường phố</a></li>
        <li><a href="<?=base_url()?>admin/province">Tỉnh/Thành phố</a></li>
        <li><a href="<?=base_url()?>admin/district">Quận/Huyện</a></li>
        <li><a href="<?=base_url()?>admin/ward">Phường/Xã</a></li>

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
                            "Trang không tồn tại." );
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