<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Overview of tuition management system</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Fee -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Jumlah Yuran</p>
                    <p class="text-sm text-gray-400">{{ $stats['currentMonth'] }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-4">RM {{ $stats['totalFee'] }}</p>
        </div>

        <!-- Total Allowance -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Jumlah Elaun</p>
                    <p class="text-sm text-gray-400">{{ $stats['currentMonth'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-800 mt-4">RM {{ $stats['totalAllowance'] }}</p>
        </div>

        <!-- Overdue Balance -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Baki Tertunggak</p>
                    <p class="text-sm text-gray-400">{{ $stats['currentMonth'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-[#800000] mt-4">RM {{ $stats['overdueBalance'] }}</p>
        </div>
    </div>

    <!-- Overdue Payment Section -->
    <div x-data="{ activeTab: 1, showTabs: false }" class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Yuran Tertunggak</h2>
            <button
                @click="showTabs = !showTabs"
                class="px-4 py-2 bg-[#800000] text-white rounded-xl hover:bg-[#600000] transition-colors flex items-center gap-2 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span x-text="showTabs ? 'Sembunyikan' : 'Lihat Butiran'"></span>
            </button>
        </div>

        <div x-show="showTabs" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-100">
                <button @click="activeTab = 1" :class="activeTab === 1 ? 'text-[#800000] border-[#800000] bg-red-50' : 'text-gray-500 border-transparent hover:text-gray-700'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors">
                    Belum Bayar
                </button>
                <button @click="activeTab = 2" :class="activeTab === 2 ? 'text-[#800000] border-[#800000] bg-red-50' : 'text-gray-500 border-transparent hover:text-gray-700'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors">
                    Gagal Bayar
                </button>
                <button @click="activeTab = 3" :class="activeTab === 3 ? 'text-[#800000] border-[#800000] bg-red-50' : 'text-gray-500 border-transparent hover:text-gray-700'" class="flex-1 px-6 py-4 text-sm font-medium border-b-2 transition-colors">
                    Dalam Proses
                </button>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Panel 1: Belum Bayar -->
                <div x-show="activeTab === 1" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach(['2022', '2023', '2024', '2025'] as $year)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-semibold text-[#800000] mb-3">{{ $year }}</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($overdueUnpaid[$year] as $month => $amount)
                                <div class="flex justify-between text-sm py-1 border-b border-gray-200">
                                    <span class="text-gray-600">{{ $month }}</span>
                                    <span class="font-medium {{ $amount > 0 ? 'text-red-600' : 'text-gray-400' }}">RM{{ number_format($amount, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Panel 2: Gagal Bayar -->
                <div x-show="activeTab === 2" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach(['2022', '2023', '2024', '2025'] as $year)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-semibold text-[#800000] mb-3">{{ $year }}</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($overdueFailed[$year] as $month => $amount)
                                <div class="flex justify-between text-sm py-1 border-b border-gray-200">
                                    <span class="text-gray-600">{{ $month }}</span>
                                    <span class="font-medium {{ $amount > 0 ? 'text-orange-600' : 'text-gray-400' }}">RM{{ number_format($amount, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Panel 3: Dalam Proses -->
                <div x-show="activeTab === 3" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach(['2022', '2023', '2024', '2025'] as $year)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-semibold text-[#800000] mb-3">{{ $year }}</h4>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($overdueProcessing[$year] as $month => $amount)
                                <div class="flex justify-between text-sm py-1 border-b border-gray-200">
                                    <span class="text-gray-600">{{ $month }}</span>
                                    <span class="font-medium {{ $amount > 0 ? 'text-yellow-600' : 'text-gray-400' }}">RM{{ number_format($amount, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Jumlah Yuran & Elaun Bulanan</h2>
                <p class="text-sm text-gray-500 mt-1">Perbandingan yuran dan elaun mengikut bulan</p>
            </div>
            <select id="yearSelect" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#800000] focus:border-transparent" onchange="updateChart()">
                <option value="">Pilih Tahun</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025" selected>2025</option>
            </select>
        </div>

        <div class="w-full" style="height: 400px;">
            <canvas id="feeChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script>
    const chartData = @json($chartData);
    const labels = ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogs', 'Sep', 'Okt', 'Nov', 'Dis'];

    const ctx = document.getElementById('feeChart').getContext('2d');
    let feeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Yuran (RM)',
                    data: chartData['2025']?.fee || [],
                    backgroundColor: '#800000',
                    borderColor: '#800000',
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Elaun (RM)',
                    data: chartData['2025']?.allowance || [],
                    backgroundColor: '#fbbf24',
                    borderColor: '#fbbf24',
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '500' }
                    }
                },
                datalabels: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        callback: function(value) {
                            return 'RM' + value.toLocaleString();
                        },
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '500' } }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        },
        plugins: [ChartDataLabels]
    });

    function updateChart() {
        const selectedYear = document.getElementById('yearSelect').value;
        if (selectedYear && chartData[selectedYear]) {
            feeChart.data.datasets[0].data = chartData[selectedYear].fee;
            feeChart.data.datasets[1].data = chartData[selectedYear].allowance;
        } else {
            feeChart.data.datasets[0].data = [];
            feeChart.data.datasets[1].data = [];
        }
        feeChart.update();
    }

    // Initialize with 2025 data
    document.getElementById('yearSelect').value = '2025';
</script>
@endpush
