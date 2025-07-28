<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Course;

class SitemapController extends Controller
{
    public function generate()
    {
        $sitemap = Sitemap::create();

        $sitemap->add(Url::create(route('courses.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0));

        Course::all()->each(function (Course $course) use ($sitemap) {
            $sitemap->add(Url::create(route('terrace.courses.show', $course))
                ->setLastModificationDate($course->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.9));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return 'Sitemap generated successfully!';
    }
}
