<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    public $fillable = [
        'hotel_id', 'hotel_name', 'prefecture_id', 'file_path', 'created_at', 'updated_at'
    ];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * Search hotel by hotel name
     *
     * @param string $hotelName
     * @return array
     */
    static public function getHotelListByName(string $hotelName): array
    {
        $result = Hotel::where('hotel_name', '=', $hotelName)
            ->with('prefecture')
            ->get()
            ->toArray();

        return $result;
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
