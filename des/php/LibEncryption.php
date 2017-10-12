<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* Encryption
*/
class LibEncryption
{
    
    function __construct()
    {
        # code...
    }
            
    /**
     * 加密
     * 加密顺序
     * 第一步：gzdeflate 9级别 压缩
     * 第二步：MCRYPT_DES, MCRYPT_MODE_CBC 
     * 第三步：base64_encode
     * 第四步：rawurlencode 通信用
     * http://www.cnblogs.com/pengxl/p/3967040.html 
     * 数据会先进行填充处理
     * @param string $str 要处理的字符串
     * @param string $key 加密Key，为8个字节长度
     * @return string
     */
    public function encode($str, $key) {
        # gzip
        $str = rawurlencode($str);
        # 为 CBC 模式创建随机的初始向量
        $iv_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        # pkcs5 pad string
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $str = $this->pkcs5Pad($str, $size);
        # 创建密文
        $str = mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_CBC, $iv);
        # 将初始向量附加在密文之前，以供解密时使用
        $str = $iv . $str;
        // 压缩
        $str = gzdeflate($str, 9);
        // base64
        $str = base64_encode($str);
        // 编码
        $str = rawurlencode($str);
        return $str;
    }
 
    /**
     * 解密
     * http://www.cnblogs.com/pengxl/p/3967040.html
     * @param string $str 要处理的字符串
     * @param string $key 解密Key，为8个字节长度
     * @return string
     */
    public function decode($str, $key) {
        $str = rawurldecode($str);
        $str = base64_decode($str);
        // 解压
        $str = @gzinflate($str);
        if (!$str) {
            return $str;
        }        
        # 为 CBC 模式获取向量
        $iv_size = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $iv = substr($str, 0, $iv_size);
        $str = substr($str, $iv_size);
        # 解密
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_CBC, $iv);
        # 移除 pkcs5 pad string
        $str = $this->pkcs5Unpad($str);
        // 解码
        $str = rawurldecode($str);
        return $str;
    }
 
    /**
     * 数据填充
     *
     * @param string $text 被填充的数据
     * @param int $blocksize 要填充到的长度
     * @return void
     * @author jinguoqiang
     */
    function pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 
    /**
     * 移除数据填充
     *
     * @param string $text 要被移除填充的数据
     * @return void
     * @author jinguoqiang
     */
    function pkcs5Unpad($text) {
        $pad = ord($text {strlen($text) - 1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, - 1 * $pad);
    }
    
}