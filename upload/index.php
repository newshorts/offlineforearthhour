<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../lib/facebook-php-sdk/src/facebook.php';

// personal
$config = array(
    'appId'  => '317973431658835',
    'secret' => '48b84c2c44f6310765681e1e51a6aabd',
    'fileUpload' => true
);

if(strpos($_SERVER['SERVER_NAME'], "localhost") === false) {    
    // ofeh
    $config = array(
        'appId'  => '442992315782142',
        'secret' => '8a53612e97e70d7096628e1212829cd1',
        'fileUpload' => true
    );
}

$facebook = new Facebook($config);
$access_token = $facebook->getAccessToken();
$user = $facebook->getUser();

if(isset($_GET['upload']) && $_GET['upload'] == true) {
    
    $path_to_image = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'facebook_share.jpg';

    $facebook->setFileUploadSupport(true);
    $args = array('message' => 'Photo Caption');
    $args['image'] = '@' . realpath($path_to_image);

    $data = $facebook->api('/me/photos', 'post', $args);

    $arr = array(response => true, data => $data);

//    header('Cache-Control: no-cache, must-revalidate');
//    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    echo json_encode($arr);
    
} else {
    
    var_dump($config);
    var_dump($facebook);
    var_dump($_SERVER);
}
?>
