<?php

namespace App\Console\Commands;

use Exception;

use App\Interfaces\Services\AutoImportBlogPostsServiceInterface;
use Illuminate\Console\Command;
use App\Services\AutoImportBlogPostsService;


class AutoImportBlogPostsCommand extends Command
{
    /**
     * The signature of the console command.
     */
    public const COMMAND_SIGNATURE = 'posts:import';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::COMMAND_SIGNATURE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a command to auto import users blog posts from third party API\'s.';

    /**
     * BlogPostRepository instance.
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

        if (!($autoImportPostsService instanceof AutoImportBlogPostsServiceInterface)) {
            throw new Exception(
                sprintf(
                    "The %s must be an instance of %s.",
                    AutoImportBlogPostsService::class,
                    AutoImportBlogPostsServiceInterface::class
                )
            );
        }

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
