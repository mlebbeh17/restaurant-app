<?php

namespace App\Jobs;

use App\Mail\NewMerchantOrderMail;
use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmailJob implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ingredients;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ingredients) 
    {
        $this->ingredients = $ingredients;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() 
    {
        $ingredients = Ingredient::with('merchant')->whereIn('id', $this->ingredients)->get();

        $ingredients->each(function ($ingredient) 
        {
            if (!$ingredient->merchant_notified && ($ingredient->quantity < ($ingredient->last_shipment / 2))) {
                Mail::to($ingredient->merchant->email)->send(new \App\Mail\NewMerchantOrderMail($ingredient->merchant->name, $ingredient->name));
                $ingredient->merchant_notified = true;
                $ingredient->save();
            }
        });
    }
}
