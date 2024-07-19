<?php
$installMode = isset($_POST['installmode']) ? (int) $_POST['installmode'] : 0;

// Determine upgradeability
$upgradeable = 0;
if ($installMode === 0) {
    $database_name = '';
    $database_server = 'localhost';
    $table_prefix = base_convert(mt_rand(10, 20), 10, 36) .
    substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), mt_rand(0, 33), 3) .
        '_';
} else {
    $database_name = '';

    if (is_file(EVO_CORE_PATH . 'custom/config/database/connections/default.php')) {
        $configFile = EVO_CORE_PATH . 'custom/config/database/connections/default.php';
    } else {
        $configFile = EVO_CORE_PATH . 'config/database/connections/default.php';
    }

    if (!is_file($configFile)) {
        $upgradeable = 0;
    } else {
        // Include the file so we can test its validity
        $db_config = include_once $configFile;
        $database_server = $db_config['host'];
        $database_collation = $db_config['collation'];
        $database_connection_method = $db_config['method'];
        $database_connection_charset = $db_config['charset'];
        $table_prefix = $db_config['prefix'];

        // We need to have all connection settings - but prefix may be empty so we have to ignore it
        if (isset($db_config['database'])) {
            $database_name = trim($db_config['database'], '`');
            try {
                $conn = mysqli_connect($db_config['host'], $db_config['username'], $db_config['password'], '', isset($db_config['port']) ? $db_config['port'] : null);
                $result = mysqli_select_db($conn, $database_name);
            } catch (Exception $e) {
                $conn = false;
                $result = false;
            }
            if (!$conn || !$result) {
                $upgradeable = (isset($_POST['installmode']) && $_POST['installmode'] === 'new') ? 0 : 2;
            } else {
                $upgradeable = 1;
            }
        } else {
            $upgradable = 2;
        }
    }
}

// check the database collation if not specified in the configuration
if ($upgradeable && (!isset($database_connection_charset) || empty($database_connection_charset))) {
    if (!$rs = mysqli_query($conn, "show session variables like 'collation_database'")) {
        $rs = mysqli_query($conn, "show session variables like 'collation_server'");
    }
    if ($rs && $collation = mysqli_fetch_row($rs)) {
        $database_collation = $collation[1];
    }
    if (empty($database_collation)) {
        $database_collation = 'utf8mb4_general_ci';
    }
    $database_charset = substr($database_collation, 0, strpos($database_collation, '_'));
    $database_connection_charset = $database_charset;
} else {
    $database_collation = 'utf8mb4_general_ci';
}

// determine the database connection method if not specified in the configuration
if ($upgradeable && (!isset($database_connection_method) || empty($database_connection_method))) {
    $database_connection_method = 'SET CHARACTER SET';
}

$ph['database_name'] = isset($_POST['database_name']) ? $_POST['database_name'] : $database_name;
$ph['tableprefix'] = isset($_POST['tableprefix']) ? $_POST['tableprefix'] : $table_prefix;
$ph['selected_set_character_set'] =
isset($database_connection_method) && $database_connection_method === 'SET CHARACTER SET' ? 'selected' : '';
$ph['selected_set_names'] =
isset($database_connection_method) && $database_connection_method === 'SET NAMES' ? 'selected' : '';
$ph['show#connection_method'] = (($installMode == 0) || ($installMode == 2)) ? 'block' : 'none';
$ph['database_collation'] = isset($_POST['database_collation']) ? $_POST['database_collation'] : $database_collation;
$ph['show#AUH'] = ($installMode == 0) ? 'block' : 'none';
$ph['cmsadmin'] = isset($_POST['cmsadmin']) ? $_POST['cmsadmin'] : 'admin';
$ph['cmsadminemail'] = isset($_POST['cmsadminemail']) ? $_POST['cmsadminemail'] : '';
$ph['cmspassword'] = isset($_POST['cmspassword']) ? $_POST['cmspassword'] : '';
$ph['cmspasswordconfirm'] = isset($_POST['cmspasswordconfirm']) ? $_POST['cmspasswordconfirm'] : '';
$ph['managerLangs'] = getLangs($install_language);
$ph['install_language'] = $install_language;
$ph['installMode'] = $installMode;
$ph['checkedChkagree'] = isset($_POST['chkagree']) ? 'checked' : '';
$ph['database_connection_method'] = isset($database_connection_method) ? $database_connection_method : '';
$ph['databasehost'] = isset($_POST['databasehost']) ? $_POST['databasehost'] : $database_server;
$ph['databaseloginname'] = isset($_SESSION['databaseloginname']) ? $_SESSION['databaseloginname'] : '';
$ph['databaseloginpassword'] = isset($_SESSION['databaseloginpassword']) ? $_SESSION['databaseloginpassword'] : '';
$ph['MGR_DIR'] = MGR_DIR;

$content = file_get_contents(dirname(__DIR__) . '/template/actions/connection.tpl');
$content = parse($content, $_lang, '[%', '%]');
$content = parse($content, $ph);

echo $content;
