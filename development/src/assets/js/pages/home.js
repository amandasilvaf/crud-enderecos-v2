var KTHome = function () {
    var _initMixedWidget1 = function () {
        var element = document.getElementById("kt_mixed_widget_1_chart");
        var height = parseInt(KTUtil.css(element, 'height'));

        const concept = '#a98ce2'
        const diamond = '#7cd2ce'
        const gold = '#ce9b22'
        const silver = '#bfbdbd'
        const bronze = '#a96a28'

        if (!element) {
            return;
        }

        var strokeColor = '#C66921';

        $.ajax({
            url: '/clientes/classificacao',
            method: 'GET',
            statusCode: {
                200: function (e) {
                    relatorioClientes(e)
                },
                400: function (response) {
                    jQuery.each(JSON.parse(response.responseText), function (key, value) {
                        toastr.error(value)
                    })
                },
                500: function () {
                    toastr.error('Ocorreu um erro no Servidor.')
                }
            }
        })

        var relatorioClientes = function (result) {
            const apexChart = "#kt_mixed_widget_1_chart"
            var options = {
                series: [{
                    name: "Clientes",
                    data: result
                }],
                chart: {
                    height: 250,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Conceito', 'Diamante', 'Ouro', 'Prata', 'Bronze'],
                },
                colors: ['#feef3c']
            }

            var chart = new ApexCharts(document.querySelector(apexChart), options)
            chart.render()
        }
    }

    return {
        init: function () {
            _initMixedWidget1()
        },
    };
}()
