var ctx = document.getElementById("myPieChart");

var myPieChart = new Chart(ctx, {
    type: 'doughnut',

    data: {
        labels: [
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jum'at",
            "Sabtu",
            "Minggu"
        ],

        datasets: [{
            data: [15, 3, 15, 14, 5, 6, 23],

            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796',
                '#5a5c69'
            ],

            hoverBackgroundColor: [
                '#2e59d9',
                '#17a673',
                '#2c9faf',
                '#dda20a',
                '#be2617',
                '#6c6e7e',
                '#42444e'
            ],

            hoverBorderColor: "rgba(234, 236, 244, 1)"
        }]
    },

    options: {
        maintainAspectRatio: false,

        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10
        },

        legend: {
            display: true,
            position: 'bottom'
        },

        cutoutPercentage: 70
    }
});
