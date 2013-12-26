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

    public function index() //seourl
    {
        header("Location: /admin");
        $data['sBody'] = 'Hello';
        $data['sTitle'] =  'Trang chủ';
        $this->render($data);
    }

    public function render($data = array())
    {
        $data['sTitle'] = $data['sTitle'] . ' - ' . $this->config->item('sufix_title');
        $this->load->view('container_v', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */