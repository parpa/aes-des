<?php
$privateKey = "1234567812345678";
$iv     = $privateKey;  // 和ios代码对应，向量同key
$data   = "Test String: i am a word slod.";
 
//加密
$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $privateKey, $data, MCRYPT_MODE_CBC, $iv);
$data = base64_encode($encrypted);
echo($data);
echo "\n";
 
//解密
// $encryptedData = base64_decode($data);
$encryptedData = base64_decode("cTLpQrCYCpE1vAeamZD0C/6GxCyHUiQWvBJPz1XZoJsE4opss4PShf2t6vFvNgcEK5JOVDk0dEdtTSkW/E3MIJYbZhNBO31eKjdi2MSCVuXEhyWzEkmwv+qQMH8yoO+6uXOnWkkdYEzjRNZztfrkivqbUBVXSjvzjLAuFYSckNI1aoHB/O/9lN0QAQvsjM6t+A4gMhUN36xxvTU7cY76U5SQrsCQ2cOcwbr0ahPKT+J9eAMUm2rYANqXYwsdqOPSVePaM3pjPKaMjr4Lv12Ytb03XM9yqsgseJQfFpjDUfHWqDN/9lPk76XzTfJnuyC84rjI0KU4xAcNHH/AF+o+lGVN+xvlhafy78yfOAStANE=");
$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $privateKey, $encryptedData, MCRYPT_MODE_CBC, $iv);
echo($decrypted);