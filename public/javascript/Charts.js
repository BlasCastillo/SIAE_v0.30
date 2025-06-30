/* grafica 1 */
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
    }
});


/* grafica 2 */
var myChart2 = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(myChart2, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Black', 'Pink'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3, 20, 40],
            backgroundColor: [
                'rgb(255, 0, 55)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgb(0, 0, 0)',
                'rgb(255, 0, 149)'
            ]
        }]
    },
    options: {
        responsive: true,
    }
});


/* grafica 3 */
var myChart3 = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(myChart3, {
    type: 'doughnut',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Black', 'Pink'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3, 20, 40],
            backgroundColor: [
                'rgb(255, 0, 55)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgb(0, 0, 0)',
                'rgb(255, 0, 149)'
            ]
        }]
    },
    options: {
        responsive: true,
    }
});

/* grafica 4 */
var myChart4 = document.getElementById('myChart4').getContext('2d');
var myChart = new Chart(myChart4, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Black', 'Pink'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3, 20, 40],
            backgroundColor: [
                'rgb(255, 0, 55)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgb(0, 0, 0)',
                'rgb(255, 0, 149)'
            ]
        }]
    },
    options: {
        responsive: true,
    }
});
