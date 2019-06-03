/**
 * imc.js
 * 
 * Realiza as operacoes pertinentes a solicitacao do TP, item 02.
 * 
 * @author Hugo Carvalho
 */
var Imc = (function($){
    //tabela imc
    var imcTable = {
        subnutricao : {'de':0,   'ate':18.5},
        saudavel    : {'de':18.5,'ate':24.9},
        sobrepeso   : {'de':25,  'ate':29.9},
        obesidade1  : {'de':30,  'ate':34.9},
        obesidade2  : {'de':35,  'ate':39.9},
        obesidade3  : {'de':40,  'ate':Infinity}
    };
    
    /**
     * inicializa o listener no preenchimento dos inputs e 
     * faz as chamadas para o calculo do imc
     * 
     * @return void
     */
    function init (){
        let peso = altura = faixa = imc = '';
        $('#analisar').click( () => {
            peso    = $('#peso').val();
            altura  = $('#altura').val();
            
            $('#peso').removeClass('is-invalid');
            $('#altura').removeClass('is-invalid');

            if(peso == ''){
                $('#peso').addClass('is-invalid');

            }
            if(altura == ''){
                $('#altura').addClass('is-invalid');
            }

            if(peso == '' || altura == ''){
                return false;
            }

            imc = calculo(peso,altura);
            faixa = classificacao(imc);
            mountTable(faixa,imc);
        });
    }

    /**
     * monta a tabela de exibicao do resultado
     * @param  string faixa faixa do imc calculada
     * @return void
     */
    function mountTable(faixa,imc){
        let html = "";
        let superhead = 'Seu IMC :'+imc.toFixed(2);
        Object.keys(imcTable).forEach(key => {
            let maximo = imcTable[key].ate == Infinity ? '~' : imcTable[key].ate;

            if(key == faixa){
                html+='<tr class="table-success">\
                <td>'+imcTable[key].de+' até '+maximo+'</td>\
                <td>'+key+'</td>';
            }else{
                html+='<tr>\
                <td>'+imcTable[key].de+' até '+maximo+'</td>\
                <td>'+key+'</td>';
            }
        });
        $("#tableResult > thead > tr > #imc").css('display','table-cell').text(superhead);
        $("#tableResult > tbody").html(html);
    }

    /**
     * classifica o indice imc de acordo com o valor do parametro imc
     * @param  float imc indice imc calculado
     * @return string  indice encontrado
     */
    function classificacao (imc){
        let index = ''
        Object.keys(imcTable).forEach(key => {
            if( imc >= imcTable[key].de && imc <= imcTable[key].ate ){
                index = key;
            }
        });

        return index;
    }

    /**
     * calcula o imc de acordo com o peso e a altura
     * @param  string peso   peso informado
     * @param  string altura altura informada
     * @return number        
     */
    function calculo(peso,altura){
        return peso/(altura ** 2);
    }

    return{
        init:init
    }
})($);

Imc.init();