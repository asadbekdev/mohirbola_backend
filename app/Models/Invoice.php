<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @property int $parent_id
 * @property int $children_id
 * @property int $course_id
 * @property boolean $bought
 */
class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'parent_id',
        'children_id',
        'course_id',
        'bought',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

//    /**
//     * Get the user's first name.
//     *
//     * @return Attribute
//     */
//    protected function createdAt(): Attribute
//    {
//        return Attribute::make(
//            get: fn ($value) => $value->format('Y-m-d H:i:s'),
//        );
//    }
}
