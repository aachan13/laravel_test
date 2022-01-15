<?php

namespace App\Jobs;

use App\Models\Kasbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMasalKasbonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kasbon;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Kasbon $kasbon)
    {
        $this->kasbon = $kasbon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->kasbon->tanggal_disetujui = now();
        $this->kasbon->save();
    }
}
