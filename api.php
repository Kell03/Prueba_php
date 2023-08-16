<?php
$cantidad = $_POST['cantidad'];
$numeroautorizacion = substr( $_POST['telefono'], -4);
$nombre = $_POST['nombre'];
$codigo;
 
$ch = curl_init();
$url = 'http://149.202.12.81/rapidprest_i2/public/api/maq1/generarqr/prueba1';

curl_setopt($ch, CURLOPT_URL, $url);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if(curl_errno($ch)){
    $error_msg = curl_error($ch);
    echo  'Error al conectarse al api';
}
else{

$params = array(
    'cantidad' => $cantidad,
    'numeroautorizacion' => $numeroautorizacion
    
);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

$token = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';
$headers = array(
             'Authorization: Bearer ' . $token,
    'Content-Type: application/x-www-form-urlencoded'
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


$response = curl_exec($ch);

if ($response === false) {
    echo 'Error en la solicitud: ' . curl_error($ch);
} else {

    // Decodificar la respuesta JSON en un array asociativo
    $data = json_decode($response, true);

    // Verificar si la decodificación fue exitosa
    if ($data === null) {
        echo 'Error al decodificar la respuesta JSON';
    } else {
        if(isset($_POST) && !empty($_POST)) {

        $codigo = $data['data']['codigo'];    

        include('phpqrcode/qrlib.php'); 
        $codesDir = "images/";   
        $codeFile = date('d-m-Y-h-i-s').'.png';
        QRcode::png($codigo, $codesDir.$codeFile, 0 , 5); 
        echo '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
        }

        else{

            echo '<img class="img-thumbnail"  />';
        }

    }
}
    curl_close($ch);
}
?>