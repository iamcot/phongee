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
        } else if (!$this->mylibs->checkRole('raAdmin')) {
            header("Location: " . base_url().'login');
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

    public $tbprefix = 'pg';
    public $tbuser = 'user';
    public $tbstore = 'store';
    public $tbnhomthietbi = 'nhomthietbi';
    public $tbthietbi = 'thietbi';
    public $tbchitietthietbi = 'chitietthietbi';
    public $crrlang = '';

    /**
     * Render whole page
     * @param array $data
     */
    public function render($data = array())
    {
        $data['title'] = $data['title'] . ' - ' . $this->config->item('sufix_title');
        $this->load->view('admin/container_v', $data);
    }

    /**
     * Render user page
     */
    public function user()
    {
        if (!$this->mylibs->checkRole('raUser'))
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminuser_v', $data, true);
        $data['cat'] = 'user';
        $data['title'] = 'Quản lý thành viên';
        $this->render($data);
    }
    /**
     * Render import and export page
     */
    public function inout()
    {
        if (!$this->mylibs->checkRole('raInout'))
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/admininout_v', $data, true);
        $data['cat'] = 'inout';
        $data['title'] = 'Quản lý Xuất nhập';
        $this->render($data);
    }
    /**
     * Render Thiet bi page
     */
    public function thietbi()
    {
        if (!$this->mylibs->checkRole('raThietbi'))
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminthietbi_v', $data, true);
        $data['cat'] = 'thietbi';
        $data['title'] = 'Quản lý thiết bị';
        $this->render($data);
    }

    public function load($table,$page = 1)
    {

        if (($rs = $this->Select($this->tbprefix.$table, null, ($page-1), array('field' => 'id', 'type' => ''))) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPage($this->tbprefix.$table, null);
            $data['page'] = $page;
            echo $this->load->view("admin/list_".$table."_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadcode($table,$id)
    {
        $sql = "SELECT * FROM " . $this->tbprefix.$table . " WHERE pgcode='$id'";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row_array();
            $this->mylibs->echojson($row);

        } else echo '0';
    }
    public function loadedit($table,$id)
    {
        $sql = "SELECT * FROM " . $this->tbprefix.$table . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row_array();
            $this->mylibs->echojson($row);

        } else echo '0';
    }

    public function listpagethietbi()
    {
        $data = array();
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbnhomthietbi." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0) $rs = $qr->result();
        else $rs = null;
        $data['aNhomthietbi'] = $rs;
        echo $this->load->view('admin/adminthietbilist_v', $data, true);
    }
    public function listpagechitietthietbi()
    {
        $data = array();
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbnhomthietbi." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0) $rs = $qr->result();
        else $rs = null;
        $data['aNhomthietbi'] = $rs;
        echo $this->load->view('admin/adminchitietthietbilist_v', $data, true);
    }
    public function listpageuser()
    {
        $data = array();
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0) $rs = $qr->result();
        else $rs = null;
        $data['aStore'] = $rs;
        echo $this->load->view('admin/adminuserlist_v', $data, true);
    }
    public function listpage($page)
    {
        $data = array();
        echo $this->load->view('admin/admin'.$page.'list_v', $data, true);
    }

    public function save($table)
    {
        $param = array();
        foreach($_POST as $k=>$post){
            if($k=="edit" || $k=='pgpassword') continue;
            $param[$k] = $this->input->post($k);
        }
        if ($this->input->post("pgpassword") != "")
            $param['pgpassword'] = md5(md5($this->input->post("pgpassword")));
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbprefix.$table, $param, " id = " . $this->input->post("edit"));
        } else { //insert
            $str = $this->db->insert_string($this->tbprefix.$table, $param);

        }
        if ($this->db->query($str)) echo 1;
        else echo 0;
    }
    /**
     * Select database with condition
     * @param $table
     * @param array $parent_id
     * @param int $page
     * @param null $order
     * @return null
     */
    public function Select($table, $parent_id = array(), $page = 0, $order = null)
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
            $sql = "SELECT * FROM " . $table . $where . " ORDER BY  " . (($order != null) ? $order['field'] . " " . $order["type"] : "pglong_name") . "  LIMIT " . ($page * $this->config->item('pp')) . "," . $this->config->item('pp');
        else $sql = "SELECT * FROM " . $table . $where . " ORDER BY  dalong_name";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            return $qr->result();
        } else return null;
    }

    /**
     * get sum row of select
     * @param $table
     * @param array $parent_id
     * @return float|int
     */
    public function getSumPage($table, $parent_id = array())
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
    public function hide($table, $id, $status)
    {
        $str = $this->db->update_string($this->tbprefix.$table, array("pgdeleted" => ($status == 0 ? 1 : 0)), " id = " . $id);
        if ($this->db->query($str)) echo 1;
        else echo 0;
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

    function saveconfig(){
        $daname= $this->input->post("pgname");
        $davalue= $this->input->post("pgvalue");
        $dacomment= $this->input->post("pgcomment");
        $sql="INSERT INTO ".$this->tbconfig." (daname,davalue,dacomment)  VALUES ('$daname','$davalue','$dacomment')";
        echo $this->db->query($sql);
    }
    function loadconfig(){
        $daname= $this->input->post("pgname");
        $sql="SELECT * FROM ".$this->tbconfig." WHERE daname='$daname'";
        $qr= $this->db->query($sql);
        if($qr->num_rows()>0)
            return $this->mylibs->echojson($qr->result_array());
        else return "";
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin.php */