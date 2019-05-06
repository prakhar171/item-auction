<?php


    $base_url="10.1.18.33:3000/api/";
    $access_token="zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";

    function callAPI($method, $url, $data){
        $curl = curl_init();

        switch ($method){
          case "POST":
             curl_setopt($curl, CURLOPT_POST, 1);
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
             break;
          case "PUT":
             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
             if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                       
             break;
          default:
             if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'APIKEY: 111111111111111111111',
          'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'functions/PHPMailer/src/Exception.php';
require 'functions/PHPMailer/src/PHPMailer.php';
require 'functions/PHPMailer/src/SMTP.php';


function SendMail($subject,$email,$message){



    $to_id1 = $email;
    
    $mail1 = new PHPMailer();
    $mail1->isSMTP();
    $mail1->Host = 'smtp.gmail.com';
    $mail1->Port = 587;
    // $mail1->SMTPSecure = 'tls';
    $mail1->SMTPAuth = true;
    $mail1->Username = 'decent.auction@gmail.com';
    $mail1->Password = 'mahavirjhawar';
    $mail1->addAddress($to_id1);
    $mail1->Subject = $subject;
    $mail1->msgHTML($message);
    $mail1->SetFrom('decent.auction@gmail.com','Decent Auction');
    // $mail1->SMTPDebug = 2;
    if (!$mail1->send()) {
    $error = "Mailer Error: " . $mail1->ErrorInfo;
    echo '<p id="para">'.$error.'</p>';
    return $error;
    }
    else {
    echo '<p id="para">Message sent!</p>';
    return "Sent";
    }


}

function encryptAES($plaintext, $password) {
    $method = "AES-256-CBC";
    $key = hash('sha256', $password, true);
    $iv = openssl_random_pseudo_bytes(16);

    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hash = hash_hmac('sha256', $ciphertext, $key, true);

    return $iv . $hash . $ciphertext;
}

function decryptAES($ivHashCiphertext, $password) {
    $method = "AES-256-CBC";
    $iv = substr($ivHashCiphertext, 0, 16);
    $hash = substr($ivHashCiphertext, 16, 32);
    $ciphertext = substr($ivHashCiphertext, 48);
    $key = hash('sha256', $password, true);

    if (hash_hmac('sha256', $ciphertext, $key, true) !== $hash) return null;

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);


}

$configargs = array(
  "config" => "F:/xampp/php/extras/openssl/openssl.cnf",
  'private_key_bits'=> 2048,
  'default_md' => "sha256",
);
// Create the private and public key
$res = openssl_pkey_new($configargs);


// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey,NULL,$configargs);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];


function encryptRSA($data)
    {
        global $pubKey;
        $enc = openssl_public_encrypt($data, $encrypted, $pubKey);
        $b64_enc = base64_encode($encrypted);

        return $b64_enc;
    }

function decryptRSA($data)
    {
        global $privKey;
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privKey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }

function caesarEncode( $message, $key ){
    $plaintext = strtolower( $message );
    $ciphertext = "";
    $ascii_a = ord( 'a' );
    $ascii_z = ord( 'z' );
    while( strlen( $plaintext ) ){
        $char = ord( $plaintext );
        if( $char >= $ascii_a && $char <= $ascii_z ){
            $char = ( ( $key + $char - $ascii_a ) % 26 ) + $ascii_a;
        }
        $plaintext = substr( $plaintext, 1 );
        $ciphertext .= chr( $char );
    }
    return $ciphertext;
}


?>