$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    if($('#select-filter-revenue')){
        loadRevenue();
    }
   
    function loadCanvasRevenue(revenue_name,month,revenue,message){
        if (month && revenue) {
        toastr.success(message);
        $('#chart_revenue').remove();
        $('#graph-container').append('<canvas id="chart_revenue"><canvas>');
            var lineChart = $('#chart_revenue');
            var myChartt = new Chart(lineChart, {
                type: 'line',
                data: {
                    labels: month.split(','),
                    datasets: [{
                            label: revenue_name,
                            data: revenue.split(','),
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                }
            });
        } else {
            toastr.warning(message);
        }
    }

    function loadRevenue(){
        var year = $('#select-filter-revenue').val();
        var url = $('#select-filter-revenue').data('url');
        $.ajax({
            url: url,
            method: "post",
            dataType:'json',
            data: {
                year: year,
            },
            success: function(data) {
                // loadCanvasRevenue(data['month'],data['revenue']);
                loadCanvasRevenue(data.chart_data['revenue_name'],
                data.chart_data['month'],data.chart_data['revenue'],data.message);
            },
            error: function (data) {
                loadCanvasRevenue(data.chart_data['month']=null,data.chart_data['revenue']=null,data.error);
                toastr.error(error);
            },
        });
    }

    $('#select-filter-revenue').change(function() {
        var year = $(this).val();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            method: "post",
            dataType:'json',
            data: {
                year: year,
            },
            success: function(data) {
                loadCanvasRevenue(data.chart_data['revenue_name'],
                data.chart_data['month'],data.chart_data['revenue'],data.message);
            },
            error: function (error) {
                toastr.error(error);
            },
        });

    });
});
