<div class="jumbotron">
   <h1>Welcome to EasyPass</h1>
   <p class="lead">EasyPass is a simple, beautiful password manager that does not use a password.
   Instead, we secure your data with information that is easy for you to remember. You are in control.
   All you have to do is set three easy questions, set your answers and you are ready. </p>
   <div class="container">
      <form method="post" action="helpers/PostLogin.php">
         <div class="row">
            <div id="login">
               <label for="usr">Enter your email address and mobile phone number to continue:</label>
               <div class='col-sm-6'>
                  <div class="form-group">
                     <input type="text" class="form-control" placeholder="Email address" id="email" name="email">
                  </div>
               </div>
               <div class='col-sm-6'>
                  <div class="form-group">
                        <input type='text' placeholder="Mobile number eg 0412345678" class="form-control" id='mobile' name='mobile' />
               </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-8 g-recaptcha" data-sitekey="6LfHuCEUAAAAANWkAHkjGbSDXhJvnn454_qrpsRX"></div>
            <div class="col-sm-2"><p><button class="btn btn-success" type="submit" role="button" id="button" >Access</button></p></div>
         </div>

      <div class="row">

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
