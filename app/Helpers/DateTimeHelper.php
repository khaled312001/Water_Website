<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    /**
     * تحويل التاريخ إلى توقيت مكة المكرمة
     */
    public static function toMakkahTime($dateTime)
    {
        if (!$dateTime) {
            return null;
        }

        $carbon = Carbon::parse($dateTime);
        return $carbon->setTimezone('Asia/Riyadh');
    }

    /**
     * عرض التاريخ بتنسيق عربي
     */
    public static function formatArabicDate($dateTime, $format = 'Y-m-d H:i')
    {
        if (!$dateTime) {
            return 'غير محدد';
        }

        $carbon = self::toMakkahTime($dateTime);
        
        // تحويل الأرقام إلى العربية
        $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        $formatted = $carbon->format($format);
        return str_replace($englishNumbers, $arabicNumbers, $formatted);
    }

    /**
     * عرض التاريخ بتنسيق "منذ"
     */
    public static function timeAgo($dateTime)
    {
        if (!$dateTime) {
            return 'غير محدد';
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->diffForHumans();
    }

    /**
     * عرض التاريخ بتنسيق كامل بالعربية
     */
    public static function fullArabicDate($dateTime)
    {
        if (!$dateTime) {
            return 'غير محدد';
        }

        $carbon = self::toMakkahTime($dateTime);
        
        $months = [
            'January' => 'يناير',
            'February' => 'فبراير',
            'March' => 'مارس',
            'April' => 'أبريل',
            'May' => 'مايو',
            'June' => 'يونيو',
            'July' => 'يوليو',
            'August' => 'أغسطس',
            'September' => 'سبتمبر',
            'October' => 'أكتوبر',
            'November' => 'نوفمبر',
            'December' => 'ديسمبر'
        ];

        $days = [
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد'
        ];

        $dayName = $days[$carbon->format('l')];
        $monthName = $months[$carbon->format('F')];
        $day = $carbon->format('j');
        $year = $carbon->format('Y');
        $time = $carbon->format('H:i');

        return "{$dayName} {$day} {$monthName} {$year} الساعة {$time}";
    }

    /**
     * الحصول على التاريخ الحالي بتوقيت مكة
     */
    public static function now()
    {
        return Carbon::now('Asia/Riyadh');
    }

    /**
     * تحويل التاريخ إلى timestamp
     */
    public static function toTimestamp($dateTime)
    {
        if (!$dateTime) {
            return null;
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->timestamp;
    }

    /**
     * التحقق من أن التاريخ في الماضي
     */
    public static function isPast($dateTime)
    {
        if (!$dateTime) {
            return false;
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->isPast();
    }

    /**
     * التحقق من أن التاريخ في المستقبل
     */
    public static function isFuture($dateTime)
    {
        if (!$dateTime) {
            return false;
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->isFuture();
    }

    /**
     * التحقق من أن التاريخ اليوم
     */
    public static function isToday($dateTime)
    {
        if (!$dateTime) {
            return false;
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->isToday();
    }

    /**
     * التحقق من أن التاريخ أمس
     */
    public static function isYesterday($dateTime)
    {
        if (!$dateTime) {
            return false;
        }

        $carbon = self::toMakkahTime($dateTime);
        return $carbon->isYesterday();
    }
} 