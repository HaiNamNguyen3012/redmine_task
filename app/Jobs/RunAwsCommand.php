<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RunAwsCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cmd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $result = shell_exec($this->cmd);
            $result = json_decode($result);
            if (!@$result->MessageId) Log::emergency("Aws Email Error: $result");;
        } catch (\Exception $e) {
            Log::emergency("AWS Email error");
        }
    }
}
