/**
 * richter.js
 * 
 * Realiza as operacoes pertinentes a solicitacao do TP, item 03.
 * 
 * @author Hugo Carvalho
 */
var Richter = (function($){

    //tabela magnitude
    var magnitudeTable = {
        m1 : {'de':0,   'ate':3.4,      'descricao': 'Menor que 3,5',   'efeitos': 'Geralmente não sentido, mas gravado'},
        m2 : {'de':3.5, 'ate':5.4,      'descricao': 'Entre 3,5 e 5,4', 'efeitos': 'Ás vezes sentido, mas raramente causa danos'},
        m3 : {'de':5.5, 'ate':6,        'descricao': 'Entre 5,5 e 6,0', 'efeitos': 'No máximo causa pequenos danos a prédios bem construídos, mas pode danificar seriamente casas mal construídas em regiões próximas'},
        m4 : {'de':6.1, 'ate':6.9,      'descricao': 'Entre 6,1 e 6,9', 'efeitos': 'Pode ser destrutivo em áreas em torno de até 100 Km do epicentro'},
        m5 : {'de':7,   'ate':7.9,      'descricao': 'Entre 7,0 e 7,9', 'efeitos': 'Grande terremoto, pode causar sérios danos numa grande faixa de área'},
        m6 : {'de':8,   'ate':Infinity, 'descricao': '8,0 ou mais',     'efeitos': 'Enorme terremoto, pode causar grandes danos em muitas áreas mesmo que estejam a centenas de quilômetros'}
    };

    function init(){
        $('#analisar').click( () => {
            let magnitude = amplitude = intervalo = '';
            
            amplitude   = $('#amplitude').val();
            intervalo   = $('#intervalo').val();
            
            $('#amplitude').removeClass('is-invalid');
            $('#intervalo').removeClass('is-invalid');

            if(amplitude == ''){
                $('#amplitude').addClass('is-invalid');

            }
            if(intervalo == ''){
                $('#intervalo').addClass('is-invalid');
            }

            if(amplitude == '' || intervalo == ''){
                return false;
            }

            magnitude = calculoMagnitude(amplitude,intervalo).toFixed(1);
            faixa = classificacao(magnitude);
            mountTable(faixa,magnitude);
            plotEscala(faixa);          
        });     
    }

    /**
     * classifica a magnitude richter de acordo com o valor do parametro magnitude
     * @param  float magnitude  magnitude calculada
     * @return string  magnitude encontrada
     */
    function classificacao (magnitude){
        let index = ''
        Object.keys(magnitudeTable).forEach(key => {
            if( magnitude >= magnitudeTable[key].de && magnitude <= magnitudeTable[key].ate ){
                index = key;
            }
        });

        return index;
    }

    /**
     * monta a tabela de exibicao do resultado
     * @param  string faixa faixa de magnitude calculada
     * @param number magnitude magnitude encontrada
     * @return void
     */
    function mountTable(faixa,magnitude){
        let html = "";
        let superhead = 'Magnitude na escala Richter : '+magnitude;
        Object.keys(magnitudeTable).forEach(key => {
            let maximo = magnitudeTable[key].ate == Infinity ? '~' : magnitudeTable[key].ate;

            if(key == faixa){
                html+='<tr class="table-success">\
                <td>'+magnitudeTable[key].descricao+'</td>\
                <td>'+magnitudeTable[key].efeitos+'</td>';
            }else{
                html+='<tr>\
                <td>'+magnitudeTable[key].descricao+'</td>\
                <td>'+magnitudeTable[key].efeitos+'</td>';
            }
        });
        $("#tableResult > thead > tr > #magnitude").css('display','table-cell').text(superhead);
        $("#tableResult > tbody").html(html);
        $("body,html").animate({
            scrollTop:$("#tableResult").offset().top - $("#formEscala").offset().top + $("#formEscala").scrollTop()
        },1500);        
    }

    /**
     * calcula a magnitude de acordo com a amplitude e tempo
     * @param  string amplitude 
     * @param  string intervalo
     * @return number        
     */
    function calculoMagnitude(amplitude,intervalo){
        return Math.log10(amplitude) + 3 * Math.log10( 8* intervalo) - 2.92;
    }

    /**
     * exibe o grafico da escala richter e a faixa calculada
     * @param  string faixa faixa de magnitude
     * @return void
     */
    function plotEscala(faixa){
        $("#chart").css('display','block');
        Highcharts.chart('chart', {
            chart:{
                type:'line'
            },
            title: {
                text: 'Magnitude calculada x Escala Richter'
            },
            xAxis: {
               plotBands:[{
                color:'#FCFFC5',
                from:magnitudeTable[faixa].de,
                to:magnitudeTable[faixa].ate
               }]
            },
            yAxis: {
                title: {
                    text: 'Faixa de magnitude calculada'
                }
            },
            series:[{
                name: 'Escala Richter',
                data:[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
            }]
        });    
    }

    return{
        init:init
    }
})($);

Richter.init();