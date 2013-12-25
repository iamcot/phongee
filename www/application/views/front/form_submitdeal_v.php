<div id="form_submitdeal">
    <? if ($user_id == 0): ?>
      <p class="smalltext8 colorgreen"><i class="fa fa-info-circle"></i> Quý khách <b>chưa đăng nhập</b> vẫn có thể nhận <?=$this->lang->line('dealname')?>, thông tin về <?=$this->lang->line('dealname')?> sẽ
       được gửi vào <b>email</b> đã đăng ký, tuy nhiên quý khách nên <b><a href="/login" class="colorred">đăng nhập</a></b> để có thể theo dõi <?=$this->lang->line('dealname')?> và có nhiều tính năng hỗ trợ hơn. </p>
    <? endif; ?>
    <p>Quý khách vui lòng nhập thông tin về người nhận <?=$this->lang->line('dealname')?></p>
    <ul>
        <li>
            <label>Họ Tên</label>
            <input type="text" name="dealusername" placeholder="Họ Tên" value="<?=($oUser!=null?$oUser->dalname.' '.$oUser->dafname:'')?>">
        </li>
        <li>
            <label>Số điện thoại</label>
            <input type="text" name="dealtel" placeholder="Số điện thoại"  value="<?=($oUser!=null?$oUser->damobi:'')?>">
        </li>
        <li>
            <label>Email</label>
            <input type="text" name="dealemail" placeholder="Email"   value="<?=($oUser!=null?$oUser->daemail:'')?>">
        </li>
        <li>
            <label>Số lượng</label>
            <input type="text" name="dealamout" placeholder="Số lượng" value="1">
        </li>
        <li>
            <label>Địa chỉ</label>
            <input type="text" name="dealaddr" placeholder="Địa chỉ"   value="<?=($oUser!=null?$oUser->daaddr:'')?>">
        </li>
        <li>
            <label>Ghi chú</label>
            <textarea name="dealcomment" placeholder="Ghi chú"></textarea>
        </li>
        <li>
            <input type="button" value="Lưu" onclick="savedealform()" >
            <input type="button" value="Đóng" onclick="closedealform()">
            <input type="hidden" name="dealuser_id" value="<?=$user_id?>">
            <input type="hidden" name="deal_id"  value="<?=$deal_id?>">
        </li>
    </ul>
    <hr>
    <br>
    <h4>HỖ TRỢ </h4>
    <div><i class="fa fa-phone-square"></i> Hotline: <?=$this->config->item('hotline')?></div>
    <div><i class="fa fa-skype"></i> Skype: <?=$this->config->item('skype')?></div>
    <div><i class="fa fa-skype"></i> Yahoo: <?=$this->config->item('yahoo')?></div>
</div>