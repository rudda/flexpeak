/**
 * Created by Rudda Beltrao on 21/07/2017.
 */

$(document).ready(

    


    $(function () {

        var professor_id;
        var professor_nome;

        if(sessionStorage.getItem('professor_id')!= undefined){

            professor_id = sessionStorage.getItem('professor_id');
            professor_nome = sessionStorage.getItem('professor_nome');


        }else{

            window.location.href='../index.html';

        }

        /*dialog notas*/

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


        //pegar o is registrado na url pelo storega
        getCursos(sessionStorage.getItem('current_curso'));



        $('.addcurso').click(function () {

            showCursos();

        });



        $('#bt_logout').click(function () {

            logout();
            
        });
        //cadastrarCursos
        function showCursos(){


            var dialog = document.getElementById('#formcurso');


            if (! dialog.showModal) {
                dialogPolyfill.registerDialog(dialog);
            }

            dialog.showModal();


            dialog.querySelector('.close').addEventListener('click', function() {
                dialog.close();
            });

            dialog.querySelector('.salvar').addEventListener('click', function () {

                var curso = new FormData();

                curso.append('nome',document.getElementById("nome_curso").value);
                curso.append('resumo', document.getElementById("resumo_curso").value);
                curso.append('foto', document.getElementById('foto').files[0]);
                curso.append('professor_id', sessionStorage.getItem('professor_id'));


                $.ajax(

                    {
                        type: "post",
                        url: "../../../flexpeak/flexpeak/api/v1/curso",
                        data: curso,
                        processData: false,
                        contentType: false
                    }

                ).done(function (dados) {

                    try{

                        var json = JSON.parse(dados);
                        if(json['code']==200){

                            alert("Curso cadastrado com sucesso!!");
                            dialog.close();


                        }else{

                            alert("Curso não cadastrado com sucesso!!");
                            dialog.close();


                        }


                    }catch (exception){

                        console.log(dados);
                        console.log(exception);

                    }


                });

            })

        }


        //mostrar os cursos do professor
        function getCursos(professor){



            $.ajax(

                {
                    type: "GET",
                    url: "../../../flexpeak/flexpeak/api/v1/curso?professor_id=1",
                    data:{

                        professor_id : "professor_id="+professor

                    },
                    processData: false,
                    contentType: false
                }


            ).done(function (dados) {

                //inflar os cursos


                var json = JSON.parse(dados);

                try{

                    var curso = json['data'];


                    var grid = document.getElementById('lista');
                    var conteudo = '';
                    for(var i=0; i<curso.length; i++){

                        var id = curso[i]['id_curso'];

                        var html=' <div class="mdl-cell mdl-cell--4-col">'+
                            '<div class="demo-card-square mdl-card mdl-shadow--2dp">'+
                            '<div class="mdl-card__title mdl-card--expand" style="height: 210px;color: #fff; background:url('+ "'" +curso[i].capa+ "'" +')">' +
                            '<h2 class="mdl-card__title-text"></h2></div>'+
                            '<div class="mdl-card__supporting-text"> <h5>Resumo do curso</h5> <div>'+
                            curso[i].resumo+
                            '</div></div>'+
                            '<div class="mdl-card__actions mdl-card--border">'+
                            '<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" onclick="goToCurso('+id+')">Visualizar</a>'+
                            '</div>'+
                            '</div>'+
                            '</div>';


                        conteudo+= html;


                    }


                    grid.innerHTML = conteudo;

                }catch (exception){


                }


            });



        }

    })


);



    function logout() {
       
        sessionStorage.clear();
        window.location.href = '/../flexpeak/public/index.html';

    }

    function goToCurso(id){

       
        window.location.href = 'cursos.html?curso_id='+id;


    }