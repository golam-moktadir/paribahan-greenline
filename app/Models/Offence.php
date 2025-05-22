<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offence extends Model
{
    use SoftDeletes;

    public const OFFENCE_TYPES = [
        'pending' => 'Pending',
        'review' => 'Review',
        'action' => 'Action',
    ];

    protected $fillable = [
        'driver_id',
        'offence_type',
        'occurrence_date',
        'description',
        'complainant_name',
        'complainant_phone',
    ];

    protected $casts = [
        'occurrence_date' => 'date:Y-m-d',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at',
        'occurrence_date',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function attachments()
    {
        return $this->hasMany(OffenceAttachment::class);
    }

    public static function getOffenceTypes(): array
    {
        return array_keys(self::OFFENCE_TYPES);
    }

    public static function getOffenceTypeLabels(): array
    {
        return self::OFFENCE_TYPES;
    }


    /**
     * Validate offence type before saving.
     *
     * @param string|null $value
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setOffenceTypeAttribute(?string $value): void
    {
        if ($value && !array_key_exists($value, self::OFFENCE_TYPES)) {
            throw new \InvalidArgumentException("Invalid offence type: {$value}");
        }
        $this->attributes['offence_type'] = $value;
    }


    /**
     * Get the display label for the offence type.
     *
     * @return string
     */
    public function getOffenceTypeLabelAttribute(): string
    {
        return self::OFFENCE_TYPES[$this->offence_type] ?? 'Unknown';
    }
}
