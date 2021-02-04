<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportLotrTcgCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:lotr-tcg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import LOTR TCG Card Set';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
