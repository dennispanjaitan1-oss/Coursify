<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    const PER_PAGE = 12;

    public function index(Request $request)
    {
        $search     = $request->get('search', '');
        $typeFilter = $request->get('type', 'all');

        $query = Institution::withCount([
                'courses as courses_count',
                'courses as students_count' => function ($q) {
                    $q->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
                      ->select(DB::raw('count(enrollments.id)'));
                },
            ])
            ->addSelect([
                'avg_rating' => DB::table('reviews')
                    ->selectRaw('ROUND(AVG(reviews.rating), 1)')
                    ->join('courses', 'courses.id', '=', 'reviews.course_id')
                    ->whereColumn('courses.institution_id', 'institutions.id')
                    ->whereNull('courses.deleted_at'),
            ]);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($typeFilter && $typeFilter !== 'all') {
            $query->where(function ($q) use ($typeFilter) {
                switch ($typeFilter) {
                    case 'universitas':
                        $q->where('name', 'like', '%universitas%')->orWhere('name', 'like', '%university%');
                        break;
                    case 'teknologi':
                        $q->where('name', 'like', '%teknologi%')->orWhere('name', 'like', '%technology%')
                          ->orWhere('name', 'like', '%teknik%')->orWhere('name', 'like', '%institute%')
                          ->orWhere('name', 'like', '%institut%');
                        break;
                    case 'bisnis':
                        $q->where('name', 'like', '%bisnis%')->orWhere('name', 'like', '%business%')
                          ->orWhere('name', 'like', '%economics%')->orWhere('name', 'like', '%ekonomi%')
                          ->orWhere('name', 'like', '%finance%')->orWhere('name', 'like', '%management%');
                        break;
                    case 'kesehatan':
                        $q->where('name', 'like', '%kesehatan%')->orWhere('name', 'like', '%health%')
                          ->orWhere('name', 'like', '%medical%')->orWhere('name', 'like', '%nursing%')
                          ->orWhere('name', 'like', '%pharmacy%');
                        break;
                    case 'lainnya':
                        $q->where('name', 'not like', '%universitas%')->where('name', 'not like', '%university%')
                          ->where('name', 'not like', '%teknologi%')->where('name', 'not like', '%technology%')
                          ->where('name', 'not like', '%institute%')->where('name', 'not like', '%bisnis%')
                          ->where('name', 'not like', '%business%')->where('name', 'not like', '%kesehatan%')
                          ->where('name', 'not like', '%health%');
                        break;
                }
            });
        }

        $paginated = $query->orderByDesc('courses_count')
                           ->paginate(self::PER_PAGE)
                           ->appends($request->query());

        $institutions = $paginated->through(function (Institution $inst) {
            return [
                'id'             => $inst->id,
                'name'           => $inst->name,
                'slug'           => $inst->slug,
                'logo_url'       => $inst->logo_url,
                'website_url'    => $inst->website_url,
                'description'    => $inst->description,
                'is_verified'    => $inst->is_verified,
                'courses_count'  => $inst->courses_count ?? 0,
                'students_count' => $this->formatNumber($inst->students_count ?? 0),
                'avg_rating'     => $inst->avg_rating ? number_format((float) $inst->avg_rating, 1) : '—',
                'type_label'     => $this->inferTypeLabel($inst->name),
                'type_key'       => $this->inferTypeKey($inst->name),
                'banner_color'   => $this->bannerColor($inst->id),
                'initials'       => $this->initials($inst->name),
            ];
        });

        $totalInstitutions = Institution::count();
        $totalCourses      = DB::table('courses')->whereNull('deleted_at')->count();
        $totalStudents     = $this->formatNumber(DB::table('enrollments')->count());

        return view('pages.universities', compact(
            'institutions', 'totalInstitutions', 'totalCourses',
            'totalStudents', 'search', 'typeFilter'
        ));
    }

    public function show(string $slug)
    {
        $institution = Institution::withCount([
                'courses as courses_count',
                'courses as students_count' => function ($q) {
                    $q->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
                      ->select(DB::raw('count(enrollments.id)'));
                },
            ])
            ->addSelect([
                'avg_rating' => DB::table('reviews')
                    ->selectRaw('ROUND(AVG(reviews.rating), 1)')
                    ->join('courses', 'courses.id', '=', 'reviews.course_id')
                    ->whereColumn('courses.institution_id', 'institutions.id')
                    ->whereNull('courses.deleted_at'),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $courses = \App\Models\Course::where('institution_id', $institution->id)
            ->where('is_published', true)
            ->with(['category'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(6)
            ->get();

        $fakerDesc = $this->fakerDescription($institution->name, $institution->id);

        return view('pages.university-detail', compact('institution', 'courses', 'fakerDesc'));
    }

    private function fakerDescription(string $name, int $id): string
    {
        $templates = [
            "{name} adalah institusi pendidikan terkemuka yang berkomitmen menghadirkan program akademik berkualitas dunia. Dengan tenaga pengajar berpengalaman dan fasilitas modern, institusi ini telah melahirkan ribuan lulusan yang berkiprah di berbagai sektor industri.",
            "Berdiri sebagai salah satu lembaga pendidikan tinggi terpercaya, {name} menawarkan kurikulum inovatif yang dirancang sesuai kebutuhan industri masa kini. Program-programnya mencakup riset terapan, kolaborasi internasional, dan pengembangan keterampilan praktis.",
            "{name} mendedikasikan diri untuk menciptakan lingkungan belajar yang inklusif dan dinamis. Menggabungkan pendekatan akademis dengan metode pembelajaran berbasis teknologi, institusi ini siap mencetak pemimpin masa depan yang adaptif dan kompeten.",
            "Sebagai institusi yang berfokus pada keunggulan akademik, {name} memiliki rekam jejak panjang dalam menghasilkan lulusan berkompeten. Jaringan alumni yang luas dan kemitraan strategis dengan industri menjadikannya pilihan utama para pelajar.",
            "{name} menjunjung tinggi nilai-nilai integritas, inovasi, dan kolaborasi. Program unggulan dirancang untuk mempersiapkan mahasiswa menghadapi tantangan global dengan bekal pengetahuan teoritis dan pengalaman praktis yang seimbang.",
        ];
        return str_replace('{name}', $name, $templates[$id % count($templates)]);
    }

    private function formatNumber(int $num): string
    {
        if ($num <= 0)    return '0';
        if ($num < 1000)  return (string) $num;
        if ($num < 10000) return number_format($num / 1000, 1) . 'K';
        return floor($num / 1000) . 'K+';
    }

    private function inferTypeLabel(string $name): string
    {
        $n = Str::lower($name);
        if (str_contains($n, 'universitas') || str_contains($n, 'university')) return 'Universitas';
        if (str_contains($n, 'teknologi') || str_contains($n, 'technology') || str_contains($n, 'institute') || str_contains($n, 'institut')) return 'Institut';
        if (str_contains($n, 'college') || str_contains($n, 'sekolah tinggi')) return 'Sekolah Tinggi';
        if (str_contains($n, 'politeknik') || str_contains($n, 'polytechnic')) return 'Politeknik';
        return 'Institusi';
    }

    private function inferTypeKey(string $name): string
    {
        $n = Str::lower($name);
        if (str_contains($n, 'universitas') || str_contains($n, 'university')) return 'universitas';
        if (str_contains($n, 'teknologi') || str_contains($n, 'technology') || str_contains($n, 'teknik') || str_contains($n, 'institute') || str_contains($n, 'institut')) return 'teknologi';
        if (str_contains($n, 'bisnis') || str_contains($n, 'business') || str_contains($n, 'economics') || str_contains($n, 'ekonomi') || str_contains($n, 'finance')) return 'bisnis';
        if (str_contains($n, 'kesehatan') || str_contains($n, 'health') || str_contains($n, 'medical') || str_contains($n, 'nursing')) return 'kesehatan';
        return 'lainnya';
    }

    private function bannerColor(int $id): string
    {
        $palettes = ['#1E3A5F','#2D4E7C','#3B5998','#1A3C5E','#2C3E50','#1B4F72','#154360','#1F618D','#21618C','#1A5276','#4A235A','#6C3483','#1B2631','#212F3D','#1C2833','#17202A'];
        return $palettes[$id % count($palettes)];
    }

    private function initials(string $name): string
    {
        $words = explode(' ', $name);
        if (count($words) === 1) return Str::upper(Str::substr($name, 0, 2));
        return Str::upper($words[0][0] . ($words[1][0] ?? ''));
    }
}