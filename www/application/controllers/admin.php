<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
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
        if (!$this->session->userdata("pgrole")) {
            $this->session->set_userdata('referer', base_url() . "admin");
            header("Location: " . base_url() . "login");
        } else if (!$this->mylibs->accessadmin()) {
            header("Location: " . base_url());
        }
        // Your own constructor code
        if ($this->session->userdata("lang"))
            $this->crrlanglang = $this->session->userdata("lang");
        else $this->crrlang = "vi";
        //default
        $this->lang->load("default", $this->crrlang);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        $data['title'] = "Admin page";
        $data['cat'] = 'admin';
        $data['body'] = $this->load->view("admin/adminoverview_v", $data, true);
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
    public $crrlang = '';
    public $tbconfig = 'daconfig';
    public $tbdealuser = "pgdeal_user";
    public $tbcomment = "pgcomment";
    public $tbdealuserlog = "pgdealuser_log";

    public function render($data = array())
    {
        $data['title'] = $data['title'] . ' - ' . $this->config->item('sufix_title');
        $this->load->view('admin/container_v', $data);
    }

    public function address()
    {
        if (!$this->mylibs->accessaddresspage())
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/address_v', $data, true);
        $data['cat'] = 'address';
        $data['title'] = lang("ADDR_MANA");
        $this->render($data);
    }

    public function deal($daserviceplace_id = "")
    {
        if (!$this->mylibs->accessdealpage())
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['daserviceplace_id'] = $daserviceplace_id;
        $data['body'] = $this->load->view('admin/admindeal_v', $data, true);
        $data['cat'] = 'deal';
        $data['title'] = lang("ADDR_MANA");
        $this->render($data);
    }

    public function user()
    {
        if (!$this->mylibs->accessuserpage())
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminuser_v', $data, true);
        $data['cat'] = 'user';
        $data['title'] = lang("ADDR_MANA");
        $this->render($data);
    }

    public function service()
    {
        if (!$this->mylibs->accessservicepage())
            header("Location: " . base_url() . "admin");

        $data = array();
        $data['province'] = $this->getAddress($this->tbprovince, null, -1, true);
        $data['body'] = $this->load->view('admin/service_v', $data, true);
        $data['cat'] = 'service';
        $data['title'] = lang("SERVICE_MANA");
        $this->render($data);
    }

    public function servicegroup()
    {
        $data = array();
        echo $this->load->view('admin/servicegroup_v', $data, true);
    }

    public function listuser()
    {
        $data = array();
        echo $this->load->view('admin/adminuserlist_v', $data, true);
    }

    public function serviceitem()
    {
        $data = array();
        $data['servicegroup'] = $this->getService($this->tbservice_group, null, -1, true);
        echo $this->load->view('admin/serviceitem_v', $data, true);
    }

    public function serviceplace()
    {
        $data = array();
        $data['province'] = $this->getAddress($this->tbprovince, null, -1, true);
        $data['district'] = $this->getAddress($this->tbdistrict, array('daprovince_id' => $data['province'][0]->id), -1);
        $data['servicegroup'] = $this->getService($this->tbservice_group, null, -1, true);
        echo $this->load->view('admin/serviceplace_v', $data, true);
    }

    public function province()
    {
        $data = array();
        echo $this->load->view('admin/province_v', $data, true);
    }

    public function district()
    {
        $data = array();
        $data['province'] = $this->getAddress($this->tbprovince, null, -1, true);
        echo $this->load->view('admin/district_v', $data, true);
    }

    public function ward()
    {
        $data = array();
        $data['province'] = $this->getAddress($this->tbprovince, null, -1, true);
        $data['district'] = $this->getAddress($this->tbdistrict, array('daprovince_id' => $data['province'][0]->id), -1);
        echo $this->load->view('admin/ward_v', $data, true);
    }

    public function street()
    {
        $data = array();
        $data['province'] = $this->getAddress($this->tbprovince, null, -1, true);
        $data['district'] = $this->getAddress($this->tbdistrict, array('daprovince_id' => $data['province'][0]->id), -1);
        $data['ward'] = $this->getAddress($this->tbward, array('dadistrict_id' => $data['district'][0]->id), -1);
        echo $this->load->view('admin/street_v', $data, true);
    }

    public function savenews()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dapic' => $this->input->post("dapic"),
            'dacontent_short' => $this->input->post("dacontent_short"),
            'dacontent' => $this->input->post("dacontent"),
            'daserviceplace_id' => $this->input->post("daserviceplace_id"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'dacat' => $this->input->post("dacat"),
            'datype' => $this->input->post("datype"),
            'dacreate' => date("Y-m-d H:i:s"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbnews, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbnews, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function saveuser()
    {
        $param = array(
            'dafname' => $this->input->post("dafname"),
            'dalname' => $this->input->post("dalname"),
            'dausername' => $this->input->post("dausername"),
            'damobi' => $this->input->post("damobi"),
            'daemail' => $this->input->post("daemail"),
            'daaddr' => $this->input->post("daaddr"),
            'daavatar' => $this->input->post("daavatar"),
            'darole' => $this->input->post("darole"),
            'dacreate' => date("Y-m-d H:i:s"),
        );
        if ($this->input->post("dapassword") != "")
            $param['dapassword'] = md5(md5($this->input->post("dapassword")));
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbuser, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbuser, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function saveprovince()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'damap' => $this->input->post("damap"),
            'daorder' => $this->input->post("daorder"),
            'daprefix' => $this->input->post("daprefix"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbprovince, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbprovince, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;

    }

    public function saveservicegroup()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'dashowhome' => $this->input->post("dashowhome"),
            'daorder' => $this->input->post("daorder"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbservice_group, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbservice_group, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;

    }

    public function savedistrict()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'damap' => $this->input->post("damap"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'daprefix' => $this->input->post("daprefix"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbdistrict, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbdistrict, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;

    }

    public function saveserviceitem()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'daservicegroup_id' => $this->input->post("daservicegroup_id"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbservice_item, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbservice_item, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function saveward()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'damap' => $this->input->post("damap"),
            'dadistrict_id' => $this->input->post("dadistrict_id"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'daprefix' => $this->input->post("daprefix"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbward, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbward, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;

    }
    public function saveplaceward()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dadistrict_id' => $this->input->post("dadistrict_id"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'daprefix' => $this->input->post("daprefix"),
        );
       //insert
            $str = $this->db->insert_string($this->tbward, $param);

        if ($this->db->query($str)) {
            $this->loadselectward($this->input->post("dadistrict_id"), $this->db->insert_id());
        }
        else echo 0;

    }
    public function saveplacestreet()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dadistrict_id' => $this->input->post("dadistrict_id"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'daward_id' => $this->input->post("daward_id"),
            'daprefix' => $this->input->post("daprefix"),
        );
       //insert
            $str = $this->db->insert_string($this->tbstreet, $param);

        if ($this->db->query($str)) {
            $this->loadselectstreet($this->input->post("daward_id"), $this->db->insert_id());
        }
        else echo 0;

    }

    public function saveserviceplace()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            "daservicegroup_id" => $this->input->post("daservicegroup_id"),
            "daservice_id" => $this->input->post("daservice_id"),
            "daprovince_id" => $this->input->post("daprovince_id"),
            "dadistrict_id" => $this->input->post("dadistrict_id"),
            "daward_id" => $this->input->post("daward_id"),
            "dastreet_id" => $this->input->post("dastreet_id"),
            "dapic" => $this->input->post("dapic"),
            "datel" => $this->input->post("datel"),
            "dawebsite" => $this->input->post("dawebsite"),
            "daemail" => $this->input->post("daemail"),
            "daaddr" => $this->input->post("daaddr"),
            "damap" => $this->input->post("damap"),
            "dalat" => $this->input->post("dalat"),
            "dalng" => $this->input->post("dalng"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbservice_place, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $param["dacreate"] = date("Y-m-d H:i:s");
            $param["dauser_id"] = $this->session->userdata("dauser_id");
            $str = $this->db->insert_string($this->tbservice_place, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function loadeditserviceplace($id, $type = 0, $ob = 0)
    {
        //ob=1: get full address
        if ($ob == 1) {
            $sql = "SELECT sp.*, p.dalong_name provincename, si.dalong_name servicename, d.dalong_name districtname, sg.dalong_name servicegroup,
            ifnull((select st.dalong_name from dastreet st where st.id = sp.dastreet_id),'') streetname,
            ifnull((select w.dalong_name from daward w where w.id = sp.daward_id),'') wardname
            FROM " . $this->tbservice_place . " sp, " . $this->tbprovince . " p, " . $this->tbservice_item . " si, " . $this->tbdistrict . " d, " . $this->tbservice_group . " sg
            WHERE sp.daprovince_id = p.id AND si.id = sp.daservice_id AND sp.dadistrict_id = d.id AND sp.daservicegroup_id = sg.id
            " . (($type == 0) ? "AND sp.id=" . $id : " ORDER BY sp.ID DESC LIMIT 0,1");
        } //, ".$this->tbward." w, ".$this->tbstreet." st
        else
            $sql = "SELECT * FROM " . $this->tbservice_place . " " . (($type == 0) ? "WHERE id=" . $id : " ORDER BY ID DESC LIMIT 0,1");
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $param = array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'daservicegroup_id' => $row->daservicegroup_id,
                'daservice_id' => $row->daservice_id,
                'daprovince_id' => $row->daprovince_id,
                'dadistrict_id' => $row->dadistrict_id,
                'daward_id' => $row->daward_id,
                'dastreet_id' => $row->dastreet_id,
                'dapic' => $row->dapic,
                'datel' => $row->datel,
                'dawebsite' => $row->dawebsite,
                'daemail' => $row->daemail,
                'daaddr' => $row->daaddr,
                'damap' => $row->damap,
                'dalat' => $row->dalat,
                'dalng' => $row->dalng,
            );
            if ($ob == 1) {
                $param['provincename'] = $row->provincename;
                $param['servicename'] = $row->servicename;
                $param['districtname'] = $row->districtname;
                $param['servicegroup'] = $row->servicegroup;
                $param['streetname'] = $row->streetname;
                $param['wardname'] = $row->wardname;
            }
            $this->mylibs->echojson($param);


        } else echo '0';
    }

    public function savedeal()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'datype' => $this->input->post("datype"),
            'dafrom' => strtotime($this->input->post("dafrom")),
            'dato' => strtotime($this->input->post("dato")),
            'daamount' => $this->input->post("daamount"),
            'daserviceplace_id' => $this->input->post("daserviceplace_id"),
            'daspecial' => $this->input->post("daspecial"),
            'dacondition' => $this->input->post("dacondition"),
            'daoldprice' => $this->input->post("daoldprice"),
            'dainfo' => $this->input->post("dainfo"),
            'dapic' => $this->input->post("dapic"),
            'dapromo' => $this->input->post("dapromo"),
            'dacreate' => date("Y-m-d H:i:s"),
            'dauser_id' => $this->session->userdata('dauser_id'),

        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbdeal, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbdeal, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function savestreet()
    {
        $param = array(
            'dalong_name' => $this->input->post("dalong_name"),
            'daurl' => $this->input->post("daurl"),
            'dainfo' => $this->input->post("dainfo"),
            'damap' => $this->input->post("damap"),
            'daward_id' => $this->input->post("daward_id"),
            'daprovince_id' => $this->input->post("daprovince_id"),
            'dadistrict_id' => $this->input->post("dadistrict_id"),
            'daprefix' => $this->input->post("daprefix"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbstreet, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbstreet, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;

    }

    public function hideuser($id, $status)
    {
        $str = $this->db->update_string($this->tbuser, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hidenews($id, $status)
    {
        $str = $this->db->update_string($this->tbnews, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hidedeal($id, $status)
    {
        $str = $this->db->update_string($this->tbdeal, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hideprovince($id, $status)
    {
        $str = $this->db->update_string($this->tbprovince, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hideserviceplace($id, $status)
    {
        $str = $this->db->update_string($this->tbservice_place, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hideserviceitem($id, $status)
    {
        $str = $this->db->update_string($this->tbservice_item, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hidedistrict($id, $status)
    {
        $str = $this->db->update_string($this->tbdistrict, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hideward($id, $status)
    {
        $str = $this->db->update_string($this->tbward, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hidestreet($id, $status)
    {
        $str = $this->db->update_string($this->tbstreet, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function hideservicegroup($id, $status)
    {
        $str = $this->db->update_string($this->tbservice_group, array("dadeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }

    public function loadeditnews($id)
    {
        $sql = "SELECT * FROM " . $this->tbnews . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dapic' => $row->dapic,
                'id' => $row->id,
                'dacontent_short' => $row->dacontent_short,
                'dacontent' => $row->dacontent,
                'datype' => $row->datype,
                'dacat' => $row->dacat,
                'daserviceplace_id' => $row->daserviceplace_id,
                'daprovince_id' => $row->daprovince_id,
            ));
        } else echo '0';
    }

    public function loadeditservicegroup($id)
    {
        $sql = "SELECT * FROM " . $this->tbservice_group . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'dashowhome' => $row->dashowhome,
                'daorder' => $row->daorder,
            ));
        } else echo '0';
    }

    public function loadeditdeal($id)
    {
        $sql = "SELECT * FROM " . $this->tbdeal . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'datype' => $row->datype,
                'dafrom' => date("Y-m-d H:i:s", $row->dafrom),
                'dato' => date("Y-m-d H:i:s", $row->dato),
                'daamount' => $row->daamount,
                'daserviceplace_id' => $row->daserviceplace_id,
                'daspecial' => $row->daspecial,
                'dacondition' => $row->dacondition,
                'daoldprice' => $row->daoldprice,
                'dapic' => $row->dapic,
                'dainfo' => $row->dainfo,
                'dapromo' => $row->dapromo,
            ));
        } else echo '0';
    }

    public function loadeditserviceitem($id)
    {
        $sql = "SELECT * FROM " . $this->tbservice_item . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
            ));
        } else echo '0';
    }

    public function loadeditprovince($id)
    {
        $sql = "SELECT * FROM " . $this->tbprovince . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'daorder' => $row->daorder,
                'damap' => $row->damap,
                'daprefix' => $row->daprefix,
            ));
        } else echo '0';
    }

    public function loadeditdistrict($id)
    {
        $sql = "SELECT * FROM " . $this->tbdistrict . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'damap' => $row->damap,
                'daprovince_id' => $row->daprovince_id,
                'daprefix' => $row->daprefix,
            ));
        } else echo '0';
    }

    public function loadeditward($id)
    {
        $sql = "SELECT * FROM " . $this->tbward . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'damap' => $row->damap,
                'dadistrict_id' => $row->dadistrict_id,
                'daprovince_id' => $row->daprovince_id,
                'daprefix' => $row->daprefix,
            ));
        } else echo '0';
    }

    public function loadedituser($id)
    {
        $sql = "SELECT * FROM " . $this->tbuser . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dafname' => $row->dafname,
                'dalname' => $row->dalname,
                'dausername' => $row->dausername,
                'dapassword' => $row->dapassword,
                'damobi' => $row->damobi,
                'daemail' => $row->daemail,
                'daaddr' => $row->daaddr,
                'daavatar' => $row->daavatar,
                'darole' => $row->darole,

            ));

        } else echo '0';
    }

    public function loadeditstreet($id)
    {
        $sql = "SELECT * FROM " . $this->tbstreet . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $this->mylibs->echojson(array(
                'id' => $row->id,
                'dalong_name' => $row->dalong_name,
                'daurl' => $row->daurl,
                'dainfo' => $row->dainfo,
                'damap' => $row->damap,
                'daward_id' => $row->daward_id,
                'daprovince_id' => $row->daprovince_id,
                'dadistrict_id' => $row->dadistrict_id,
                'daprefix' => $row->daprefix,
            ));
        } else echo '0';
    }

    public function getAddress($table, $parent_id = array(), $page = 0, $order = false)
    {

        $where = "";
        if ($parent_id != null) {
            foreach ($parent_id as $k => $v) {
                $where .= ($where != "" ? " AND " : " WHERE ") . $k . " = " . $v;
            }
        }
        if ($page >= 0)
            $sql = "SELECT * FROM " . $table . $where . " ORDER BY " . (($order) ? "daorder desc," : "") . " dalong_name LIMIT " . ($page * $this->config->item('pp')) . "," . $this->config->item('pp');
        else $sql = "SELECT * FROM " . $table . $where . " ORDER BY " . (($order) ? "daorder desc," : "") . " dalong_name";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            return $qr->result();
        } else return null;
    }

    public function getService($table, $parent_id = array(), $page = 0, $order = null)
    {

        $where = "";
        if ($parent_id != null) {
            foreach ($parent_id as $k => $v) {
                if ($v > 0 || strlen($v) >= 3)    {
                    if($where != ""){
                        if(strpos("OR",$k) != false){
                            $where .= $k . " = " . "'$v'";
                        }
                        else{
                            $where .= " AND ". $k . " = " . "'$v'";
                        }
                    }
                    else{
                        $where .= " WHERE ". $k . " = " . "'$v'";
                    }
                }
                   // $where .= ($where != "" ? ((strpos("OR",$k) != false)?" AND ":"") : " WHERE ") . $k . " = " . "'$v'";
            }
        }
        if ($page >= 0)
            $sql = "SELECT * FROM " . $table . $where . " ORDER BY  " . (($order != null) ? $order['field'] . " " . $order["type"] : "dalong_name") . "  LIMIT " . ($page * $this->config->item('pp')) . "," . $this->config->item('pp');
        else $sql = "SELECT * FROM " . $table . $where . " ORDER BY  dalong_name";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            return $qr->result();
        } else return null;
    }

    public function getSumPageAddress($table, $parent_id = array())
    {
        $where = "";
        if ($parent_id != null) {
            foreach ($parent_id as $k => $v) {
                if ($v > 0 || strlen($v) >= 3)
                    $where .= ($where != "" ? " AND " : " WHERE ") . $k . " = " . "'$v'";
            }
        }
        $sql = "SELECT count(id) numid FROM " . $table . $where;
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            return ceil($qr->row()->numid / $this->config->item("pp"));
        } else return 0;
    }

    public function loaduser($page = 1)
    {
        $page -= 1;
        if (($rs = $this->getService($this->tbuser, null, $page, array('field' => 'id', 'type' => ''))) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbuser, null);
            echo $this->load->view("admin/list_user_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadprovince($page = 1)
    {
        $page -= 1;
        if (($rs = $this->getAddress($this->tbprovince, null, $page)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbprovince, null);
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadselectdist($daprovince_id = 0, $id = 0)
    {
        $options = "<option value='0'>Chọn Quận</option>";
        if (($rs = $this->getAddress($this->tbdistrict, array("daprovince_id" => $daprovince_id), -1)) != null) {
            foreach ($rs as $row) {
                $options .= "<option value='" . $row->id . "' " . (($row->id == $id) ? 'selected=true' : '') . ">" . $row->dalong_name . "</option>";
            }
        }
        echo $options;
    }

    public function loadselectward($daprovince_id = 0, $id = 0)
    {
        $options = "<option value='0'>Chọn Phường</option><option value='-1'>Tạo Phường mới</option>";
        if (($rs = $this->getAddress($this->tbward, array("dadistrict_id" => $daprovince_id), -1)) != null) {
            foreach ($rs as $row) {
                $options .= "<option value='" . $row->id . "' " . (($row->id == $id) ? 'selected=true' : '') . ">" . $row->dalong_name . "</option>";
            }
        }
        echo $options;
    }

    public function loadselectstreet($daprovince_id = 0, $id = 0)
    {
        $options = "<option value='0'>Chọn Đường/Phố</option><option value='-1'>Tạo Đường/Phố mới</option>";
        if (($rs = $this->getAddress($this->tbstreet, array("daward_id" => $daprovince_id), -1)) != null) {
            foreach ($rs as $row) {
                $options .= "<option value='" . $row->id . "' " . (($row->id == $id) ? 'selected=true' : '') . ">" . $row->dalong_name . "</option>";
            }
        }
        echo $options;
    }

    public function loadselectserviceitem($daprovince_id = 0, $id = 0)
    {
        $options = "<option value='0'>Chọn Dịch vụ</option>";
        if (($rs = $this->getService($this->tbservice_item, array("daservicegroup_id" => $daprovince_id), -1)) != null) {
            foreach ($rs as $row) {
                $options .= "<option value='" . $row->id . "' " . (($row->id == $id) ? 'selected=true' : '') . ">" . $row->dalong_name . "</option>";
            }
        }
        echo $options;
    }

    public function loaddistrict($daprovince_id = 0, $page = 1)
    {
        $page -= 1;
        if (($rs = $this->getAddress($this->tbdistrict, array("daprovince_id" => $daprovince_id), $page)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbdistrict, array("daprovince_id" => $daprovince_id));
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadward($daprovince_id = 0, $page = 1)
    {
        $page -= 1;
        if (($rs = $this->getAddress($this->tbward, array("dadistrict_id" => $daprovince_id), $page)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbward, array("dadistrict_id" => $daprovince_id));
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadstreet($daprovince_id = 0, $page = 1)
    {
        $page -= 1;
        if (($rs = $this->getAddress($this->tbstreet, array("daward_id" => $daprovince_id), $page)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbstreet, array("daward_id" => $daprovince_id));
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadservicegroup($page = 1)
    {
        $page -= 1;
        if (($rs = $this->getService($this->tbservice_group, null, $page, array("field"=>"daorder","type"=>"DESC"))) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbservice_group, null);
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadservice_item($daprovince_id = 0, $page = 1)
    {
        $page -= 1;
        if (($rs = $this->getService($this->tbservice_item, array("daservicegroup_id" => $daprovince_id), $page)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbservice_item, array("daservicegroup_id" => $daprovince_id));
            echo $this->load->view("admin/list_province_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadlistdeal($daserviceplace_id, $page = 1)
    {
        $page -= 1;
        $param = array(
            "daserviceplace_id" => $daserviceplace_id,
        );

        if (($rs = $this->getService($this->tbdeal, $param, $page, array("field" => 'id', 'type' => 'DESC'))) != null) {
            $data['serviceplace'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbdeal, $param);
            echo $this->load->view("admin/list_deal_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadnews($type, $daserviceplace_id,$province_id, $page = 1)
    {
        $page -= 1;
        if ($type == "service") {
            $param = array(
                " daserviceplace_id" => $daserviceplace_id,
            );
        } else if ($type == "home") {
            if($province_id == 0)
            $param = array(
                " dacat" => $daserviceplace_id,
                " OR daprovince_id" => $province_id,
            );
            else $param = array(
                " dacat" => $daserviceplace_id,
                " daprovince_id" => $province_id,
            );
        }

        if (($rs = $this->getService($this->tbnews, $param, $page, array("field" => 'id', 'type' => 'DESC'))) != null) {
            $data['newslist'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbnews, $param);
            echo $this->load->view("admin/list_news_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadserviceplace($daprovince_id = 0, $dadistrict_id = 0, $daward_id = 0, $dastreet_id = 0, $daservicegroup_id = 0, $daservice_id = 0, $page = 1)
    {
        $page -= 1;
        $param = array(
            "daservicegroup_id" => $daservicegroup_id,
            "daprovince_id" => $daprovince_id,
            "dadistrict_id" => $dadistrict_id,
            "daward_id" => $daward_id,
            "dastreet_id" => $dastreet_id,
            "daservice_id" => $daservice_id,
        );

        if (($rs = $this->getService($this->tbservice_place, $param, $page, array("field" => 'id', 'type' => 'DESC'))) != null) {
            $data['serviceplace'] = $rs;
            $data['sumpage'] = $this->getSumPageAddress($this->tbservice_place, $param);
            echo $this->load->view("admin/list_serviceplace_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function calljupload()
    {
        $this->load->helper("jupload");
        $configs['upload_dir'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/././images/';
        $configs['upload_url'] = base_url() . 'images/';
        $configs['thumbnail'] = array(
            'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/././thumbnails/',
            'upload_url' => base_url() . 'thumbnails/',
            'max_width' => 300,
            'max_height' => 300
        );
        $upload_handler = jupload($configs);

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $upload_handler->delete();
                } else {
                    $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
    }

    function delfile($filename, $deldb = 0)
    {
        //important!!! need admin permission here
        try {
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././images/" . $filename);
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././thumbnails/" . $filename);
            if ($deldb == 1) {
                $sql = "DELETE FROM " . $this->tbdapic . " WHERE dapic='$filename'";
                $this->db->query($sql);
            }
            echo 1;
        } catch (Exception $ex) {
            echo 0;
        }
    }

    public function savemorepic($id)
    {
        $sql = "SELECT count(id) numr FROM " . $this->tbservice_place . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->row()->numr == 1) {
            $aNewPic = explode(",", $this->input->post("img"));
            $aNewCaption = explode(",", $this->input->post("caption"));
            $sVal = "";
            if (!$this->session->userdata("dauser_id")) $user = 1;
            else $user = $this->session->userdata("dauser_id");
            for ($i = 0; $i < count($aNewPic); $i++) {
                $pic = $aNewPic[$i];
                if (trim($pic) == "") continue;
                $cap = $aNewCaption[$i];
                if ($sVal != "") $sVal .= ",";
                $sVal .= "('$user','$id','$pic','$cap')";
            }
            if ($sVal != "") {
                $sql = "INSERT INTO " . $this->tbdapic . " (dauser_id,daserviceplace_id,dapic,dacaption) VALUES " . $sVal;
                echo $this->db->query($sql);
            } else {
                return 0;
            }

        } else {
            echo -1;
        }
    }

    public function loadserviceplacepic($id)
    {
        $sql = "SELECT * FROM " . $this->tbdapic . " WHERE daserviceplace_id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $arr = $qr->result_array();
            $this->mylibs->echojson($arr);
        } else {
            echo 0;
        }
    }

    public function updateoldpic($id)
    {
        $aNewPic = explode(",", $this->input->post("img"));
        $aNewCaption = explode(",", $this->input->post("caption"));
        $kq = 0;
        for ($i = 0; $i < count($aNewPic); $i++) {
            $pic = $aNewPic[$i];
            if (trim($pic) == "") continue;
            $cap = $aNewCaption[$i];
            $sql = "UPDATE " . $this->tbdapic . " SET dacaption='$cap' WHERE dapic='$pic'";
            $kq += $this->db->query($sql);

        }
        echo $kq;
    }

    public function checkexitsseourl()
    {
        $table = $this->input->post("table");
        $catname = $this->input->post("catname");
        $catval = $this->input->post("catval");
        $url = $this->input->post("url");
        $sql = "SELECT count(id) numrow FROM " . $table . " WHERE $catname='$catval' AND daurl='$url'";
        $qr = $this->db->query($sql);
        if ($qr->row()->numrow == 0) echo 0;
        else echo 1;
    }

    public function savebanner()
    {
        $aNewPic = explode(",", $this->input->post("img"));
        $aNewCaption = explode(",", $this->input->post("caption"));
        $sVal = "";
        for ($i = 0; $i < count($aNewPic); $i++) {
            $pic = $aNewPic[$i];
            if (trim($pic) == "") continue;
            $cap = $aNewCaption[$i];
            if ($sVal != "") $sVal .= ",";
            $sVal .= "('banner','$pic','$cap')";
        }
        if ($sVal != "") {
            $sql = "INSERT INTO " . $this->tbconfig . " (daname,davalue,dacomment) VALUES " . $sVal;
            echo $this->db->query($sql);
        } else {
            return 0;
        }
    }

    public function loadbanner()
    {
        $sql = "SELECT * FROM " . $this->tbconfig . " WHERE daname='banner'";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $arr = $qr->result_array();
            $this->mylibs->echojson($arr);
        } else {
            echo 0;
        }
    }
    public function updateoldbanner()
    {
        $aNewPic = explode(",", $this->input->post("img"));
        $aNewCaption = explode(",", $this->input->post("caption"));
        $kq = 0;
        for ($i = 0; $i < count($aNewPic); $i++) {
            $pic = $aNewPic[$i];
            if (trim($pic) == "") continue;
            $cap = $aNewCaption[$i];
            $sql = "UPDATE " . $this->tbconfig . " SET dacomment='$cap' WHERE davalue='$pic'";
            $kq += $this->db->query($sql);

        }
        echo $kq;
    }
    function delbanner($filename, $deldb = 0)
    {
        //important!!! need admin permission here
        try {
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././images/" . $filename);
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././thumbnails/" . $filename);
            if ($deldb == 1) {
                $sql = "DELETE FROM " . $this->tbconfig . " WHERE davalue='$filename'";
                $this->db->query($sql);
            }
            echo 1;
        } catch (Exception $ex) {
            echo 0;
        }
    }
    function saveconfig(){
        $daname= $this->input->post("daname");
        $davalue= $this->input->post("davalue");
        $dacomment= $this->input->post("dacomment");
        $sql="INSERT INTO ".$this->tbconfig." (daname,davalue,dacomment)  VALUES ('$daname','$davalue','$dacomment')";
        echo $this->db->query($sql);
    }
    function loadconfig(){
        $daname= $this->input->post("daname");
        $sql="SELECT * FROM ".$this->tbconfig." WHERE daname='$daname'";
        $qr= $this->db->query($sql);
        if($qr->num_rows()>0)
            return $this->mylibs->echojson($qr->result_array());
        else return "";
    }
    function deltoplink(){
        $id = $this->input->post("id");
        $sql="DELETE FROM ".$this->tbconfig." WHERE id=".$id;
        echo $this->db->query($sql);
    }
    public function loaddealuserlist($page=1){
        $page -= 1;
        $where = "";
        $dealid = $this->input->post("dealid");
        $username = $this->input->post("username");
        $dealuserid = $this->input->post("dealuserid");
        $dastatus = $this->input->post("dastatus");
        if($dealid > 0) $where .= " AND dadeal_id = $dealid ";
        if($dealuserid > 0) $where .= " AND id = $dealuserid ";
        if($username !="") $where .= " AND daname LIKE '%$username%' ";
        if($dastatus != "all") $where .= " AND dastatus = '$dastatus' ";
        $sql=" SELECT * FROM ".$this->tbdealuser."
        WHERE  dadeleted=0 $where
        ORDER BY id DESC LIMIT ".($page * $this->config->item("num_admindealuserlist")).", ".$this->config->item("num_admindealuserlist");
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $data['aDeal'] = $qr->result();
            $sql=" SELECT count(id) numrow FROM ".$this->tbdealuser."
        WHERE  dadeleted=0 $where";
            $qr = $this->db->query($sql);
            $data['sumpage'] = ceil($qr->row()->numrow/$this->config->item("num_admindealuserlist"));
            $data['page'] = $page;
            echo $this->load->view("admin/dealuserlist_v",$data,true);
        }
        else echo "<tr><td colspan='10'>Hện tại không có đơn hàng nào thỏa yêu cầu tìm kiếm </td></tr>";
    }
    function changedealstatus(){
        $aold = explode("-",$this->input->post("oldstatus"));
        $anew = explode("-",$this->input->post("newstatus"));

        $sql="UPDATE ".$this->tbdealuser." SET dastatus='$anew[1]' WHERE id=$anew[0]";
        $this->db->query($sql);
        $param = array(
        "dadealuser_id" => $anew[0],
        "danewstatus" => $anew[1],
        "daoldstatus" => $aold[1],
        "dauser_id" => $this->session->userdata("dauser_id"),
    );
        $sql= $this->db->insert_string($this->tbdealuserlog, $param);
        echo $this->db->query($sql);
    }
    function loaddealuserlog($id){
        $sql="SELECT d.*,u.dausername FROM ".$this->tbdealuserlog." d, ".$this->tbuser." u WHERE d.dadealuser_id=$id AND u.id=d.dauser_id ORDER BY id DESC";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $str = "<table><tr style='font-weight:bold'><td>Nhân viên</td><td>Thay đổi</td><td>Thời gian</td></tr>";
            $i=1;
            $select = $this->config->item('dealuserstatus');

            foreach($qr->result() as $row){
                $str.='<tr class="'.(($i%2==0)?'odd':'').'">

                <td>'.$row->dausername.'</td>
                <td>'.$select[$row->daoldstatus].' => '.$select[$row->danewstatus].'</td>
                <td>'.date("H:i d/m/Y",strtotime($row->dacreate)).'</td>
                </tr>';
                $i++;
            }
            $str .= '</table>';
            echo $str;
        }
        else echo "Chưa có lịch sử nào với đơn hàng này.";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin.php */