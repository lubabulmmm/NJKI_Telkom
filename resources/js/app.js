import './bootstrap';
import Chart from 'chart.js/auto';
// import Alpine from 'alpinejs';
import financejs from 'https://cdn.jsdelivr.net/npm/financejs@4.1.0/+esm'


// document.addEventListener("DOMContentLoaded", function () {
//     const ctx = document.getElementById('evaluationChart').getContext('2d');

//     new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: ['Layak', 'Tidak Layak'],
//             datasets: [
//                 {
//                     label: 'User Count',
//                     data: [180, 75],
//                     backgroundColor: [
//                         'rgba(75, 192, 192, 0.7)',
//                         'rgba(255, 99, 132, 0.7)'
//                     ],
//                     borderColor: [
//                         'rgba(75, 192, 192, 1)',
//                         'rgba(255, 99, 132, 1)'
//                     ],
//                     borderWidth: 1,
//                 },
//             ],
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 title: {
//                     display: true,
//                     text: 'User Evaluation Results',
//                     font: {
//                         size: 18
//                     }
//                 },
//                 tooltip: {
//                     callbacks: {
//                         label: function (context) {
//                             return `${context.label}: ${context.raw} users`;
//                         }
//                     }
//                 }
//             },
//             scales: {
//                 x: {
//                     title: {
//                         display: true,
//                         text: 'Evaluation Categories',
//                         font: {
//                             size: 14
//                         }
//                     }
//                 },
//                 y: {
//                     beginAtZero: true,
//                     title: {
//                         display: true,
//                         text: 'Number of Users',
//                         font: {
//                             size: 14
//                         }
//                     }
//                 }
//             }
//         },
//     });
// });