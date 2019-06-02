/**
 * rolima.js
 * 
 * Realiza as operacoes pertinentes a solicitacao do TP, item 01.
 * 
 * @author Hugo Carvalho
 */

/**
 * Clona os inputs para novas entradas
 */
$("#addCompetidor").click(function(){
    $("#formCompetidor .row:first-child").clone().appendTo("#formCompetidor");
});

/**
 * Realiza a ordernacao de competidores, verifica os vencedores e popula 
 * a tabela para exibicao de resultado
 */
$("#analisar").click(function (){
    let result = [];
    $("#formCompetidor > .row").each( (index,data) => {
        let item = {};
        item.largada = $(data).children()[0].children[1].value;
        item.competidor = $(data).children()[1].children[1].value;
        item.tempo = $(data).children()[2].children[1].value;
        item.resultado = '--';
        item.posicao = 0;

        result.push(item);
    });

    result.sort( (a,b) => parseInt(a.tempo) - parseInt(b.tempo) );
    
    winner = result[0];
    posicao = 1;
    result.map((item,index) => {
        if(item.tempo == winner.tempo){
            item.posicao = 1;
            item.resultado = 'Vencedor(a)!'; 
            posicao++;
        }else{
            item.posicao = posicao;
            posicao++;
        }
    });

    let html = "";
    result.forEach(element=>{
        html+='<tr>\
        <td>'+element.posicao+'</td>\
        <td>'+element.largada+'</td>\
        <td>'+element.competidor+'</td>\
        <td>'+element.tempo+'</td>\
        <td>'+element.resultado+'</td>\
        </tr>';
    });

    $("#tableResult > tbody").html(html);
});