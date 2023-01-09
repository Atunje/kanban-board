<?php

namespace App\Models;

use Illuminate\Support\Fluent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Card
 *
 * @method static \Database\Factories\CardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newQuery()
 * @method static \Illuminate\Database\Query\Builder|Card onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Card query()
 * @method static \Illuminate\Database\Query\Builder|Card withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Card withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $position
 * @property int $column_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static Builder|Card whereColumnId($value)
 * @method static Builder|Card whereCreatedAt($value)
 * @method static Builder|Card whereDeletedAt($value)
 * @method static Builder|Card whereDescription($value)
 * @method static Builder|Card whereId($value)
 * @method static Builder|Card wherePosition($value)
 * @method static Builder|Card whereTitle($value)
 * @method static Builder|Card whereUpdatedAt($value)
 */
class Card extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var Card|Builder
     */
    private Card|Builder $query;

    /**
     * @var Fluent
     */
    private Fluent $filterParams;

    protected $table = "cards";

    protected $fillable = [
        'title',
        'description',
        'column_id',
        'position'
    ];

    /**
     * @param Fluent $filterParams
     * @return Collection
     */
    public static function getAll(Fluent $filterParams): Collection
    {
        return (new self())->setInstanceParams($filterParams)
                    ->addDateToQuery()
                    ->query->get();
    }

    private function addDateToQuery(): self
    {
        if ($this->filterParams->__isset('date')) {
            $this->query->whereDate('created_at', strval($this->filterParams->get('date')));
        }

        return $this;
    }

    /**
     * initializes query and set filterParams on the current instance
     *
     * @param Fluent $filterParams
     * @return self
     */
    private function setInstanceParams(Fluent $filterParams): self
    {
        $this->filterParams = $filterParams;

        if ($filterParams->__isset('status')) {
            $this->query = ! $filterParams->get('status') ? self::onlyTrashed() : self::query();
        } else {
            $this->query = self::withTrashed();
        }

        return $this;
    }

    public function shiftUp(): bool
    {
        $this->position -= 1;
        return $this->save();
    }

    public function shiftDown(): bool
    {
        $this->position += 1;
        return $this->save();
    }

    public function setInPosition(int $position, Column $column = null): bool
    {
        $this->column_id = $column == null ? $this->column_id : $column->id;
        $this->position = $position;
        return $this->save();
    }
}
