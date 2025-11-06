<?php
// Lokasi: app/Console/Commands/GenerateSitemap.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post; // Import Model Post kita

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        // Path tempat menyimpan file sitemap.xml di dalam public_html
        $sitemapPath = public_path('sitemap.xml');

        $sitemap = Sitemap::create();

        // 1. Menambahkan halaman statis menggunakan named routes
        $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('services'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create(route('gallery'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('blog'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('contact'))->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));
        $sitemap->add(Url::create(route('booking'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));
        
        // 2. Menambahkan halaman dinamis dari Postingan Blog
        $posts = Post::whereNotNull('published_at')->latest('published_at')->get();
        foreach ($posts as $post) {
            $sitemap->add(
                Url::create(route('post.detail', $post))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }

        // Menyimpan file sitemap
        $sitemap->writeToFile($sitemapPath);

        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
