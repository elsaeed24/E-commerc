<?php

namespace App\Jobs;

use App\Mail\NewProductsNewsletter;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewProductEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = Product::whereDate('created_at','>=', Carbon::now()->subDays(7))
                        ->latest()
                        ->limit(10)
                        ->get();

        $user = User::where('type','=', 'user')->get();

        Mail::to( $user)->send(new NewProductsNewsletter($products));
    }


}
