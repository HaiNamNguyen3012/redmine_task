<?php

namespace App\Jobs;

use App\Services\User\PlanService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class planPaymentFail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $var;
    private $planService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($var)
    {
        $this->var = $var;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PlanService $planService)
    {
        $planService->paymentFail($this->var);
    }
}
