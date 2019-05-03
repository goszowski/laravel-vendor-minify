<?php

namespace Goszowski\VendorMinify;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class VendorMinifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:minify {dir=vendor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify vendor directory.';

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
        $vendorDir = realpath($this->argument('dir'));
        $this->info("Minifing dir: $vendorDir");

        $filesystem = new Filesystem();
        $files = $filesystem->allFiles($vendorDir);

        foreach($files as $file)
        {
            if($file->isFile() and $file->getExtension() == 'php')
            {
                File::put($file->getRealPath(), php_strip_whitespace($file->getRealPath()));
                $this->info('Minifing ' . $file->getRealPath());
            }
        }
        
    }
}
