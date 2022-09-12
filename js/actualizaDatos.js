function showEdit(editableObj) {
            $(editableObj).css("background","rgb(215, 195, 247)");
        } 
function guardaCliente(editableObj,column,id) {
    $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
    $.ajax({
        url: "actualizaCliente.php",
        type: "POST",
        data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
            $(editableObj).css("background","rgb(217, 237, 247)");
        }        
   });
}
function guardaAuto(editableObj,column,id) {
    $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
    $.ajax({
        url: "actualizaAuto.php",
        type: "POST",
        data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        success: function(data){
            $(editableObj).css("background","rgb(217, 237, 247)");
        }        
   });
}
        //inquilino
        // function guardaInquilino(editableObj,column,id) {
        //     $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        //     $.ajax({
        //         url: "actualizaInquilino.php",
        //         type: "POST",
        //         data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        //         success: function(data){
        //             $(editableObj).css("background","rgb(217, 237, 247)");
        //         }        
        //    });
        // }
        // //garante
        // function guardaGarante(editableObj,column,id) {
        //     $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        //     $.ajax({
        //         url: "actualizaGarante.php",
        //         type: "POST",
        //         data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        //         success: function(data){
        //             $(editableObj).css("background","rgb(217, 237, 247)");
        //         }        
        //    });
        // }
        // //impuestos
        // function guardaImpuestos(editableObj,column,id) {
        //     $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        //     $.ajax({
        //         url: "actualizaImpuestos.php",
        //         type: "POST",
        //         data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        //         success: function(data){
        //             $(editableObj).css("background","rgb(217, 237, 247)");
        //         }        
        //    });
        // }        
        // //consorcio
        // function guardaConsorcio(editableObj,column,id) {
        //     $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        //     $.ajax({
        //         url: "actualizaConsorcio.php",
        //         type: "POST",
        //         data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        //         success: function(data){
        //             $(editableObj).css("background","rgb(217, 237, 247)");
        //         }        
        //    });
        // }        
        // //ocupantes
        // function guardaOcupante(editableObj,column,id) {
        //     $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
        //     $.ajax({
        //         url: "actualizaOcupante.php",
        //         type: "POST",
        //         data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
        //         success: function(data){
        //             $(editableObj).css("background","rgb(217, 237, 247)");
        //         }        
        //    });
        // }