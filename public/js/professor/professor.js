/**
 * Created by Rudda Beltrao on 21/07/2017.
 */
$(function () {

    /*dialog notas*/

    //pegar o is registrado no storege
    getCursos(1);


    $('.addcurso').click(function () {

        showCursos();

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
            curso.append('professor_id', 1);


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


                   var html=' <div class="mdl-cell mdl-cell--4-col">'+
                       '<div class="demo-card-square mdl-card mdl-shadow--2dp">'+
                       '<div class="mdl-card__title mdl-card--expand" style="height: 210px;color: #fff; background:url('+ "'" +curso[i].capa+ "'" +')">' +
                       '<h2 class="mdl-card__title-text"></h2></div>'+
                       '<div class="mdl-card__supporting-text"> <h5>Resumo do curso</h5> <div>'+
                       curso[i].resumo+
                       '</div></div>'+
                       '<div class="mdl-card__actions mdl-card--border">'+
                       '<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">Visualizar</a>'+
                       '</div>'+
                       '</div>'+
                       '</div>';


                    conteudo+= html;


                }

                console.log(conteudo);
                grid.innerHTML = conteudo;

            }catch (exception){


            }


        });



    }

});