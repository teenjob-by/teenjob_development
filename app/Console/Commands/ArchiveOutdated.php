<?php

namespace App\Console\Commands;

use App\Event;
use App\Offer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class ArchiveOutdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archives all outdated events and offers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $offers = Offer::all();
        $events = Event::all();

        foreach ($offers as $offer)
        {
            if((Date::now() > $offer->getTimeBeforeArchiving()) || ($offer->status == 1)) {
                $offer->status = 2;
                $offer->save();
            }
        }

        foreach ($events as $event)
        {
            if((Date::now() > $event->getTimeBeforeArchiving()) || ($event->status == 1)) {
                $event->status = 5;
                $event->save();
            }
        }
    }
}
