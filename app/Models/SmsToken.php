<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $phone
 * @property string $code
 * @property boolean $is_sent
 */
class SmsToken extends Model
{
    protected $table = 'sms_tokens';

    protected $fillable = ['phone', 'code', 'is_sent'];
}
