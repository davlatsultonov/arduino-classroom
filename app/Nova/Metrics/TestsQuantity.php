<?php

namespace App\Nova\Metrics;

use App\Models\Test;
use App\Models\TestAnswer;
use \App\Models\TestQuestion;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class TestsQuantity extends Partition
{
    public $width = '1/4';


    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $count1 = Test::count();
        $count2 = TestQuestion::count();
        $count3 = TestAnswer::count();

        return $this->result([
            'tests' => $count1,
            'questions' => $count2,
            'answers' => $count3,
        ])->label(fn ($value) => match ($value) {
            null => 'None',
            default => ucfirst($value)
        });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'tests-quantity';
    }
}
