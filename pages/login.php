<form method="post" action="helpers/login.php">
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
      <div class="col-md-12"><p><button class="btn btn-lg btn-success" role="button" id="button" onclick="return checkForm()" >Access</button></p></div>
   </div>
   <div id="informationArea"></div>
</form>
