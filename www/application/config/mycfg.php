<?php
$config['sitename'] = 'Phongee';
$oonfig['slogan'] = '';
$config['sufix_title'] = 'phongee.com';
$config['submitdealsendemail'] = false;
$config['pp'] = 10;

$config['mapw'] = 400;
$config['maph'] = 200;
$config['mapz'] = 15;

$config['iHomeServicePlae'] = 10;
$config['num_comment'] = 10;
$config['num_dealhot'] = 9;
$config['num_servicegroup'] = 10;
$config['num_admindealuserlist'] = 10;
$config['num_homeservicepopular'] = 18;


$config['aRole'] = array(
    'custom'=>'Khách hàng',
    'member'=>'Thành viên',
    'provider'=>'Nhà cung cấp',
    'staff'=>'Nhân viên',
    'ketoan'=>'Kế toán cửa hàng',
    'ketoankho'=>'Kế toán Kho',
    'ketoantonghop'=>'Kế toán Tổng hợp',
    'admin'=>'Quản trị',
);
$config['aRoleOrder'] = array(
    'member'=>0,
    'provider'=>0,
    'custom'=>0,
    'staff'=>1,
    'ketoan'=>2,
    'ketoankho'=>3,
    'ketoantonghop'=>8,
    'admin'=>9,
);
// role = 0 : not alow, ra = 1: can view, ra = 2: can create and edit yourself, ra=3 edit all
//$config['raAdmin'] = '0001123';
//$config['raUser'] = '0000003';
//$config['raThietbi'] = '0001123';
//$config['raInout'] = '0000123';
//$config['raReport'] = '0000123';
//$config['rqStore'] = '0002233'; //
//$config['rsNhapRadio'] = '0000033';
//$config['rsXuatRadio'] = '0000233';
//$config['rsXuatCuaHang'] = '0000033';
//$config['rlinout'] = '0001233';
//$config['rlinout_details'] = '0001233';
//$config['rlv_inout'] = '0001233';
//$config['rlv_moneytransfer'] = '0001233';
//$config['rluser'] = '0001233';
//$config['rlnhomthietbi'] = '0001233';
//$config['rlthietbi'] = '0001233';
//$config['rlchitietthietbi'] = '0001233';
//$config['rlmoneytransfer'] = '0001233';
//$config['rlstore'] = '0001233';

//User group default role
$config['aRoleName'] = array(
    'pgraadmin', // 0
    'pgrauser', // 1
    'pgrastore', //2
    'pgranhomthietbi', //3
    'pgrathietbi', //4
    'pgrachitietthietbi', //5
    'pgrainout', //6
    'pgramoneytransfer', //7
    'pgrareport', //8
    'pgrbnhapradio', //9
    'pgrbxuatradio', //10
    'pgrbnhapkho', //11
    'pgrbthuhoi', //12
    'pgrbxuatkho', //13
    'pgrbcuahang', //14
    'pgrbkhachhang', //15
    'pgrbkhachle', //16
    'pgrbthanhtoan', //17
    'pgrptinout', //18
    'pgrpmoney', //19
    'pgrpcongnocuahang', //20
    'pgrpcongnodoitac', //21
    'pgrptonkho', //22
    'pgrlchitietthietbi', //23
    'pgrlinout', //24
    'pgrlinout_details', //25
    'pgrlmoneytransfer', //26
    'pgrlnhomthietbi', //27
    'pgrlrole', //28
    'pgrlstore', //29
    'pgrlthietbi', //30
    'pgrluser', //31
    'pgrlv_inout', //32
    'pgrlv_moneytransfer', //33
    'pgrbnhaptien', //34
    'pgrbxuattien', //35
);

$config['adRole'] = array(
    //0: no,1:view,2:create,3:edit,4:delete 1, 9:all

    'member'        =>  array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',),
    'provider'      =>  array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',),
    'custom'        =>  array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',),
    'staff'         =>  array('1','0','1','1','1','3','3','3','1','0','1','0','0','0','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3',),
    'ketoan'        =>  array('1','3','0','1','1','3','3','3','1','1','1','0','1','1','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3',),
    'ketoankho'  =>  array('9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9',),
    'ketoantonghop'  =>  array('9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9',),
    'admin'         =>  array('9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9','9',),
);
$config['roletype'] = array(
    array('0','Cấm'),
    array('1','Xem'),
    array('2','Ghi'),
    array('3','Sửa'),
    array('4','Xóa'),
    array('9','All'),
);

$config['aMoneyType'] = array(
    'tm' => array('tm','Tiền mặt','VNĐ',1),
    'usd' => array('usd','USD','USD',21000),
    'vcbap' => array('vcbap','VCB Mr Phong','VNĐ',1),
    'scbap' => array('scbap','SCB Mr Phong','VNĐ',1),
    'vcbcp' => array('vcbcp','VCB Ms Phương','VNĐ',1),
    'bidvap' => array('bidvap','BIDV Anh Phong (cà thẻ)','VNĐ',1),
    'agrcp' => array('agrcp','AGRIBANK Phương (cà thẻ)','VNĐ',1),
    'np' => array('np','TK Nhất Phong','VNĐ',1),
);

$config['linkweather'] = "http://muasamcangay.com/tool/weather/Weather.php?id=";
//tp_hcm; ha_noi
$config['linkgold'] = "http://www.sjc.com.vn/xml/tygiavang.xml?t=";
$config['linkusd'] = "http://www.sjc.com.vn/ajax_currency.php?time=";
$config['linkvnexpress'] = 'http://vnexpress.net/block/crawler?arrKeys%5B%5D=thoi_tiet&arrKeys%5B%5D=gia_vang&arrKeys%5B%5D=ty_gia';