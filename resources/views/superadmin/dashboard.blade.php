<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        /* Background gradient - lighter version */
        .bg-gradient-main {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            min-height: 100vh;
        }

        /* Glassmorphism effect - darker for better contrast */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        /* Enhanced card animations */
        .stat-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        /* Pulse effect */
        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }

            50% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Number counter animation */
        .counter {
            display: inline-block;
            transition: all 0.3s ease;
        }

        /* Enhanced table rows */
        .table-row {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .table-row::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s;
        }

        .table-row:hover::before {
            left: 100%;
        }

        .table-row:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }

        /* Icon animations */
        .icon-bounce {
            transition: transform 0.3s ease;
        }

        .icon-bounce:hover {
            transform: scale(1.1) rotate(5deg);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Card hover effects */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Progress bar animation */
        .progress-bar {
            width: 0%;
            transition: width 1.5s ease-in-out;
        }

        /* Shimmer effect */
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: calc(200px + 100%) 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 37%, #f0f0f0 63%);
            background-size: 400px 100%;
            animation: shimmer 1.5s ease-in-out infinite;
        }

        /* Status badge animations */
        .status-badge {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .status-badge:hover::before {
            left: 100%;
        }
    </style>

    <div class="ml-0 sm:ml-60 max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8">
            <div class="flex-1 overflow-y-auto p-6 mt-8 min-h-screen">
                <!-- Header Section with enhanced styling -->
                <div class="glass rounded-2xl p-6 mb-8 hover-lift">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center pulse-glow">
                                <i class="fas fa-crown text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Super Admin</p>
                                <h2 class="font-bold text-3xl text-gray-800 leading-tight flex items-center">
                                    Dashboard
                                    <i class="fas fa-chart-line ml-3 text-2xl icon-bounce"></i>
                                </h2>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-lg">
                            <i class="fas fa-clock mr-2"></i>
                            Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Enhanced Stats Cards with dynamic data -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users Card -->
                    <div class="stat-card rounded-2xl p-6 float" style="animation-delay: 0s;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl flex items-center justify-center icon-bounce">
                                    <i class="fas fa-users text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Total Pengguna</h3>
                                    <p class="text-sm text-gray-600">Pengguna terdaftar</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-800 counter" data-target="{{ $usersCount }}">0
                                </p>
                                <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                                    <div class="bg-red-500 h-1 rounded-full progress-bar" style="width: 75%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Calculations Card -->
                    <div class="stat-card rounded-2xl p-6 float" style="animation-delay: 0.2s;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center icon-bounce">
                                    <i class="fas fa-calculator text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Total Perhitungan</h3>
                                    <p class="text-sm text-gray-600">Semua perhitungan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-800 counter"
                                    data-target="{{ $calculationsCount ?? 0 }}">0</p>
                                <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                                    <div class="bg-blue-500 h-1 rounded-full progress-bar" style="width: 90%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Viable Investments Card -->
                    <div class="stat-card rounded-2xl p-6 float" style="animation-delay: 0.4s;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center icon-bounce">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Layak</h3>
                                    <p class="text-sm text-gray-600">Investasi layak</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-800 counter"
                                    data-target="{{ $viableCount ?? 0 }}">0</p>
                                <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                                    <div class="bg-green-500 h-1 rounded-full progress-bar" style="width: 60%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Non-Viable Investments Card -->
                    <div class="stat-card rounded-2xl p-6 float" style="animation-delay: 0.6s;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center icon-bounce">
                                    <i class="fas fa-times-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Tidak Layak</h3>
                                    <p class="text-sm text-gray-600">Investasi tidak layak</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-800 counter"
                                    data-target="{{ $nonViableCount ?? 0 }}">0</p>
                                <div class="w-full bg-gray-200 rounded-full h-1 mt-2">
                                    <div class="bg-orange-500 h-1 rounded-full progress-bar" style="width: 40%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Enhanced Chart Section with dynamic data -->
                    <div class="glass rounded-2xl p-8 hover-lift">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Analisis Kelayakan Investasi</h3>
                                <p class="text-gray-600">Perbandingan antara investasi layak dan tidak layak</p>
                            </div>
                            <div class="flex space-x-4 mt-4 md:mt-0">
                                <div class="flex items-center bg-green-50 px-3 py-2 rounded-lg border border-green-200">
                                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                    <span class="text-sm font-medium text-green-700">Layak
                                        ({{ $viableCount ?? 0 }})</span>
                                </div>
                                <div class="flex items-center bg-red-50 px-3 py-2 rounded-lg border border-red-200">
                                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                    <span class="text-sm font-medium text-red-700">Tidak Layak
                                        ({{ $nonViableCount ?? 0 }})</span>
                                </div>
                            </div>
                        </div>

                        <div class="relative h-96 w-full bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <canvas id="evaluationChart" class="w-full h-full"></canvas>
                        </div>

                        <div
                            class="mt-4 flex justify-between items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <span><i class="fas fa-sync-alt mr-2"></i>Terakhir diperbarui:
                                {{ now()->format('d M Y, H:i') }}</span>
                            <span><i class="fas fa-chart-bar mr-2"></i>Total:
                                {{ ($viableCount ?? 0) + ($nonViableCount ?? 0) }} perhitungan</span>
                        </div>
                    </div>

                    <!-- Enhanced Recent Calculations Section with dynamic data -->
                    <div class="glass rounded-2xl p-8 hover-lift">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Perhitungan Terkini</h3>
                                <p class="text-gray-600">Evaluasi investasi terbaru</p>
                            </div>
                            <a href="{{ route('superadmin.investment.archive.index') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all duration-300 hover:scale-105 flex items-center">
                                <i class="fas fa-eye mr-2"></i>Lihat Semua
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider w-2/5">
                                            <i class="fas fa-user mr-2"></i>Pengguna
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider w-2/5">
                                            <i class="fas fa-calendar mr-2"></i>Tanggal
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider w-1/5">
                                            <i class="fas fa-flag mr-2"></i>Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentCalculations as $calculation)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap w-2/5">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span
                                                            class="text-gray-600">{{ substr($calculation->user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4 min-w-0">
                                                        <div class="text-sm font-medium text-gray-900 truncate">
                                                            {{ $calculation->user->name }}</div>
                                                        <div class="text-sm text-gray-500 truncate">
                                                            {{ $calculation->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap w-2/5">
                                                <div class="text-sm text-gray-900">
                                                    {{ $calculation->created_at->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $calculation->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap w-1/5">
                                                <span
                                                    class="px-3 py-1 inline-flex items-center justify-center text-xs leading-5 font-semibold rounded-full 
                              {{ $calculation->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <i
                                                        class="{{ $calculation->is_viable ? 'fas fa-check' : 'fas fa-times' }} mr-1"></i>
                                                    {{ $calculation->is_viable ? 'Layak' : 'Tidak Layak' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada perhitungan terkini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            // Counter animation
            function animateCounters() {
                const counters = document.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const increment = target / 100;
                    let current = 0;

                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.floor(current).toLocaleString();
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target.toLocaleString();
                        }
                    };

                    updateCounter();
                });
            }

            // Progress bar animation
            function animateProgressBars() {
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 500);
                });
            }

            // Chart initialization
            document.addEventListener('DOMContentLoaded', function() {
                // Animate counters and progress bars
                setTimeout(animateCounters, 500);
                setTimeout(animateProgressBars, 1000);

                // Register Chart.js plugin
                Chart.register(ChartDataLabels);

                // Chart data with dynamic values
                const viableCount = {{ $viableCount ?? 0 }};
                const nonViableCount = {{ $nonViableCount ?? 0 }};
                const total = viableCount + nonViableCount;

                const data = {
                    labels: ['Layak', 'Tidak Layak'],
                    datasets: [{
                        data: [viableCount, nonViableCount],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 3,
                        hoverBackgroundColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderRadius: 15,
                        borderSkipped: false,
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 30,
                                bottom: 20,
                                left: 20,
                                right: 20
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    color: 'rgba(255, 255, 255, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: 'rgba(75, 85, 99, 0.8)',
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: true,
                                    color: 'rgba(75, 85, 99, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: 'rgba(75, 85, 99, 0.8)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true,
                                backgroundColor: 'rgba(31, 41, 55, 0.95)',
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                padding: 15,
                                cornerRadius: 12,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        const percentage = Math.round((value / total) * 100);
                                        return `${context.label}: ${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: 'rgba(255, 255, 255, 0.9)',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                },
                                formatter: function(value) {
                                    const percentage = Math.round((value / total) * 100);
                                    return `${value.toLocaleString()}\n(${percentage}%)`;
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeOutBounce',
                            delay: (context) => {
                                return context.dataIndex * 300;
                            }
                        },
                        elements: {
                            bar: {
                                barPercentage: 0.6,
                                categoryPercentage: 0.8
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                };

                const ctx = document.getElementById('evaluationChart').getContext('2d');
                new Chart(ctx, config);
            });

            // Add scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.stat-card, .glass').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });
        </script>
    </div>
</x-app-layout>
