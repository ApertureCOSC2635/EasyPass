<?php
   use Helpers\Passwords;
   $p = new Passwords;
   $passwords = $p->getPasswords($_SESSION['login']);
 ?>
<form method="post" id="new_password" action="helpers/PostPassword.php" class="row hidden" autocomplete="off">
   <div class="col-md-11">
      <h4>Add a new password or private data.</h4>
   </div>
   <div class="col-md-1">
      <button type="button" class="btn btn-default btn-sm" onClick="hideForm()">
        <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span> Hide
      </button>
   </div>
   <div class="form-group col-md-4">
      <input type="text" class="form-control" placeholder="Name" id="name" name="name"/>
   </div>
   <div class="form-group col-md-4">
      <input type="text" class="form-control" placeholder="Username" id="username" name="username"/>
   </div>
   <div class="form-group col-md-4">
      <input type="password" class="form-control" placeholder="Password" id="password" name="password"/>
   </div>
   <div class="form-group col-md-12">
      <textarea class="form-control" rows="3" id="notes" name="notes" placeholder="Notes"></textarea>
   </div>
   <div class="pull-right"><p><button class="btn btn-success" type="submit" role="button" id="button" >Save</button></p></div>
</form>

<form method="post" id="update_form" action="helpers/UpdatePassword.php" class="row hidden" autocomplete="off">
   <div class="col-md-11">
      <h4>Update existing password or private data.</h4>
   </div>
   <div class="col-md-1">
      <button type="button" class="btn btn-default btn-sm" onClick="hideForm()">
        <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span> Hide
      </button>
   </div>
   <div class="form-group col-md-4">
      <input type="hidden" class="form-control" id="update_id" name="update_id"/>
      <input type="text" class="form-control" placeholder="Name" id="update_name" name="name"/>
   </div>
   <div class="form-group col-md-4">
      <input type="text" class="form-control" placeholder="Username" id="update_username" name="username"/>
   </div>
   <div class="form-group col-md-4">
      <input type="password" class="form-control" placeholder="Password" id="update_password" name="password"/>
   </div>
   <div class="form-group col-md-12">
      <textarea class="form-control" rows="3" id="update_notes" name="notes" placeholder="Notes"></textarea>
   </div>
   <div class="pull-right"><p><button class="btn btn-success" type="submit" role="button" id="button" >Save</button></p></div>
</form>
<table class="table table-hover">
   <thead>
      <tr>
         <th>Name</th>
         <th>Username</th>
         <th>Password</th>
         <th>Notes</th>
         <th>
            <button type="button" class="btn btn-default btn-sm" onClick="showForm()">
              <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add
            </button>
         </th>
      </tr>
   </thead>
   <tbody>
      <?php
	if(isset($passwords)) {
         foreach($passwords as $p) {
            echo '
            <tr>
               <td id="name">'.$p->name.'</td>
               <td id="username">'.$p->username.'</t>
               <td id="password"><span class="password" pw="'.$p->password.'" style="margin-right: 5px;">'.$p->password.'</span><a class="unmask" href=""><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>
               <td id="notes">'.$p->notes.'</td>
               <td num="'.$p->id.'"><a class="edit" href="" style="margin-right: 5px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a><a class="remove" href=""><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
            </tr>
            ';
         }
	}
      ?>
   </tbody>
</table>
<script>

   $(document).ready(function(){
      maskAll();
   });

   $(document).on('click', 'a.unmask', function() {
      $(this).children(":first").attr('class', 'glyphicon glyphicon-eye-close');
      $(this).attr('class', 'mask');
      var el = $(this).parent().children(":first");
      var pw = $(el).attr('pw');
      $(el).unmask();
      $(el).text(pw);
      $(el).removeAttr('class');
      return false;
   });

   $(document).on('click', 'a.mask', function() {
      $(this).children(":first").attr('class', 'glyphicon glyphicon-eye-open');
      $(this).attr('class', 'unmask');
      var el = $(this).parent().children(":first");
      $(el).attr('class', 'password');
      return false;
   });

   $(document).on('click', 'a.edit', function() {
      // alert ("somehow we need to edit " + $(this).parent().attr('num'));
      $('#update_id').val($.trim($(this).parent().attr('num')));
      $('#update_name').val($.trim($(this).parent().siblings('#name').text()));
      $('#update_username').val($.trim($(this).parent().siblings('#username').text()));
      $('#update_notes').val($.trim($(this).parent().siblings('#notes').text()));
      $('#update_password').val($.trim($(this).parent().siblings('#password').children('.password').attr('pw')));
      updateForm()
      return false;
   });

   $(document).on('click', 'a.remove', function() {
      var id = $(this).parent().attr('num');
      $.ajax({
         type: "POST",
         data: {password: id},
         url: "helpers/PostPasswordRemove.php",
         success: function(data){
            console.log(data);
         }
      });
   });

   function maskAll() {
      $('.password').mask('**************');
   }

   function updateForm() {
      $('#update_form').attr('class', 'row');
      $('#new_password').attr('class', 'row hidden');
   }

   function showForm() {
      $('#update_form').attr('class', 'row hidden');
      $('#new_password').attr('class', 'row');
   }

   function hideForm() {
      $('form').attr('class', 'row hidden');
   }
</script>
