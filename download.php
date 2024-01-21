<?php 
include 'functions.php';
if(isset($_POST['id'])){
    $bin = '';
    $file = get_file($_POST['id']);
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.htmlspecialchars($file['name']).'"');
    foreach (json_decode($file['chunks'],true) as $key => $value) {
        $bin.=file_get_contents($value);
    }
    echo $bin;
}
?>