<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <?php
    $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
    $base_url .= '://' . $_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    $base_url = preg_replace('/install.*/', '', $base_url);
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ultimate Project Manager CRM PRO</title>
    <link rel="stylesheet" href="../assets/plugins/install/app.css" type="text/css"/>
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/install/fuelux/fuelux.css" type="text/css"/>
	  <link rel="stylesheet" href="../assets/plugins/select2/dist/css/select2.min.css">
    <link rel="stylesheet"
          href="../assets/plugins/select2/dist/css/select2-bootstrap.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- danger: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container" style="width:80%">
        <section class="panel panel-default bg-white m-t-lg">
            <header class="panel-heading text-center">
                <strong>Thank You for Purchasing Ultimate Project Manager CRM PRO</strong>
            </header>
            <div class="panel-body wrapper-lg">
                <?php
                $step1 = $step2 = $step3 = $step4 = '';
                $badge1 = $badge2 = $badge3 = $badge4 = 'badge';
                if (isset($step)) {
                    switch ($step) {
                        case '2':
                            $step2 = 'active';
                            $badge2 = 'badge badge-success';
                            break;
                        case '3':
                            $step3 = 'active';
                            $badge3 = 'badge badge-success';
                            break;
                        case '4':
                            $step4 = 'active';
                            $badge4 = 'badge badge-success';
                            break;

                        default:
                            $step1 = 'active';
                            $badge1 = 'badge badge-success';
                            break;
                    }
                } else {
                    $step1 = 'active';
                    $badge1 = 'badge badge-success';
                }

                ?>
                <div class="panel panel-default wizard">
                    <div class="wizard-steps clearfix" id="form-wizard">
                        <ul class="steps">
                            <li class="<?= $step1 ?>"><span class="<?= $badge1 ?>">1</span> Requirements</li>
                            <li class="<?= $step2 ?>"><span class="<?= $badge2 ?>">2</span> Envato Account</li>
                            <li class="<?= $step3 ?>"><span class="<?= $badge3 ?>">3</span> Database Settings</li>
                            <li class="<?= $step4 ?>"><span class="<?= $badge4 ?>">4</span> Basic Settings</li>
                        </ul>
                    </div>
                    <div class="step-content clearfix">
                        <?php
                        if ($step == 1) { ?>
                            <div class="step-pane <?= $step1 ?>" id="step1">
                                <?php
                                $database_file = ".././application/config/database.php";
                                $config_file = ".././application/config/config.php";
                                $htaccess_file = "../.htaccess";
                                $error = FALSE;
                                if (phpversion() < "5.5") {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>Your PHP version is " . phpversion() . "! PHP 5.5 or higher required!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> You are running PHP " . phpversion() . "</div>";
                                }
                                if (!extension_loaded('mysqli')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>Mysqli PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> Mysqli PHP extension loaded!</div>";
                                }
                                if (!extension_loaded('imap')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>IMAP PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> IMAP PHP extension loaded!</div>";
                                }

                                if (!extension_loaded('mbstring')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>MBString PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> MBString PHP extension loaded!</div>";
                                }

                                if (!extension_loaded('zip')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>ZIP PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> ZIP PHP extension loaded!</div>";
                                }

                                if (!extension_loaded('gd')) {
                                    echo "<div class='alert alert-danger'>GD PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> GD PHP extension loaded!</div>";
                                }
                                if (!extension_loaded('pdo')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>PDO PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> PDO PHP extension loaded!</div>";
                                }


                                if (!extension_loaded('curl')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>CURL PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> CURL PHP extension loaded!</div>";
                                }
                                if (!extension_loaded('openssl')) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'> OpenSSL PHP extension missing!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> OpenSSL PHP extension loaded!</div>";
                                }

                                $url_f_open = ini_get('allow_url_fopen');
                                if ($url_f_open != "1" && $url_f_open != 'On') {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>Allow_url_fopen is not enabled!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> Allow_url_fopen is loaded!</div>";
                                }
                                if (!is_writeable($config_file)) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>Config File (application/config/config.php) is not writeable!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> Config file is writeable!</div>";
                                }
                                if (!is_writeable($database_file)) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>Database File (application/config/database.php) is not writeable!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> Database file is writeable!</div>";
                                }
                                if (!is_writeable($htaccess_file)) {
                                    $error = TRUE;
                                    echo "<div class='alert alert-danger'>HTACCESS File (.htaccess) is not writeable!</div>";
                                } else {
                                    echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> HTACCESS file is writeable!</div>";
                                }

                                ?>
                                <?php if ($error == true) {
                                    echo '<div class="text-center alert alert-danger">You need to fix the requirements in order to continue installing Ultimate Project Manager CRM PRO</div>';
                                } else {
                                    echo '<div class="text-center">';
                                    echo '<form action="" method="post" accept-charset="utf-8">';
                                    echo '<input type="hidden" name="permissions_success" value="true">';
                                    echo '<button type="submit" class="btn btn-primary">Setup Database</button>';
                                    echo '</form>';
                                    echo '</div>';
                                } ?>

                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <hr/>
                        <?php if ($debug != '') { ?>
                            <p class="sql-debug-alert text-success text-center"
                               style="margin-bottom:20px;"><?php echo $debug; ?></p>
                        <?php } ?>
                        <?php
                        if (isset($bug_error) && $bug_error != '') { ?>
                            <div class="alert alert-danger text-center">
                                <?php echo $bug_error; ?>
                            </div>
                        <?php } ?>
                        <?php if ($step == 2) { ?>
                            <div class="step-pane <?= $step2 ?>" id="step2">
                                <?php echo '<form action="" id="verify" novalidate="novalidate" class="form-horizontal" method="post" accept-charset="utf-8">'; ?>
                                <?php echo '<input type="hidden" name="step" value="' . $step . '">'; ?>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Envato Username</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="your envato username"
                                               name="envato_username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Support Email</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="your_support_email@gmail.com"
                                               name="support_email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Purchase Code</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" 
                                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" name="purchase_code">
                                        <span class="help-block m-b-none">Your purchase code from Envato <a
                                                    href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Can-I-Find-my-Purchase-Code-"
                                                    target="_blank">Read More</a></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"></label>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Almost Done</button>
                                    </div>
                                </div>
                                </form>

                            </div>
                        <?php } ?>
                        <?php if ($step == 3) { ?>
                            <div class="step-pane <?= $step3 ?>" id="step3">
                                <?php echo '<form action="" id="database" novalidate="novalidate" class="form-horizontal" method="post" accept-charset="utf-8">'; ?>
                                <?php echo '<input type="hidden" name="step" value="' . $step . '">'; ?>
                                <?php echo '<input type="hidden" name="envato_username" value="' . $_POST['envato_username'] . '">'; ?>
                                <?php echo '<input type="hidden" name="support_email" value="' . $_POST['support_email'] . '">'; ?>
                                <?php echo '<input type="hidden" name="purchase_code" value="' . $_POST['purchase_code'] . '">'; ?>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Database Host</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" value="localhost"
                                               placeholder="localhost"
                                               name="hostname">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Database Name</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="db_crm"
                                               name="database">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Database Username</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="db_crm_user"
                                               name="db_username">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Database Password</label>
                                    <div class="col-lg-7">
                                        <input type="password" class="form-control" placeholder="crm@!@@"
                                               name="db_password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label"></label>
                                    <div class="col-lg-7">
                                        <button type="submit" class="btn btn-primary">Check Database</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <?php } ?>
                        <?php if ($step == 4) { ?>
                            <div class="step-pane <?= $step4 ?>" id="step4">
                                <?php echo '<form action="" id="complete" novalidate="novalidate" class="form-horizontal" method="post" accept-charset="utf-8">'; ?>
                                <?php echo '<input type="hidden" name="step" value="' . $step . '">'; ?>
                                <?php echo '<input type="hidden" name="hostname" value="' . $_POST['hostname'] . '">'; ?>
                                <?php echo '<input type="hidden" name="database" value="' . $_POST['database'] . '">'; ?>
                                <?php echo '<input type="hidden" name="db_username" value="' . $_POST['db_username'] . '">'; ?>
                                <?php echo '<input type="hidden" name="db_password" value="' . $_POST['db_password'] . '">'; ?>
                                <?php echo '<input type="hidden" name="envato_username" value="' . $_POST['envato_username'] . '">'; ?>
                                <?php echo '<input type="hidden" name="support_email" value="' . $_POST['support_email'] . '">'; ?>
                                <?php echo '<input type="hidden" name="purchase_code" value="' . $_POST['purchase_code'] . '">'; ?>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Full Name</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="John Doe"
                                               name="admin_fullname">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Username</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="johndoe"
                                               name="admin_username">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Password</label>
                                    <div class="col-lg-7">
                                        <input type="password" class="form-control" placeholder="password"
                                               name="admin_password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Confirm Password</label>
                                    <div class="col-lg-7">
                                        <input type="password" class="form-control" placeholder="password"
                                               name="confirm_password">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label"> Email</label>
                                    <div class="col-lg-7">
                                        <input type="email" class="form-control" value="<?= $_POST['support_email'] ?>"
                                               placeholder="admin@unique_coder.com"
                                               name="admin_email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Company Name</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" placeholder="unique_coder"
                                               name="company_name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Company Email</label>
                                    <div class="col-lg-7">
                                        <input type="email" class="form-control" placeholder="info@unique_coder.com"
                                               name="company_email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Timezone</label>
                                    <div class="col-lg-7">
                                        <select name="timezone" class="form-control select_box"  style="width: 100%" required>
                                            <?php foreach ($this->get_timezones_list() as $timezone => $description) { ?>
                                                <option
                                                    value="<?php echo $timezone; ?>"><?php echo $description; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"></label>
                                    <div class="col-lg-7">
                                        <button type="submit" id="finish" class="btn btn-primary">Complete</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        <?php } else if ($step == 5) {
                            $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
                            $base_url .= '://' . $_SERVER['HTTP_HOST'];
                            $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
                            $base_url = preg_replace('/install.*/', '', $base_url);

                            ?>
                            <h4 class="bold">Installation successful!</h4>
                            <p>Please delete the install directory and login as administrator at <a
                                    href="<?php echo $base_url; ?>login"
                                    target="_blank"><?php echo $base_url; ?>login</a></p>
                            <p><b>Remember:</b></p>
                            <ul class="list-unstyled">
                                <li>Administrators needs to login at <a href="<?php echo $base_url; ?>login"
                                                                        target="_blank"><?php echo $base_url; ?>
                                        login</a></li>
                            </ul>
                            <hr/>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<!--main content end-->
<script src="../assets/plugins/install/jquery-2.2.4.min.js"></script>
<script src="../assets/plugins/install/app.js"></script>
<script src="../assets/plugins/install/jquery.validate.min.js"></script>
<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $('#finish').on('click', function () {
            var ubtn = $(this);
            ubtn.html('Please wait...');
            ubtn.addClass('disabled');

        });
    });
</script>
<script>
    $(function () {
		 $(".select_box").select2({});
        setTimeout(function () {
            $('.sql-debug-alert').slideUp();
        }, 3000);
    });
</script>
<script>
    $(function () {
        $("#database").validate({
            rules: {
                hostname: "required",
                database: "required",
                db_username: "required"
            },

            // Specify the validation error messages
            messages: {
                hostname: "Please enter your hostname usually localhost",
                database: "Please specify your database name",
                db_username: "Please specify your database username"
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#verify").validate({
            rules: {
                envato_username: "required",
                support_email: "required",
                purchase_code: "required"
            },

            // Specify the validation error messages
            messages: {
                envato_username: "We need your envato username to verify The purchase",
                support_email: "We need your valid email to Support you",
                purchase_code: "Enter your envato purchase code here"
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#complete").validate({
            rules: {
                admin_username: "required",
                admin_fullname: "required",
                admin_pass: "required",
                admin_email: {
                    required: true,
                    email: true
                },
                company_name: "required",
                company_email: {
                    required: true,
                    email: true
                },
            },

            // Specify the validation error messages
            messages: {
                admin_username: "Please enter admin username",
                admin_fullname: "Set your admin full name",
                admin_pass: "Set your admin password",
                admin_email: "Set admin email address",
                company_name: "Set your company name",
                company_email: "Enter your company email address e.g info@domain.com",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    });
</script>
</body>
</html>
