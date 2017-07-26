$('select[name=product-statistic]').change(function() {
    var id = $(this).val();

    $.ajax({
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        url: '/admin/product/'+id+'/statistic',
        method: 'post',
        dataType: 'json',
        error: function(a, b, c){
            console.log(a.responseText);
        },
        success: function(response){
            $('#product-statistic img').attr('src', response.image);
            $('#product-statistic .today').text(response.today);
            $('#product-statistic .week').text(response.week);
            $('#product-statistic .month').text(response.month);
            $('#product-statistic .total').text(response.total);
            $('#product-statistic .sale').text(response.sale);
        }
    });
});

$.ajax({
    data: {'_token': $('meta[name="csrf-token"]').attr('content')},
    url: '/admin/sale/statistic',
    method: 'post',
    dataType: 'json',
    error: function(a, b, c){
        console.log(a.responseText);
    },
    success: function(response){
        console.log(response);
        var ctx = document.getElementById("myChart");
        var data = {
            labels: response.labels,
            datasets: [
                {
                    label: "Sales",
                    fill: false,
                    lineTension: 0,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: 'rgba(54, 162, 235, 1)',
                    pointHoverRadius: 5,
                    pointHoverBorderWidth: 1,
                    pointRadius: 3,
                    pointHitRadius: 10,
                    data: response.data,
                }
            ]
        };
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 5
                        }
                    }]
                }
            }
        });
    }
});
