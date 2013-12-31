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
        } else if ($this->mylibs->checkRole('raAdmin')==0) {
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
        if ($this->mylibs->checkRole('raUser')==0)
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
        if ($this->mylibs->checkRole('raInout')==0)
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
        if ($this->mylibs->checkRole('raThietbi')==0)
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminthietbi_v', $data, true);
        $data['cat'] = 'thietbi';
        $data['title'] = 'Quản lý thiết bị';
        $this->render($data);
    }

    public function load($table,$page = 1,$where = "")
    {
        $parent = null;
        if($where!= ""){
            if($table == 'inout_details')
            $parent = array("pginout_id" => $where);
            else  if($table == 'moneytransfer')
                $parent = array("pginout_id" => $where);
        }
        $role = $this->mylibs->checkRole("rl".$table);
        if($role == 1 || $role == 2){
            $parent['pgcreateuser_id'] = $this->session->userdata('pguser_id');
        }
        if (($rs = $this->Select($this->tbprefix.$table, $parent, ($page-1), array('field' => 'id', 'type' => 'DESC'))) != null) {
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
        $param['pgcreateuser_id'] = $this->session->userdata('pguser_id');
        if($table=='inout'){
            $param['pgdate'] = strtotime($param['pgdate']);
        }
        if ($this->input->post("pgpassword") != "")
            $param['pgpassword'] = md5(md5($this->input->post("pgpassword")));
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbprefix.$table, $param, " id = " . $this->input->post("edit"));
            echo $this->db->query($str);
        } else { //insert
            if($table == 'inout_details'){
                $sql3 = "SELECT d.* FROM ".$this->tbprefix."inout d WHERE d.id=".$param['pginout_id']."";
                $qr = $this->db->query($sql3);
                if ($qr->num_rows > 0) {
                    $row = $qr->row();
                    $type=$row->pgtype;
                    $hdid = $row->id;
                    $xuattype=$row->pgxuattype;
                    $sql2 = "SELECT d.*,i.pgtype, i.pgxuattype  FROM " . $this->tbprefix . "inout_details d, " . $this->tbprefix . "inout i WHERE d.pginout_id = i.id  AND d.pgseries='" . $param['pgseries'] . "' ORDER BY d.id DESC LIMIT 0,1";
                    $qr = $this->db->query($sql2);
                    if ($qr->num_rows() > 0) {
                        $row = $qr->row();
                        if($type == 'nhap'){
                            if($row->pgto == $param['pgto']){
                                echo '-1'; // da duoc nhap ve
                                return;
                            }
                        }
                    }
                }
            }
            $str = $this->db->insert_string($this->tbprefix.$table, $param);
            if ($this->db->query($str)) {
                echo $this->db->insert_id();
            }
            else echo 0;
        }

    }
    public function checkSeriesNr($series,$inout_id,$pgfrom,$pgto){
        $sql3 = "SELECT d.* FROM ".$this->tbprefix."inout d WHERE d.id=".$inout_id."";
        $qr = $this->db->query($sql3);
        if ($qr->row()->numrows > 0) {
            $row = $qr->row();
            $type=$row->pgtype;
            $hdid = $row->id;
            $xuattype=$row->pgxuattype;
            $sql2 = "SELECT d.*,i.pgtype, i.pgxuattype  FROM " . $this->tbprefix . "inout_details d, " . $this->tbprefix . "inout i WHERE d.inout_id = i.id  AND d.pgseries='" .$series . "' ORDER BY d.id DESC LIMIT 0,1";
            $qr = $this->db->query($sql2);
            if ($qr->num_rows() > 0) {
                $row = $qr->row();
                if($type == 'nhap'){
                    if($row->pgto == $pgto){
                        echo '-1'; // da duoc nhap ve
                        return;
                    }
                }
                else {

                        }

            }
        }
    }
    public function checkxuat($sn){
        $pgtype="xuat";
        $pgxuattype = $this->input->post('xuattype');
        $pgto = $this->input->post('to');
        $pgfrom = $this->input->post('from');
        $pginout_id = $this->input->post('inout_id');
        $kq = 0;
        if($pgto == -1 || $pgfrom == -1){
            echo -5;//chua chon target
            return ;
        }
        if($pgxuattype == "cuahang" && $pgfrom == $pgto){
            echo  -4;// to va from giong nhau
            return;
        }
        $sql="SELECT count(id) numrows FROM ".$this->tbprefix."inout_details WHERE pginout_id='$pginout_id' AND pgseries='$sn'";
        $qr = $this->db->query($sql);
        if($qr->row()->numrows >0){
            echo -6; // da co sp trong don hang
            return;
        }
        //kiem tra hoa don cuoi cung
        $sql="SELECT i.pgtype,d.pgfrom, d.pgto, i.pgxuattype FROM ".$this->tbprefix."inout_details d, ".$this->tbprefix."inout i
        WHERE i.id = d.pginout_id AND d.pgdeleted=0 AND d.pgseries = '$sn' ORDER BY d.id DESC LIMIT 0,1";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $row = $qr->row();
            if($row->pgxuattype == "khachhang") $kq = -1;//da ban
            else if($row->pgtype=="xuat" && $row->pgto != $pgfrom) $kq = -3;//sp ko co o cua hang nay
            else if($row->pgxuattype == "cuahang" && $row->pgto == $pgto) $kq = -2;// sp da o cua hang nay
            else $kq = 1;
        }
        echo $kq;
    }
    public function getStore(){
        if($this->mylibs->checkRole("rqStore")>= 2)
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." WHERE pgdeleted=0 ";
        if($this->mylibs->checkRole("rqStore")== 2)
             $sql.= " AND id =".$this->session->userdata("pgstore_id")."";
        $sql .= " ORDER BY pgorder ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            return $qr->result_array();
        }
        else return null;
    }
    public function jsGetStore(){
        $arr = $this->getStore();
        if($arr!=null){
            $this->mylibs->echojson($arr);
        }
        else echo "";
    }
    public  function getSuminout($inout_id){
        $sql="SELECT sum(pgcount * pgprice) summoney FROM ".$this->tbprefix."inout_details WHERE pginout_id='$inout_id' ";
        $qr = $this->db->query($sql);
        return $qr->row()->summoney;
    }
    public function jxloadsuminout($inout_id){
        echo number_format($this->getSuminout($inout_id),0,'.',' ');
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
                if ($v > 0)    {
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
    public function getUserList($type=""){
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbuser." WHERE pgdeleted=0 AND pgrole='$type' ORDER BY pgfname";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            return $qr->result_array();
        }
        else return null;
    }
    public function jxloadcustomer(){
        $provider = $this->getUserList("custom");
        if($provider!=null){
            $this->mylibs->echojson($provider);
        }   else echo '';
    }
    public function jxloadnhacungcap(){
        $provider = $this->getUserList("provider");
        if($provider!=null){
            $this->mylibs->echojson($provider);
        }   else echo '';
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/admin.php */