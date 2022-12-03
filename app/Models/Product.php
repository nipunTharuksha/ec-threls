<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Freshbitsweb\LaravelCartManager\Traits\Cartable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use Cartable;

    protected $guarded = [];

    protected $casts = ['price' => MoneyCast::class];


    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

}
