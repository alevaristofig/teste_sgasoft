<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Mail;

Artisan::command('relatorio', function () {
   
    $result = DB::table('pedidos')
        ->select('status', DB::raw('COUNT(*) as total'))
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('status')
        ->get();

    $msg = "";

    foreach($result as $r) {
        $msg.= "Foram feitos ".$r->total. " de pedidos com status ".$r->status."<br>";        
    }
    
     Mail::raw($msg, function ($message) {
        $message->from('figalexandre@gmail.com', 'Alexandre');
        $message->sender('alevaristofig@gmail.com', 'Alexandre');
        $message->to('alevaristofig@gmail.com', 'Alexandre');
});
})->purpose('Relatorio');

app(Schedule::class)->command('relatorio')->dailyAt('08:00');
