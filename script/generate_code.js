$(document).ready(function() {
    $("#codeForm").submit(function(){
        $.ajax({
            url:'api.php',
            type:'POST',
            data: { telefono:$("#telefono").val(), nombre:$("#nombre").val() , cantidad:$("#cantidad").val()},
            success: function(response) {
                $(".showQRCode").html(response);  
            },
         });
    });
});