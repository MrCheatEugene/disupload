<?php 
session_start();
ob_start();
set_time_limit(300);

$sql = ['127.0.0.1', 'vdsupload', 'fwfHoCMlgU64JVJd', 'vdsupload']; // DB credentials: IP, User, password, database
$webhook = 'https://discord.com/api/webhooks/'; // set your webhook here 
$mysqli = new mysqli($sql[0],$sql[1],$sql[2],$sql[3]);

function auth($pass){
    global $mysqli;
    return password_verify($pass, $mysqli->query('SELECT * FROM auth')->fetch_array()[0]);
}

function partupload($file, $id){
    global $webhook;
    $fn = '/tmp/tmp_'.bin2hex(random_bytes(16));
    file_put_contents($fn ,$file);
    $message = "File ID ".$id;
    $pn = $id.'_'.bin2hex(random_bytes(2)).'_.bin';

    $json_data = [
        "content" => $message,
        "tts" => "false",
        "file" => curl_file_create($fn, 'text/plain', $pn)
    ];
    
    $curl = curl_init( $webhook );
    curl_setopt($curl, CURLOPT_TIMEOUT, 300);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    
    $returned_data = curl_exec( $curl );
    curl_close( $curl );
    unlink($fn);
    return json_decode($returned_data, true)['attachments'][0]['url'];
}

function upload($file, $public =0){
    global $mysqli;
    $ogf = $file;
    $file = file_get_contents($file['tmp_name']);
    $id = bin2hex(random_bytes(8));
    $parts = [];
    if(strlen($file)>24500000){
        foreach (explode("\r\n", chunk_split(base64_encode($file), 24500000)) as $key => $value) {
            array_push($parts, partupload(base64_decode($value), $id));
        }
    }else{
        array_push($parts, partupload($file, $id));
    }

    $mysqli->query("INSERT INTO files (`id`, `name`, `chunks`, `public`) VALUES ('".$mysqli->escape_string($id)."', '".$mysqli->escape_string(basename($ogf['name']))."', '".$mysqli->escape_string(json_encode($parts))."', '".strval(intval($public))."' )");
    return $id;
}

function get_file($file_id){
    global $mysqli;
    return $mysqli->query("SELECT * FROM files WHERE id = '".$mysqli->escape_string($file_id)."'")->fetch_array();
}