<?php

if (!function_exists('get_openssl_version_number')) {

    /**
     * Parse OPENSSL_VERSION_NUMBER constant to
     * use in version_compare function
     * @param null $openssl_version_number
     * @param boolean $patch_as_number [description]
     * @return false|string [type]                          [description]
     */
    function get_openssl_version_number($openssl_version_number = null, bool $patch_as_number = false): bool|string
    {
        if (is_null($openssl_version_number)) $openssl_version_number = OPENSSL_VERSION_NUMBER;
        $openssl_numeric_identifier = str_pad((string)dechex($openssl_version_number), 8, '0', STR_PAD_LEFT);

        $openssl_version_parsed = array();
        $preg = '/(?<major>[[:xdigit:]])(?<minor>[[:xdigit:]][[:xdigit:]])(?<fix>[[:xdigit:]][[:xdigit:]])';
        $preg .= '(?<patch>[[:xdigit:]][[:xdigit:]])(?<type>[[:xdigit:]])/';
        preg_match_all($preg, $openssl_numeric_identifier, $openssl_version_parsed);
        $openssl_version = false;
        if (!empty($openssl_version_parsed)) {
            $alphabet = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h', 9 => 'i', 10 => 'j', 11 => 'k',
                12 => 'l', 13 => 'm', 14 => 'n', 15 => 'o', 16 => 'p', 17 => 'q', 18 => 'r', 19 => 's', 20 => 't', 21 => 'u',
                22 => 'v', 23 => 'w', 24 => 'x', 25 => 'y', 26 => 'z');
            $openssl_version = intval($openssl_version_parsed['major'][0]) . '.';
            $openssl_version .= intval($openssl_version_parsed['minor'][0]) . '.';
            $openssl_version .= intval($openssl_version_parsed['fix'][0]);
            $patch_level_dec = hexdec($openssl_version_parsed['patch'][0]);
            if (!$patch_as_number && array_key_exists($patch_level_dec, $alphabet)) {
                $openssl_version .= $alphabet[$patch_level_dec]; // ideal for text comparison
            } else {
                $openssl_version .= '.' . $patch_level_dec; // ideal for version_compare
            }
        }
        return $openssl_version;
    }
}
