<?php

namespace App\Console\Commands;

use App\Mail\Subscribers;
use App\Models\Subscribe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Mail to subscribers.';

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
     * @return int
     */
    public function handle()
    {
        //ask for website
        $website = $this->ask('Which website ?');
        // fetch users
        $subscribers = Subscribe::where('website_name', $website)->get();

        if (count($subscribers) > 0 ) {
            //ask for title
            $title = $this->ask('Post Title ?');
            //ask for descripttion
            $description = $this->ask('Post Description ?');

            $details = [
                'title' => $title,
                'description' => $description,
            ];

            foreach($subscribers as $subscriber){
                Mail::to($subscriber)->send(new Subscribers($details));
            }


        }

    }
}
