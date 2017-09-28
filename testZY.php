<?php
//中原银行加解密方法
$post_data = [
    'cust_name' => 'xxx',                              //姓名
    'id_typ' => '20',
    'id_no' => 'xxx',                                  //身份证号
    'loan_typ' => 'X201801857',
    'loan_prom' => 'X20180185701209',
    'reserve_mobile' => '',
    'register_mobile' => '',
    'trade_code' => 'ZYXF004'
];
$result = reqt_zhongyuan($post_data);                    //调用
print_r($result);

function reqt_zhongyuan($params) {
    $serno = '12' . '12' . date('Ymd', time()) . '51' . date('His', time());
    $trade_code = $params['trade_code'];
    unset($params['trade_code']);
    $post_data = [
        'request' => [
            'head' => [
                'trade_code' => $trade_code,
                'serno' => $serno,
                'sys_flag' => '12',
                'trade_type' => '',
                'trade_date' => date('Y-m-d', time()),
                'trade_time' => date('H:i:s', time()),
                'channel_no' => '12',
                'ret_flag' => '',
                'ret_msg' => '',
                'ext1' => '',
                'ext2' => ''
            ],
            'body' => $params
        ]
    ];
    $post_xml = arr2xml($post_data);
    $aes_key = getRandKey(22) . '==';
    $info = base64_encode(rijndael_encrypt($post_xml, base64_decode($aes_key)));
    $encrypt_key = 'rsa_zhongyuan_51gjj_public_key_dev.pem';                                       //中原银行的公钥存放地址
    $encrypted_data = rsa_encrypt(base64_decode($aes_key), $encrypt_key);                        //rsa公钥加密
    $key = base64_encode($encrypted_data);

    $url = 'http://54.222.145.239:20002/web/InvokeTradeServer';                                //中原银行地址
    $header = [
        CURLOPT_HTTPHEADER => [
            'Content-Type:application/x-www-form-urlencoded'
        ],
    ];
    $req_data = [
        'serno' => $serno,
        'key' => $key,
        'info' => $info
    ];
    $json_data = urlencode(json_encode($req_data, JSON_UNESCAPED_UNICODE));
    $req = http_build_query(['arg' => $json_data]);

    $resp = send_request($url, $req, $header);

    $resp = $resp['response'];
    $res = json_decode(str_replace("\n", "", $resp), true);

    if ($res['trade_flag'] == 'AAAAAAA' && isset($res['info']) && isset($res['key'])) {
        $res_info = $res['info'];
        $res_key = $res['key'];
        $pubkey = file_get_contents($encrypt_key);                            //中原银行的公钥
        $pi_key = openssl_pkey_get_public($pubkey);
        openssl_public_decrypt(base64_decode($res_key), $aeskey, $pi_key);     //rsa公钥解密
        $base64info = base64_decode($res_info);
        $result = rijndael_decrypt($base64info, $aeskey);
        $result = xml2arr($result);
        return $result;
    } else {
        return false;
    }
}

function getRandKey($len = 62) {//产生一定位数的随机密码，最长62位
    $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = str_shuffle($str);
    return substr($str, 0, $len);
}

function arr2xml($arr) {//数组转xml
    $xml = '';
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arr2xml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    return $xml;
}

function rijndael_encrypt($input, $key) {//aes加密
    $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
    $input = pkcs5_pad($input, $size);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $data;
}

function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

function rijndael_decrypt($sStr, $sKey) {//aes解密
    $decrypted = @mcrypt_decrypt(
        MCRYPT_RIJNDAEL_128,
        $sKey,
        $sStr,
        MCRYPT_MODE_ECB
    );

    $dec_s = strlen($decrypted);
    $padding = ord($decrypted[$dec_s - 1]);
    $decrypted = substr($decrypted, 0, -$padding);
    return $decrypted;
}

function rsa_encrypt($rawData, $publickey_file) {//rsa加密
    $pubkey = file_get_contents($publickey_file);
    if (empty($pubkey)) {
        throw new Exception('empty key', 0);
    }
    $res = openssl_get_publickey($pubkey);
    $keyInfo = openssl_pkey_get_details($res);
    $step = $keyInfo['bits'] / 8 - 11;
    $encryptedList = array();
    for ($i = 0, $len = strlen($rawData); $i < $len; $i += $step) {
        $data = substr($rawData, $i, $step);
        $encrypted = '';
        openssl_public_encrypt($data, $encrypted, $res);
        $encryptedList[] = ($encrypted);
    }
    openssl_free_key($res);
    $data = join('', $encryptedList);
    return $data;
}

function send_request($url, $params = [], $options = []) {//发送请求
    $default_options = [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_URL => $url,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'curl',
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    ];

    $options = array_replace($default_options, $options);
    if (stripos($url, 'https://') === 0) {
        $options[CURLOPT_SSL_VERIFYHOST] = 2;
    }

    if (empty($options[CURLOPT_POST])) {
        if(!empty($params)){
            $options[CURLOPT_URL] .= '?' . http_build_query($params);
        }
        unset($options[CURLOPT_POST], $options[CURLOPT_POSTFIELDS]);
    }

    $ch = curl_init();
    foreach ($options as $k => $v) {
        curl_setopt($ch, $k, $v);
    }
    $start_time = microtime(true);
    $response = curl_exec($ch);
    $end_time = microtime(true);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error_number = curl_errno($ch);
    curl_close($ch);
    return [
        'response' => $response,
        'status_code' => $status_code,
        'error_number' => $error_number,
        'cost_time' => $end_time - $start_time,
    ];
}

function xml2arr($contents) {//xml转数组
    if (!$contents) return array();
    if (!function_exists('xml_parser_create')) {
        return array();
    }
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values) return;

    $xml_array = array();

    $current = &$xml_array;
    $repeated_tag_index = array();
    foreach ($xml_values as $data) {
        unset($value);
        $type = $level = $tag = '';
        extract($data);
        $result = '';

        if (isset($value)) {
            $result = $value;
        }

        if ($type == "open") {//The starting of the tag '<tag>'
            $parent[$level - 1] = &$current;
            if (!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = &$current[$tag];
            } else { //There was another element with the same tag name
                if (isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag], $result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = &$current[$tag][$last_item_index];
            }
        } elseif ($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if (!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
            } else { //If taken, put all things inside a list(array)
                if (isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag], $result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                }
            }
        } elseif ($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level - 1];
        }
    }
    return ($xml_array);
}

?>
