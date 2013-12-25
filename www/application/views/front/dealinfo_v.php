<? if ($oDealInfo != ""): ?>
    <div id="dealinfocontent">
        <div class="left margin15">
           <div style="position: relative;overflow: hidden">
            <img src="<?= base_url() ?>main/makethumb/?f=<?= $oDealInfo->dapic ?>&w=300&h=300">
            <span class="dt-hightlight-saleoff" style="top:5px;right: 5px;">
                <span style="position: relative">
                    <img src="/sale_promotion.png" width="50px" height="50px">
                    <span class="dt-sale-bbb">
                        <?=(($oDealInfo->datype=="percent")?($oDealInfo->daamount):number_format(ceil($oDealInfo->daamount/$oDealInfo->daoldprice*100),0))?></b> <span style="font-size: .8em"> %</span>
                    </span>
                </span>
            </span>
           </div>
            <h4>ĐIỂM NỔI BẬT</h4>

            <div class="liicon"><?= $oDealInfo->daspecial ?></div>
        </div>
        <div class="left">
            <ul>
                <li><h4><b><?= $oDealInfo->dalong_name ?></b></h4></li>
                <li><i class="fa fa-home"></i>
                    <span><?= $oCurrentPlace->dalong_name ?></span></li>
                <li><i class="fa fa-dollar"></i>
                    <span><b
                            class="colorred size15"><?= (($oDealInfo->datype == "percent") ? number_format($oDealInfo->daoldprice * (100- $oDealInfo->daamount)/100, 0, ',', '.') : number_format(($oDealInfo->daoldprice - $oDealInfo->daamount), 0, ',', '.')) ?></b> <span
                            style="font-size: .8em">đ</span> </span>
                </li>
                <li><i class="fa fa-strikethrough"></i>
                    <span
                        style="text-decoration: line-through;font-size:.8em"><?= number_format($oDealInfo->daoldprice, 0, ',', '.') ?>
                        đ </span>
                </li>
                <li>
                    <div id="countdown" class="colorgreen"></div>
                    <br>
                    <? $now = time();
                        if($now < $oDealInfo->dafrom): ?>
                        <b class="colorred">Khuyến mãi chưa bắt đầu</b>
                    <? elseif($now > $oDealInfo->dato):?>
                        <b  class="colorred">Khuyến mãi đã hết hạn</b>
                        <? else:?>
                            <input type="button" value="Nhận <?=$this->lang->line('dealname')?>" style="height:50px;padding: 10px 20px 10px 20px;font-size:1.7em" onclick="opendealsubmit(<?=$oDealInfo->id?>)">

                        <? endif;?>
                </li>
                <li class="noticegetdeal">
                    <div>- Nhận thẻ <?= $this->lang->line('dealname') ?> free ( giao thẻ tận nơi phí
                         ship <b class="colorred"><?= $this->config->item("shipfee") ?></b> đ)
                    </div>
                    <div>- Quý khách cầm thẻ <?= $this->lang->line('dealname') ?> đến sử dụng dịch
                         vụ và được giảm <b
                            class="colorred"><?= number_format($oDealInfo->daamount, 0, ',', '.') ?></b>
                        <span
                            style="font-size: .8em"><?= (($oDealInfo->datype == "percent") ? "%" : "đ") ?></span></b>
                         theo đúng như thông tin ghi trên thẻ.
                    </div>
                </li>
                <li>
                </li>
                <li id="supportdeal">
                    <hr>
                    <br>
                    <div><i class="fa fa-rocket"></i>
                    <span>Lượt xem: <b><?= $oDealInfo->daview ?></b></span></div>
                    <br>
                    <hr>
                    <br>
                    <h4>HỖ TRỢ </h4>
                    <div><i class="fa fa-phone-square"></i> Hotline: <?=$this->config->item('hotline')?></div>
                    <div><i class="fa fa-skype"></i> Skype: <?=$this->config->item('skype')?></div>
                    <div><i class="fa fa-skype"></i> Yahoo: <?=$this->config->item('yahoo')?></div>
                    <br>
                    <hr>
                </li>
                <li>
                    <h4>ĐIỀU KHOẢN SỬ DỤNG</h4>

                    <div class="liicon"><?= $oDealInfo->dacondition ?></div>
                </li>
            </ul>

        </div>
    </div>
    <script>
    $(function () {
        $( "#dialog" ).dialog({
            autoOpen: false,
            minWidth: 500,
            position: { my: "right top", at: "right top", of: window },
            buttons:null,
            modal: true
        });
       // var dsince = new Date(<?=date("Y",$oDealInfo->dafrom)?>, <?=date("m",$oDealInfo->dafrom)?> - 1, <?=date("d",$oDealInfo->dafrom)?>);
        var duntil = new Date(<?=date("Y",$oDealInfo->dato)?>, <?=date("m",$oDealInfo->dato)?> - 1, <?=date("d",$oDealInfo->dato)?>);
        $('#countdown').countdown({until: duntil});
    });
        function opendealsubmit(id){
            //loadSubmitDealForm
<!--            $("#dialog").load("--><?//=base_url()?><!--main/loadSubmitDealForm/"+id,$("#dialog").parent().css('position', 'Fixed').end().dialog('open'));-->
            $("#dialog").html("").load("<?=base_url()?>main/loadSubmitDealForm/"+id,$("#dialog").dialog({
                position: { my: "right top", at: "right top", of: window },
                title: "Thông tin người nhận <?=$this->lang->line('dealname')?> <?=$oDealInfo->dalong_name?>",
                buttons: null
            }).dialog('open'));
        }
        function closedealform(){
            $("#dialog").html("").dialog("close");
        }
        function savedealform(){
          //  alert(document.URL);
            var dadeal_id   = $("input[name=deal_id]").val();
            var dauser_id   = $("input[name=dealuser_id]").val();
            var daname      = $("input[name=dealusername]").val();
            var datel       = $("input[name=dealtel]").val();
            var daaddr      = $("input[name=dealaddr]").val();
            var daemail     = $("input[name=dealemail]").val();
            var daamount    = $("input[name=dealamout]").val();
            var dacomment   = $("textarea[name=dealcomment]").val();
            if(dadeal_id > 0 && daname != "" && datel != "" && daaddr !="" && daamount > 0){
            $.ajax({
                type:"post",
                url: "<?=base_url()?>main/savedealuser",
                data:"dadeal_id="+dadeal_id
                    +"&dauser_id="+dauser_id
                    +"&daname="+daname
                    +"&datel="+datel
                    +"&daaddr="+daaddr
                    +"&daemail="+daemail
                    +"&daamount="+daamount
                    +"&dacomment="+dacomment,
                success: function(msg){
                    if(msg==0){
                        alert("Lưu <?=$this->lang->line("dealname")?> thất bại, vui lòng thử lại hoặc liên hệ với nhóm hỗ trợ.");
                    }
                    else{
                        var bill = eval(msg);
                        console.log(bill);
                        $("#dialog").dialog("close");
                        $("#dialog").html("" +
                            "Mã đơn hàng: <b>" + bill.dadealuser_id+"</b> <br>"+
                            "Tên người nhận: <b>"+ bill.daname+"</b><br>"+
                            "Địa chỉ nhận <?=$this->lang->line("dealname")?>: <b>"+ bill.daaddr+ "</b><br>"+
                            <?if($this->config->item("submitdealsendemail")):?>"Thông tin hóa đơn đã gửi tới email: <b>"+ bill.daemail+ "</b>"+ <? endif;?>
                            "<br><br><hr><br>"+
                            "<h4  class='smalltext8'>HỖ TRỢ </h4>"+
                            '<div class="smalltext8"><i class="fa fa-phone-square"></i> Hotline: <?=$this->config->item('hotline')?></div>'+
                            '<div  class="smalltext8"><i class="fa fa-skype"></i> Skype: <?=$this->config->item('skype')?></div>'+
                            '<div  class="smalltext8"><i class="fa fa-skype"></i> Yahoo: <?=$this->config->item('yahoo')?></div>').dialog({
                                title:"Thông tin Hóa Đơn",
                                position: { my: "center", at: "center", of: window },
                                buttons:[{
                                    text:"Đóng",
                                    click: function(){$(this).dialog("close");}
                                }]
                            }).dialog("open");
                    }
                }
            });
            }
            else{
                alert("Vui lòng nhập đủ các thông tin yêu cầu.");
            }
        }
    </script>
<? endif; ?>
<div id="dialog" title="Thông tin người nhận <?=$this->lang->line('dealname')?> <?=$oDealInfo->dalong_name?>">
</div>
