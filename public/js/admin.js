$(document).ready(function() {

    const labels = [
        '22/01/2022',
        '23/01/2022',
        '24/01/2022',
        '25/01/2022',
        '26/01/2022',
        '27/01/2022',
        '28/01/2022',
        '29/01/2022'
    ];
    
    const data = {
        labels: labels,
        datasets: [{
            label: 'Ordenes',
            backgroundColor: 'rgb(255, 94, 31)',
            borderColor: 'rgb(255, 94, 31)',
            data: [ 0, 10, 5, 2, 20, 30, 3, 15 ],
        }]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                title: {
                  display: true,
                  text: 'Ventas',
                }
            }
        }
    };
    
    const ordersChart = new Chart(
        document.getElementById('orders-chart'),
        config
    );

    $('.btn-side-bar').click(function() {
        $('.side-bar').toggleClass('active');
    });

});