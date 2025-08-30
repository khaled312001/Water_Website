<?php

return [
    'year' => 'سنة|:count سنوات',
    'y' => 'سنة|:count سنوات',
    'month' => 'شهر|:count أشهر',
    'm' => 'شهر|:count أشهر',
    'week' => 'أسبوع|:count أسابيع',
    'w' => 'أسبوع|:count أسابيع',
    'day' => 'يوم|:count أيام',
    'd' => 'يوم|:count أيام',
    'hour' => 'ساعة|:count ساعات',
    'h' => 'ساعة|:count ساعات',
    'minute' => 'دقيقة|:count دقائق',
    'min' => 'دقيقة|:count دقائق',
    'second' => 'ثانية|:count ثوان',
    's' => 'ثانية|:count ثوان',
    'ago' => 'منذ :time',
    'from_now' => 'من الآن :time',
    'after' => 'بعد :time',
    'before' => 'قبل :time',
    'diff_now' => 'الآن',
    'diff_yesterday' => 'أمس',
    'diff_tomorrow' => 'غداً',
    'diff_before_yesterday' => 'قبل أمس',
    'diff_after_tomorrow' => 'بعد غد',
    'period_recurrences' => 'مرة واحدة|:count مرات',
    'period_interval' => 'كل :interval',
    'period_start_date' => 'من :date',
    'period_end_date' => 'إلى :date',
    'formats' => [
        'LT' => 'HH:mm',
        'LTS' => 'HH:mm:ss',
        'L' => 'DD/MM/YYYY',
        'LL' => 'D MMMM YYYY',
        'LLL' => 'D MMMM YYYY HH:mm',
        'LLLL' => 'dddd D MMMM YYYY HH:mm',
    ],
    'calendar' => [
        'sameDay' => '[اليوم عند الساعة] LT',
        'nextDay' => '[غداً عند الساعة] LT',
        'nextWeek' => 'dddd [عند الساعة] LT',
        'lastDay' => '[أمس عند الساعة] LT',
        'lastWeek' => 'dddd [عند الساعة] LT',
        'sameElse' => 'L',
    ],
    'ordinal' => function ($number, $period) {
        switch ($period) {
            case 'M':
            case 'd':
            case 'Q':
                return $number;
            case 'D':
                return $number;
            default:
                return $number;
        }
    },
    'months' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
    'months_short' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
    'weekdays' => ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
    'weekdays_short' => ['أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
    'weekdays_min' => ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],
    'list' => [', ', ' و '],
    'meridiem' => ['ص', 'م'],
]; 