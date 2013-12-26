<?php
$config['sitename'] = 'Phongee';
$oonfig['slogan'] = '';
$config['sufix_title'] = 'phongee.com';
$config['submitdealsendemail'] = false;
$config['pp'] = 10;

$config['mapw'] = 400;
$config['maph'] = 200;
$config['mapz'] = 15;
$config['aAddrTree'] = array(  // table,parenttable)
                               'daprovince' => array('daprovince',''            ),
                               'dadistrict' => array('dadistrict','daprovince'  ),
);

$config['iHomeServicePlae'] = 10;
$config['num_comment'] = 10;
$config['num_dealhot'] = 9;
$config['num_servicegroup'] = 10;
$config['num_admindealuserlist'] = 10;
$config['num_homeservicepopular'] = 18;

$config['iHomeCatDeal'] = 6;
$config['shipfee'] = '10.000';
$config['hotline'] = '04 113 113 113';
$config['skype'] = 'websaigonhanoi';
$config['yahoo'] = 'websaigonhanoi';
$config['dealuserstatus'] = array(
    "nan" => "Không xác định",
    "wait" => "Đang chờ",
    "confirm" => "Xác nhận",
    "sending" => "Đang giao hàng",
    "receive" => "Đã nhận ",
    "cancel" => "Bị Khách hủy",
    "reject" => "Bị Cty từ chối",
);
$config['aNewsCat'] = array(
    "news"  =>  "Tin tức",
);
$config['suggest'] = "goi-y-dia-chi";
$config['aNewsSuggest'] = array(
  "event" => array("Sự kiện","star-o"),
  "relax" => array("Vui chơi","gamepad"),
  "food" => array("Ăn uống","cutlery"),
  "spa" => array("Làm đẹp","leaf"),
);
$config['aNewsHelp'] = array(
    "about" =>  "Giới thiệu",
    "help" =>   "Giúp đỡ ",
);
