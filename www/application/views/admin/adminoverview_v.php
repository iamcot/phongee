<h1>Tổng quan về hệ thống</h1>
<p></p>
<p>Các chức năng cần thêm, vui lòng liên hệ <a
        href="mailto:thang102@gmail.com">thang102@gmail.com</a></p>
<div id="tabs">
    <ul>
        <li><a href="#tab-1">Tổng quan hệ thống</a></li>

    </ul>

    <div id="tab-1">
        <div class="block">
            <div id="leftside">
                <div class="gridcolumn">
                    <div class="gridblock">
                        <li class="fa fa-usd">Tiền mặt cửa hàng: <b id="cash"></b></li>
                    </div>
                    <div class="gridblock" style="height:500px"></div>
                </div>
                <div class="gridcolumn">
                    <div class="gridblock" style="height:400px"></div>
                    <div class="gridblock" style="height:200px"></div>
                </div>



            </div>
            <div id="rightside">
                <div class="block">
                    <div  class="blockhead"><img src="<?=base_url()?>src/img/cloud.png" style="">  Thời tiết</div>
                    <table>
                        <thead>
                        <tr>
                            <td style="width: 50%">Sài Gòn</td>
                            <td style="width: 50%">Hà Nội</td>
                        </tr>
                        </thead>

                        <tr>
                            <td id="saigon"></td>
                            <td id="hanoi"></td>
                        </tr>
                    </table>
                    <div id="weather"></div>
                </div>
                <div class="clear"></div>
                <div id="usd" class="block">
                    <div class="blockhead"><img src="<?=base_url()?>src/img/circle-chart.png" style="float:left;display: inline-block;margin-right: 10px"> Ngoại tệ</div>
                    <table>
                        <thead>
                        <tr>
                            <td>Loại</td>
                            <td>Mua vào</td>
                            <td>Bán ra</td>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
                <div class="clear"></div>
                <div id="gold" class="block">
                    <div  class="blockhead"><img src="<?=base_url()?>src/img/money.png" style="float:left;display: inline-block;margin-right: 10px"> Giá vàng </div>
                    <table>
                        <thead>
                        <tr>
                            <td>Loại</td>
                            <td>Mua vào</td>
                            <td>Bán ra</td>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
$(function () {
    $("#tabs").tabs();
    loadvnexpress();
    getCash("tm");
});
    function loadvnexpress(){
        var surl = "<?=base_url()?>admin/getvnexpress";
        $.ajax({
           type:"get",
            url:surl,
            success: function(msg){
                var obj = eval(msg);
                var gia_vang = obj.gia_vang;
                var ty_gia = obj.ty_gia;
                var thoi_tiet = obj.thoi_tiet;
                var str_gia_vang = "<tr><td>"+gia_vang[0].name+"</td> <td>"+gia_vang[0].buy+"</td> <td>"+gia_vang[0].sell+"</td></tr>"+
                    "<tr><td>"+gia_vang[1].name+"</td> <td>"+gia_vang[1].buy+"</td> <td>"+gia_vang[1].sell+"</td></tr>";
                $("#gold tbody").html(str_gia_vang);
                var str_ty_gia = "<tr><td>USD</td> <td>"+ty_gia.data[1].buytm+"</td> <td>"+ty_gia.data[1].sell+"</td></tr>"+
                    "<tr><td>HKD</td> <td>"+ty_gia.data[3].buytm+"</td> <td>"+ty_gia.data[3].sell+"</td></tr>"+
                    "<tr><td>SGD</td> <td>"+ty_gia.data[8].buytm+"</td> <td>"+ty_gia.data[8].sell+"</td></tr>"+
                    "<tr><td>EUR</td> <td>"+ty_gia.data[9].buytm+"</td> <td>"+ty_gia.data[9].sell+"</td></tr>";
                $("#usd tbody").html(str_ty_gia);
                $("#saigon").html("" +
                    "<span class='temp'><img src='http://st.f2.vnecdn.net/i/v2/weather/"+thoi_tiet.tp_hcm.weather_code+".gif'> "+thoi_tiet.tp_hcm.temp+" &deg;C </span>" +
                    "<br><b>"+thoi_tiet.tp_hcm.weather+"</b>"+
                "<br>Độ ẩm "+thoi_tiet.tp_hcm.humid+
                "<br>"+thoi_tiet.tp_hcm.wind);
                $("#hanoi").html("" +
                    "<span class='temp'><img src='http://st.f2.vnecdn.net/i/v2/weather/"+thoi_tiet.ha_noi.weather_code+".gif'> "+thoi_tiet.ha_noi.temp+" &deg;C </span>" +
                    "<br><b>"+thoi_tiet.ha_noi.weather+"</b>"+
                "<br>Độ ẩm "+thoi_tiet.ha_noi.humid+
                "<br>"+thoi_tiet.ha_noi.wind);
            }
        });
    }
   function getCash(type){
       $("#cash").load("<?=base_url()?>admin/getCash/"+type);
   }
</script>