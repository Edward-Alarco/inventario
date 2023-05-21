const month = document.querySelector('#month'),
    product = document.querySelector('#product'),
    search = document.querySelector('#search');

//html_formulas
var emin = document.querySelector('#emin'),
    pp = document.querySelector('#pp'),
    emax = document.querySelector('#emax'),
    cp = document.querySelector('#cp');

search.addEventListener('click', (e)=>{
    e.preventDefault();

    emin.innerHTML = '';emax.innerHTML = '';cp.innerHTML = '';pp.innerHTML = '';

    var mes = parseInt(month.value),
        id_activo = parseInt(product.value);

    const formulario = new FormData()
    formulario.append("mes", mes)
    formulario.append("id_activo", id_activo)
    formulario.append("validar", "control")
    fetch('src/views/resources/ajax/inventario.php', {
        method: "POST",
        body: formulario
    })
    .then(res => res.json())
    .then(data => {

        emin.innerHTML = data['Emin'],
        emax.innerHTML = data['Emax'],
        cp.innerHTML = data['CP'],
        pp.innerHTML = data['Pp'];

        doGraphic(data['estadistica_egreso'], data['estadistica_reposicion'])
    })
})

var e = [], r = [];

function doGraphic(egresos, repuestos){
    // console.log(egresos)
    // console.log(repuestos)

    egresos.forEach(l=>{
        e.push(parseInt(l[0]))
    })
    repuestos.forEach(m=>{
        r.push(parseInt(m[0]))
    })

    console.log(e, r)

    Highcharts.chart('graphic', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Movimientos en Cantidades'
        },
        subtitle: {
            text: 'Cantidades'
        },
        yAxis: {
            title: {text: ''},
            tickInterval: 1,
        },
        xAxis: {
            tickInterval: 1,
        },
        tooltip: {
            shared: true,
            headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><br>'
        },
        plotOptions: {
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Cant. Egresada',
            data: e
        }, {
            name: 'Cant. Repuesta',
            data: r
        }]
      });
}