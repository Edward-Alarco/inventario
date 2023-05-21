if(document.querySelector('#containerDonut')){
    var chartBox = document.querySelector('#containerDonut'),
        description = chartBox.nextElementSibling,
        contenedor = document.querySelector('#stats1'),
        cantidadBase = parseInt(contenedor.children.length);

    var data = [], cats = [];

    Array.from(contenedor.children).forEach(p=>{
        cats.push(p.textContent.toString())
    })
    var categorias = [...new Set(cats)]

    Array.from(categorias).forEach(cat=>{
        var cantidad = parseInt(contenedor.querySelectorAll(`.${cat.toLowerCase()}`).length),
            percentage = parseFloat((cantidad/cantidadBase)*100);

        data.push({name: cat, y: percentage})
    })

    // Data retrieved from https://netmarketshare.com
    Highcharts.chart(chartBox, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        exporting: {enabled: false},
        title: {text: 'Porcentaje de Activos (por tipo) dentro del Inventario'},
        tooltip: {pointFormat: '<b>{series.name}:<b><br><b>{point.percentage:.1f}%</b>'},
        accessibility: {point: {valueSuffix: '%'}},
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {enabled: true,format: '<b>{point.name}</b>: {point.percentage:.1f} %'}
            }
        },
        series: [{name: 'Porcentaje',colorByPoint: true,data: data}]
    });

    description.innerHTML = `En total existen ${cantidadBase} activos registrados en el inventario`;
}

/*if(document.querySelector('#containerBars')){
    var contenedor = document.querySelector('#stats2'),
        cats = [], nums = [];

    Array.from(contenedor.children).forEach(p=>{
        cats.push(p.textContent.toString())
        nums.push(parseInt(p.getAttribute('data-cantidad')))
    })

    cats.length = 50
    nums.length = 50
    
    Highcharts.chart('containerBars', {
        chart: {type: 'bar'},
        exporting: {enabled: false},
        title: {text: `Cantidades de Activos dentro del Inventario`},
        xAxis: {categories: cats},
        yAxis: {
            title: {text: 'Nro° de activos dentro del inventario'},
            //tickInterval: 500
        },
        series: [{
            type: 'column', name: 'Cantidad',
            dataSorting: { enabled: true },
            colorByPoint: true, data: nums, showInLegend: false
        }]
    })
}*/