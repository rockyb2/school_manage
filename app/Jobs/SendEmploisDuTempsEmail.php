<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmploisDuTempsMail;
use App\Models\Enseignant;

class SendEmploisDuTempsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $enseignant;
    protected $emploisDuTemps;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Enseignant $enseignant, $emploisDuTemps)
    {
        $this->enseignant = $enseignant;
        $this->emploisDuTemps = $emploisDuTemps;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->enseignant->email)->send(new EmploisDuTempsMail($this->emploisDuTemps, $this->enseignant));
    }
}
