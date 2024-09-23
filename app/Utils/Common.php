<?php

namespace App\Utils;
use Carbon\Carbon;
use DateTime;

class Common
{

    public static function J_trim($arrInput)
    {
        if (!is_array($arrInput)) {
            $arrInput = trim($arrInput);
        } else {
            foreach ($arrInput as $key => $value) {
                $arrInput[$key] = self::J_trim($value);
            }
        }
        return $arrInput;
    }

    public static function J_filterEntities($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                if (empty($value)) {
                    $input[$key] = $value;
                } else {
                    $input[$key] = self::J_filterEntities($value);
                }
            }

            return $input;
        }

        return str_replace(
            array("<", ">", "\'", "\"", "'", '"'), array("&lt;", "&gt;", "&#39;", "&quot;", "&#39;", "&quot;"), trim(strip_tags($input))
        );
    }

    public static function J_array_map($strFunction, $arrInput)
    {
        if (!is_array($arrInput)) {
            $arrInput = call_user_func($strFunction, $arrInput);
        } else {
            foreach ($arrInput as $key => $value) {
                $arrInput[$key] = self::J_array_map($strFunction, $value);
            }
        }
        return $arrInput;
    }

    public static function J_array_merge($arrDefault, $arrData)
    {
        return array_merge($arrDefault, $arrData);
    }

    public static function J_generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        $iLenght = strlen($characters) - 1;
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, $iLenght)];
        }
        return $string;
    }

    public static function J_filterData($input)
    {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = self::J_filterData($value);
            }

            return $input;
        }

        $input = trim(strip_tags($input));
        return str_replace(array('/', '<', '?', '>', '\\'), '', $input);
    }

    public static function J_getImage($string)
    {
        $arrImages = array();
        preg_match_all('/(img|src)\=(\"|\')[^\"\'\>]+/i', $string, $media);
        if (!empty($media[0])) {
            $data = preg_replace('/(img|src)(\"|\'|\=\"|\=\')(.*)/i', "$3", $media[0]);
            if (!empty($data)) {
                foreach ($data as $url) {
                    $info = pathinfo($url);
                    if (isset($info['extension']) && in_array($info['extension'], array('jpg', 'jpeg', 'gif', 'png'))) {
                        array_push($arrImages, $url);
                    }
                }
            }
        }
        return $arrImages;
    }

    public static function J_removeXss($string)
    {
        $string = preg_replace('#&(?!\#[0-9]+;)#si', '&amp;', $string);
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        $string = str_replace("\"", "&quot;", $string);
        static $preg_find = array('#javascript#i', '#vbscript#i');
        static $preg_replace = array('java script', 'vb script');
        return preg_replace($preg_find, $preg_replace, $string);
    }

    public static function J_removeXss2($string)
    {
        $string = preg_replace('#&(?!\#[0-9]+;)#si', '&amp;', $string);
        $string = str_replace("\"", "&quot;", $string);
        $string = strip_tags($string, '<a><b><strong><em>');
        static $preg_find = array('#javascript#i', '#vbscript#i');
        static $preg_replace = array('java script', 'vb script');
        return preg_replace($preg_find, $preg_replace, $string);
    }

    public static function J_generateOption($arrArray, $valueSelect = FALSE)
    {
        $strHtml = '';
        foreach ($arrArray as $key => $value) {
            $strSelect = ($valueSelect === $key) ? ' selected = "selected"' : '';
            $strHtml .= '<option value="' . $key . '"' . $strSelect . '>' . $value . '</option>';
        }
        return $strHtml;
    }

    public static function J_generateOptionDB($arrArray, $strValue, $strKey, $valueSelect = FALSE)
    {
        $strHtml = '';
        foreach ($arrArray as $keyArray => $valueArray) {
            $value = $valueArray[$strValue];
            $key = $valueArray[$strKey];

            $strSelect = ($valueSelect === $key) ? ' selected = "selected"' : '';
            $strHtml .= '<option value="' . $key . '"' . $strSelect . '>' . $value . '</option>';
        }
        return $strHtml;
    }

    public static function J_generateExtendContent($arrArray)
    {
        $strHtml = '';
        if (!empty($arrArray)) {
            foreach ($arrArray as $arrContentExtend) {
                if ($arrContentExtend['field_type'] == 'checkbox') {
                    $strCheck = (isset($arrContentExtend['content_data']) && $arrContentExtend['content_data'] == 'yes') ? ' checked="checked"' : '';
                    $strHtml .= '
                    <p>
                        <label>' . $arrContentExtend['field_title'] . ' </label>
                        <input type="checkbox" name="' . $arrContentExtend['field_name'] . '" value=""' . $strCheck . ' />
                    </p>';
                } elseif ($arrContentExtend['field_type'] == 'text') {
                    $strValue = isset($arrContentExtend['content_data']) ? $arrContentExtend['content_data'] : '';
                    $strHtml .= '
                    <p>
                        <label>' . $arrContentExtend['field_title'] . ': </label>
                        <input type="text" name="' . $arrContentExtend['field_name'] . '" class="w600" value="' . $strValue . '" />
                    </p>';
                }
            }
        }
        return $strHtml;
    }

    public static function urlencode_rfc3986($input)
    {
        if (is_array($input)) {
            return array_map(array('Core_Util', 'urlencode_rfc3986'), $input);
        } else if (is_scalar($input)) {
            return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
        } else {
            return '';
        }
    }

    public static function urldecode_rfc3986($string)
    {
        return urldecode($string);
    }

    public static function J_substr($strInput, $intLenght, $strEnchar = '...', $bolCath = true)
    {
        ini_set('iconv.internal_encoding', 'utf-8');
        $strReturn = $strInput;
        if ($strInput) {
            if (iconv_strlen($strInput) > $intLenght) {
                if ($bolCath) {
                    $arrTemp = explode(' ', $strInput);
                    $strReturn = '';
                    foreach ($arrTemp as $strString) {
                        if (iconv_strlen($strReturn . $strEnchar) > $intLenght) {
                            break;
                        }
                        $strReturn .= $strString . ' ';
                    }
                    return trim($strReturn) . $strEnchar;
                } else {
                    return iconv_substr($strInput, 0, $intLenght) . $strEnchar;
                }
            }
        }
        return $strReturn;
    }

    public static function J_getRealIpAddr()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }
        return $ip;
    }

    public static function J_getCurUrl()
    {
        $pageURL = 'http';
        $_SERVER["HTTPS"] = isset($_SERVER["HTTPS"]) ? $_SERVER["HTTPS"] : null;
        $_SERVER["SERVER_PORT"] = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : null;
        $_SERVER["SERVER_NAME"] = isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : null;
        $_SERVER["REQUEST_URI"] = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : null;
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    public static function J_getDomainByUri($strUri)
    {
        $strDomain = null;
        if ($strUri) {
            $parse = parse_url($strUri);
            $strDomain = isset($parse['host']) ? $parse['host'] : null;
        }
        return $strDomain;
    }

    public static function J_getHostByUri($strUri)
    {
        $strHost = null;
        if ($strUri) {
            $parse = parse_url($strUri);
            $strDomain = isset($parse['host']) ? $parse['host'] : null;
            $strScheme = isset($parse['scheme']) ? $parse['scheme'] : null;
            $strHost = ($strScheme) ? $strScheme : '';
            $strHost .= ($strDomain) ? '://' . $strDomain : '';
        }
        return $strHost;
    }

    public static function J_encodeCardID($str = null)
    {
        $temp1 = strlen($str) - 3;
        $temp2 = substr($str, $temp1);
        $temp3 = '';
        for ($i = 0; $i < $temp1; $i++) {
            $temp3 .= '*';
        }
        return $str == null ? 'N/a' : $temp3 . $temp2;
    }

    public static function J_encodeEmail($str = null)
    {
        if ($str == null) {
            return 'N/a';
        }

        $temp = strpos($str, '@');

        $domain = substr($str, $temp);

        $temp2 = strpos($domain, '.');

        $temp3 = '';
        for ($i = 0; $i < $temp2; $i++) {
            $temp3 .= '*';
        }
        $domain = '@' . $temp3 . substr($domain, $temp2);
        $name = self::J_encodeCardID(substr($str, 0, $temp));

        return $name . $domain;
    }

    public static function J_formatNumber($str = null)
    {
        $str = (int)$str;
        return $str ? number_format($str, 0, '.', ',') : $str;
    }

    public static function J_SpecialCharacter($str = null)
    {
        $str = str_replace(\App\Utils\Filter::$arrCharFrom, \App\Utils\Filter::$arrCharEnd, $str);
        return !preg_match('/^([a-zA-Z0-9\s\-\_]+)$/', $str);
    }

    public static function J_SpecialCharacterAddress($str = null)
    {
        $str = str_replace(\App\Utils\Filter::$arrCharFrom, \App\Utils\Filter::$arrCharEnd, $str);
        return !preg_match('/^([a-zA-Z0-9\s\-\,\_\/\.]+)$/', $str);
    }

    public static function get_pagin_path($params = array())
    {
        $sRequest = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
        $aTemp = explode('?', $sRequest);
        $sUri = count($aTemp) ? current($aTemp) : $aTemp;
        unset($params['page']);

        if (empty(array_filter($params))) {
            return config('app.url') . $sUri;
        }
        return config('app.url') . $sUri . '?' . http_build_query($params);
    }
    public static function GenerateTimeSlots($hour, $period)
    {
        $timeSlots = [];
        $formattedHour = intval($hour);

        // Kiểm tra nếu giờ có giá trị hợp lệ
        if ($formattedHour < 1 || $formattedHour > 12) {
            return "Invalid hour. Please provide an hour between 1 and 12.";
        }

        // Kiểm tra nếu khoảng thời gian hợp lệ
        $period = strtoupper($period);
        if ($period !== 'AM' && $period !== 'PM') {
            return "Invalid period. Please provide either 'AM' or 'PM'.";
        }

        for ($minute = 0; $minute < 60; $minute += 20) {
            $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
            $timeSlots[] = "{$formattedHour}:{$formattedMinute} {$period}";
        }

        return $timeSlots;
    }

    public static function ArraysFrameTime($times = [])
    {
        $groupedTimes = [];

   
            foreach ($times as $time) {
                $date =  Carbon::parse( $time['date'])->format('d-m-Y');
                $userId = $time['user_id'];

                if (!isset($groupedTimes[$userId][$date])) {
                    $groupedTimes[$userId][$date] = [
                        'id' => $time['id'],
                        'user_id' => $userId,
                        'date' => $date,
                        'duration' => []
                    ];
                }

                $groupedTimes[$userId][$date]['duration'][] = [
                    'key' => $time['key'],
                    'time' => $time['time']
                ];
            }

            $result = [];
            foreach ($groupedTimes as $dates) {
                foreach ($dates as $entry) {
                    $result[] = $entry;
                }
            }

        return $result;
    }

    public static function generateAvatarInitials($fullName) {
        $words = explode(' ', trim($fullName));
        $initials = '';

        if (count($words) > 0) {
            // Lấy chữ cái đầu của từ đầu tiên
            $initials .= strtoupper(substr($words[0], 0, 1));
        }

        if (count($words) > 1) {
            // Lấy chữ cái đầu của từ cuối cùng
            $initials .= strtoupper(substr(end($words), 0, 1));
        } elseif (count($words) == 1) {
            // Nếu chỉ có một từ, lấy hai chữ cái đầu của từ đó
            $initials .= strtoupper(substr($words[0], 1, 1));
        }

        return $initials;
    }


}
