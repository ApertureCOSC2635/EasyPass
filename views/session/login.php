<div class="jumbotron">
   <h1>Welcome to EasyPass</h1>
   <p class="lead">EasyPass is a simple, beautiful password manager that does not use a password.
   Instead, we secure your data with information that is easy for you to remember. You are in control.
   All you have to do is set three easy questions, set your answers and you are ready. </p>
   <div class="container">
      <form method="post" action="helpers/PostLogin.php">
         <div class="row">
            <div id="login">
               <label for="usr">Enter your email address and date of birth to continue:</label>
               <div class='col-sm-6'>
                  <div class="form-group">
                     <input type="text" class="form-control" placeholder="Email address" id="email" name="email">
                  </div>
               </div>
               <div class='col-sm-6'>
                  <div class="form-group">
                     <div class='input-group date' id='dateOfBirth'>
                        <input type='text' placeholder="Date of Birth" class="form-control" id='dateOfBirth2' name='dateOfBirth' />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                     </div>
               </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12"><p><button class="btn btn-success" type="submit" role="button" id="button" >Access</button></p></div>
         </div>
      </form>
   </div>
   <div id="error-message">
      <?php
         if(isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
         }
       ?>
   </div>
</div>
<script type="text/javascript">
   $(function () {
      $('#dateOfBirth').datetimepicker({
         format: 'DD/MM/YYYY'
      });
   });
</script>
