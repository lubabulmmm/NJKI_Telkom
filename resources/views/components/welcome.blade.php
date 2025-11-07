<div
    class="p-8 md:p-12 bg-gradient-to-br from-red-600 to-orange-800 text-white rounded-xl shadow-2xl flex flex-col md:flex-row items-center">
    <div class="flex-1 mb-4 md:mb-0 md:pr-8">
        <h1 class="text-4xl font-extrabold mb-6 leading-tight">Selamat Datang di Platform Investasi <span
                class="text-yellow-300">NJKI</span>!</h1>
        <p class="text-lg leading-relaxed mb-6 bg-white/10 backdrop-blur-sm p-4 rounded-lg">
            Kalkulator Investasi NJKI membantu Anda menilai kelayakan investasi dengan menghitung potensi pengembalian
            setelah memperhitungkan pajak atas penjualan properti atau aset. Buat keputusan yang tepat dengan proyeksi
            akurat.
        </p>
        <div class="flex flex-wrap gap-4 mt-8">
            <a href="{{ route('user.calculator') }}"
                class="bg-yellow-400 hover:bg-yellow-300 text-amber-900 font-bold py-3 px-6 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                Coba Kalkulator Sekarang
            </a>
            {{-- <a href="#"
                class="bg-transparent border-2 border-white hover:border-yellow-400 text-white font-semibold py-3 px-6 rounded-full hover:bg-white/10 transition duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l3-2z"
                        clip-rule="evenodd" />
                </svg>
                Lihat Tutorial
            </a> --}}
        </div>
    </div>
    <div class="flex-1 flex justify-center">
        <div class="relative w-full max-w-md">
            <!-- Update video element with proper attributes and fallback -->
            <video class="mx-auto rounded-lg shadow-xl mb-6 w-full max-w-4xl object-cover" autoplay muted loop
                playsinline poster="{{ asset('/dashboard-poster.jpg') }}">
                <source src="{{ asset('/bandicam 2025-06-16 17-44-47-689.mp4') }}" type="video/mp4">
                <source src="{{ asset('/bandicam 2025-06-16 17-44-47-689.webm') }}" type="video/webm">
                <!-- Optional: Add WebM format -->
                <p class="text-center text-gray-600">
                    Your browser doesn't support HTML5 video. Here is a
                    <a href="{{ asset('/bandicam 2025-06-16 17-44-47-689.mp4') }}"
                        class="text-blue-500 hover:underline">link to the
                        video</a> instead.
                </p>
            </video>

            <!-- Decorative elements -->
            <div class="absolute -bottom-4 -right-4 bg-yellow-400 w-24 h-24 rounded-xl shadow-lg z-0"></div>
            <div class="absolute -top-4 -left-4 bg-white/20 w-16 h-16 rounded-xl z-0"></div>
        </div>
    </div>
</div>

<!-- Bagian Hasil (Awalnya tersembunyi) -->
<div class="bg-gray-50 border-t border-gray-200 p-6 md:p-8 hidden" id="results-section">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Hasil Proyeksi Investasi</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <p class="text-gray-500 text-sm font-medium">Total Investasi</p>
            <p class="text-2xl font-bold text-blue-600">Rp24.000</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <p class="text-gray-500 text-sm font-medium">Nilai Kotor</p>
            <p class="text-2xl font-bold text-green-600">Rp32.450</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            <p class="text-gray-500 text-sm font-medium">Setelah Pajak</p>
            <p class="text-2xl font-bold text-purple-600">Rp29.582</p>
        </div>
    </div>

    <div class="h-80 mb-6">
        <canvas id="investmentChart"></canvas>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left">Tahun</th>
                    <th class="py-3 px-4 text-left">Kontribusi</th>
                    <th class="py-3 px-4 text-left">Bunga</th>
                    <th class="py-3 px-4 text-left">Saldo</th>
                    <th class="py-3 px-4 text-left">Pajak</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4">1</td>
                    <td class="py-3 px-4">Rp2.400</td>
                    <td class="py-3 px-4">Rp720</td>
                    <td class="py-3 px-4">Rp11.120</td>
                    <td class="py-3 px-4">Rp108</td>
                </tr>
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4">2</td>
                    <td class="py-3 px-4">Rp2.400</td>
                    <td class="py-3 px-4">Rp1.017</td>
                    <td class="py-3 px-4">Rp14.537</td>
                    <td class="py-3 px-4">Rp153</td>
                </tr>
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4">3</td>
                    <td class="py-3 px-4">Rp2.400</td>
                    <td class="py-3 px-4">Rp1.371</td>
                    <td class="py-3 px-4">Rp18.308</td>
                    <td class="py-3 px-4">Rp206</td>
                </tr>
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4">4</td>
                    <td class="py-3 px-4">Rp2.400</td>
                    <td class="py-3 px-4">Rp1.789</td>
                    <td class="py-3 px-4">Rp22.497</td>
                    <td class="py-3 px-4">Rp268</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">5</td>
                    <td class="py-3 px-4">Rp2.400</td>
                    <td class="py-3 px-4">Rp2.279</td>
                    <td class="py-3 px-4">Rp27.176</td>
                    <td class="py-3 px-4">Rp342</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-12 bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white p-6">
        <h3 class="text-xl font-bold flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Analisis Kinerja Investasi
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Grafik Distribusi Investasi -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Investasi</h4>
                <div class="h-64">
                    <canvas id="investmentDistributionChart"></canvas>
                </div>
            </div>

            <!-- Grafik Analisis Kelayakan -->
            <div class="bg-white rounded-lg p-4 shadow">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Analisis Kelayakan</h4>
                <div class="h-64">
                    <canvas id="viabilityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Metrik Kinerja -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-lg p-4 shadow border border-gray-100">
                <h5 class="text-sm font-medium text-gray-500">Total Investasi</h5>
                <p class="text-2xl font-bold text-indigo-600" id="totalInvestments">0</p>
            </div>
            <div class="bg-white rounded-lg p-4 shadow border border-gray-100">
                <h5 class="text-sm font-medium text-gray-500">Proyek Layak</h5>
                <p class="text-2xl font-bold text-green-600" id="viableProjects">0</p>
            </div>
            <div class="bg-white rounded-lg p-4 shadow border border-gray-100">
                <h5 class="text-sm font-medium text-gray-500">Rata-rata IRR</h5>
                <p class="text-2xl font-bold text-purple-600" id="averageIRR">0%</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Kartu Kalkulator Pajak -->
    <div
        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
        <div class="bg-gradient-to-r from-red-600 to-orange-500 text-white p-6">
            <h2 class="text-xl font-bold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                </svg>
                Kalkulator Investasi Kelayakan
            </h2>
            <p class="text-sm opacity-90 mt-1">Evaluasi kelayakan proyek secara finansial</p>
        </div>

        <div class="p-6">
            <div class="space-y-5">

                <!-- Langkah 1 -->
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">1</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Masukkan Parameter Investasi</h3>
                        <p class="text-sm text-gray-600 mt-1">Input nilai CAPEX, OPEX, estimasi revenue, WACC, masa
                            investasi, depresiasi, dan target IRR.</p>
                    </div>
                </div>

                <!-- Langkah 2 -->
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">2</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Analisis Arus Kas</h3>
                        <p class="text-sm text-gray-600 mt-1">Sistem akan menghitung arus kas masuk dan keluar tahunan
                            berdasarkan data yang dimasukkan.</p>
                    </div>
                </div>

                <!-- Langkah 3 -->
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">3</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Tinjau Hasil NPV & IRR</h3>
                        <p class="text-sm text-gray-600 mt-1">Lihat hasil perhitungan Net Present Value dan Internal
                            Rate of Return untuk menentukan apakah proyek layak.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">4</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Feedback Note</h3>
                        <p class="text-sm text-gray-600 mt-1">Berikan catatan / note ketika hasil tidak layak agar
                            dapat mengubah item investasi.</p>
                    </div>
                </div>
            </div>

            {{-- <a href="#"
                class="mt-6 inline-flex items-center justify-center bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 w-full">
                Ke Kalkulator Investasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a> --}}
        </div>
    </div>


    <!-- Kartu Kalkulator Investasi -->
    <div
        class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
        <div class="bg-gradient-to-r from-green-600 to-teal-500 text-white p-6">
            <h2 class="text-xl font-bold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                Kalkulator Investasi Kelayakan
            </h2>
            <p class="text-sm opacity-90 mt-1">Evaluasi kelayakan finansial proyek berdasarkan analisis NPV dan IRR</p>
        </div>
        <div class="p-6">
            <div class="space-y-5">
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">1</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Input Data Investasi</h3>
                        <p class="text-sm text-gray-600 mt-1">Masukkan nilai investasi awal (CAPEX), estimasi
                            pendapatan tahunan, biaya operasional (OPEX), tingkat diskonto (WACC), dan masa proyek.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">2</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Perhitungan NPV & IRR</h3>
                        <p class="text-sm text-gray-600 mt-1">Sistem akan menghitung Net Present Value (NPV) dan
                            Internal Rate of Return (IRR) secara otomatis.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">3</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Evaluasi Kelayakan</h3>
                        <p class="text-sm text-gray-600 mt-1">Jika NPV positif dan IRR di atas tingkat minimum yang
                            ditentukan, maka investasi dianggap layak.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span
                        class="bg-green-100 text-green-600 font-bold rounded-full w-7 h-7 flex items-center justify-center mr-4 mt-1 flex-shrink-0">4</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">Evaluasi Kelayakan</h3>
                        <p class="text-sm text-gray-600 mt-1">Jika NPV positif dan IRR di atas tingkat minimum yang
                            ditentukan, maka investasi dianggap layak.</p>
                    </div>
                </div>
            </div>

            {{-- <a href="#"
                class="mt-6 inline-flex items-center justify-center bg-gradient-to-r from-green-600 to-teal-500 hover:from-green-700 hover:to-teal-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 w-full">
                Mulai Evaluasi Investasi
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a> --}}
        </div>
    </div>

</div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi grafik
        const distributionCtx = document.getElementById('investmentDistributionChart').getContext('2d');
        const viabilityCtx = document.getElementById('viabilityChart').getContext('2d');

        // Ambil data investasi dari backend
        fetch('/api/investment-data')
            .then(response => response.json())
            .then(data => {
                console.log('Data diterima:', data); // Untuk debugging

                // Perbarui metrik
                document.getElementById('totalInvestments').textContent = data.totalInvestments;
                document.getElementById('viableProjects').textContent = data.viableProjects;
                document.getElementById('averageIRR').textContent = (data.averageIRR || 0).toFixed(2) + '%';

                // Grafik Distribusi Investasi
                const distributionChart = new Chart(distributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Pendapatan', 'Total Input'],
                        datasets: [{
                            data: [
                                parseFloat(data.totalRevenue || 0),
                                parseInt(data.totalInvestments || 0)
                            ],
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)', // Biru untuk Pendapatan
                                'rgba(249, 115, 22, 0.8)' // Oranye untuk Input
                            ],
                            borderColor: 'white',
                            borderWidth: 2,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        if (label === 'Total Pendapatan') {
                                            return `${label}: Rp ${parseInt(value).toLocaleString('id-ID')}`;
                                        } else {
                                            return `${label}: ${parseInt(value)} kali`;
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                // Grafik Analisis Kelayakan
                new Chart(viabilityCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Status Kelayakan'],
                        datasets: [{
                                label: 'Proyek Layak',
                                data: [data.viableProjects],
                                backgroundColor: 'rgba(16, 185, 129, 0.9)', // hijau
                                borderColor: 'rgb(16, 185, 129)',
                                borderWidth: 2,
                                borderRadius: 6,
                                barPercentage: 0.4,
                                categoryPercentage: 0.5,
                                stack: 'Stack 0'
                            },
                            {
                                label: 'Proyek Tidak Layak',
                                data: [data.totalInvestments - data.viableProjects],
                                backgroundColor: 'rgba(239, 68, 68, 0.9)', // merah
                                borderColor: 'rgb(239, 68, 68)',
                                borderWidth: 2,
                                borderRadius: 6,
                                barPercentage: 0.4,
                                categoryPercentage: 0.5,
                                stack: 'Stack 1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    display: true,
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)'
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    padding: 10
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Proyek',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    padding: {
                                        bottom: 10
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'center',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Kelayakan Proyek',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 13
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw} proyek`;
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data investasi:', error);
                alert('Gagal memuat data investasi');
            });
    });
</script>

<script>
    // Ini akan mengimplementasikan fungsionalitas kalkulator sebenarnya
    document.addEventListener('DOMContentLoaded', function() {
        // Contoh menampilkan hasil saat tombol hitung diklik
        const calculateBtn = document.querySelector('button[type="button"]');
        if (calculateBtn) {
            calculateBtn.addEventListener('click', function() {
                document.getElementById('results-section').classList.remove('hidden');
                // Di sini Anda akan menambahkan logika perhitungan sebenarnya
            });
        }

        // Inisialisasi grafik akan ditempatkan di sini
    });
</script>
