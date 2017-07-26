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
            url:"../flexpeak/api/v1/professor?email="+email+"&senha="+senha,
            headers: {
                "Access-Control-Allow-Origin":"*"
            },
            dataType: 'json',
            crossDomain: true,
            processData: false,
            contentType: false

        }).done(function (data) {


            
            


            if(data['code']==200){

                //var json = JSON.parse(data['data']);
                sessionStorage.setItem('professor_id', data['data']['id_professor']);
                sessionStorage.setItem('professor_nome', data['data']['nome']);
                window.location.href= 'html/professor.html'
            }else{

                alert("Usuario ou senha não conferem");

            }


        });


    }


});