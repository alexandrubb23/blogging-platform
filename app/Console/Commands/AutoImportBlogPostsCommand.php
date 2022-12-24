<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoImportBlogPostsService;

class AutoImportBlogPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a command to import users blog posts.';

    /**
     * BlogPostService instance.
     * 
     * @var AutoImportBlogPostsService
     */
    private AutoImportBlogPostsService $autoImportPostsService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AutoImportBlogPostsService $autoImportPostsService)
    {
        parent::__construct();

        $this->autoImportPostsService = $autoImportPostsService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $this->autoImportPostsService->import();
    }
}
