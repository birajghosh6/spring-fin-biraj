<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateQR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $address;

    /**
     * Create a new job instance.
     */
    public function __construct(string $address)
    {
        $this->address =  $address;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image = file_get_contents(
            'https://api.qrserver.com/v1/create-qr-code/?' . 
            'size=150x150' . 
            '&data=' . urlencode($this->address) . 
            '&format=jpeg'
        );
        file_put_contents('./qr/' . (string) Str::uuid() . '.jpeg', $image);
    }
}
