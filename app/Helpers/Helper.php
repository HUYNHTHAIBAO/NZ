<?php

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($string, $encoding = 'utf8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
}

if (!function_exists('mb_ucwords')) {
    function mb_ucwords($text)
    {
        $text = mb_strtolower($text);
        $upper_words = array();
        $words = explode(" ", $text);

        foreach ($words as $word) {
            $upper_words[] = mb_ucfirst($word);
        }
        return implode(" ", $upper_words);
    }
}

if (!function_exists('timeToHumanDate')) {
    function timeToHumanDate($time, $options = array('type' => 'vn', 'title' => '', 'second' => 'giây', 'seconds' => 'giây', 'minute' => 'phút', 'minutes' => 'phút', 'hour' => 'giờ', 'hours' => 'giờ', 'date' => 'ngày', 'dates' => 'ngày', 'week' => 'tuần', 'weeks' => 'tuần', 'month' => 'tháng', 'months' => 'tháng', 'year' => 'năm', 'years' => 'năm'))
    {
        //Get today
        $today = time();

        //Get start time of today
        $start = mktime(0, 0, 1, date('m', $today), date('d', $today), date('Y', $today));

        //Get end time of today
        $end = mktime(23, 59, 59, date('m', $today), date('d', $today), date('Y', $today));

        //Get String Week
        $strWeekCurrent = date('W', $today) . date('Y', $today);

        //Get String Week Input
        $strWeekInput = date('W', $time) . date('Y', $time);

        //Lower string type
        $options['type'] = strtolower($options['type']);

        //Check timestamp
        if (($start <= $time) && ($time <= $end)) {
            $options['title'] = 'Hôm nay, lúc ' . date('H:i', $time);
        } elseif ((($start - 24 * 3600 + 1) <= $time) && ($time < ($start - 1))) {
            $options['title'] = 'Hôm qua, lúc ' . date('H:i', $time);
        } elseif ($strWeekCurrent == $strWeekInput) {
            //Get week number
            $weekNumber = date('N', $time);

            //Check number to add string
            switch ($weekNumber) {
                case 1:
                    $options['title'] = 'Thứ hai, lúc ';
                    break;
                case 2:
                    $options['title'] = 'Thứ ba, lúc ';
                    break;
                case 3:
                    $options['title'] = 'Thứ tư, lúc ';
                    break;
                case 4:
                    $options['title'] = 'Thứ năm, lúc ';
                    break;
                case 5:
                    $options['title'] = 'Thứ sáu, lúc ';
                    break;
                case 6:
                    $options['title'] = 'Thứ bảy, lúc ';
                    break;
                case 7:
                    $options['title'] = 'Chủ nhật, lúc ';
                    break;
                default:
                    break;
            }

            //Add hours
            $options['title'] .= date('H:i', $time);
        } else {
            $options['title'] = date('d/m', $time) . ' lúc ' . date('H:i', $time);
        }

        //Return data
        return $options['title'];
    }
}

if (!function_exists('product_link')) {
    function product_link($slug, $id, $product_type_id)
    {
        $view_data = \View::getShared();
        $all_category = $view_data['all_category'];

        return $product_type_id?$all_category[$product_type_id]['link'] . '/' . $slug:'';
    }
}

if(!function_exists('format_date_custom')) {
    function format_date_custom($date, $format = 'd-m-Y') {
        return \Carbon\Carbon::parse($date)->format($format);
    }
};


if (!function_exists('format_number_vnd')) {
    function format_number_vnd($number, $decimals = 0, $dec_point = '', $thousands_sep = '.') {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}
