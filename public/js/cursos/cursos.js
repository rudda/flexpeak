/**
 * Created by Rudda Beltrao on 21/07/2017.
 */
var curso;

$(document).ready(

    $(function () {



        var query = location.search.slice(1);
        var partes = query.split('&');
        var data= {};
        partes.forEach(function (parte) {
            var chaveValor = parte.split('=');
            var chave = chaveValor[0];
            var valor =  chaveValor[1];
            data[chave]= valor;

        });

        curso = data['curso_id'];

        if(curso != undefined)
            sessionStorage.setItem('current_curso', curso);

        /*dialog notas*/

        getAlunosCurso(sessionStorage.getItem('current_curso'));


        function getAlunosCurso(id){

            $.ajax({
                type: "GET",
                url: "../../../flexpeak/flexpeak/api/v1/aluno?curso_id="+id,
                data:{

                },
                processData: false,
                contentType: false

            }).done(function (data) {


                var listaAlunos = JSON.parse(data);

                try{

                    if(listaAlunos.code==200){

                        var lista = document.getElementById("lista_alunos_curso");
                        var conteudo='';

                        for(var i=0; i< listaAlunos.data.length; i++){

                            var texto= 'mae:'+listaAlunos.data[i]['mae']+' endereco: logradouro'+listaAlunos.data[i]['logradouro']+' bairro: '+listaAlunos.data[i]['bairro']+' cidade '+listaAlunos.data[i]['cidade'];
                            var id_aluno_json= listaAlunos.data[i]['id_aluno'];
                            var nome= listaAlunos.data[i]['nome'];
                            console.log(id_aluno_json);

                            var li= '<li  class="clicar mdl-list__item mdl-list__item--three-line " onclick="showNotas('+id_aluno_json+')">'+
                                '<span class="mdl-list__item-primary-content">'+
                                '<i class="material-icons  mdl-list__item-avatar">person</i>'+
                                '<span>'+nome+'</span>'+
                                '<span class="mdl-list__item-text-body">'+
                                texto+
                                '</span>'+
                                '</span>'+
                                '<span class="mdl-list__item-secondary-content">' +
                                '<div class="mdl-list__item-secondary-action" >' +
                                '<i class="material-icons">&#xE8DC;</i>' +
                                '</div>'+
                                '</span>'+
                                '<div class="idaluno" style="display: none">'+id+'</div>'+
                                '</li>';

                            conteudo+= li;
                        }
                        lista.innerHTML = conteudo;
                    }


                }catch (exception){

                    alert('ocorreu algum erro, favor recarregue a pagina');

                }

            });





        }




        var id_curso = sessionStorage.getItem('current_curso');

        var dialog = document.querySelector('dialog');
        var showDialogButton = document.querySelector('#show-dialog');
        document.getElementById('p2').style.display = 'none';
        var cep = document.getElementById('cep').value;
        var btcep = document.getElementById('p_cep');

        btcep.addEventListener('click', function(){

            document.getElementById('p2').style.display = 'block';
            $.ajax({
                method:"get",
                url:"https://viacep.com.br/ws/"+document.getElementById('cep').value+"/json"

            }).done(function (data) {
                document.getElementById('p2').style.display = 'none';
                document.getElementById('logradouro').value = data["logradouro"];
                document.getElementById('bairro').value = data["bairro"];
                document.getElementById('cidade').value = data["localidade"];

            });


        });

        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        showDialogButton.addEventListener('click', function() {
            dialog.showModal();
        });
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();

        });

        dialog.querySelector('.cadastrar').addEventListener('click', function() {

            form = new FormData();
            form.append('nome',document.getElementById('nome_aluno').value);
            form.append('mae',document.getElementById('nome_mae').value);
            form.append('cep',document.getElementById('cep').value);
            form.append('bairro',document.getElementById('bairro').value);
            form.append('cidade',document.getElementById('cidade').value);
            form.append('logradouro',document.getElementById('logradouro').value);
            form.append('curso_id', id_curso);


            console.log(form);

            $.ajax(
                {
                    type: "post",
                    url:"../../flexpeak/api/v1/aluno",
                    data:form,
                    processData: false,
                    contentType: false

                }).done(function(dados){

                var json = JSON.parse(dados);
                if(json['code']==200){

                    alert('aluno cadastrado com sucesso');
                    dialog.close();

                }else{

                    alert('aluno não foi cadastrado com sucesso');

                }

            });

        });



        $('#report').click(function () {

            
            report();
            
        });
        
    })


    
    
);



    function showNotas(id){

    console.log('show '+id);
     var dialog = document.getElementById('#nota');
     var code;
    var url = 'http://localhost/flexpeak/flexpeak/api/v1/curso/notas/'+id+'?curso_id='+curso;

     $.ajax({

        url: url,
        type: "get"


        ,

        processData: false,
        contentType: false

    }).done(function(data){

        var jsoon = JSON.parse(data);
        var code = jsoon['code'];

        if(code == 200){

            console.log(jsoon);
            document.getElementById('nota_1').value = jsoon['data'][0]['nota_1'];
            document.getElementById('nota_2').value = jsoon['data'][0]['nota_2'];
            document.getElementById('nota_3').value = jsoon['data'][0]['nota_3'];
            document.getElementById('nota_4').value = jsoon['data'][0]['nota_4'];
            document.getElementById('situacao').innerHTML = jsoon['data'][0]['situacao'];

        }else{

            document.getElementById('nota_1').value = 0;
            document.getElementById('nota_2').value = 0;
            document.getElementById('nota_3').value = 0;
            document.getElementById('nota_4').value = 0;


        }

    });

    if (! dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }

    dialog.showModal();


    dialog.querySelector('.close').addEventListener('click', function() {

        dialog.close();

    });

    dialog.querySelector('.salvar').addEventListener('click', function () {


        var form = new FormData();
        form.append('nota_1',document.getElementById('nota_1').value);
        form.append('nota_2',document.getElementById('nota_2').value);
        form.append('nota_3',document.getElementById('nota_3').value);
        form.append('nota_4',document.getElementById('nota_4').value);
        form.append('curso_id', curso);



        $.ajax({

            url: "../../../flexpeak/flexpeak/api/v1/curso/notas/"+id,
            type: "post",
            data:form,

            processData: false,
            contentType: false

        }).done(function(data){

            alert(data);

            $(document).reload();
            dialog.close();

        });
        

    })


    

}


function report() {

    var id = sessionStorage.getItem('current_curso');
    

    $.get(
        {
            url:'http://localhost/flexpeak/flexpeak/api/v1/reports?curso_id='+id

        }

    ).done(function (data) {




    });


}