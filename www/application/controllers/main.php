<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        if ($this->session->userdata("lang"))
            $this->crrlanglang = $this->session->userdata("lang");
        else $this->crrlang = "vi";
        //default
        $this->lang->load("default", $this->crrlang);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->load->model("main_m");
    }

    public function index($sCurrentProvince = "") //seourl
    {
        $oCurrentProvince = $this->main_m->getProvince($sCurrentProvince);
        $data['oCurrentProvince'] = $oCurrentProvince;
        $this->session->set_userdata("province", $oCurrentProvince->daurl);
        $data['sTitle'] = $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['sCat'] = 'start';
        $data['sCurrentTree'] = '/' . $oCurrentProvince->daurl . '/';
        $data = $this->processCurrentTreeForService($data);
        $data['aDistrict'] = $this->main_m->getsubcat($this->tbprovince, $oCurrentProvince->id, $this->tbdistrict);
        $aServiceHome = $this->main_m->getNavService();
        $catsdeal = array();
        foreach ($aServiceHome as $servicegroup) {
            $data['aHotDealList'] = $this->main_m->getDealList($oCurrentProvince->id, "hot", 4, $servicegroup->id);
            $sServiceCat = $this->load->view("front/homedealitem_v", $data, true);
            $catsdeal[$servicegroup->id][0] = $servicegroup->dalong_name;
            $catsdeal[$servicegroup->id][1] = $servicegroup->daurl;
            $catsdeal[$servicegroup->id][2] = $sServiceCat;
        }
        $data['aComment'] = $this->main_m->getNewComment($oCurrentProvince->id);

        $data['sComment'] = $this->load->view("/front/homecommentcontent_v",$data,true);
        $data['catsdeal'] = $catsdeal;
        $data['sServicePlace_hot'] = $this->main_m->getHomeServicePlace("hot", $oCurrentProvince->id);
        $data['sServicePlace_new'] = $this->main_m->getHomeServicePlace("new", $oCurrentProvince->id);
        $data['aHotDealList'] = $this->main_m->getDealList($oCurrentProvince->id, "hot", $this->config->item('num_dealhot'));
        $data['sHotDealList'] = $this->load->view("front/homedealitem_v", $data, true);
        $data['aPopularService'] = $this->main_m->getPopularService($oCurrentProvince->id);
        $data['aNewsSuggest'] = $this->main_m->getNewsSuggest($this->config->item("aNewsSuggest"),$oCurrentProvince->id,5,0);
        if($data['aNewsSuggest'] != null)
        do{
            $data['sSuggestRandom'] = array_rand($this->config->item("aNewsSuggest"),1);
        }while(!isset($data['aNewsSuggest'][($data['sSuggestRandom'])]));
        else{
            $data['sSuggestRandom'] = 'event';//
        }

        $data['sBody'] = $this->load->view("front/start_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;

        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbprovince, $aNavAddr);
        $data['bIsPromoDeal'] = 1;
        $data['aHotDealList'] = $this->main_m->getDealList($oCurrentProvince->id, "promo", 2);
        $data['sPromoDealList'] = $this->load->view("front/homedealitem_v", $data, true);
        $data['aBanner'] = $this->main_m->getBanner();

        $this->render($data);
    }

    public function district($province, $daseorul)
    {
        $oCurrentProvince = $this->main_m->getProvince($province);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $daseorul);
        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['aWard'] = $this->main_m->getsubcat($this->tbdistrict, $oCurrentDistrict->id, $this->tbward);
        $data['sTitle'] = $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ', ' . $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree(array("k" => $this->tbdistrict . "_id", "v" => $oCurrentDistrict->id));
        $data['sCurrentTree'] = '/' . $oCurrentProvince->daurl . '/' . $oCurrentDistrict->daurl . '/';
        $data = $this->processCurrentTreeForService($data);

        //$data['sCat'] = 'start';
        $data['aStreet'] = $this->main_m->getStreet($oCurrentProvince->id, $oCurrentDistrict->id, 0);
        $data['sBody'] = $this->load->view("front/district_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;

        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbdistrict, $aNavAddr);
        $this->render($data);
    }

    public function ward($province, $district, $daseorul)
    {
        $oCurrentProvince = $this->main_m->getProvince($province);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $district);
        $oCurrentWard = $this->main_m->getWard($oCurrentDistrict->id, $daseorul);
        $data['aWard'] = $this->main_m->getOtherWard($oCurrentDistrict->id, $oCurrentWard->id);
        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['oCurrentWard'] = $oCurrentWard;

        $data['aStreet'] = $this->main_m->getStreet($oCurrentProvince->id, $oCurrentDistrict->id, $oCurrentWard->id);
//        $data['aStreet'] = $this->main_m->getsubcat($this->tbward, $oCurrentWard->id, $this->tbstreet);
        $data['sTitle'] = $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ', ' . $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ', ' . $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree(array("k" => $this->tbward . "_id", "v" => $oCurrentWard->id));
        $data['sCurrentTree'] = '/' . $oCurrentProvince->daurl . '/' . $oCurrentDistrict->daurl . '/';
        $data = $this->processCurrentTreeForService($data);
        //$data['sCat'] = 'start';
        $data['sBody'] = $this->load->view("front/ward_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;
        $aNavAddr[$this->tbward] = $oCurrentWard;

        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbward, $aNavAddr);
        $this->render($data);
    }

    public function street($province, $district, $ward, $daseorul)
    {
        $oCurrentProvince = $this->main_m->getProvince($province);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $district);
        $oCurrentWard = $this->main_m->getWard($oCurrentDistrict->id, $ward);
        $oCurrentStreet = $this->main_m->getStreet($oCurrentProvince->id, $oCurrentDistrict->id, $oCurrentWard->id, $daseorul);
        if ($oCurrentStreet != null) $oCurrentStreet = $oCurrentStreet[0];
        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['oCurrentWard'] = $oCurrentWard;
        $data['oCurrentStreet'] = $oCurrentStreet;
        $data['sTitle'] = $oCurrentStreet->daprefix . ' ' . $oCurrentStreet->dalong_name . ', ' . $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ', ' . $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ', ' . $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree(array("k" => $this->tbstreet . "_id", "v" => $oCurrentStreet->id));
        $data['sCurrentTree'] = '/' . $oCurrentProvince->daurl . '/' . $oCurrentDistrict->daurl . '/' . $oCurrentWard->daurl . '/';
        $data = $this->processCurrentTreeForService($data);
        //$data['sCat'] = 'start';
        $data['sBody'] = $this->load->view("front/street_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;
        $aNavAddr[$this->tbward] = $oCurrentWard;
        $aNavAddr[$this->tbstreet] = $oCurrentStreet;

        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbstreet, $aNavAddr);
        $this->render($data);
    }

    public function serviceplace($province, $district, $ward, $daseorul, $place_id)
    {
        $oCurrentProvince = $this->main_m->getProvince($province);
        $this->session->set_userdata("province", $oCurrentProvince->daurl);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $district);
        $oCurrentWard = $this->main_m->getWard($oCurrentDistrict->id, $ward);
        $oCurrentStreet = $this->main_m->getStreet($oCurrentProvince->id, $oCurrentDistrict->id, $oCurrentWard->id, $daseorul);
        if ($oCurrentStreet != null) $oCurrentStreet = $oCurrentStreet[0];
        // $place_id = $this->mylibs->getIdFromSeourl($seourl);
        $oCurrentPlace = $this->main_m->getServicePlace($place_id);
        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['oCurrentWard'] = $oCurrentWard;
        $data['oCurrentStreet'] = $oCurrentStreet;
        $data['oCurrentPlace'] = $oCurrentPlace;
        $data['sTitle'] = $oCurrentPlace->dalong_name . ' ' . $oCurrentPlace->daaddr . ', ' . $oCurrentStreet->daprefix . ' ' . $oCurrentStreet->dalong_name . ', ' . $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ',' . $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ', ' . $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['placeAddres'] = $oCurrentPlace->daaddr . ', ' . $oCurrentStreet->daprefix . ' ' . $oCurrentStreet->dalong_name . ', ' . $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ', ' . $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ', ' . $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree();
        $data['sCurrentTree'] = '/' . $oCurrentProvince->daurl . '/' . $oCurrentDistrict->daurl . '/' . $oCurrentWard->daurl . '/' . $oCurrentStreet->daurl . '/';
        $data = $this->processCurrentTreeForService($data);
        //$data['sCat'] = 'start';
        $data['page'] = 'serviceplace';
        $data['placetab'] = (($this->input->get("tab")) ? $this->input->get("tab") : "info");
        if ($this->input->get("dealinfo") && is_numeric($this->input->get("dealinfo"))) {
            $data['placetab'] = 'dealinfo';
            $this->main_m->updateItemView($this->tbdeal, $this->input->get("dealinfo"));
            $data['oDealInfo'] = $this->main_m->getDealInfo($this->input->get("dealinfo"));
            $data['sTabContent'] = $this->load->view('front/dealinfo_v', $data, true);
            $data['sDealcontent'] = $data['oDealInfo']->dainfo;
            $data['aDealUser'] = $this->main_m->getDealUserList($this->input->get("dealinfo"));
        }
        if ($this->input->get("newsinfo") && is_numeric($this->input->get("newsinfo"))) {
            $data['placetab'] = 'newsinfo';
            $this->main_m->updateItemView($this->tbnews, $this->input->get("newsinfo"));
            $data['oNews'] = $this->main_m->getNewsInfo($this->input->get("newsinfo"));
            $data['sTabContent'] = $this->load->view('front/newsinfo_v', $data, true);
        }
        if ($data['placetab'] == "info") {
            $this->main_m->updateItemView($this->tbservice_place, $oCurrentPlace->id);
        }
        else if ($data['placetab'] == 'deal') {
            $data['aDeal'] = $this->main_m->getPlaceDeal($oCurrentPlace->id);
            $data['sTabContent'] = $this->load->view('front/deal_list_v', $data, true);
        }
        else if ($data['placetab'] == 'pics') {
            $data['aPics'] = $this->main_m->getPlacePics($oCurrentPlace->id);
            $data['sTabContent'] = $this->load->view('front/listpics_v', $data, true);
        }
        else if ($data['placetab'] == 'news') {
            $data['aNews'] = $this->main_m->getPlaceNews($oCurrentPlace->id);
            $data['sTabContent'] = $this->load->view('front/listplacenews_v', $data, true);
        }
        $data['aNewDeal'] = $this->main_m->getDealList($oCurrentProvince->id, "new", $this->config->item('iHomeServicePlae'));
        $data['sNewDeal'] = $this->load->view("front/sidelistdeal_v", $data, true);
        $data['aStreetPlaces'] = $this->main_m->getsubcat($this->tbstreet, $oCurrentStreet->id, $this->tbservice_place);
        $data['commentbox'] = $this->load->view("front/comment_v", $data, true);
        $data['sBody'] = $this->load->view("front/serviceplace_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;
        $aNavAddr[$this->tbward] = $oCurrentWard;
        $aNavAddr[$this->tbstreet] = $oCurrentStreet;
        $aNavAddr[$this->tbservice_place] = $oCurrentPlace;

        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbservice_place, $aNavAddr, $oCurrentPlace->id);
        $this->render($data);
    }

    public $tbprovince = 'daprovince';
    public $tbdistrict = 'dadistrict';
    public $tbward = 'daward';
    public $tbstreet = 'dastreet';
    public $tbservice_group = 'daservice_group';
    public $tbservice_item = 'daservice';
    public $tbservice_place = 'daservice_place';
    public $tbdapic = 'dapic';
    public $tbuser = 'dauser';
    public $tbdeal = 'dadeal';
    public $tbnews = 'danews';
    public $tbdealuser = "dadeal_user";
    public $tbcomment = "dacomment";
    public $crrlang = '';

    protected function processCurrentTreeForService($data = array())
    {
        if (!isset($data['sCurrentTreeForService']) || $data['sCurrentTreeForService'] == "") {
            $data['sCurrentTreeForService'] = "";
            if (isset($data['oCurrentStreet']) && $data['oCurrentStreet'] != null)
                $data['sCurrentTreeForService'] = $data['oCurrentStreet']->daurl . '/';
            if (isset($data['oCurrentWard']) && $data['oCurrentWard'] != null)
                $data['sCurrentTreeForService'] = $data['oCurrentWard']->daurl . '/' . $data['sCurrentTreeForService'];
            if (isset($data['oCurrentDistrict']) && $data['oCurrentDistrict'] != null)
                $data['sCurrentTreeForService'] = $data['oCurrentDistrict']->daurl . '/' . $data['sCurrentTreeForService'];
            if (isset($data['oCurrentProvince']) && $data['oCurrentProvince'] != null)
                $data['sCurrentTreeForService'] = '/' . $data['oCurrentProvince']->daurl . '/' . $data['sCurrentTreeForService'];
        }
        return $data;
    }

    public function render($data = array())
    {
        //get navigator service group
        $data['aNavService'] = $this->main_m->getNavService();
        $data['sTitle'] = $data['sTitle'] . ' - ' . $this->config->item('sufix_title');
        $data['aTopMenu'] = $this->main_m->getconfig("toplink");

        $data = $this->processCurrentTreeForService($data);
        $this->load->view('container_v', $data);
    }

    public function loadsubcat()
    {
        $current = $this->input->post('current');
        $parentname = $this->input->post('parentname');
        $parentid = $this->input->post('parentid');
        $arr = $this->main_m->getsubcat($parentname, $parentid, $current);
        $this->mylibs->echojson($arr);
    }

    public function news($cat = "help",$province="", $news_id = 0)
    {
        $oCurrentProvince = $this->main_m->getProvince($province);
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['sType'] = $cat;
        if( $this->input->get("page") )
        {
            $data['crrpage'] = $this->input->get("page");
            $data['sumpage'] = $this->main_m->getSumNewsCat(array($news_id),$oCurrentProvince->id);
            $data['aCat'] = $this->main_m->getNewsCat(array($news_id),$oCurrentProvince->id, " dacat  ", $this->config->item("pp"),($data['crrpage']-1));
            echo $this->load->view("front/suggestcat_v",$data,true);
            return;
        }
        $data['showcomment'] = true;
        if ($cat == "help"){
            $data['sTitle'] = "Trợ giúp";
            $asugess =  array();
            foreach($this->config->item("aNewsHelp") as $k=>$v)
                $asugess[] = $k;
            $data['aCat'] = $this->main_m->getNewsCat($asugess,$oCurrentProvince->id, " dacat  ", 0);
        }
        else if($cat == $this->config->item('suggest')){
            $data['sTitle'] = "Gợi ý địa chỉ";
            $data['aCat'] = null;
        }
        else
        {
            $data['sTitle'] = "Tin tức";
            $asugess =  array();
            foreach($this->config->item("aNewsCat") as $k=>$v)
                $asugess[] = $k;
            $data['aCat'] = $this->main_m->getNewsCat($asugess,$oCurrentProvince->id, " dacat  ", 10);
        }

        //$data['sTitle'] = $this->lang->line($cat);
        // $news_id = $this->mylibs->getIdFromSeourl($id);
        $data['cattype'] = "";
        if (is_numeric($news_id)) {
            $this->main_m->updateItemView($this->tbnews, $news_id);
            $data['oNews'] = $this->main_m->getNews($news_id);

            if($data['oNews']==null){ $data['showcomment'] = false;
            }
            else{
                $data['sTitle'] =  $data['oNews']->dalong_name;
            }
        }
        else {
            $data['aCat'] = $this->main_m->getNewsCat(array($news_id),$oCurrentProvince->id, " dacat  ", $this->config->item("pp"),0);
            $data['sumpage'] = $this->main_m->getSumNewsCat(array($news_id),$oCurrentProvince->id);
            $data['crrpage'] = 1;
            $data['cattype'] = $this->config->item('suggest');

            $data['oNews'] = null;
            $data['showcomment'] = false;
        }

        $data['sBody'] = $this->load->view("front/news_v", $data, true);

        //if ($this->session->userdata("province")) $province = $this->session->userdata("province");
        //else $province = "";
        //$oCurrentProvince = $this->main_m->getProvince($province);
        $data['aNavAddr'] = $this->mylibs->makeNavAddr($this->tbprovince, array($this->tbprovince => $oCurrentProvince));
        if ($cat == "help")
            $data['addNavAddr'] = "Trợ giúp";
            else if($cat == $this->config->item('suggest')){
                $data['addNavAddr'] = "Gợi ý địa chỉ";
            }
        else $data['addNavAddr'] = 'Tin tức';
        $this->render($data);
    }

    public function makethumb()
    {
        $filename = $this->input->get("f");
        $width = $this->input->get("w");
        $height = $this->input->get("h");
        $file_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/././images/';
        $thumb = $this->mylibs->makeThumbnails($file_path, $filename, $width, $height);
        header('Content-Type: image/jpeg');
        imagejpeg($thumb, null, 80);
        imagedestroy($thumb);
    }

    public function servicegroup($url, $servicegroup_id, $province_url, $district_url = "", $ward_url = "", $street_url = "")
    {
        if ($this->input->get('page')) $page = ($this->input->get('page') - 1) * $this->config->item('num_servicegroup');
        else $page = 0;
        $data['aService'] = $this->main_m->getPlaceFromServiceGroup($servicegroup_id, $province_url, null, $page, $district_url, $ward_url, $street_url);
        if ($this->input->get('page')) {
            echo $this->load->view("front/serviceli_v", $data, true);
            return;
        }
        $data['sumpage'] = $this->main_m->getSumPage($this->tbservice_group, $servicegroup_id, $province_url, $district_url, $ward_url, $street_url);

        $oCurrentProvince = $this->main_m->getProvince($province_url);
        $this->session->set_userdata("province", $oCurrentProvince->daurl);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $district_url);
        if ($oCurrentDistrict != null)
            $oCurrentWard = $this->main_m->getWard($oCurrentDistrict->id, $ward_url);
        else $oCurrentWard = null;
        if ($oCurrentWard != null)
            $oCurrentStreet = $this->main_m->get1street($oCurrentWard->id, $street_url);
        else $oCurrentStreet = null;

        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['oCurrentWard'] = $oCurrentWard;
        $data['oCurrentStreet'] = $oCurrentStreet;
        if ($data['aService'] != null)
            $data['sTitle'] = $data['aService'][0]->servicegroupname;
        else $data['sTitle'] = $this->main_m->getServiceNameFromId($this->tbservice_group, $servicegroup_id);
        $currentplaceid = $oCurrentProvince->id;
        $currenttable = $this->tbprovince;
        $currentobject = $oCurrentProvince;

        $data['currentLevel'] = $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        if ($oCurrentDistrict != null) {
            $currentplaceid = $oCurrentDistrict->id;
            $currenttable = $this->tbdistrict;
            $currentobject = $oCurrentDistrict;
            $data['currentLevel'] = $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ", " . $data['currentLevel'];
        }

        if ($oCurrentWard != null) {
            $currentplaceid = $oCurrentWard->id;
            $currenttable = $this->tbward;
            $currentobject = $oCurrentWard;
            $data['currentLevel'] = $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ", " . $data['currentLevel'];
        }
        if ($oCurrentStreet != null) {
            $currentplaceid = $oCurrentStreet->id;
            $currenttable = $this->tbstreet;
            $currentobject = $oCurrentStreet;
            $data['currentLevel'] = $oCurrentStreet->daprefix . ' ' . $oCurrentStreet->dalong_name . ", " . $data['currentLevel'];
        }


        $data['currentobject'] = $currentobject;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree(array("k" => $currenttable . "_id", "v" => $currentplaceid));
        $data = $this->processCurrentTreeForService($data);
        $data['sBody'] = $this->load->view("front/service_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;
        $aNavAddr[$this->tbward] = $oCurrentWard;
        $aNavAddr[$this->tbstreet] = $oCurrentStreet;


        $data['aNavAddr'] = $this->mylibs->makeNavAddr($currenttable, $aNavAddr, $currentplaceid);
        $this->render($data);
    }

    public function service($url, $service_id, $province_url, $district_url = "", $ward_url = "", $street_url = "")
    {
        //$data['currentUrl'] = base_url()
        if ($this->input->get('page')) $page = ($this->input->get('page') - 1) * $this->config->item('num_servicegroup');
        else $page = 0;
        $data['aService'] = $this->main_m->getPlaceFromService($service_id, $province_url, null, $page, $district_url, $ward_url, $street_url);
        if ($this->input->get('page')) {
            echo $this->load->view("front/serviceli_v", $data, true);
            return;
        }
        $data['sumpage'] = $this->main_m->getSumPage($this->tbservice_item, $service_id, $province_url, $district_url, $ward_url, $street_url);
        $oCurrentProvince = $this->main_m->getProvince($province_url);
        $this->session->set_userdata("province", $oCurrentProvince->daurl);
        $oCurrentDistrict = $this->main_m->getDistrict($oCurrentProvince->id, $district_url);
        if ($oCurrentDistrict != null)
            $oCurrentWard = $this->main_m->getWard($oCurrentDistrict->id, $ward_url);
        else $oCurrentWard = null;
        if ($oCurrentWard != null)
            $oCurrentStreet = $this->main_m->get1street($oCurrentWard->id, $street_url);
        else $oCurrentStreet = null;

        $data['oCurrentDistrict'] = $oCurrentDistrict;
        $data['oCurrentProvince'] = $oCurrentProvince;
        $data['oCurrentWard'] = $oCurrentWard;
        $data['oCurrentStreet'] = $oCurrentStreet;
        if ($data['aService'] != null)
            $data['sTitle'] = $data['aService'][0]->servicename;
        else $data['sTitle'] = $this->main_m->getServiceNameFromId($this->tbservice_item, $service_id);
        $currentplaceid = $oCurrentProvince->id;
        $currenttable = $this->tbprovince;
        $currentobject = $oCurrentProvince;
        $data['currentLevel'] = $oCurrentProvince->daprefix . ' ' . $oCurrentProvince->dalong_name;
        if ($oCurrentDistrict != null) {
            $currentplaceid = $oCurrentDistrict->id;
            $currenttable = $this->tbdistrict;
            $currentobject = $oCurrentDistrict;
            $data['currentLevel'] = $oCurrentDistrict->daprefix . ' ' . $oCurrentDistrict->dalong_name . ", " . $data['currentLevel'];
        }

        if ($oCurrentWard != null) {
            $currentplaceid = $oCurrentWard->id;
            $currenttable = $this->tbward;
            $currentobject = $oCurrentWard;
            $data['currentLevel'] = $oCurrentWard->daprefix . ' ' . $oCurrentWard->dalong_name . ", " . $data['currentLevel'];
        }
        if ($oCurrentStreet != null) {
            $currentplaceid = $oCurrentStreet->id;
            $currenttable = $this->tbstreet;
            $currentobject = $oCurrentStreet;
            $data['currentLevel'] = $oCurrentStreet->daprefix . ' ' . $oCurrentStreet->dalong_name . ", " . $data['currentLevel'];
        }


        $data['currentobject'] = $currentobject;
        $data['aServiceTree'] = $this->main_m->getFullServiceTree(array("k" => $currenttable . "_id", "v" => $currentplaceid));
        $data = $this->processCurrentTreeForService($data);

        $data['sBody'] = $this->load->view("front/service_v", $data, true);
        $aNavAddr[$this->tbprovince] = $oCurrentProvince;
        $aNavAddr[$this->tbdistrict] = $oCurrentDistrict;
        $aNavAddr[$this->tbward] = $oCurrentWard;
        $aNavAddr[$this->tbstreet] = $oCurrentStreet;


        $data['aNavAddr'] = $this->mylibs->makeNavAddr($currenttable, $aNavAddr, $currentplaceid);
        $this->render($data);
    }

    public function loadSubmitDealForm($dealid)
    {
        $user_id = (($this->session->userdata("dauser_id")) ? $this->session->userdata("dauser_id") : 0);
        $data['oUser'] = $this->main_m->getUser($user_id);
        $data['user_id'] = $user_id;
        $data['deal_id'] = $dealid;
        echo $this->load->view("front/form_submitdeal_v", $data, true);
    }


    public function savedealuser()
    {
        $param = array(
            "dadeal_id" => $this->input->post("dadeal_id"),
            "dauser_id" => $this->input->post("dauser_id"),
            "daname" => $this->input->post("daname"),
            "datel" => $this->input->post("datel"),
            "daaddr" => $this->input->post("daaddr"),
            "daemail" => $this->input->post("daemail"),
            "daamount" => $this->input->post("daamount"),
            "dacomment" => $this->input->post("dacomment"),
            "dastatus" => "wait",
        );
        $sql = $this->db->insert_string($this->tbdealuser, $param);
        if ($this->db->query($sql)) {
            $param['dadealuser_id'] = $this->db->insert_id();
            if ($this->config->item("submitdealsendemail")) {
                //send email
            }
            $this->mylibs->echojson($param);
        }
        else echo 0;
    }

    public function savecomment()
    {
        if ($this->session->userdata("dauser_id"))
            $dauser_id = $this->session->userdata("dauser_id");
        else $dauser_id = 0;
        $param = array(
            "daserviceplace_id" => $this->input->post("daserviceplace_id"),
            "dacontent" => $this->input->post("dacontent"),
            "daname" => $this->input->post("daname"),
            "daemail" => $this->input->post("daemail"),
            "datel" => $this->input->post("datel"),
            "daavatar" => $this->input->post("daavatar"),
            "dauser_id" => $dauser_id,
        );
        $sql=$this->db->insert_string($this->tbcomment, $param);
        echo $this->db->query($sql);
    }
    public function loadcomment($daserviceplace_id,$page=1){
        $data['page'] = $page;
        $data['sumpage'] = $this->main_m->getSumComment($daserviceplace_id);
        $data['aComment'] = $this->main_m->getComment($daserviceplace_id,$page);
        echo $this->load->view("/front/commentcontent_v",$data,true);
    }
    public function delcomment($id){
        $sql="DELETE FROM ".$this->tbcomment." WHERE id=$id LIMIT 1";
        echo $this->db->query($sql);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */