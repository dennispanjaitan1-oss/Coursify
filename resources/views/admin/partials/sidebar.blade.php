{{-- FONT AWESOME --}}
@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

<aside class="w-72 bg-white shadow-lg p-5 flex flex-col justify-between min-h-screen">

    <div>

        {{-- LOGO --}}
        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-gray-100">

            <div class="w-12 h-12 rounded-2xl overflow-hidden">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo"
                    class="w-full h-full object-cover"
                >
            </div>

            <div>
                <h1 class="text-lg font-bold text-gray-800">
                    Ruang<span class="text-orange-500">Kelas</span>
                </h1>

                <p class="text-xs text-gray-400">
                    Admin Dashboard
                </p>
            </div>

        </div>

        {{-- MENU --}}
        <nav class="space-y-2">

            {{-- DASHBOARD --}}
           <a href="{{ route('admin.dashboard') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

    <i class="fa-solid fa-chart-line w-5 text-center"></i>

    <span class="font-medium">
        Dashboard
    </span>

</a>

            {{-- ANALYTICS --}}
            <a href="{{ route('admin.analytics') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-chart-pie w-5 text-center"></i>

                <span class="font-medium">
                    Analytics
                </span>

            </a>

            {{-- USERS --}}
            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-users w-5 text-center"></i>

                <span class="font-medium">
                    Users
                </span>

            </a>

            {{-- COURSES --}}
            <a href="{{ route('admin.courses.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-book-open w-5 text-center"></i>

                <span class="font-medium">
                    Courses
                </span>

            </a>

            {{-- INSTITUTIONS --}}
            <a href="{{ route('admin.institutions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-school w-5 text-center"></i>

                <span class="font-medium">
                    Institutions
                </span>

            </a>

            {{-- CATEGORIES --}}
            <a href="{{ route('admin.categories') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-layer-group w-5 text-center"></i>

                <span class="font-medium">
                    Categories
                </span>

            </a>

            {{-- APPROVALS --}}
            <a href="{{ route('admin.approvals') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-circle-check w-5 text-center"></i>

                <span class="font-medium">
                    Approvals
                </span>

            </a>

            {{-- REVIEWS --}}
            <a href="{{ route('admin.reviews') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-star w-5 text-center"></i>

                <span class="font-medium">
                    Reviews
                </span>

            </a>

            {{-- REPORTS --}}
            <a href="{{ route('admin.reports') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-flag w-5 text-center"></i>

                <span class="font-medium">
                    Reports
                </span>

            </a>

            {{-- TRANSACTIONS --}}
            <a href="{{ route('admin.transactions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-credit-card w-5 text-center"></i>

                <span class="font-medium">
                    Transactions
                </span>

            </a>

            {{-- PAYOUTS --}}
            <a href="{{ route('admin.payouts') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-wallet w-5 text-center"></i>

                <span class="font-medium">
                    Payouts
                </span>

            </a>

            {{-- SETTINGS --}}
            <a href="{{ route('admin.settings') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-gear w-5 text-center"></i>

                <span class="font-medium">
                    Settings
                </span>

            </a>

            {{-- LOGS --}}
            <a href="{{ route('admin.logs') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 hover:text-orange-600 text-gray-700 transition">

                <i class="fa-solid fa-file-lines w-5 text-center"></i>

                <span class="font-medium">
                    Logs
                </span>

            </a>

        </nav>

    </div>

</aside>