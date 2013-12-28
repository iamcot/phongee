<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

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
    }
    public function index()
    {
        $nofi = "";
        if ($this->input->post("login")) {
            $rs = $this->checklogin();
            if ($rs != null) {
                header("Location: " . $this->session->userdata('referer'));
            } else $nofi = "Tên tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại.";
        }
        if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "" && strpos($_SERVER["HTTP_REFERER"],base_url()) >= 0 && strpos($_SERVER["HTTP_REFERER"],'login') == false)
            $this->session->set_userdata('referer', $_SERVER["HTTP_REFERER"]);
        else if (!$this->session->userdata('referer') || ($this->session->userdata('referer') != "" && strpos($this->session->userdata('referer'),'login') != false))
            $this->session->set_userdata('referer', base_url());
        if ($nofi != "")
            $data["nofi"] = $nofi;
        $data['title'] = "Login";
        $this->render($data);
    }

    public function checklogin()
    {
        $dausername = $this->input->post("pgusername");
        $dapassword = $this->input->post("pgpassword");
        $dapassword = md5(md5($dapassword));
        $sql = "select * FROM " . $this->tbuser . " WHERE pgusername= '$dausername' AND pgpassword='$dapassword' and pgdeleted=0";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() == 1) {
            $user = $qr->row();
            $param = array(
                "pgusername" => $user->pgusername,
                "pguser_id" => $user->id,
                "pgfname" => $user->pgfname,
                "pglname" => $user->pglname,
                "pgrole" => $user->pgrole,
                "pgmobi" => $user->pgmobi,
                "pgemail" => $user->pgemail,
                "pgaddr" => $user->pgaddr,
                "pgavatar" => $user->pgavatar,
                "pgstore_id" => $user->pgstore_id,
            );
            $this->session->set_userdata($param);
            if($this->mylibs->accessadmin()){
                header("Location: ".base_url()."admin");
            }
            else
                return $user;
        } else return null;
    }

    public $tbuser = 'pguser';
    public $crrlang = '';

    public function render($data = array())
    {
        $data['title'] = $data['title'] . ' - ' . $this->config->item('sufix_title');
        $this->load->view('login_v', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        if(isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"],'admin')!=false)
            header("Location: " . base_url()."login");
        else header("Location: " . base_url());
    }
}