/**
 * Created by Rudda Beltrao on 22/07/2017.
 */


$(function () {

    var bt = document.getElementById('bt_logar').addEventListener('click', function(){
        
       login(); 
        
    });


    function login(){
        var email = document.getElementById('email').value;
        var senha = document.getElementById('senha').value;

        $.ajax({

            type:"get",
            url:"../../../flexpeak/flexpeak/api/v1/professor?email="+email+"&senha="+senha,

            processData: false,
            contentType: false

        }).done(function (data) {

            var json = JSON.parse(data);


            if(json['code']==200){


                sessionStorage.setItem('professor_id', json['data']['id_professor']);
                sessionStorage.setItem('professor_nome', json['data']['nome']);
                window.location.href= 'html/professor.html'
            }else{

                alert("Usuario ou senha não conferem");

            }


        });


    }


});