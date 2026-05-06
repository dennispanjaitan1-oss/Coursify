<?php

namespace Database\Seeders;
 
use App\Models\Category;
use App\Models\Course;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
 
class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructors  = User::where('role', 'instructor')->get();
        $institution  = Institution::first();
        $categories   = Category::whereNull('parent_id')->get();
 
        $coursesData = [
            // ── Web Development ──────────────────────────────────────
            [
                'title'       => 'Laravel 12 untuk Pemula: Bangun Web Modern',
                'category'    => 'Web Development',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 8,
                'desc'        => 'Pelajari Laravel 12 dari nol hingga bisa membangun aplikasi web modern yang lengkap.',
                'sections'    => [
                    ['Pengenalan Laravel', ['Apa itu Laravel?', 'Instalasi & Setup', 'Struktur Folder', 'MVC Pattern']],
                    ['Routing & Controller', ['Routing Dasar', 'Route Parameters', 'Controller', 'Middleware']],
                    ['Database & Eloquent', ['Migrasi Database', 'Eloquent ORM', 'Relationships', 'Query Builder']],
                    ['Views & Blade', ['Blade Template', 'Layout & Section', 'Component', 'Form & Validasi']],
                    ['Authentication', ['Login & Register', 'Middleware Auth', 'Password Reset', 'Remember Me']],
                ],
            ],
            [
                'title'       => 'HTML, CSS & JavaScript: Dasar Web Development',
                'category'    => 'Web Development',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 4,
                'desc'        => 'Kuasai fundamental web development: HTML semantik, CSS modern, dan JavaScript ES6+.',
                'sections'    => [
                    ['Dasar HTML', ['Struktur HTML', 'Tag Semantik', 'Form & Input', 'Tabel & List']],
                    ['CSS Modern', ['Box Model', 'Flexbox', 'CSS Grid', 'Responsive Design', 'Animasi CSS']],
                    ['JavaScript ES6+', ['Variable & Tipe Data', 'Function & Arrow', 'Array Method', 'DOM Manipulation', 'Fetch API']],
                ],
            ],
            [
                'title'       => 'React.js: Bangun UI yang Interaktif',
                'category'    => 'Web Development',
                'price'       => 199000,
                'difficulty'  => 'intermediate',
                'duration'    => 6,
                'desc'        => 'Dari komponen dasar hingga state management dengan React Hooks dan Context API.',
                'sections'    => [
                    ['React Dasar', ['JSX & Komponen', 'Props & State', 'Event Handling', 'Conditional Rendering']],
                    ['React Hooks', ['useState & useEffect', 'useContext', 'Custom Hooks', 'useMemo & useCallback']],
                    ['React Router & API', ['React Router v6', 'Fetch & Axios', 'Loading States', 'Error Handling']],
                ],
            ],
 
            // ── Data Science ─────────────────────────────────────────
            [
                'title'       => 'Python untuk Data Science: Pandas & NumPy',
                'category'    => 'Data Science',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 6,
                'desc'        => 'Mulai perjalanan data science-mu dengan Python. Analisis data nyata menggunakan Pandas dan NumPy.',
                'sections'    => [
                    ['Python Dasar', ['Tipe Data Python', 'List & Dictionary', 'Function', 'OOP Python']],
                    ['NumPy', ['Array NumPy', 'Operasi Matriks', 'Broadcasting', 'Statistik Dasar']],
                    ['Pandas', ['DataFrame', 'Membaca Data', 'Cleaning Data', 'GroupBy & Aggregasi']],
                    ['Visualisasi', ['Matplotlib', 'Seaborn', 'Plot Interaktif', 'Dashboard Sederhana']],
                ],
            ],
            [
                'title'       => 'Machine Learning: Dari Teori ke Praktik',
                'category'    => 'Data Science',
                'price'       => 299000,
                'difficulty'  => 'intermediate',
                'duration'    => 10,
                'desc'        => 'Pelajari algoritma machine learning klasik dan implementasinya dengan Scikit-learn.',
                'sections'    => [
                    ['Pengenalan ML', ['Apa itu Machine Learning?', 'Jenis-jenis ML', 'Pipeline ML', 'Evaluasi Model']],
                    ['Supervised Learning', ['Linear Regression', 'Logistic Regression', 'Decision Tree', 'Random Forest', 'SVM']],
                    ['Unsupervised Learning', ['K-Means Clustering', 'PCA', 'DBSCAN', 'Anomaly Detection']],
                    ['Deep Learning Intro', ['Neural Network', 'TensorFlow Dasar', 'Keras API', 'Proyek Akhir']],
                ],
            ],
 
            // ── Artificial Intelligence ───────────────────────────────
            [
                'title'       => 'Pengenalan Kecerdasan Buatan & Etikanya',
                'category'    => 'Artificial Intelligence',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 4,
                'desc'        => 'Pahami dasar AI, sejarah, aplikasi nyata, dan isu etika yang perlu diketahui semua orang.',
                'sections'    => [
                    ['Dasar AI', ['Sejarah AI', 'Jenis-jenis AI', 'AI vs ML vs DL', 'Aplikasi AI']],
                    ['Etika AI', ['Bias dalam AI', 'AI & Privasi', 'Regulasi AI', 'AI yang Bertanggung Jawab']],
                ],
            ],
 
            // ── Cybersecurity ─────────────────────────────────────────
            [
                'title'       => 'Keamanan Web: Lindungi Aplikasimu dari Serangan',
                'category'    => 'Cybersecurity',
                'price'       => 149000,
                'difficulty'  => 'intermediate',
                'duration'    => 6,
                'desc'        => 'Pelajari OWASP Top 10, SQL Injection, XSS, CSRF, dan cara mencegahnya di aplikasi Laravel.',
                'sections'    => [
                    ['OWASP Top 10', ['Injection Attack', 'Broken Auth', 'XSS', 'IDOR', 'Security Misconfiguration']],
                    ['Keamanan Laravel', ['CSRF Protection', 'SQL Injection Prevention', 'Rate Limiting', 'Encryption']],
                    ['Praktik Terbaik', ['HTTPS & SSL', 'Security Headers', 'Input Validation', 'Logging & Monitoring']],
                ],
            ],
 
            // ── Cloud Computing ───────────────────────────────────────
            [
                'title'       => 'Cloud Computing: Fundamental AWS untuk Developer',
                'category'    => 'Cloud Computing',
                'price'       => 199000,
                'difficulty'  => 'intermediate',
                'duration'    => 8,
                'desc'        => 'Deploy aplikasi Laravel ke AWS menggunakan EC2, RDS, S3, dan layanan AWS lainnya.',
                'sections'    => [
                    ['Pengenalan Cloud', ['Apa itu Cloud?', 'Model Layanan', 'AWS Global Infrastructure', 'IAM & Security']],
                    ['Komputasi', ['EC2 Instance', 'Auto Scaling', 'Load Balancer', 'Lambda Serverless']],
                    ['Storage & Database', ['S3 Storage', 'RDS MySQL', 'ElastiCache', 'DynamoDB Intro']],
                ],
            ],
 
            // ── UI/UX Design ──────────────────────────────────────────
            [
                'title'       => 'UI/UX Design dengan Figma: Dari Wireframe ke Prototype',
                'category'    => 'UI/UX Design',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 6,
                'desc'        => 'Pelajari prinsip desain UI/UX dan buat prototype profesional menggunakan Figma.',
                'sections'    => [
                    ['Dasar Desain', ['Prinsip UI', 'Color Theory', 'Typography', 'Grid System']],
                    ['Figma Essentials', ['Interface Figma', 'Component & Variant', 'Auto Layout', 'Prototype']],
                    ['UX Research', ['User Persona', 'User Journey', 'Usability Testing', 'Iterasi Desain']],
                ],
            ],
 
            // ── Business ─────────────────────────────────────────────
            [
                'title'       => 'Kewirausahaan Digital: Dari Ide ke Startup',
                'category'    => 'Business & Finance',
                'price'       => 0,
                'difficulty'  => 'beginner',
                'duration'    => 4,
                'desc'        => 'Pelajari cara memvalidasi ide bisnis, membuat MVP, dan membangun startup digital dari nol.',
                'sections'    => [
                    ['Mindset Entrepreneur', ['Growth Mindset', 'Validasi Ide', 'Market Research', 'Competitor Analysis']],
                    ['Bangun Produk', ['MVP & Lean Startup', 'Product Market Fit', 'Agile Development', 'Pivot Strategy']],
                    ['Bisnis & Monetisasi', ['Model Bisnis', 'Pricing Strategy', 'Digital Marketing', 'Pitching ke Investor']],
                ],
            ],
 
            // ── Digital Marketing ─────────────────────────────────────
            [
                'title'       => 'SEO & Digital Marketing untuk Bisnis Online',
                'category'    => 'Digital Marketing',
                'price'       => 99000,
                'difficulty'  => 'beginner',
                'duration'    => 4,
                'desc'        => 'Tingkatkan visibilitas bisnis online-mu dengan SEO, Google Ads, dan social media marketing.',
                'sections'    => [
                    ['SEO Fundamental', ['Cara Kerja Search Engine', 'Keyword Research', 'On-Page SEO', 'Off-Page & Backlink']],
                    ['Google Ads', ['Setup Campaign', 'Targeting', 'Budget & Bidding', 'Analisis Performa']],
                    ['Social Media Marketing', ['Content Strategy', 'Instagram & TikTok', 'Influencer Marketing', 'Analytics']],
                ],
            ],
 
            // ── Mobile Development ────────────────────────────────────
            [
                'title'       => 'Flutter: Bangun Aplikasi Mobile iOS & Android',
                'category'    => 'Mobile Development',
                'price'       => 249000,
                'difficulty'  => 'intermediate',
                'duration'    => 10,
                'desc'        => 'Kuasai Flutter dan Dart untuk membangun aplikasi mobile cross-platform yang indah.',
                'sections'    => [
                    ['Dart & Flutter Dasar', ['Dart Programming', 'Widget Dasar', 'Layout', 'Stateless vs Stateful']],
                    ['State Management', ['setState', 'Provider', 'Riverpod', 'BLoC Pattern']],
                    ['Backend Integration', ['HTTP & REST API', 'Firebase', 'Local Storage', 'Push Notification']],
                ],
            ],
        ];
 
        foreach ($coursesData as $data) {
            // Cari kategori
            $category = $categories->firstWhere('name', $data['category'])
                ?? $categories->first();
 
            // Pilih instruktur acak
            $instructor = $instructors->random();
 
            // Buat slug unik
            $slug = Str::slug($data['title']);
 
            // Buat course
            $course = Course::create([
                'institution_id'    => $institution->id,
                'category_id'       => $category->id,
                'title'             => $data['title'],
                'slug'              => $slug,
                'short_description' => $data['desc'],
                'description'       => $data['desc'] . "\n\nKursus ini dirancang untuk memberikan pemahaman mendalam dan keterampilan praktis yang bisa langsung diterapkan. Setiap materi disajikan dengan cara yang mudah dipahami, dilengkapi dengan latihan dan proyek nyata.",
                'price'             => $data['price'],
                'duration_weeks'    => $data['duration'],
                'difficulty'        => $data['difficulty'],
                'language'          => 'id',
                'is_published'      => true,
            ]);
 
            // Daftarkan instruktur
            $course->instructors()->attach($instructor->id, ['role' => 'lead']);
 
            // Buat sections & lessons
            foreach ($data['sections'] as $sectionIndex => [$sectionTitle, $lessonTitles]) {
                $section = Section::create([
                    'course_id'   => $course->id,
                    'title'       => $sectionTitle,
                    'order_index' => $sectionIndex,
                ]);
 
                foreach ($lessonTitles as $lessonIndex => $lessonTitle) {
                    Lesson::create([
                        'section_id'       => $section->id,
                        'title'            => $lessonTitle,
                        'type'             => $lessonIndex === count($lessonTitles) - 1 ? 'quiz' : 'video',
                        'video_url'        => null,
                        'content'          => "Materi lengkap tentang **{$lessonTitle}** akan tersedia di sini. Silakan ikuti penjelasan instruktur dan kerjakan latihan yang disediakan.",
                        'duration_seconds' => rand(300, 1800), // 5 - 30 menit
                        'order_index'      => $lessonIndex,
                        'is_free_preview'  => ($sectionIndex === 0 && $lessonIndex === 0), // Lesson pertama gratis
                    ]);
                }
            }
        }
 
        // Tambah 5 kursus dummy via Factory
        $remainingInstructors = $instructors->random(min(3, $instructors->count()));
        foreach ($remainingInstructors as $inst) {
            $course = Course::factory()->create([
                'institution_id' => $institution->id,
            ]);
            $course->instructors()->attach($inst->id, ['role' => 'lead']);
 
            // Buat 2 section dengan 3 lesson masing-masing
            for ($s = 0; $s < 2; $s++) {
                $section = Section::create([
                    'course_id'   => $course->id,
                    'title'       => 'Bagian ' . ($s + 1),
                    'order_index' => $s,
                ]);
                for ($l = 0; $l < 3; $l++) {
                    Lesson::create([
                        'section_id'       => $section->id,
                        'title'            => 'Lesson ' . ($l + 1),
                        'type'             => 'video',
                        'duration_seconds' => rand(300, 900),
                        'order_index'      => $l,
                        'is_free_preview'  => ($s === 0 && $l === 0),
                    ]);
                }
            }
        }
    }
}
