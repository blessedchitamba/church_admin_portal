        </div><!-- end .container -->

        <footer class="text-center">
            <hr>
            <small>Coded with &hearts; by <a href="#">Blessed</a> in Cape Town</small>
        </footer>
        
        <!-- jQuery
        <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
        
         Bootstrap JS
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->

        <script>
            $(document).ready(function(){
             $('#framework').multiselect({
              nonSelectedText: 'Select member(s)',
              enableFiltering: true,
              enableCaseInsensitiveFiltering: true,
              buttonWidth:'400px'
             });
             
             $('#framework_form').on('add', function(event){
              event.preventDefault();
              var form_data = $(this).serialize();
              $.ajax({
               url:"assignCells.php",
               method:"POST",
               data:form_data,
               success:function(data)
               {
                $('#framework option:selected').each(function(){
                 $(this).prop('selected', false);
                });
                $('#framework').multiselect('refresh');
                alert(data);
               }
              });
             });
             
             
            });
        </script>
    </body>
</html>
