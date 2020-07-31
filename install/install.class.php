<?php error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
define('UPDATE_URL', 'https://update.uniquecoder.com/');
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
ini_set('max_execution_time', 30000000);

class Install
{
    public function go()
    {
        $debug = '';
        $bug_error = '';
        $step = 1;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST['step']) && $_POST['step'] == 2) {
                if ($_POST['envato_username'] == '') {
                    $bug_error = 'We need your envato username to verify The purchase';
                } elseif (filter_var($_POST['support_email'], FILTER_VALIDATE_EMAIL) === false) {
                    $bug_error = 'We need your valid email to Support you';
                } elseif ($_POST['purchase_code'] == '') {
                    $bug_error = 'Enter your envato purchase code here';
                }
                $step = 2;
                $env_data = $this->remote_get_contents($_POST);
                $result = json_decode($env_data, true);
                if ($result['success'] == true) {
                    $debug = "Congratulation and Thanks for purchasing it.your setup is almost done";
                    $step = 3;
                } else {
                    $bug_error = $result['error'];
                    $step = 2;
                }
            } elseif (isset($_POST['permissions_success'])) {
                $step = 2;
            } elseif (isset($_POST['step']) && $_POST['step'] == 3) {
                $step = 3;
                $p = array();
                if ($_POST['hostname'] == '') {
                    $bug_error = 'Hostname is required';
                } elseif ($_POST['database'] == '') {
                    $bug_error = 'Enter database name';
                } elseif ($_POST['db_password'] == '' && !$this->is_localhost()) {
                    $bug_error = 'Enter database password';
                } elseif ($_POST['db_username'] == '') {
                    $bug_error = 'Enter database username';
                }
                if ($bug_error === '') {
                    $link = @mysqli_connect($_POST['hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['database']);
                    if (!$link) {
                        $bug_error .= "Error: Unable to connect to MySQL." . PHP_EOL;
                        $bug_error .= "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                        $bug_error .= "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                    } else {
                        $debug .= "Success: A proper connection to MySQL was made! The " . $_POST['database'] . " database is great." . PHP_EOL;
                        $debug .= "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
                        $step = 4;
                        mysqli_close($link);
                    }
                }
            } elseif (isset($_POST['step']) && $_POST['step'] == 4) {
                if ($_POST['admin_email'] == '') {
                    $bug_error = 'Enter admin email address';
                } elseif (filter_var($_POST['admin_email'], FILTER_VALIDATE_EMAIL) === false) {
                    $bug_error = 'Enter valid email address';
                } elseif ($_POST['admin_password'] == '') {
                    $bug_error = 'Enter admin password';
                } elseif ($_POST['admin_password'] != $_POST['confirm_password']) {
                    $bug_error = 'Your password not match';
                }
                $step = 4;
            }
            if ($bug_error === '' && isset($_POST['step']) && $_POST['step'] == 4) {
                $env_data = $this->remote_get_contents($_POST, true);
                $result = json_decode($env_data, true);
                if (!empty($result['success'])) {
                    $success = $this->install_db($_POST, $result['all_table']);
                    if (!empty($success)) {
                        $link = mysqli_connect($_POST['hostname'], $_POST['db_username'], $_POST['db_password'], $_POST['database']);

                        $this->write_app_config();

                        $this->clean_up_db_query($link);

                        $fullname = $_POST['admin_fullname'];
                        $username = $_POST['admin_username'];
                        $password = $this->hash($_POST['admin_password']);
                        $user_email = $_POST['admin_email'];
                        $company_name = $_POST['company_name'];
                        $company_email = $_POST['company_email'];
                        $timezone = $_POST['timezone'];
                        $created = date('Y-m-d H:i:s');

                        $sql = "INSERT INTO tbl_users(username,email,password,role_id,activated,created) VALUES ('$username','$user_email','$password',1,1,'$created')";
                        mysqli_query($link, $sql);
                        $last_id = mysqli_insert_id($link);
                        if (empty($last_id) || $last_id == 0) {
                            $last_id = 1;
                        }
                        $sql = "INSERT INTO tbl_account_details (fullname,user_id) VALUES('$fullname','$last_id')";
                        mysqli_query($link, $sql);


                        $sql = "UPDATE tbl_config SET value='$company_name' WHERE config_key='company_name'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$company_name' WHERE config_key='company_legal_name'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$company_name' WHERE config_key='website_name'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$company_name' WHERE config_key='contact_person'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$username' WHERE config_key='mail_username'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$company_email' WHERE config_key='company_email'";
                        mysqli_query($link, $sql);

                        $sql = "UPDATE tbl_config SET value='$timezone' WHERE config_key='timezone'";
                        mysqli_query($link, $sql);

                        $step = 5;
                    }
                } else {
                    $bug_error = $result['error'];
                }
            } else {
                $bug_error = $bug_error;
            }
        }
        $this->already_installed();
        require_once('html.php');
    }

    public function hash($string)
    {
        $encryption_key = 'I6PnEPbQNLslYMj7ChKxDJ2yenuHLkXn';
        return hash('sha512', $string . $encryption_key);
    }

    public function install_db($POST, $sql_file)
    {
        $mysqli = new mysqli($POST['hostname'], $POST['db_username'], $POST['db_password'], $POST['database']);

        if (mysqli_connect_errno())
            return false;
        $mysqli->multi_query($sql_file);

        do {

        } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
        $mysqli->close();

        return true;
    }

    public function remote_get_contents($post, $getDB = null)
    {
        if (function_exists('curl_init')) {
            return self::curl_get_contents($post, $getDB);
        } else {
            return 'Please enable the curl function';
        }
    }

    public function curl_get_contents($post, $getDB = null)
    {
        if (!empty($getDB)) {
            $url = UPDATE_URL . 'api/getDB';
        } else {
            $url = UPDATE_URL . 'api/check';
        }
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        $path = substr(realpath(dirname(__FILE__)), 0, -8);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'envato_username' => $post['envato_username'],
            'support_email' => $post['support_email'],
            'purchase_code' => $post['purchase_code'],
            'item_id' => '16292398',
            'ip_address' => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER["HTTP_HOST"],
            'url' => $this->base_url(), // please do not change the URL this is mandatory to setup the software
            'path' => $path,
        ));
        $output = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $output;

    }

    public function is_localhost()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        }

        return false;
    }

    private function clean_up_db_query($link)
    {
        while (mysqli_more_results($link) && mysqli_next_result($link)) {
            $dummyResult = mysqli_use_result($link);

            if ($dummyResult instanceof mysqli_result) {
                mysqli_free_result($link);
            }
        }
    }

    public function already_installed()
    {
        $output_path = '../application/config/install.php';
        if (!file_exists($output_path)) {
            header('location:../login');
        }
    }

    private function write_app_config()
    {

        $template_path = 'config/database.php';
        $output_path = '../application/config/database.php';
        $install = '../application/config/install.php';

        $database_file = file_get_contents($template_path);

        $new = str_replace("%HOSTNAME%", $_POST['hostname'], $database_file);
        $new = str_replace("%USERNAME%", $_POST['db_username'], $new);
        $new = str_replace("%PASSWORD%", $_POST['db_password'], $new);
        $new = str_replace("%DATABASE%", $_POST['database'], $new);

        $handle = fopen($output_path, 'w+');

        @chmod($output_path, 0777);
        if (file_exists($install)) {
            unlink($install);
        }
        if (is_writable($output_path)) {

            if (fwrite($handle, $new)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function base_url()
    {
        $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
        $base_url .= '://' . $_SERVER['HTTP_HOST'];
        $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $base_url = preg_replace('/install.*/', '', $base_url);

        return $base_url;
    }

    public function get_timezones_list()
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = array(
                'offset' => (int)$currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier
            );
        }

        usort($tempTimezones, function ($a, $b) {
            return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                $tz['identifier'];
        }
        return $timezoneList;
    }
}
