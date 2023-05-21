if(document.querySelector('#data')){
    const dataIngreso = document.querySelector('ul#ingresos'),
        dataEgreso = document.querySelector('ul#egresos'),
        selMonth = document.querySelector('#month'),
        selType = document.querySelector('#type'),
        table = document.querySelector('table tbody');

    selMonth.addEventListener('change', stock)
    selType.addEventListener('change', stock)

    function stock(){
        var type = selType.value,
            month = selMonth.value,
            query = `li[data-tipo="${type}"].month-${month}`;

        var i = 1;
        table.innerHTML = '';

        if(dataIngreso.querySelector(query)){
            Array.from(dataIngreso.querySelectorAll(query)).forEach(li=>{

                var stock_final = parseFloat(li.textContent)
                var stock_inicial = stock_final
    
                if(dataEgreso.querySelector(query+`.${li.classList[1]}`)){
                    Array.from(dataEgreso.querySelectorAll(query+`.${li.classList[1]}`)).forEach(le=>{
                        stock_inicial += parseFloat(le.textContent)
                    })
                }

                var stock_promedio = (stock_inicial+stock_final)/2
    
                if(stock_inicial != stock_final){
                    var tr = document.createElement('TR');

                    tr.innerHTML = `
                        <th>${i++}</th>
                        <td>${li.getAttribute('data-nombre').toString()}</td>
                        <td class="inicial">${stock_inicial}</td>
                        <td class="final">${stock_final}</td>
                        <td>${stock_promedio}</td>`;
    
                    table.appendChild(tr)
                }
            })
        }

        doGraphic()
    }

    function doGraphic(){
        var chartBox1 = document.querySelector('#graphic1'),
            chartBox2 = document.querySelector('#graphic2'),
            cats = ['Cant. Activos Completamente', 'Cant. Activos Parcialmente'], nums = [], porcents = [];

        var contadorCompleto = 0, contadorParcial = 0, contadorTotal = 0;
        Array.from(document.querySelectorAll('table tbody tr')).forEach(tr=>{
            var c = parseInt(tr.querySelector('.inicial').textContent),
                d = parseInt(tr.querySelector('.final').textContent);

            if(d === 0){
                contadorCompleto += 1
            }else{
                contadorParcial += 1
            }
        })
        contadorTotal = contadorParcial +  contadorCompleto;

        var percent_completo = 0, percent_parcial = 0;
        percent_completo = (contadorCompleto/contadorTotal)*100;
        percent_parcial = (contadorParcial/contadorTotal)*100;


        porcents.push({name:'% Activos Completamente',y:percent_completo}, {name:'% Activos Parcialmente',y:percent_parcial})
        nums.push(contadorCompleto, contadorParcial)

        const chart1 = Highcharts.chart(chartBox1, {
            chart: {type: 'bar', inverted: false},
            exporting: {enabled: false},
            title: {text: `Cantidad Activos Retirados`},
            xAxis: {categories: cats},
            yAxis: {
                title: {text: ''},
            },
            series: [{
                type: 'column', name: 'Cantidad',
                dataSorting: { enabled: true },
                colorByPoint: true, data: nums, showInLegend: false
            }]
        })

        const chart2 = Highcharts.chart(chartBox2, {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            exporting: {enabled: false},
            title: {text: 'Porcentaje de Activos Retirados'},
            tooltip: {pointFormat: '<b>{series.name}:<b><br><b>{point.percentage:.1f}%</b>'},
            accessibility: {point: {valueSuffix: '%'}},
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {enabled: true,format: '<b>{point.name}</b>: {point.percentage:.1f} %'}
                }
            },
            series: [{name: 'Porcentaje',colorByPoint: true,data: porcents}]
        });
    }
}