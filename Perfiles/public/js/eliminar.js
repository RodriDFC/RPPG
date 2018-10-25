$('.eliminar').click(function(e){
    e.preventDefault();
    var divLista = $('.listaDatos');
    var fila = $(this).parents('tr');
    var url  = $(this).attr('href');
    var form = $(this).parents('form');
    var urlForm = form.attr('action');
    alertify.confirm("Esta seguro de eliminar",
        function(){
            $.get(url,[],function(res){
                if(res.eliminado){
                    fila.fadeOut();
                    alertify.alert(res.mensaje).set('basic', true);
                    $.get(urlForm,form.serialize(),function(res){ 
                        divLista.empty();
                        divLista.html(res);
                    });
                }else{
                    alertify.set('notifier','position', 'top-right');
                    alertify.error(""+res.mensaje);
                }  
            }).fail(function(ress,status,error){
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('UPS no se pudo eliminar');  
            })
        },
        function(){ 
    });
})

$('.registrar').click(function(e){
    e.preventDefault();
    form = $(this).parents('form');
    url  = form.attr('action');
    datos = form.serialize();
    $.post(url,datos,function(res){
        alertify.alert(res.mensaje).set('basic', true); 
          form.submit();
    }).fail(function(ress,status,error){
        var errores="";
        var cont = 18;
       // $('#mensajeError').show();//muestra los mensajes
        $.each($.parseJSON(ress.responseText), function (ind, elem) {     
                errores += "<li>"+elem+"</li>"
                alertify.set('notifier','position', 'top-right');
                alertify.error(""+elem,cont--);
               
        }); 
       /* $('#errores').html(
            errores    
        );*/
        
    });
})