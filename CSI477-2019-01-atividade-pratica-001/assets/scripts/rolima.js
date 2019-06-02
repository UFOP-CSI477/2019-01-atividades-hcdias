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
    $("#formCompetidor .row:last-child .is-invalid").removeClass('is-invalid');
    $("#formCompetidor .row:last-child input").val('');
});

/**
 * Realiza a ordernacao de competidores, verifica os vencedores e popula 
 * a tabela para exibicao de resultado
 */
$("#analisar").click(function (){
    var result = [];
    var validation = [];

    //remove os alertas de input vazio
    $(".is-invalid").removeClass('is-invalid');

    $("#formCompetidor > .row").each( (index,data) => {
        let item = {};
        let largada     = $(data).children()[0].children[1].value;
        let competidor  = $(data).children()[1].children[1].value;
        let tempo       = $(data).children()[2].children[1].value;

        //valida as entradas do usuario
        let elementWithError = [];
        $(data).children().each( (indexInput,dataInput) => {
            if(dataInput.children[1].value == ''){
                elementWithError[indexInput] = dataInput.children[1].id;
            }
        });

        //se existem campos vazios, armazena-os com o indice da row para exibir alerta
        if(Object.keys(elementWithError).length){
            validation[index] = elementWithError;
        }

        //seta os dados do competidor
        item.largada    = largada;
        item.competidor = competidor;
        item.tempo      = tempo;
        item.resultado  = '--';
        item.posicao    = 0;

        //armazena para posterior avaliacao das colocacoes
        result.push(item);
    });

    //existem erros no formulario?
    if(validation.length){
        //para cada row com erro
        validation.forEach((item,index) => {
            //para cada coluna com erro, marque os inputs
            for(element in item){
                input = $("#formCompetidor > .row")[index].children[element].children[item[element]];
                $(input).addClass('is-invalid');
            }
        });
        //interrompa a execucao
        return false;
    }


    //ordena os resultados por tempo
    result.sort( (a,b) => parseInt(a.tempo) - parseInt(b.tempo) );
    
    //separa o melhor tempo
    winner = result[0];
    posicao = 1;
    //compara os tempos e distribui as posicoes
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

    //monta a saida para a tabela
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
    //exibe os resultados
    $("#tableResult > tbody").html(html);
});