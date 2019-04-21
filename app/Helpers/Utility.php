<?php namespace app\Helpers;

/**
 * Loans - Utilities Functions Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Holyday;

class Utility
{
    /**
     * [Format Currency to Nearest Thousands such as Kilos, Millions, Billions, and Trillions]
     * @param  [Float] $num [value to convert]
     * @return [String]     [Formated number]
     */
    public static function thousandSuffix($num)
    {
        if ($num<999) {
            return $num;
        }
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('K', 'M', 'B', 'T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    /**
     * [price description]
     * @param  [float or array] $arg [it could be float or an array, if its array you can put
     *         'amount' to display,'discount' that it already has, 'thousandSuffix' if you wanna use that format ]
     *         if you use 'discount' the return is gonna be something like that 'The final value is USD 7.50 (after a 25% discount)'
     *         this function works with config('app.payment_method') then there could be Points or Currency
     * @return [String]      [Formated number or explaint of discount]
     */
    public static function showPrice($arg)
    {
        $options = ['amount'=>'','discount'=>0, 'thousandSuffix'=>1];
        if (is_array($arg)) {
            $options = $arg + $options;
            if (isset($options['price'])) {
                $options['amount']=$options['price'];
            }
        } else {
            $options['amount']=$arg;
        }

        setlocale(LC_MONETARY, config('app.lc_monetary'));
        $format='%i';
        if ($options['discount']) {
            $format= str_replace('##', $options['discount'], trans('product.globals.price_after_discount')) ;
        }
        return self::money_format($format, $options['amount']);

    }
    /**
     * [active description]
     * @param  string $route [Route to compare ]
     * @param  string $active [class]
     * @return [string]       [description]
     */
    public static function active($route, $active = 'active')
    {
        return parse_url(\Request::url(), PHP_URL_PATH) == $route  ? $active : '';
    }

    /**
     * codeMasked
     * It is able to generate a mask for any string passed through it
     * @param  [string] $code is the var to be masked
     * @param  [integer] $lenght is the mask lenght
     * @param  [char]  $char is the character passed to build the string
     * @return string masked
     */
    public static function codeMasked($code, $prefix = '', $lenght = 5, $char = '0')
    {
        $mask = '';
        for ($i=strlen($code); $i < $lenght; $i++) {
            $mask .= $char;
        }

        return $prefix.$mask.$code;
    }

    /**
     * emulate money format if the function is not defined in the O.S.
     */
    public static function money_format($format, $number)
    {
        #checking if money_format exists
        if (function_exists('money_format')) {
            return money_format($format, $number);
        }
        #starting emulation
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
                  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                               $match[1] : ' ',
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                               $match[0] : '+',
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value  *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                            ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                            $csuffix;
            } else {
                $currency = '';
            }
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                     $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                         STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }

    public static function setMessage($data = [])
    {
        $options = [
            'messageTitle' => trans('globals.error_alert_title'),
            'messageIcon' => 'glyphicon glyphicon-remove-circle',
            'message' => trans('validation.error_default')
        ];

        $data = $data + $options;

        \Session::forget(['messageTitle', 'message', 'messageClass', 'messageIcon']);
        \Session::save();

        foreach ($data as $key => $value) {
           \Session::put($key, $value);
        }
        \Session::save();
    }

    public static function getValDate($date, &$holyday_id)
    {
        $date = strtotime($date);
        $next = $date;
        $holyday = Holyday::where('holyday', date('Y-m-d', $date))->first();

        if ($holyday || date('D', $date) == 'Sun') {
            $next = strtotime("+1 day", $date);
            $holyday_id = ($holyday) ? $holyday->id : 0;
        } else {
            $holyday_id = 0;
        }

        return date('Y-m-d', $next);
    }

    public static function myExplode($string, $needle = '|')
    {
        $array = explode($needle, $string);
        return count($array) > 0 ? array_filter(array_map('trim', $array), 'strlen') : [];
    }

    public static function numberFormat($num, $inserting = true)
    {
        if ($inserting) {

            $num = str_replace('.', '', $num);
            $num = str_replace(',', '.', $num);

        } else {

            $num = + $num;
            $aux = explode('.', $num);

            if (isset($aux[1]) && strlen($aux[1]) == 2) {

                $num = number_format($num, 2, ',', '.');

            }elseif (isset($aux[1]) && strlen($aux[1]) < 2) {

                $num = number_format($num, 1, ',', '.');

            }elseif (empty($aux[1])) {

                $num = number_format($num, 0, ',', '.');

            }

        }

        return $num;
    }
}
