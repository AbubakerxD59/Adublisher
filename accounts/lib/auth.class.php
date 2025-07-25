<?php

/**
 * Authentication Class
 *
 * @package Wojo Framework
 * @author wojoscripts.com
 * @copyright 2020
 * @version $Id: aout.class.php, v1.00 2020-05-05 10:12:05 gewa Exp $
 */

if (!defined("_WOJO"))
    die('Direct access to this location is not allowed.');

class Auth
{

    public $logged_in = 0;
    public $uid = 0;
    public $username;
    public $sesid;
    public $email;
    public $name;
    public $fname;
    public $lname;
    public $country;
    public $avatar;
    public $membership_id = 0;
    public $mem_expire;
    public $usertype = null;
    public $userlevel = 0;
    public $lastlogin;
    public $lastip;
    public $acl = array();
    public static $userdata = array();
    public static $udata = array();

    /**
     * Auth::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->logged_in = $this->loginCheck();

        if (!$this->logged_in) {
            $this->username = App::Session()->set('MMP_username', '');
            $this->sesid = sha1(session_id());
            $this->userlevel = 0;
        }
    }

    /**
     * Auth::loginCheck()
     * 
     * @return
     */
    private function loginCheck()
    {
        $session = App::Session();
        if ($session->isExists('MMP_username') and $session->get('MMP_username') != "") {

            $this->uid = $session->get('userid');
            $this->username = $session->get('MMP_username');
            $this->email = $session->get('email');
            $this->fname = $session->get('fname');
            $this->lname = $session->get('lname');
            $this->name = $session->get('fname') . ' ' . $session->get('lname');
            $this->country = $session->get('country');
            $this->avatar = $session->get('avatar');
            $this->lastlogin = $session->get('lastlogin');
            $this->lastip = $session->get('lastip');
            $this->sesid = sha1(session_id());
            $this->usertype = $session->get('type');
            $this->membership_id = $session->get('membership_id');
            $this->mem_expire = $session->get('mem_expire');
            $this->userlevel = $session->get('userlevel');
            $this->acl = $session->get('acl');
            $this->domain = $session->get('MMP_domain');
            $this->phone = $session->get('phone');
            $this->team_role = $session->get('team_role');
            $this->team_id = $session->get('team_id');
            $this->status = $session->get('status');
            self::$userdata = $session->get('userdata');
            self::$udata = $this;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Auth::is_Admin()
     * 
     * @return
     */
    public function is_Admin()
    {
        $level = array(9, 8, 7);
        return (in_array($this->userlevel, $level)) ? 1 : 0;
    }

    /**
     * Auth::is_User()
     * 
     * @return
     */
    public function is_User()
    {
        $level = array(1);
        return (in_array($this->userlevel, $level) and $this->usertype == "member") ? 1 : 0;
    }

    /**
     * Auth::login()
     * 
     * @param mixed $username
     * @param mixed $password
     * @param bool $auto
     * @return
     */
    public function loginRest($username, $password, $auto = true)
    {
        if ($username == "" && $password == "") {
            Message::$msgs['username'] = Lang::$word->LOGIN_R5;
            $json['type'] = "error";
            $json['title'] = Lang::$word->ERROR;
            $json['message'] = Lang::$word->LOGIN_R5;
        } else {
            $status = $this->checkStatus($username, $password);

            switch ($status) {
                case "e":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R1;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R1;
                    break;

                case "b":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R2;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R2;
                    break;

                case "n":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R3;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R3;
                    break;

                case "t":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R4;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R4;
                    break;
            }
        }
        if (empty(Message::$msgs) && $status == "y") {
            $session = App::Session();
            $row = $this->getUserInfo($username);
            $this->uid = $session->set('userid', $row->id);
            $this->username = $session->set('MMP_username', $row->username);
            $this->fullname = $session->set('fullname', $row->fname . ' ' . $row->lname);
            $this->fname = $session->set('fname', $row->fname);
            $this->lname = $session->set('lname', $row->lname);
            $this->email = $session->set('email', $row->email);
            $this->country = $session->set('country', $row->country);
            $this->userlevel = $session->set('userlevel', $row->userlevel);
            $this->usertype = $session->set('type', $row->type);
            $this->membership_id = $session->set('membership_id', $row->membership_id);
            $this->mem_expire = $session->set('mem_expire', $row->mem_expire);
            $this->trial_used = $session->set('trial_used', $row->trial_used);
            $this->avatar = $session->set('avatar', $row->avatar);
            $this->lastlogin = $session->set('lastlogin', Db::toDate());
            $this->lastip = $session->set('lastip', Url::getIP());
            $this->domain = $session->set('MMP_domain', $row->domain);
            $this->phone = $session->set('phone', $row->ph);
            $this->team_role = $session->set('team_role', $row->team_role);
            $this->team_id = $session->set('team_id', $row->team_id);
            $this->status = $session->set('status', $status);

            if ($row->userlevel < 2) {
                if ($row->team_role == 'owner') {
                    $this->team_owner_id = $session->set('team_owner_id', $row->id);
                } else {
                    $where = array("team_id =" => $row->team_id, "AND team_role =" => "owner");
                    $row_owner = Db::run()->first(Users::mTable, null, $where);
                    $this->team_owner_id = $session->set('team_owner_id', $row_owner->id);
                    $this->team_owner_id = $session->set('membership_id', $row_owner->membership_id);
                    $this->team_owner_id = $session->set('mem_expire',  $row_owner->mem_expire);
                    $this->team_owner_id = $session->set('trial_used', $row_owner->trial_used);
                }
            }

            $result = self::getAcl($row->type);
            $privileges = array();
            for ($i = 0; $i < count($result); $i++) {
                $privileges[$result[$i]->code] = ($result[$i]->active == 1) ? true : false;
            }

            $this->acl = $session->set('acl', $privileges);
            $data = array('lastlogin' => Db::toDate(), 'lastip' => Validator::sanitize(Url::getIP()));
            Db::run()->update(Users::mTable, $data, array('id' => $row->id));
            self::$userdata = $session->set('userdata', $row);
            // self::setUserCookies($session->get('MMP_username'), $session->get('fullname'), $session->get('avatar'));
            $json['type'] = "success";
            $json['title'] = Lang::$word->SUCCESS;
        } else {
            $json['type'] = "error";
            $json['title'] = Lang::$word->ERROR;
        }

        $json['user'] = @$row;
        return $json;
    }
    public function login($username, $password, $auto = true)
    {
        if ($username == "" && $password == "") {
            Message::$msgs['username'] = Lang::$word->LOGIN_R5;
            $json['type'] = "error";
            $json['title'] = Lang::$word->ERROR;
            $json['message'] = Lang::$word->LOGIN_R5;
        } else {
            $status = $this->checkStatus($username, $password);
            //   echo '<pre>'; print_r($status); exit;
            switch ($status) {
                case "e":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R1;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R1;
                    break;

                case "b":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R2;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R2;
                    break;

                case "n":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R3;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R3;
                    break;

                case "t":
                    Message::$msgs['username'] = Lang::$word->LOGIN_R4;
                    $json['type'] = "error";
                    $json['title'] = Lang::$word->ERROR;
                    $json['message'] = Lang::$word->LOGIN_R4;
                    break;
            }
        }
        if (empty(Message::$msgs) && $status == "y") {
            $session = App::Session();
            $row = $this->getUserInfo($username);
            $this->uid = $session->set('userid', $row->id);
            $this->username = $session->set('MMP_username', $row->username);
            $this->fullname = $session->set('fullname', $row->fname . ' ' . $row->lname);
            $this->fname = $session->set('fname', $row->fname);
            $this->lname = $session->set('lname', $row->lname);
            $this->email = $session->set('email', $row->email);
            $this->country = $session->set('country', $row->country);
            $this->userlevel = $session->set('userlevel', $row->userlevel);
            $this->usertype = $session->set('type', $row->type);
            $this->membership_id = $session->set('membership_id', $row->membership_id);
            $this->mem_expire = $session->set('mem_expire', $row->mem_expire);
            $this->trial_used = $session->set('trial_used', $row->trial_used);
            $this->avatar = $session->set('avatar', $row->avatar);
            $this->lastlogin = $session->set('lastlogin', Db::toDate());
            $this->lastip = $session->set('lastip', Url::getIP());
            $this->domain = $session->set('MMP_domain', $row->domain);
            $this->phone = $session->set('phone', $row->ph);
            $this->team_role = $session->set('team_role', $row->team_role);
            $this->team_id = $session->set('team_id', $row->team_id);
            $this->status = $session->set('status', $status);

            if ($row->userlevel < 2) {
                if ($row->team_role == 'owner') {
                    $this->team_owner_id = $session->set('team_owner_id', $row->id);
                } else {
                    $where = array("team_id =" => $row->team_id, "AND team_role =" => "owner");
                    $row_owner = Db::run()->first(Users::mTable, null, $where);
                    $this->team_owner_id = $session->set('team_owner_id', $row_owner->id);
                    $this->team_owner_id = $session->set('membership_id', $row_owner->membership_id);
                    $this->team_owner_id = $session->set('mem_expire',  $row_owner->mem_expire);
                    $this->team_owner_id = $session->set('trial_used', $row_owner->trial_used);
                }
            }

            $result = self::getAcl($row->type);
            $privileges = array();
            for ($i = 0; $i < count($result); $i++) {
                $privileges[$result[$i]->code] = ($result[$i]->active == 1) ? true : false;
            }
            $this->acl = $session->set('acl', $privileges);

            $data = array('lastlogin' => Db::toDate(), 'lastip' => Validator::sanitize(Url::getIP()));
            Db::run()->update(Users::mTable, $data, array('id' => $row->id));
            self::$userdata = $session->set('userdata', $row);
            self::setUserCookies($session->get('MMP_username'), $session->get('fullname'), $session->get('avatar'));
            $json['type'] = "success";
            $json['title'] = Lang::$word->SUCCESS;
        } else {
            $json['type'] = "error";
            $json['title'] = Lang::$word->ERROR;
        }
        ($auto == true) ? print json_encode($json) : null;
    }




    /**
     * Auth::checkStatus()
     * 
     * @param mixed $username
     * @param mixed $pass
     * @return
     */
    public function checkStatus($username, $pass)
    {

        $username = Validator::sanitize($username, "string");
        $pass = Validator::sanitize($pass);
        // if($username == 'admin'){
        //     $where = array('username =' => $username, 'or email =' => $username);
        // }
        // else{
        //     $where = array('email =' => $username);
        // }
        $where = array('username =' => $username, 'or email =' => $username);
        $row = Db::run()->first(Users::mTable, array(
            'salt',
            'hash',
            'active'
        ), $where);

        if (!$row)
            return "e";

        $validpass = $this->_validate_login($pass, $row->hash, $row->salt);

        if (!$validpass)
            return "e";

        switch ($row->active) {
            case "b":
                return "b";

            case "n":
                return "n";

            case "t":
                return "t";

            case "y" and $validpass == true:
                return "y";
        }
    }

    /**
     * Auth::getUserInfo()
     * 
     * @param mixed $username
     * @return
     */
    public function getUserInfo($username)
    {
        $username = Validator::sanitize($username, "string");
        $row = Db::run()->first(Users::mTable, null, array('username =' => $username, 'OR email =' => $username));

        return ($row) ? $row : 0;
    }

    /**
     * Auth::getAcl() 
     * 
     * @param mixed $role
     * @return
     */
    public static function getAcl($role = '')
    {
        $sql = "
		  SELECT 
			p.code,
			p.name,
			p.description,
			rp.active 
		  FROM `" . Users::rpTable . "` rp 
			INNER JOIN `" . Users::rTable . "` r 
			  ON rp.rid = r.id 
			INNER JOIN `" . Users::pTable . "` p 
			  ON rp.pid = p.id 
		  WHERE r.code = ? ;";

        return Db::run()->pdoQuery($sql, array($role))->results();
    }

    /**
     * Auth::hasPrivileges()
     * 
     * @param mixed $code
     * @param mixed $val
     * @return
     */
    public static function hasPrivileges($code = '', $val = '')
    {
        $privileges_info = App::Session()->get('acl');
        if (!empty($val)) {
            if (isset($privileges_info[$code]) && is_array($privileges_info[$code])) {
                return in_array($val, $privileges_info[$code]);
            } else {
                return ($privileges_info[$code] == $val);
            }
        } else {
            return (isset($privileges_info[$code]) && $privileges_info[$code] == true) ? true : false;
        }
    }

    /**
     * Auth::logout()
     * 
     * @return
     */
    public function logout()
    {
        App::Session()->endSession();
        $this->logged_in = false;
        $this->username = "Guest";
        $this->userlevel = 0;
    }

    /**
     * Auth::usernameExists()
     * 
     * @param mixed $username
     * @return
     */
    public static function usernameExists($username)
    {
        $username = Validator::sanitize($username, "string");
        if (strlen($username) < 4)
            return 1;

        //Username should contain only alphabets, numbers, or underscores.Should be between 4 to 15 characters long
        $valid_uname = "/^[a-zA-Z0-9_]{4,15}$/";
        if (!preg_match($valid_uname, $username))
            return 2;

        $row = Db::run()->select(Users::mTable, array('username'), array('username' => $username), 'LIMIT 1')->result();

        return ($row) ? 3 : false;
    }

    /**
     * Auth::emailExists()
     * 
     * @param mixed $email
     * @return
     */
    public static function emailExists($email)
    {
        $row = Db::run()->select(Users::mTable, array('email'), array('email' => $email), ' LIMIT 1')->result();

        if ($row) {
            return true;
        } else
            return false;
    }

    /**
     * Auth::checkAcl()
     * 
     * @return
     */
    public static function checkAcl()
    {

        $acctypes = func_get_args();
        foreach ($acctypes as $type) {
            $args = explode(',', $type);
            foreach ($args as $arg) {
                if (App::Auth()->usertype == $arg)
                    return true;
            }
        }
        return false;
    }

    /**
     * Auth::setUserCookies()
     * 
     * @param mixed $username
     * @param mixed $name
     * @param mixed $avatar
     * @return
     */
    public static function setUserCookies($username, $name, $avatar)
    {
        $avatar = empty($avatar) ? "blank.png" : $avatar;
        @setcookie("MMP_loginData[0]", $username, strtotime('+30 days'));
        @setcookie("MMP_loginData[1]", $name, strtotime('+30 days'));
        @setcookie("MMP_loginData[2]", $avatar, strtotime('+30 days'));
    }

    /**
     * Auth::getUserCookies()
     * 
     * @return
     */
    public static function getUserCookies()
    {
        if (isset($_COOKIE['CMP_loginData'])) {
            $data = array(
                'username' => $_COOKIE['CMP_loginData'][0],
                'name' => $_COOKIE['CMP_loginData'][1],
                'avatar' => $_COOKIE['CMP_loginData'][2]
            );
            return $data;
        } else {
            return false;
        }
    }

    /**
     * Auth::generateToken()
     * 
     * @return
     */
    public static function generateToken($length = 24)
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    /**
     * Auth::create_hash()
     * 
     * @param mixed $password
     * @param string $salt
     * @param integer $stretch_cost
     * @return
     */
    public function create_hash($password, &$salt = '', $stretch_cost = 10)
    {
        $salt = strlen($salt) != 21 ? $this->_create_salt() : $salt;
        if (function_exists('crypt') && defined('CRYPT_BLOWFISH')) {
            return crypt($password, '$2a$' . $stretch_cost . '$' . $salt . '$');
        }

        if (!function_exists('hash') || !in_array('sha512', hash_algos())) {
            Debug::AddMessage("errors", "hash", "You must have the PHP PECL hash module installed");
        }

        return $this->_create_hash($password, $salt);
    }


    /**
     * Auth::validate_hash()
     * 
     * @param mixed $pass
     * @param mixed $hashed_pass
     * @param mixed $salt
     * @return
     */
    public function validate_hash($pass, $hashed_pass, $salt)
    {
        return $hashed_pass === $this->create_hash($pass, $salt);
    }

    /**
     * Auth::_validate_login()
     * 
     * @param mixed $pass
     * @param mixed $hash
     * @param mixed $salt
     * @return
     */
    protected function _validate_login($pass, $hash, $salt)
    {
        if ($this->validate_hash($pass, $hash, $salt)) {
            return true;
        } else
            return false;
    }

    /**
     * Auth::_create_salt()
     * 
     * @return
     */
    protected function _create_salt()
    {
        $salt = $this->_pseudo_rand(128);
        return substr(preg_replace('/[^A-Za-z0-9_]/is', '.', base64_encode($salt)), 0, 21);
    }

    /**
     * Auth::_pseudo_rand()
     * 
     * @param mixed $length
     * @return
     */
    protected function _pseudo_rand($length)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $is_strong = false;
            $rand = openssl_random_pseudo_bytes($length, $is_strong);
            if ($is_strong === true)
                return $rand;
        }
        $rand = '';
        $sha = '';
        for ($i = 0; $i < $length; $i++) {
            $sha = hash('sha256', $sha . mt_rand());
            $chr = mt_rand(0, 62);
            $rand .= chr(hexdec($sha[$chr] . $sha[$chr + 1]));
        }
        return $rand;
    }

    /**
     * Auth::_create_hash()
     * 
     * @param mixed $password
     * @param mixed $salt
     * @return
     */
    private function _create_hash($password, $salt)
    {
        $hash = '';
        for ($i = 0; $i < 20000; $i++) {
            $hash = hash('sha512', $hash . $salt . $password);
        }
        return $hash;
    }
}
