<?php
class MyLibs
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public $CI;

    public function echojson($data = array())
    {
        $this->CI->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function getUserPosition()
    {
        $i = 0;
        foreach ($this->CI->config->item("aRole") as $k => $v) {
            if ($k == $this->CI->session->userdata("pgrole"))
                break;
            $i++;
        }
        return $i;
    }
    function get_web_page( $url, $proxy="")
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_PROXY           => $proxy, //proxy
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "iamcot", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }


        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;


        return $header;
    }
    public function buildinoutcode($type, $number)
    {
        $code = "";
        if ($type == 'nhap') $code = 'N';
        else $code = "X";
        $code .= date("y");
        $lengofcode = 7;
        $lengid = strlen($number);
        for ($i = $lengofcode; $i > $lengid; $i--)
            $code .= "0";
        $code .= $number;
        return $code;
    }

    public function getDefaultRole($groupname = "", $rolename = '')
    {
        $index = array_search($rolename, $this->CI->config->item('aRoleName'));
        $aDefaultRole = $this->CI->config->item('adRole');
        if ($index >= 0)
            return $aDefaultRole[$groupname][$index];
        else return 0;
    }

    public function checkRole($rolename = "")
    {
        $sql = "SELECT $rolename as role FROM pgrole WHERE pguser_id='" . $this->CI->session->userdata('pguser_id') . "' ";
        $qr = $this->CI->db->query($sql);
        if ($qr->num_rows() > 0) {
            $role = $qr->row();
            if ($role->role > -1)
                return $role->role;
        }
        //default role
        return $this->getDefaultRole($this->CI->session->userdata('pgrole'), $rolename);

    }


    public function isTongKho($role = "")
    {
        if ($role == 'ketoantonghop' || $role == 'admin'|| $role == 'ketoankho'|| $role == 'ketoan') return true;
        else return false;
    }

    public function makeThumbnails($file_path, $file_name, $width, $height)
    {
        $file_path = $file_path . $file_name;

        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }

        if ($width > $img_width || $height > $img_height) {
            $height = $img_height;
            $tmph = $img_height;
            $width = $img_width;
            $tmpw = $img_width;
        }
        if ($height == 'auto') {
            $height = $img_height * ($width / $img_width);
            $offW = 0;
            $offH = 0;
            $tmpw = $img_width;
            $tmph = $img_height;
        } else {
            $ratew = $width / $img_width;
            $rateh = $height / $img_height;

            $rate = ($ratew > $rateh) ? $ratew : $rateh; //lay rate cao hon
            $tmpw = $width / $rate;
            $tmph = $height / $rate;


            if ($tmph < $img_height)
                $offH = ($img_height - $tmph) / 2;
            else $offH = ($tmph - $img_height) / 2;

            if ($tmpw < $img_width)
                $offW = ($img_width - $tmpw) / 2;
            else $offW = ($tmpw - $img_width) / 2;
        }
        $new_img = @imagecreatetruecolor($width, $height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                //$write_image = 'imagejpeg';
                //$image_quality = isset($options['jpeg_quality']) ?
                //    $options['jpeg_quality'] : 80;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                //$write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                //$write_image = 'imagepng';
                //$image_quality = isset($options['png_quality']) ?
                //    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }

        @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, $offW, $offH,
            $width,
            $height,
            $tmpw,
            $tmph
        );
        @imagedestroy($src_img);
        return $new_img;
    }

    public function convert_number_to_words($number)
    {
        $hyphen = ' ';
        $conjunction = '  ';
        $separator = ' ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'Không',
            1 => 'Một',
            2 => 'Hai',
            3 => 'Ba',
            4 => 'Bốn',
            5 => 'Năm',
            6 => 'Sáu',
            7 => 'Bảy',
            8 => 'Tám',
            9 => 'Chín',
            10 => 'Mười',
            11 => 'Mười một',
            12 => 'Mười hai',
            13 => 'Mười ba',
            14 => 'Mười bốn',
            15 => 'Mười lăm',
            16 => 'Mười sáu',
            17 => 'Mười bảy',
            18 => 'Mười tám',
            19 => 'Mười chín',
            20 => 'Hai mươi',
            30 => 'Ba mươi',
            40 => 'Bốn mươi',
            50 => 'Năm mươi',
            60 => 'Sáu mươi',
            70 => 'Bảy mươi',
            80 => 'Tám mươi',
            90 => 'Chín mươi',
            100 => 'trăm',
            1000 => 'ngàn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
// overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }
}