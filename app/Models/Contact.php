<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';
    const STATUS_CLOSED = 'closed';

    // Subject options
    public static function getSubjectOptions()
    {
        return [
            'general' => 'استفسار عام',
            'order' => 'مشكلة في الطلب',
            'delivery' => 'مشكلة في التوصيل',
            'quality' => 'مشكلة في الجودة',
            'suggestion' => 'اقتراح',
            'complaint' => 'شكوى',
            'partnership' => 'شراكة تجارية',
            'technical' => 'مشكلة تقنية',
        ];
    }

    public function getSubjectTextAttribute()
    {
        $options = self::getSubjectOptions();
        return $options[$this->subject] ?? $this->subject;
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_READ => 'تم القراءة',
            self::STATUS_REPLIED => 'تم الرد',
            self::STATUS_CLOSED => 'مغلق',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'badge bg-warning',
            self::STATUS_READ => 'badge bg-info',
            self::STATUS_REPLIED => 'badge bg-success',
            self::STATUS_CLOSED => 'badge bg-secondary',
        ];

        return $badges[$this->status] ?? 'badge bg-secondary';
    }

    // Scope for pending messages
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_READ]);
    }
}
