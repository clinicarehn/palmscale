<?php

namespace App\Orchid\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Field;

class DateRangeFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Rango de Fecha';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['start_date', 'end_date'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $query): Builder
    {
        $startDate = $this->request->get('start_date') ?? Carbon::now()->subMonth()->format('Y-m-d');
        $endDate = $this->request->get('end_date') ?? Carbon::now()->format('Y-m-d');

        return $query->whereBetween(DB::raw('DATE(production_date)'), [$startDate, $endDate]);
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            DateTimer::make('start_date')
                ->title('Fecha de Inicio')
                ->allowInput()
                ->format('Y-m-d'),
            DateTimer::make('end_date')
                ->title('Fecha de Fin')
                ->allowInput()
                ->format('Y-m-d'),
        ];
    }
}
