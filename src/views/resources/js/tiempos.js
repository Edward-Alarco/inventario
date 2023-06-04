if (document.querySelector('.tiempo')) {
    const times = document.querySelector('#times');

    var contadorNoDemora = 0,
        contadorUnDia = 0,
        contadorMasDias = 0;

    if (times.querySelector('p')) {
        Array.from(times.querySelectorAll('p')).forEach(p => {

            var array = p.textContent.split('||'),
                nombre = array[0],
                fecha_reposicion = array[1],
                fecha_ingreso = array[2],
                id_activo = array[3],
                delay = array[4];

            if (delay == 0) {
                delay = 'Sin demora'
                contadorNoDemora++
            } else if (delay == 1) {
                delay = delay + ' día'
                contadorUnDia++
            } else {
                delay = delay + ' días'
                contadorMasDias++
            }

            var tr = document.createElement('TR')
            tr.innerHTML = `
            <th scope="row">${id_activo}</th>
            <td>${nombre}</td>
            <td>${fecha_ingreso}</td>
            <td>${fecha_reposicion}</td>
            <td>${delay}</td>
        `

            document.querySelector('table tbody').appendChild(tr)

        })
    }

    const container = document.querySelector('#delays'),
        lista = document.querySelector('ul.datos');

    //datos
    var cantidad_activos_registrados_excel = parseInt(container.querySelector('.cantidad_activos_registrados_excel').textContent),
        cantidad_activos_registrados_manual = parseInt(container.querySelector('.cantidad_activos_registrados_manual').textContent),
        promedio_activos_registrados_manual = container.querySelector('.promedio_activos_registrados_manual').textContent;

    var total_activos_registrados = cantidad_activos_registrados_excel + cantidad_activos_registrados_manual

    lista.children[0].innerHTML = `Existen ${cantidad_activos_registrados_excel} activos registrados mediante el módulo de importar excel`
    lista.children[1].innerHTML = `Existen ${cantidad_activos_registrados_manual} activos registrados mediante el módulo de registro manual`
    lista.children[2].innerHTML = `El promedio de demora de un usuario al registrar los activos de forma manual es de: ${promedio_activos_registrados_manual}`


    var porcents = [], numbers = [];
    function doGraphic() {

        numbers.push({ name: '% sin demoras', y: contadorNoDemora },
            { name: '% en un día', y: contadorUnDia },
            { name: '% más de un día', y: contadorMasDias })

        Highcharts.chart('graphic1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            exporting: { enabled: false },
            title: { text: 'Porcentaje de Demoras' },
            tooltip: { pointFormat: '<b>{series.name}:<b><br><b>{point.percentage:.1f}%</b>' },
            accessibility: { point: { valueSuffix: '%' } },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' }
                }
            },
            series: [{ name: 'Porcentaje', colorByPoint: true, data: numbers }]
        });


        porcents.push({ name: '% Registros Excel', y: (cantidad_activos_registrados_excel / total_activos_registrados) * 100 },
            { name: '% Registros Manual', y: (cantidad_activos_registrados_manual / total_activos_registrados) * 100 })

        Highcharts.chart('graphic2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            exporting: { enabled: false },
            title: { text: 'Porcentaje de Registros' },
            tooltip: { pointFormat: '<b>{series.name}:<b><br><b>{point.percentage:.1f}%</b>' },
            accessibility: { point: { valueSuffix: '%' } },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.percentage:.1f} %' }
                }
            },
            series: [{ name: 'Porcentaje', colorByPoint: true, data: porcents }]
        });
    }

    doGraphic()
}