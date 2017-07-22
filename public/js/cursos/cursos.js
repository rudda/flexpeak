/**
 * Created by Rudda Beltrao on 21/07/2017.
 */

$(function () {


    /*dialog notas*/

    

    $('.clicar').click(function () {

        showNotas(1);

    });


    function showNotas($id){


        var dialog = document.getElementById('#nota');


        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        
        dialog.showModal();
        
        
        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });
        
        dialog.querySelector('.salvar').addEventListener('click', function () {

             
            
        })

    }

    
   

});