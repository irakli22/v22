<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = [
        'product_id',
        'category_id',
        'description',
        'color',
        'screen_size',
        'storage_capacity',
        'camera_resolution',
        'battery_capacity',
        'operating_system',
        'processor',
        'ram',
        'display_type',
        'refresh_rate',
        'body_material',
        'water_resistant',
        'wireless_charging',
        'front_camera_resolution',
        'connectivity',
        'sim_type',
        'fingerprint_sensor',
        'weight',
        'audio_jack',
        'bluetooth_version',
        'nfc',
        'gps',
        'usb_type',
    ];
}
