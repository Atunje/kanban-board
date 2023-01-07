<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Column
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\ColumnFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Column newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Column newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Column query()
 * @method static \Illuminate\Database\Query\Builder|Column onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Column whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Column whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Column whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Column whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Column whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Column withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Column withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 */
class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "columns";

    protected $fillable = [
        'title',
    ];

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
