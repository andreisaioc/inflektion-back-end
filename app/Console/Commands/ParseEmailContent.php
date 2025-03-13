<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SuccessfulEmail;
use App\Services\EmailParserService;

class ParseEmailContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $emailParserService;
    protected $signature = 'app:parse-email-content {--output}'; // Add an option for output



    public function __construct(EmailParserService $emailParserService)
    {
        parent::__construct();
        $this->emailParserService = $emailParserService;
    }
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses raw email content into plain text and saves it in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$emails = SuccessfulEmail::inRandomOrder()->limit(2)->get();
        $emails = SuccessfulEmail::whereNull('raw_text')->get();

        foreach ($emails as $email) {
            // Strip HTML and keep only text with printable characters
            $plainText = strip_tags($email->email);            
            $plainText = $this->emailParserService->parseEmailContent($email->email);
            
            $email->update(['raw_text' => $plainText]);

            // Output to stdout if the --output flag is present
            if ($this->option('output')) {
                $this->line("Email ID: {$email->id}");
                $this->line($plainText);
                $this->line(str_repeat('-', 40)); // Divider for clarity
            }
        }

        $this->info("Successfully parsed " . count($emails) . " emails.");
    }
}
