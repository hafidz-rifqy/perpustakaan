<?php
require_once __DIR__ . '/env_parser.php';

function sendFonnteOTP($target, $otp_code) {
    $token = $_ENV['FONNTE_TOKEN'] ?? '';
    if(empty($token) || $token == 'YOUR_FONNTE_API_KEY_HERE'){
        // Untuk tujuan testing jika Fonnte belum di-setup, kita pura-pura sukses
        // Jangan di-block aplikasinya
        return ["status" => true, "detail" => "Simulated success. Token is empty."];
    }
    
    $message = "*PERPUSTAKAAN HAFIDZ*\n\nKode OTP Anda adalah: *$otp_code*\n\nKode ini bersifat RAHSIA. Jangan berikan kode ini kepada siapapun.";
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
        'target' => $target,
        'message' => $message,
      ),
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $token
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if ($err) {
        return ["status" => false, "detail" => $err];
    } else {
        $res = json_decode($response, true);
        return $res;
    }
}
?>
