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
        } else if ($this->mylibs->checkRole('pgraadmin')==0) {
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
        if ($this->mylibs->checkRole('pgrauser')==0)
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
        if ($this->mylibs->checkRole('pgrainout')==0)
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/admininout_v', $data, true);
        $data['cat'] = 'inout';
        $data['title'] = 'Quản lý Xuất nhập';
        $this->render($data);
    }
    /**
     * Render Report page
     */
    public function report()
    {
        if ($this->mylibs->checkRole('pgrareport')==0)
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminreport_v', $data, true);
        $data['cat'] = 'report';
        $data['title'] = 'Báo cáo';
        $this->render($data);
    }
    /**
     * Render Thiet bi page
     */
    public function thietbi()
    {
        if ($this->mylibs->checkRole('pgrathietbi')==0)
            header("Location: " . base_url() . "admin");
        $data = array();
        $data['body'] = $this->load->view('admin/adminthietbi_v', $data, true);
        $data['cat'] = 'thietbi';
        $data['title'] = 'Quản lý thiết bị';
        $this->render($data);
    }

    public function load($table,$page = 1,$where = "")
    {
        $otherwhere = "";
        $parent = null;
        if ($where != "") {
            if ($table == 'inout_details' || $table == 'moneytransfer')
                $parent = array("pginout_id" => $where);
            else if ($table == 'user') {
                $arr = explode("-", $where);
                if ($arr[0] == 'false')
                    $otherwhere .= " pgrole!='admin' AND pgrole!='ketoantonghop' AND pgrole!='ketoankho' AND pgrole!='ketoan' AND pgrole!='staff' ";
                if($arr[1] =='false')
                {
                    if($otherwhere!="") $otherwhere.=" AND ";
                    $otherwhere.=" pgrole!='provider' ";
                }
                if($arr[2] =='false')
                {
                    if($otherwhere!="") $otherwhere.=" AND ";
                    $otherwhere.=" pgrole!='custom' ";
                }
                if($arr[3]!=""){
                    if($otherwhere!="") $otherwhere.=" AND ";
                    $otherwhere.=" (pgusername like '%".$arr[3]."%' OR pglname like '%".$arr[3]."%' OR pgfname like '".$arr[3]."') ";
                }
            }
        }
        if ($this->session->userdata("pgstore_id") > 0) {
            if ($table == 'inout') {
                $otherwhere .= "  (((pgxuattype='thuhoi' OR pgtype='xuat') AND pgfrom = '" . $this->session->userdata("pgstore_id") . "') OR ((pgtype='nhap' OR pgxuattype='cuahang') AND pgto = " . $this->session->userdata("pgstore_id") . ")) ";
            }
        }
        $data['aStore'] = $this->getStore("");
        $role = $this->mylibs->checkRole("pgrl".$table);
        if($role == 1 || $role == 2){
            $parent['pgcreateuser_id'] = $this->session->userdata('pguser_id');
        }
//        if($this->session->userdata("pgrole")!='admin' && $this->session->userdata("pgrole")!='ketoantonghop' ){
//            $parent['pgcreateuser_id'] = $this->session->userdata('pguser_id');
//        }
        if (($rs = $this->Select($this->tbprefix.$table, $parent, ($page-1), array('field' => 'id', 'type' => 'DESC'),$otherwhere)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPage($this->tbprefix.$table, $parent,$otherwhere);
            $data['page'] = $page;
            echo $this->load->view("admin/list_".$table."_v", $data, true);
        } else echo lang("NO_DATA");
    }
    public function loadview($table,$page = 1,$where = "")
    {
        $otherwhere = "";
        $parent = null;
        if ($where != "") {
            if ($table == 'v_inout' || $table == 'v_moneytransfer')
                $parent = array("pginout_id" => $where);
        }
        if ($this->session->userdata("pgstore_id") > 0) {
            if ($table == 'v_inout') {
                $otherwhere .= "  (((pgxuattype='thuhoi' OR inouttype='xuat') AND inoutfrom = '" . $this->session->userdata("pgstore_id") . "')
                OR ((inouttype='nhap' OR pgxuattype='cuahang' OR pgxuattype='xuatkho') AND inoutto = " . $this->session->userdata("pgstore_id") . ")) ";
            }
            else if ($table == 'v_moneytransfer')
                $otherwhere .= "  pgstore_id = '" . $this->session->userdata("pgstore_id") . "' ";
        }
//        if($this->session->userdata('pgrole')!='admin'){
//            if ($table == 'v_moneytransfer'){
//                $otherwhere .= "  pgstore_id = '" . $this->session->userdata("pgstore_id") . "' ";
//            }
//        }

        $role = $this->mylibs->checkRole("pgrl".$table);
        if($role == 1 || $role == 2){
            $parent['pgcreateuser_id'] = $this->session->userdata('pguser_id');
        }
        if (($rs = $this->Select($table, $parent, ($page-1), array('field' => 'id', 'type' => 'DESC'),$otherwhere)) != null) {
            $data['province'] = $rs;
            $data['sumpage'] = $this->getSumPage($table, $parent,$otherwhere);
            $data['page'] = $page;
            echo $this->load->view("admin/list_".$table."_v", $data, true);
        } else echo lang("NO_DATA");
    }

    public function loadcode($table,$id=0,$type='')
    {
        if($table!="chitietthietbi")
            $sql = "SELECT * FROM " . $this->tbprefix.$table . " WHERE pgcode='$id'";
        else
            $sql = "SELECT c.*,b.pgtype thietbitype FROM " . $this->tbprefix . "chitietthietbi c, ".$this->tbprefix."thietbi b
            WHERE c.pgcode='$id' AND b.id=c.pgthietbi_id ";
        //OR c.pgimei = '$id' OR c.pgpartno='$id'
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row_array();
            if($type=='nhapkho' && $row['thietbitype']=='thietbi'){
                if($this->TBremaininstock($id) > 0) {
                    echo -1;
                    return false;
                }
            }
            $this->mylibs->echojson($row);

        } else echo '0';
    }
    public function TBremaininstock($sn){
        $sql="SELECT count(id) numrow from v_inout WHERE pgseries='$sn' AND pgxuattype='nhapkho'
        union all
        SELECT count(id) from v_inout WHERE pgseries='$sn' AND (pgxuattype='khachle' OR pgxuattype='khachhang')";
//        echo $sql;
        $qr = $this->db->query($sql);
        $result = $qr->result();
        return $result[0]->numrow - $result[1]->numrow;
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
    public function listpagerp($page)
    {
        $data = array();
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." where pgdeleted=0 ORDER BY pgorder,pglong_name";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0) $rs = $qr->result();
        else $rs = null;
        $data['aStore'] = $rs;
        $data['aCustom'] = $this->getUserList(array('custom','provider'));
        if($page=='tonkho'){
            $sql="SELECT *  FROM ".$this->tbprefix.$this->tbthietbi." where pgdeleted=0 ORDER BY pglong_name ";
            $qr = $this->db->query($sql);
            if($qr->num_rows()>0) $rs = $qr->result();
            else $rs = null;
            $data['aThietbi'] = $rs;
        }
        if($page=='congno'){
            $sql="SELECT *  FROM ".$this->tbprefix.$this->tbuser." where pgdeleted=0 ORDER BY pgfname ";
            $qr = $this->db->query($sql);
            if($qr->num_rows()>0) $rs = $qr->result();
            else $rs = null;
            $data['aUser'] = $rs;
        }

        echo $this->load->view('admin/admin'.$page.'list_v', $data, true);
    }
    public function listpage($page)
    {
        $data = array();
        echo $this->load->view('admin/admin'.$page.'list_v', $data, true);
    }

    public function save($table)
    {
        $param = array();
        foreach ($_POST as $k => $post) {
            if ($k == "edit" || $k == 'pgpassword') continue;
            $param[$k] = $this->input->post($k);
        }
        $param['pgcreateuser_id'] = $this->session->userdata('pguser_id');
        if ($table == 'inout') {
            $param['pgdate'] = strtotime($param['pgdate']);
            $param['pghanthanhtoan'] = strtotime($param['pghanthanhtoan']);

            $rolexuattype = $this->mylibs->checkRole("pgrb".$param['pgxuattype']);
            switch($rolexuattype){
                case 1: echo 'r1'; return; break;
                case 2: if($this->input->post("edit") != "") echo 'r2'; return; break;
                case 3: break;
                case 4: break;
                case 9: break;
                default: echo 'r0'; return; break;
            }
            if ($this->input->post("edit") == ""){
                $this->db->query("CALL buildinoutcode(?,@number);",array($param['pgtype']));
                $qr = $this->db->query("SELECT @number");
                $row=$qr->row_array();
                $param['pgcode'] = $this->mylibs->buildinoutcode($param['pgtype'],$row['@number']);
            }

        }
        else if($table == 'moneytransfer'){
            $rolemoney = $this->mylibs->checkRole('pgramoneytransfer');
            switch($rolemoney){
                case 1: echo 'r1'; return; break;
                case 2: break;
                case 3: break;
                case 4: break;
                case 9: break;
                default: echo 'r0'; return; break;
            }
        }
        if ($this->input->post("pgpassword") != "")
            $param['pgpassword'] = md5(md5($this->input->post("pgpassword")));
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbprefix . $table, $param, " id = " . $this->input->post("edit"));
            try{
                echo $this->db->query($str);
            }catch (Exception $e){
                echo 0;
            }

        } else { //insert
            $param['pgcreateuser_id'] = $this->session->userdata('pguser_id');
            if ($table == 'inout_details') {
                $sql3 = "SELECT d.* FROM " . $this->tbprefix . "inout d WHERE d.id=" . $param['pginout_id'] . "";
                $qr = $this->db->query($sql3);
                if ($qr->num_rows > 0) {
                    $flag = 1;
                    $sqls = "SELECT id FROM pgchitietthietbi WHERE pgcode = '" . $this->input->post('pgseries') . "'";
                    $qrs = $this->db->query($sqls);
                    if ($qrs->num_rows() <= 0) {
                        $sqlins = "INSERT INTO pgchitietthietbi (pglong_name,pgcode,pgthietbi_id,pgthietbi_code,
                    pgprice,pgcolor,pgcountry,pgyear,pgcreateuser_id) VALUES
                    ((SELECT pglong_name from pgthietbi where id='" . $this->input->post('pgthietbi_id') . "'),'" . $this->input->post('pgseries') . "','" . $this->input->post('pgthietbi_id') . "',
                    '" . $this->input->post('pgthietbi_code') . "','" . $this->input->post('pgprice') . "','" . $this->input->post('pgcolor') . "',
                    '" . $this->input->post('pgcountry') . "','" . $this->input->post('pgyear') . "','".$this->session->userdata('pguser_id')."' )";
                        $flag = $this->db->query($sqlins);
                    }

                    if ($flag) {
                        $row = $qr->row();
                        $type = $row->pgtype;
                        $hdid = $row->id;
                        $xuattype = $row->pgxuattype;
                        $sql2 = "SELECT count(d.id) numdetail, b.pgtype pgthietbitype
                    FROM " . $this->tbprefix . "inout_details d, " . $this->tbprefix . "thietbi b
                    WHERE  d.pgseries='" . $param['pgseries'] . "'
                    AND d.pginout_id='" . $param['pginout_id'] . "'";
                        $qr = $this->db->query($sql2);
                        $row = $qr->row();
                        if ($type == 'nhap' && $row->numdetail > 0) {
//                            if($row->pgto == $param['pgto']){
                            echo '-1'; // da duoc nhap ve
                            return;
//                            }
                        }
                        if ($type == 'xuat' && $row->numdetail > 0) {
//                            if($row->pgto == $param['pgto']){
                            echo '-11'; // da duoc xuat trong hoa don nay
                            return;
//                            }
                        }
                    }
                    else {
                        echo -99; //them sn moi that bai
                        return;
                    }

                }
            }
            try{
                $str = $this->db->insert_string($this->tbprefix . $table, $param);
                if ($this->db->query($str)) {
                    echo $this->db->insert_id();
                } else echo 0;
            } catch(Exception $e){
                echo 0;
            }

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
//        if($pgto == -1 || $pgfrom == -1){
//            echo -5;//chua chon target
//            return ;
//        }
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
        if($pgxuattype == 'xuatkho'){
            $done = false;
            $i = 0;
            do{
            if($i==0) $max = "";
                else $max = " AND id < $i";
            $sql="SELECT * FROM v_inout WHERE pgdeleted=0 AND pgseries='$sn' AND inouttype='nhap' ".$max." ORDER BY id DESC LIMIT 0,1";
            $qr = $this->db->query($sql);
            if($qr->num_rows()>0){
                $row = $qr->row();
                if($this->gettonkho($sn,$row->inoutto) > 0) {
                    echo $row->inoutto;
                    $done = true;
                    return;
                }
                else{
                    $i= $row->id;
                    continue;
                }

            }
            else{
                echo -11;  //khong co trong kho
                $done=true;
                return;
            }
            }while(!$done);
        }

        $kq = 1;
        //kiem tra hoa don cuoi cung
//        $sql="SELECT i.pgtype,d.pgfrom, d.pgto, i.pgxuattype FROM ".$this->tbprefix."inout_details d, ".$this->tbprefix."inout i
//        WHERE i.id = d.pginout_id AND d.pgdeleted=0 AND d.pgseries = '$sn' ORDER BY d.id DESC LIMIT 0,1";
//        $qr = $this->db->query($sql);
//        if($qr->num_rows()>0){
//            $row = $qr->row();
//            if($row->pgxuattype == "khachhang") $kq = -1;//da ban
//            else if($row->pgtype=="xuat" && $row->pgto != $pgfrom) $kq = -3;//sp ko co o cua hang nay
//            else if($row->pgxuattype == "cuahang" && $row->pgto == $pgto) $kq = -2;// sp da o cua hang nay
//
//        }
        echo $kq;
    }
    public function getStore($type=''){
        if($this->mylibs->checkRole("pgrlstore")>= 1)
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." WHERE pgdeleted=0 ";
        if($type == 'role'){
            if($this->session->userdata("pgrole")=='ketoankho') $sql .=" AND pgtype='kho' ";
            else if($this->session->userdata("pgrole")=='ketoan') $sql .=" AND pgtype='cuahang' ";

        }
        else if($type!='' && $type!='all') $sql.= " AND pgtype='$type' ";

        if(($this->mylibs->checkRole("pgrlstore")== 3 || $this->mylibs->checkRole("pgrlstore")== 2) && $type!='kho' && $type!='all')
             $sql.= " AND id =".$this->session->userdata("pgstore_id")."";
        $sql .= " ORDER BY pgorder ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            return $qr->result_array();
        }
        else return null;
    }
    public function jsGetStore($type=''){
        $arr = $this->getStore($type);
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
    public function getSumremain($inout_id){
        $sql="SELECT sum( pgamount) summoney FROM ".$this->tbprefix."moneytransfer WHERE pginout_id='$inout_id' ";
        $qr = $this->db->query($sql);
        return $qr->row()->summoney;
    }
    public function jxloadsuminout($inout_id){
        $sum = $this->getSuminout($inout_id);
        $remain = $this->getSumremain($inout_id);
        $arr = array(
            'sum' =>number_format($sum,0,'.',','),
            'remain' =>number_format(($sum - $remain),0,'.',','),
        );
        $this->mylibs->echojson($arr);

    }
    public function jxloadsuminoutfromcode($inout_code){
        $sql = "SELECT * from pginout WHERE pgcode='$inout_code'";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $row = $qr->row();
            $inout_id = $row->id;
            $sum = $this->getSuminout($inout_id);
            $remain = $this->getSumremain($inout_id);
            $arr = array(
                'sum' => number_format($sum, 0, '.', ' '),
                'remain' => number_format(($sum - $remain), 0, '.', ' '),
                'type' => $row->pgtype,
                'id' => $row->id,
                'pgxuattype' => $row->pgxuattype,
                'pgfrom' => $row->pgfrom,
                'pgto' => $row->pgto,

            );
            $this->mylibs->echojson($arr);
        } else {
            echo '-1';
        }
    }
    /**
     * Select database with condition
     * @param $table
     * @param array $parent_id
     * @param int $page
     * @param null $order
     * @return null
     */
    public function Select($table, $parent_id = array(), $page = 0, $order = null, $otherwhere = "")
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
        if($otherwhere != ""){
            if($where !="") $otherwhere = " AND ".$otherwhere;
            else $otherwhere = " WHERE ".$otherwhere;
        }

        if ($page >= 0)
            $sql = "SELECT * FROM " . $table . $where . " $otherwhere ORDER BY  " . (($order != null) ? $order['field'] . " " . $order["type"] : "pglong_name") . "  LIMIT " . ($page * $this->config->item('pp')) . "," . $this->config->item('pp');
        else $sql = "SELECT * FROM " . $table . $where . " $otherwhere ORDER BY  dalong_name";
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
    public function getSumPage($table, $parent_id = array(),$otherwhere  = "")
    {
        $where = "";
        if ($parent_id != null) {
            foreach ($parent_id as $k => $v) {
                if ($v > 0 || strlen($v) >= 3)
                    $where .= ($where != "" ? " AND " : " WHERE ") . $k . " = " . "'$v'";
            }
        }
        if($otherwhere != ""){
            if($where !="") $otherwhere = " AND ".$otherwhere;
            else $otherwhere = " WHERE ".$otherwhere;
        }
        $sql = "SELECT count(id) numid FROM " . $table . $where.$otherwhere;
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
    public function getUserList($type=array()){
		$role = '';
		foreach($type as $k=>$v){
			if($role == '') $role .= ' AND (';
			else $role .= ' OR ';
			$role.= " pgrole='$v' ";
		}
		if($role !='') $role .= ')';
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbuser." WHERE pgdeleted=0 $role ORDER BY pgfname";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            return $qr->result_array();
        }
        else return null;
    }
    public function jxloadcustomer(){
        $provider = $this->getUserList();
        if($provider!=null){
            $this->mylibs->echojson($provider);
        }   else echo '';
    }
    public function jxloadnhacungcap(){
        $provider = $this->getUserList();
        if($provider!=null){
            $this->mylibs->echojson($provider);
        }   else echo '';
    }
    public function gettonkho($sn,$from=0){
        $sql="SELECT sum(d.pgcount) numin from ".$this->tbprefix."inout_details d,pginout i
        where i.id = d.pginout_id and i.pgto=$from and d.pgseries='$sn' AND (i.pgtype='nhap' OR i.pgxuattype='cuahang' OR i.pgxuattype='xuatkho')";
        $qr = $this->db->query($sql);
        $in = $qr->row()->numin;
        $sql="SELECT sum(d.pgcount) numout from ".$this->tbprefix."inout_details d,pginout i
        where i.id = d.pginout_id and i.pgfrom=$from and d.pgseries='$sn' AND (i.pgtype='xuat' OR i.pgxuattype='thuhoi')";
        $qr = $this->db->query($sql);
        $out = $qr->row()->numout;
        return ($in - $out);

    }
    public function jxgettonkho($sn,$from=0){
        echo $this->gettonkho($sn,$from);
    }
    public function reportxnt(){
        $pgtype=$this->input->get("pgtype");
        $pgstore_id=explode(",",$this->input->get("pgstore_id"));
        $pgname=$this->input->get("pgname");
        $pgdatefrom=$this->input->get("pgdatefrom");
        $pgdateto=$this->input->get("pgdateto");
        $pgcode=$this->input->get("pgcode");
        $pgprice=$this->input->get("pgprice");
        $pgcountry=$this->input->get("pgcountry");
        $pgcolor=$this->input->get("pgcolor");
        $pgyear=$this->input->get("pgyear");
        $pgcreateuser=$this->input->get("pgcreateuser");
        $pgseries=$this->input->get("pgseries");
        $showalltongkho=$this->input->get("showalltongkho");
        $pguser_id=explode(",",$this->input->get("pguser_id"));
        $print=$this->input->get("print");
        $data['pgtype'] = $pgtype;
        $data['pgname'] = $pgname;
        $data['pgstore_id'] = $pgstore_id;
        $data['pgdatefrom'] = $pgdatefrom;
        $data['pgdateto'] = $pgdateto;
        $data['pgcode'] = $pgcode;
        $data['pgprice'] = $pgprice;
        $data['pgcountry'] = $pgcountry;
        $data['pgcolor'] = $pgcolor;
        $data['pgyear'] = $pgyear;
        $data['pgcreateuser'] = $pgcreateuser;
        $data['pgseries'] = $pgseries;
        $data['pguser_id'] = $pguser_id;
        $data['showalltongkho'] = $showalltongkho;
        $data['print'] = $print;

        echo  $this->calReportXNT($data);
    }
    function calReportXNT($param){
        $aStore = null;
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $rs = $qr->result();
            foreach($rs as $v){
                $aStore[$v->id] = $v;
            }
        }
        $param['aStore'] = $aStore;
        $aProvider = null;
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbuser." where pgdeleted=0 ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $rs = $qr->result();
            foreach($rs as $v){
                $aProvider[$v->id] = $v;
            }
        }
        $param['aProvider'] = $aProvider;
        $sstore = '';
        foreach($param['pgstore_id'] as $store){
              if($store == 'all'){
                  $sstore = '';
                  break;
              }
            else {
                if($sstore == '') $sstore.=' AND (';
                else $sstore .=' OR ';
                $sstore.=" inoutfrom = '$store' OR inoutto = '$store'";
            }
        }
        if($sstore!='') $sstore.=')';
        $scustom = '';
        foreach($param['pguser_id'] as $store){
              if($store == 'all'){
                  $scustom = '';
                  break;
              }
            else {
                if($scustom == '') $scustom.=' AND (';
                else $scustom .=' OR ';
                $scustom.=" ( (pgxuattype='khachhang' AND inoutto = '$store' ) OR (pgxuattype='nhapkho' AND inoutfrom = '$store') ) ";
            }
        }
        if($scustom!='') $scustom.=')';

        $date = "";
        if($param['pgdatefrom'] != "")
            $date .= " AND inoutdate >= ".strtotime($param['pgdatefrom']);
        if($param['pgdateto'] != "")
            $date .= " AND inoutdate <= ".strtotime($param['pgdateto']);
        if($param['pgseries']!=''){
            $series = " AND pgseries like '%".$param['pgseries']."%' ";
        }

        else $series = '';
        if($param['showalltongkho']=='true'){
            $showalltongkho = " AND ( pgxuattype !='khachhang' AND pgxuattype!='cuahang' AND pgxuattype!='doitac' ) ";

        }
        else $showalltongkho = "";

        $sql="SELECT * FROM v_inout WHERE pgdeleted = 0 ".$sstore.$date.$series.$scustom.$showalltongkho;
     //    echo $sql;
         $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $report = $qr->result();
        }
        else $report = null;
        $param['aReport'] = $report;

        return $this->load->view("admin/rp_xnt",$param);
    }
    public function reporttonkho(){
        $pgthietbi_id=$this->input->get("pgthietbi_id");
        $storename=$this->input->get("storename");
        $pgstore_id=$this->input->get("pgstore_id");
        $print=$this->input->get("print");
        $data['pgthietbi_id'] = explode(",",$pgthietbi_id);
        $data['storename'] = $storename;
        $data['pgstore_id'] = $pgstore_id;
        $data['print'] = $print;

        echo  $this->calReportTonkho($data);
    }
    function calReportTonkho($param){
        //print_r($param['pgstore_id']) ;
        $aStore = null;
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $rs = $qr->result();
            foreach($rs as $v){
                $aStore[$v->id] = $v;
            }
        }
        $param['aStore'] = $aStore;
        $sstore = '';
        if($param['pgstore_id'] == 'all'){
        $sstore.=" AND (pgxuattype='nhapkho' OR pgxuattype='khachhang' OR pgxuattype='khachle' )";
        }
        else if($param['pgstore_id'] == 'cuahang'){
            $sstore.=" AND ( inouttype='xuat' OR pgxuattype = 'thuhoi')";
        }
        else if($param['pgstore_id'] == 'kho'){
            $sstore.=" AND ( pgxuattype='xuatkho' OR inouttype='nhap' )";
        }
        else{
           $sstore .= " AND ( ( (inouttype='nhap' OR pgxuattype='xuatkho') AND inoutto='".$param['pgstore_id']."' )
           OR ( (inouttype='xuat' OR pgxuattype = 'thuhoi') AND inoutfrom = '".$param['pgstore_id']."' )  ) ";
        }
        $sthietbi = '';
        foreach($param['pgthietbi_id'] as $thietbi){
            if($thietbi == 'all'){
                $sthietbi = '';
                break;
            }
            else {
                if($sthietbi == '') $sthietbi.=' AND (';
                else $sthietbi .=' OR ';
                $sthietbi.=" pgthietbi_id = '$thietbi'";
            }
        }
        if($sthietbi!='') $sthietbi.=')';
        if($param['pgstore_id'] =='all')
            $sql="SELECT thietbiname, sum(case when (pgxuattype='nhapkho') then (pgcount) else (pgcount*-1) end) tbcount FROM v_inout WHERE pgdeleted = 0 ".$sstore.$sthietbi." GROUP BY thietbiname ORDER BY nhomthietbiname, thietbiname ";
        else if($param['pgstore_id'] =='cuahang')
            $sql="SELECT thietbiname, sum(case when (pgxuattype='xuatkho') then (pgcount) else (pgcount*-1) end) tbcount FROM v_inout WHERE pgdeleted = 0 ".$sstore.$sthietbi." GROUP BY thietbiname ORDER BY nhomthietbiname, thietbiname ";
        else if($param['pgstore_id'] == 'kho')
            $sql="SELECT thietbiname, sum(case when (pgxuattype='xuatkho') then (pgcount*-1) else (pgcount) end) tbcount FROM v_inout WHERE pgdeleted = 0 ".$sstore.$sthietbi." GROUP BY thietbiname ORDER BY nhomthietbiname, thietbiname ";
        else
            $sql="SELECT thietbiname, sum(case when (inoutfrom='".$param['pgstore_id']."') then (pgcount*-1) else (pgcount) end) tbcount FROM v_inout WHERE pgdeleted = 0 ".$sstore.$sthietbi." GROUP BY thietbiname ORDER BY nhomthietbiname, thietbiname ";

//         echo $sql;
         $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $report = $qr->result();
        }
        else $report = null;
        $param['aReport'] = $report;

        return $this->load->view("admin/rp_tonkho",$param);
    }
    public function reporttienquy(){
        $pgtype=$this->input->get("pgtype");
        $pgstore_id=$this->input->get("pgstore_id");
        $pgdatefrom=$this->input->get("pgdatefrom");
        $pgdateto=$this->input->get("pgdateto");
        $pgmoneytype=$this->input->get("pgmoneytype");
        $data['pgtype'] = explode(",",$pgtype);
        $data['pgstore_id'] = $pgstore_id;
        $data['pgdatefrom'] = ($pgdatefrom);
        $data['pgdateto'] = ($pgdateto);
        $data['pgmoneytype'] = ($pgmoneytype);

        echo  $this->calReportTienQuy($data);
    }
    function calReportTienQuy($param){
        //print_r($param['pgstore_id']) ;
        $aStore = null;
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $rs = $qr->result();
            foreach($rs as $v){
                $aStore[$v->id] = $v;
            }
        }
        $param['aStore'] = $aStore;
        $date = "";
        if($param['pgdatefrom'] != "")
            $date .= " WHERE a.pgdate >= ".strtotime($param['pgdatefrom']);
        if($date != "") $date .=" AND ";
        else $date .=' WHERE ';
        if($param['pgdateto'] != "")
            $date .= " a.pgdate <= ".strtotime($param['pgdateto']);
        if($param['pgstore_id']=='all'){
            $store  = '';
            $xuatmoney = " or a.inouttype='xuat' ";
        }
        else{
            $xuatmoney = " or ( a.inouttype='xuat' and a.inoutfrom = '".$param['pgstore_id']."' ) ";
            if($date=='') $store = " WHERE ";
            else $store = " AND ";
            $store .= " ( a.pgstore_id = ".$param['pgstore_id']."
            OR (a.inoutfrom = ".$param['pgstore_id']." AND a.inouttype='xuat' )
            OR (a.inoutto = ".$param['pgstore_id']." AND (a.inouttype='nhap' OR a.inoutxuattype='xuatkho' OR a.inoutxuattype='cuahang')   )
            ) ";
        }
        if($param['pgmoneytype']=='all')
            $moneytype = '';
        else $moneytype = " AND pgmoneytype='".$param['pgmoneytype']."' ";
        $sql = "SELECT a.*,
         (CASE WHEN ( (a.pgtype='nhap' and a.inout_id=0)  $xuatmoney ) THEN (a.amountorg) ELSE ( 0 ) END) moneyin,
         (CASE WHEN ( (a.pgtype='xuat' and a.inout_id=0 ) or (a.inouttype='nhap') or (a.inoutto = '".$param['pgstore_id']."' and (a.inoutxuattype='xuatkho' or a.inoutxuattype='cuahang' ) )  ) THEN (-1*a.amountorg) ELSE ( 0 ) END) moneyout
         FROM v_tienquy a $date $store $moneytype ORDER BY a.pgdate";
//        echo $sql;
         $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $report = $qr->result();
        }
        else $report = null;
        $param['dudauky'] = $this->getdudauky(strtotime($param['pgdatefrom']),$param['pgstore_id']);
        $param['aReport'] = $report;

        return $this->load->view("admin/rp_tienquy",$param);
    }
    function getdudauky($datefrom,$store_id='all'){
        if($store_id=='all'){
            $store  = '';
            $xuatmoney = " or inouttype='xuat' ";
        }
        else{
            $xuatmoney = " or ( inouttype='xuat' and inoutfrom = '".$store_id."' ) ";
            $store = " AND ";
            $store .= " ( pgstore_id = ".$store_id."
            OR (inoutfrom = ".$store_id." AND inouttype='xuat' )
            OR (inoutto = ".$store_id." AND (inouttype='nhap' OR inoutxuattype='xuatkho' OR inoutxuattype='cuahang')   )
            ) ";
        }
        $sql="SELECT COALESCE((sum((CASE WHEN ( (pgtype='nhap' and inout_id=0) $xuatmoney ) THEN (pgamount) ELSE ( 0 ) END))
        + sum((CASE WHEN ( (pgtype='xuat' and inout_id=0 ) or (inouttype='nhap') or (inoutto = '".$store_id."' and (inoutxuattype='xuatkho' or inoutxuattype='cuahang' ) ) ) THEN (-1*pgamount) ELSE ( 0 ) END)) ),0) dudauky
        FROM v_tienquy WHERE pgdate < '$datefrom' $store";
//        echo $sql;
        $qr = $this->db->query($sql);
        return $qr->row()->dudauky;
    }
    public function reportcongno(){
        $pgtype=$this->input->get("pgtype");
        $pguser_id=$this->input->get("pguser_id");
        $khachno=$this->input->get("khachno");
        $shopno=$this->input->get("shopno");
        $hanthanhtoan=$this->input->get("hanthanhtoan");
        $print=$this->input->get("print");

        $data['pgtype'] = $pgtype;
        $data['pguser_id'] = explode(",",$pguser_id);
        $data['hanthanhtoan'] = $hanthanhtoan;
        $data['shopno'] = $shopno;
        $data['khachno'] = $khachno;
        $data['print'] = $print;


        echo  $this->calreportcongno($data);
    }
    public function reportcongnostore(){
        $pgstore_id=$this->input->get("pgstore_id");
        $print=$this->input->get("print");

        $data['pgstore_id'] = explode(",",$pgstore_id);

        $data['print'] = $print;


        echo  $this->calreportcongnostore($data);
    }
    function calreportcongno($param){
        //print_r($param['pgstore_id']) ;
        $aStore = null;
        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $rs = $qr->result();
            foreach($rs as $v){
                $aStore[$v->id] = $v;
            }
        }
        $param['aStore'] = $aStore;
        $suser = '';
        foreach($param['pguser_id'] as $user){
            if($user == 'all'){
                $suser = '';
                break;
            }
            else {
                if($suser == '') $suser.=' WHERE ';
                else $suser .=' OR ';
                $suser.=" id = '$user' ";
            }
        }
        $sql = "SELECT * FROM v_congno $suser  ORDER BY pgfname";
        //echo $sql;
         $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $report = $qr->result();
        }
        else $report = null;
        $param['aReport'] = $report;

        return $this->load->view("admin/rp_congno",$param);
    }
    function calreportcongnostore($param){
        //print_r($param['pgstore_id']) ;
//        $aStore = null;
//        $sql="SELECT * FROM ".$this->tbprefix.$this->tbstore." ";
//        $qr = $this->db->query($sql);
//        if($qr->num_rows()>0){
//            $rs = $qr->result();
//            foreach($rs as $v){
//                $aStore[$v->id] = $v;
//            }
//        }
//        $param['aStore'] = $aStore;
//        $aProvider = null;
//        $sql="SELECT * FROM ".$this->tbprefix.$this->tbuser." where pgdeleted=0 ";
//        $qr = $this->db->query($sql);
//        if($qr->num_rows()>0){
//            $rs = $qr->result();
//            foreach($rs as $v){
//                $aProvider[$v->id] = $v;
//            }
//        }
//        $param['aProvider'] = $aProvider;
        $suser = '';
        foreach($param['pgstore_id'] as $user){
            if($user == 'all'){
                $suser = '';
                break;
            }
            else {
                if($suser == '') $suser.=' WHERE ( ';
                else $suser .=' OR ';
                $suser.=" c.id = '$user' ";
            }
        }
        if($suser!="") $suser.=')';
        $tiennhap = "";
        $tienxuat = "";
        if($this->session->userdata("pgrole")=='ketoan'){
            $tiennhap = " SELECT sum(t1.pgamount) FROM v_tienquy t1 WHERE t1.pgstore_id = c.id AND t1.pgtype='nhap' AND t1.inout_id=0 ";
            $tienxuat = " SELECT sum(t1.pgamount) FROM v_tienquy t1 WHERE t1.pgstore_id = c.id AND t1.pgtype='xuat' AND t1.inout_id=0 ";
        }
        else{
            $tiennhap = " SELECT sum(t1.pgamount) FROM v_tienquy t1 WHERE t1.pgstore_idall = c.id AND t1.pgtype='nhap' AND t1.inout_id=0 ";
            $tienxuat = " SELECT sum(t1.pgamount) FROM v_tienquy t1 WHERE t1.pgstore_idall = c.id AND t1.pgtype='xuat' AND t1.inout_id=0 ";

        }
        $sql = "SELECT c.*,
         ($tiennhap) tiennhap,
         ($tienxuat) tienxuat
         FROM v_congno_store c $suser group by c.id";
        //echo $sql;
         $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $report = $qr->result();
        }
        else $report = null;
        $param['aReport'] = $report;

        return $this->load->view("admin/rp_congnostore",$param);
    }
    public function getUserTransfer($user_id){
        $sql="SELECT * FROM v_inout where (pgxuattype='nhapkho' AND inoutfrom = '".$user_id."') OR (pgxuattype='khachhang' AND inoutto = ".$user_id.")";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $data['aInout'] = $qr->result();
        }
        else $data['aInout'] = null;
        $sql="SELECT * FROM v_moneytransfer where user_id = '".$user_id."'";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $data['aMoney'] = $qr->result();
        }
        else $data['aMoney'] = null;
        $tmp = $this->getStore('all');
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aStore'] = $aStore;
        $tmp = $this->getUserList();
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aCustom'] = $aStore;
        return $this->load->view('admin/list_usertransfer_v',$data,true);
    }
    public function jsgetUserTransfer($user_id){
        echo $this->getUserTransfer($user_id);
    }
    public function jsgetStoreTransfer($store_id,$type,$page=1){
        echo $this->getStoreTransfer($store_id,$type,$page);
    }
    public function jsgetStoreTransferMoney($store_id,$type,$page=1){
        echo $this->getStoreTransferMoney($store_id,$type,$page);
    }
    public function getStoreTransfer($store_id,$type,$page){
        if($type=='nhap')
            $wherestore = " inoutto = $store_id ";
        else if($type=='xuat')
            $wherestore = " inoutfrom = $store_id ";
        else $wherestore = "";
       // if($wherestore != " ") $wherestore = " where ".$wherestore;

        $sql="SELECT * FROM v_inout WHERE (pgxuattype ='thuhoi' OR pgxuattype='xuatkho') AND $wherestore";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $data['aInout'] = $qr->result();
        }
        else $data['aInout'] = null;

        $data['aMoney'] = null;
        $tmp = $this->getStore('all');
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aStore'] = $aStore;
        $tmp = $this->getUserList();
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aCustom'] = $aStore;
        return $this->load->view('admin/list_usertransfer_v',$data,true);
    }
    public function getStoreTransferMoney($store_id,$type,$page){
        $data['aInout'] = null;
        if ($type == 'nhap') {
            if ($this->session->userdata('pgrole') == 'ketoan')
                $wherestore = " ( inoutxuattype='thuhoi' OR (pgtype='nhap' AND pgstore_id=$store_id AND inout_id=0) )";
            else
                $wherestore = " ( inoutxuattype='xuatkho' OR (pgtype='nhap' AND pgstore_idall=$store_id  AND inout_id=0) )";
        }
        else if ($type == 'xuat') {
            if ($this->session->userdata('pgrole') == 'ketoan')
                $wherestore = "( inoutxuattype='xuatkho' OR (pgtype='xuat' AND pgstore_id=$store_id AND inout_id=0) ) ";
            else
                $wherestore = " ( inoutxuattype='thuhoi' OR (pgtype='xuat' AND pgstore_idall=$store_id  AND inout_id=0) )";

        }
        else $wherestore = "";
       // if($wherestore != " ") $wherestore = " where ".$wherestore;

        $sql="SELECT * FROM v_tienquy WHERE (pgstore_id=$store_id OR pgstore_idall=$store_id) AND $wherestore";
//        echo $sql;
        $qr = $this->db->query($sql);

        if($qr->num_rows()>0){
            $data['aMoney'] = $qr->result();
        }
        else $data['aMoney'] = null;
        $tmp = $this->getStore('all');
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aStore'] = $aStore;
        $tmp = $this->getUserList();
        $aStore = array();
        if ($tmp != null)
            foreach ($tmp as $v) {
                $aStore[($v['id'])] = $v;
            }
        $data['aCustom'] = $aStore;
        return $this->load->view('admin/list_usertransfer_v',$data,true);
    }
    public function getstaffrole(){
        $sql="select u.pgusername,u.id userid,
                r.*
                FROM pguser u
                LEFT JOIN pgrole r
                ON r.pguser_id = u.id
                WHERE u.`pgrole` = 'admin' OR u.`pgrole`='staff' OR u.pgrole = 'ketoan' OR u.pgrole = 'ketoantonghop' OR u.pgrole = 'ketoankho'";
        $qr= $this->db->query($sql);
        if($qr->num_rows()>0){
            return $qr->result_array();
        }
        else return null;
    }
    public function loadstaffrole(){
        $data['aStaffRole'] = $this->getstaffrole();
        echo $this->load->view('admin/liststaffrole_v',$data,true);
        return;
    }
    public function save1role($user_id,$rolename,$roleval){
        $sql="SELECT pguser_id from pgrole WHERE pguser_id = $user_id";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){ //update
            $sql="UPDATE pgrole SET $rolename= $roleval WHERE pguser_id=$user_id";

        }
        else{//insert
            $sql="INSERT INTO pgrole (pguser_id,$rolename) VALUES ('$user_id','$roleval')" ;
        }
        echo $this->db->query($sql);
    }
    public function savedefault($userid){
        $sql="SELECT pgrole FROM pguser WHERE id=$userid";
        $qr = $this->db->query($sql);
        $usergroup = $qr->row()->pgrole;
        $sql="SELECT pguser_id from pgrole WHERE pguser_id = $userid";
        $qr = $this->db->query($sql);
        $rolename = $this->config->item('aRoleName');
        $rolegroup = $this->config->item('adRole');
        $numrole = count($rolename);
        if($qr->num_rows()>0){ //update
            $col = "";

            for($i=0;$i< $numrole;$i++){
                if($i>0) $col .=', ';
                $col.= " ".$rolename[$i]."= ".$rolegroup[$usergroup][$i]." ";
            }
            $sql="UPDATE pgrole SET $col WHERE pguser_id=$userid";

        }
        else{//insert
            $col = "";

            for($i=0;$i< $numrole;$i++){
                if($i>0) $col .=', ';
                $col.= " ".$rolename[$i]." ";
            }
            $val = "";
            for($i=0;$i< $numrole;$i++){
                if($i>0) $val .=', ';
                $val.= " '".$rolegroup[$usergroup][$i]."' ";
            }
            $sql="INSERT INTO pgrole (pguser_id,$col) VALUES ('$userid',$val)" ;
        }
        echo $this->db->query($sql);
    }
    public function getUserInout($userid){
        $sql="SELECT * FROM v_suminout WHERE
         (pgxuattype='nhapkho' AND inoutfrom = $userid ) OR
         (pgxuattype='khachhang' AND inoutto = $userid)
         ORDER by inoutdate";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $this->mylibs->echojson($qr->result_array());
        }
        else
            echo "";
    }
    public function getHoaDon($page=0,$full='false'){
        $otherwhere = "";
        if ($this->session->userdata("pgstore_id") > 0) {
                $otherwhere .= "
                (
                    (
                        (a.pgxuattype='thuhoi' OR a.inouttype='xuat')
                        AND a.inoutfrom = '" . $this->session->userdata("pgstore_id") . "'
                    )
                    OR
                    (
                        (a.inouttype='nhap' OR a.pgxuattype='cuahang'  OR a.pgxuattype='xuatkho' )
                        AND a.inoutto = " . $this->session->userdata("pgstore_id") . "
                    )
                ) ";
        }
       // var_dump($full);
        if($full=='true')
            $sfull = " (a.sumthanhtoan IS NULL OR
                ( (a.sumthanhtoan < a.sumduocnhan AND a.sumduocnhan > 0)
                OR  ( a.sumthanhtoan < a.sumphaitra AND a.sumphaitra > 0 ) ) ) ";

        else $sfull = "";


        if($sfull!="" && $otherwhere != "") $otherwhere = " AND ".$otherwhere;
        $ktkho = "";
        if($this->session->userdata('pgrole')=='ketoankho' && $this->session->userdata("pgstore_id") == 0){
            $ktkho ="(
                    (
                        (a.pgxuattype='thuhoi' OR a.inouttype='xuat')
                        AND a.inoutfrom in (SELECT x1.id FROM pgstore x1 WHERE x1.pgtype='kho')
                    )
                    OR
                    (
                        (a.inouttype='nhap' OR a.pgxuattype='cuahang'  OR a.pgxuattype='xuatkho' )
                        AND a.inoutto in (SELECT x2.id FROM pgstore x2 WHERE x2.pgtype='kho')
                    )
                )";
        }
        if(($sfull!="" ||  $otherwhere != "") && $ktkho!="") $ktkho = " AND ".$ktkho;
        $sqlcommon=" FROM (
                Select i.*,
                SUM(m.`pgamount`) sumthanhtoan
                from v_suminout i
                LEFT JOIN `pgmoneytransfer` m
                ON m.`pginout_id`= i.pginout_id

                GROUP BY i.pginout_id
                ) a
                 ".(($sfull!="" || $otherwhere !="" || $ktkho!="")?'WHERE':'')." $sfull $otherwhere $ktkho"
                ;
        $sqlsum = "SELECT count(a.pginout_id) sumrow ".$sqlcommon;
        $sqllimit = "SELECT a.* ".$sqlcommon."ORDER BY a.pginout_id DESC
                LIMIT " . (($page-1) * $this->config->item('pp')) . "," . $this->config->item('pp');
//       echo $sqllimit;
       // echo $sqlsum;
        $qrlimit = $this->db->query($sqllimit);
        $qrsum = $this->db->query($sqlsum);
        if($qrlimit->num_rows()>0)
            $rs = $qrlimit->result();
        else $rs = null;
        $data['province'] = $rs;
        $data['sumpage'] = ceil($qrsum->row()->sumrow / $this->config->item("pp"));
        $data['page'] = $page;
        echo $this->load->view("admin/list_inout_v", $data, true);

    }
    public function printinout($id){
        $sql="SELECT i.*,
        COALESCE(u.pgfname,'') userfname, COALESCE(u.pglname,'') userlname,COALESCE(u.pgmobi,'') usermobi,COALESCE(u.pgaddr,'') useraddr,
        COALESCE(s.pglong_name) storename
         FROM v_inout i
            LEFT JOIN pguser u
            ON (u.id = i.inoutto and i.pgxuattype = 'khachhang') OR (u.id = i.inoutfrom AND i.pgxuattype='nhapkho')
            LEFT JOIN pgstore s
            ON (s.id = i.inoutto and i.pgxuattype='xuatkho') OR (s.id = i.inoutfrom and i.pgxuattype = 'thuhoi')
        WHERE i.pginout_id = $id";
        $qr = $this->db->query($sql);
        if($qr->num_rows()>0){
            $data['aInout'] = $qr->result();
        }
        else{
            $data['aInout'] = null;
        }

        echo $this->load->view("admin/printinout_v",$data,true);
    }
    public function barcode($content = ""){
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        return Zend_Barcode::render('code39', 'image', array('text' => $content), array());
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/admin.php */