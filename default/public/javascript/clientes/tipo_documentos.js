
function borrar(id){
    if(confirm('Esta seguro de eliminar el registro'))
    {
        var rowSelected=$("body").find('#' + 'c' + id)
        rowSelected.html('<td colspan="4"> <img src="<?php echo PUBLIC_PATH ?>/img/ui/ajax-loader.gif" /> Eliminando ...</td>');
        $.ajax({
         type: "GET",
         url: "<?php echo PUBLIC_PATH . 'tipos_documentos/borrar/' ?>" + id,
         success:
          function(data){
           $(rowSelected).hide();
           $('#list').html(data);
          }

        });
    }
}

