<?php

namespace Goszowski\VendorMinify;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class VendorCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendor:cleanup {dir=vendor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup vendor directory.';

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
        $this->info("Cleaning dir: $vendorDir");

        $rules = Config::get('laravel-vendor-cleanup.rules');

        $filesystem = new Filesystem();

        foreach($rules as $packageDir => $rule){
            if(!file_exists($vendorDir . '/' . $packageDir)){
                continue;
            }
            $patterns = explode(' ', $rule);
            foreach($patterns as $pattern){
                try{
                    $finder = new Finder();
                    $finder->ignoreDotFiles(false)->name($pattern)->in($vendorDir . '/' . $packageDir);

                    // we can't directly iterate over $finder if it lists dirs we're deleting
                    $files = iterator_to_array($finder);

                    /** @var \SplFileInfo $file */
                    foreach($files as $file){
                        if($file->isDir()){
                            $this->info('Removing directory: ' . $file);
                            $filesystem->deleteDirectory($file);
                        }elseif($file->isFile()){
                            $this->info('Removing file:      ' . $file);
                            $filesystem->delete($file);
                        }
                    }
                }catch(\Exception $e){
                    $this->error("Could not parse $packageDir ($pattern): ".$e->getMessage());
                }
            }
        }
    }
}
