<aside class="w-72 bg-white shadow-lg p-5 flex flex-col justify-between">

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

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>📊</span>
                <span class="font-medium">Dashboard</span>

            </a>

            <a href="{{ route('admin.analytics') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>📈</span>
                <span class="font-medium">Analytics</span>

            </a>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>👥</span>
                <span class="font-medium">Users</span>

            </a>

            <a href="{{ route('admin.courses') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>📚</span>
                <span class="font-medium">Courses</span>

            </a>

            <a href="{{ route('admin.institutions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>🏫</span>
                <span class="font-medium">Institutions</span>

            </a>

            <a href="{{ route('admin.categories') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>🗂️</span>
                <span class="font-medium">Categories</span>

            </a>

            <a href="{{ route('admin.approvals') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>✅</span>
                <span class="font-medium">Approvals</span>

            </a>

            <a href="{{ route('admin.reviews') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>⭐</span>
                <span class="font-medium">Reviews</span>

            </a>

            <a href="{{ route('admin.reports') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>🚩</span>
                <span class="font-medium">Reports</span>

            </a>

            <a href="{{ route('admin.transactions') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>💳</span>
                <span class="font-medium">Transactions</span>

            </a>

            <a href="{{ route('admin.payouts') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>💰</span>
                <span class="font-medium">Payouts</span>

            </a>

            <a href="{{ route('admin.settings') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>⚙️</span>
                <span class="font-medium">Settings</span>

            </a>

            <a href="{{ route('admin.logs') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-orange-100 text-gray-700 transition">

                <span>📋</span>
                <span class="font-medium">Logs</span>

            </a>

        </nav>

    </div>

</aside>