<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Institution;
use App\Models\Program;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $navBrowseTopics = Cache::remember('nav_browse_topics', 3600, function () {
                return Category::withCount(['courses' => function ($q) {
                    $q->where('is_published', true);
                }])
                    ->whereNull('parent_id')
                    ->orderByDesc('courses_count')
                    ->take(7)
                    ->get()
                    ->map(function ($cat) {
                        return [
                            'name' => $cat->name,
                            'slug' => $cat->slug,
                        ];
                    })
                    ->toArray();
            });

            $navCertificatePrograms = Cache::remember('nav_certificate_programs', 3600, function () {
                return Program::where('is_published', true)
                    ->where('type', 'professional_certificate')
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get()
                    ->map(function ($prog) {
                        return [
                            'name' => $prog->title,
                            'slug' => $prog->slug,
                        ];
                    })
                    ->toArray();
            });

            $navDegreePrograms = Cache::remember('nav_degree_programs', 3600, function () {
                return Program::where('is_published', true)
                    ->whereIn('type', ['degree', 'micromasters', 'microbachelors'])
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get()
                    ->map(function ($prog) {
                        return [
                            'name' => $prog->title,
                            'slug' => $prog->slug,
                        ];
                    })
                    ->toArray();
            });

            $navPartnerInstitutions = Cache::remember('nav_partner_institutions', 3600, function () {
                return Institution::withCount(['courses' => function ($q) {
                    $q->where('is_published', true);
                }])
                    ->orderByDesc('courses_count')
                    ->take(6)
                    ->get()
                    ->map(function ($inst) {
                        return [
                            'name' => $inst->name,
                            'slug' => $inst->slug,
                        ];
                    })
                    ->toArray();
            });

            $navBeginnerTopics = [
                ['name' => 'Python untuk Pemula', 'query' => 'python pemula'],
                ['name' => 'Excel untuk Pemula', 'query' => 'excel pemula'],
                ['name' => 'Web Dev Dasar', 'query' => 'web dasar'],
            ];

            $navPopularCertificateSearches = [
                ['name' => 'AI dalam 3 bulan', 'query' => 'ai 3 bulan'],
                ['name' => 'Data Analyst Bootcamp', 'query' => 'data analyst bootcamp'],
                ['name' => 'Fullstack Laravel', 'query' => 'fullstack laravel'],
                ['name' => 'UI/UX dengan Figma', 'query' => 'ui ux figma'],
            ];

            $navCareerPaths = [
                ['name' => 'Software Engineer', 'query' => 'software engineer'],
                ['name' => 'Data Scientist', 'query' => 'data scientist'],
                ['name' => 'UI/UX Designer', 'query' => 'ui ux designer'],
                ['name' => 'Cybersecurity Analyst', 'query' => 'cybersecurity analyst'],
            ];

            $view->with([
                'navBrowseTopics' => $navBrowseTopics,
                'navCertificatePrograms' => $navCertificatePrograms,
                'navDegreePrograms' => $navDegreePrograms,
                'navPartnerInstitutions' => $navPartnerInstitutions,
                'navBeginnerTopics' => $navBeginnerTopics,
                'navPopularCertificateSearches' => $navPopularCertificateSearches,
                'navCareerPaths' => $navCareerPaths,
            ]);
        });
    }
}
