 <?php 
  class Calendar{ 
      public static function text($field, $attrs = NULL, $value = NULL){ 
          static $i = false; 
          $code   =   ''; 
          if($i == false){ 
                  $i = true; 
                  //Tag::css('jquery/jquery-ui-1.11.4.custom/jquery.ui.all');
                  Tag::css('jquery/jquery-ui-1.11.4.custom/jquery-ui.theme');
                  
                  $code  = Tag::js('jquery/jquery-ui-1.11.4.custom/jquery.ui.core');
                  $code .= Tag::js('jquery/pickadate');
          } 
          $code   .=   Form::text($field, $attrs, $value); 
          $field  =   str_replace('.', '_', $field); 
          $code   .=  "<script type=\"text/javascript\"> 
                      $(function() { 
                          $(\"#" . $field . "\").datepicker({ 
                          altFormat: 'd/m/yy', 
                          autoSize: true, 
                          dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'], 
                          dayNamesMin: ['Dom', 'Lu', 'Ma', 'Mi', 'Je', 'Vi', 'Sa'], 
                          firstDay: 1, 
                          monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'], 
                          monthNamesShort: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'], 
                          dateFormat: 'dd/mm/yy', 
                          changeMonth: true, 
                          changeYear: true}); 
                      }); 
                      </script>"; 
          return $code; 
      } 
  } 
  ?>
