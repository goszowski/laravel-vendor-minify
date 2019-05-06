<?php

namespace Goszowski\VendorMinify;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class VendorCleanupCommand extends Command
{
    /**
     * The standard rules to cleanups
     *
     * @var string
     */
    protected $patterns = [
        'README*',
        'readme*',
        'CHANGELOG*',
        'ChangeLog*',
        'CHANGES*',
        'changelog*',
        'FAQ*',
        'CONTRIBUTING*',
        'HISTORY*',
        'UPGRADING*',
        'UPGRADE*',
        'upgrading.md',
        'package*',
        'demo',
        'example',
        'examples',
        'doc',
        'docs',
        'LICENSE*',
        'CONDUCT*',
        '.gitignore',
        '.gitattributes',
        'Doxyfile',
        'CODE_OF_CONDUCT*',
        'RELICENSED*',
        'ISSUE_TEMPLATE*',
        '.travis.yml',
        '.scrutinizer.yml',
        'phpunit.xml*',
        'phpunit.php',
        'test',
        'tests',
        'Tests',
    ];

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
        $finder = new Finder();

        $vendorFolders = $finder->directories()->depth('== 0')->in($vendorDir . '*/*');

        foreach($vendorFolders as $package)
        {
            $pathDirs = explode('/', $package->getPath());
            $vendorPackage = end($pathDirs) . '/' . $package->getBasename();

            $this->line('<fg=white;bg=black>Searching files for </><fg=red>Red' . $vendorPackage . '</><fg=white;bg=black>...</>');

            $patterns = $this->patterns;
            if(isset($rules[$vendorPackage]))
            {
                $patterns = array_merge($patterns, $rules[$vendorPackage]);
            }
            
            foreach($this->patterns as $pattern){
                try{
                    $finder = new Finder();
                    $finder->ignoreDotFiles(false)->name($pattern)->in($vendorDir . '/' . $vendorPackage);

                    // we can't directly iterate over $finder if it lists dirs we're deleting
                    $files = iterator_to_array($finder);

                    /** @var \SplFileInfo $file */
                    foreach($files as $file){
                        if($file->isDir()){
                            $this->line('<fg=white;bg=black>Removing directory: </>' . $file);
                            $filesystem->deleteDirectory($file);
                        }elseif($file->isFile()){
                            $this->line('<fg=white;bg=black>Removing file:      </>' . $file);
                            $filesystem->delete($file);
                        }
                    }
                }catch(\Exception $e){
                    $this->error("Could not parse $vendorPackage ($pattern): ".$e->getMessage());
                }
            }
        }
    }
}
