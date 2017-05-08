<!--
First we need a page that displays the users passwords and
privately stored data in some way.
It also needs to let users add a new password to be stored.
This should be stored in the '/pages' folder.
If you look at the structure of the 'rebuild' branch,
this is just a page that gets included in the index page.

Second we need a new helper in '/helpers'.
This helper needs to receive input (new password/data)
from the user and store it.

We can either store this in the database or create each user their own
file and continue to append data to it. I do believe we are hashing this
though like we did with html local storage??
The helper also needs to be able to remove specific passwords.

Thirdly we need another helper that generates the password data to be
displayed on the first page.
So I guess this will need to fetch the hashed data,
decrypt it and format it in a readable format.

My advice would be to put each piece of data (site:password) into an array.

Both helpers need to bounce back to index if $_SESSION['login'] is not set.
-->

<?php
session_start();
require_once './vendor/autoload.php';
include_once './helpers/db.php';
/* Connect to SQL Database */
$database = dbConnect();

$test_data=array
  (
  array("website"=>"facebook", "username"=>"scotty", "password"=>"Password1"),
  array("website"=>"google", "username"=>"scott.phillips", "password"=>"my_password"),
  array("website"=>"ebay", "username"=>"darth_scotty", "password"=>"p@ssw0rd")
  );

$test_user = 'scotty.phillips@hotmail.com';

$query = "SELECT * FROM passwords WHERE email = '$test_user'";
$result = mysqli_fetch_all($database->query($query), MYSQLI_ASSOC);

?>



  <div class="panel panel-default">
    <div class="panel-heading">Password database for * user * </div>
    <div class="panel-body">

        <form>



      	<div class="input-group control-group after-add-more" style='margin-top:10px'>
          <div class='col-sm-3 no-padding'>
            <input type="text" name="website[]" class="form-control" placeholder="Website">
          </div>
          <div class='col-sm-4 no-padding'>
            <input type="text" name="username[]" class="form-control" placeholder="Username">
          </div>
          <div class='col-sm-4 no-padding'>
            <input type="text" name="password[]" class="form-control" placeholder="Password">
          </div>
          <div class='col-sm-1'>
            <div class="input-group-btn">
              <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
          </div>
        </div>

        <?php
             foreach ($test_data as $values) {
            echo "<div class='input-group control-group' style='margin-top:10px'>
                 <div class='col-sm-3 no-padding'>
                    <input type='text' name='website[]' class='form-control' value='{$values['website']}'>
                  </div>
                  <div class='col-sm-4 no-padding'>
                    <input type='text' name='username[]' class='form-control' value='{$values['username']}'>
                  </div>
                  <div class='col-sm-4 no-padding'>
                    <input type='text' name='password[]' class='form-control' value='{$values['password']}'>
                  </div>
                  <div class='col-sm-1'>
                    <div class='input-group-btn'>
              <button class='btn btn-danger remove' type='button'><i class='glyphicon glyphicon-minus'></i></button>
                  </div>
                  </div>
                </div> ";
             }
        ?>

        <div class="row spacer">
           <div class="col-md-12"><p><button class="btn btn-success" role="button" id="button" >Save</button></p></div>
        </div>
        </form>

        <!-- Copy Fields -->
        <div class="copy hide">
          <div class="control-group input-group" style="margin-top:10px">
            <div class='col-sm-3 no-padding'>
              <input type="text" name="website[]" class="form-control" placeholder="Website">
            </div>
            <div class='col-sm-4 no-padding'>
              <input type="text" name="username[]" class="form-control" placeholder="Username">
            </div>
            <div class='col-sm-4 no-padding'>
              <input type="text" name="password[]" class="form-control" placeholder="Password">
            </div>
            <div class='col-sm-1'>
              <div class="input-group-btn">
                <button class="btn btn-danger remove" id="button" type="button"><i class="glyphicon glyphicon-minus"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div id="scottsDiv"></div>
    </div>
  </div>

<script type="text/javascript">

    $(document).ready(function() {

      $(".add-more").click(function(){
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });

      $("body").on("click",".remove",function(){
          $(this).parents(".control-group").remove();
      });

    });

</script>

<script>
$(document).ready(function(){
  $("#button").click(function(){
      $.ajax({
        type: "POST",
        url: "pages/ajaxsubmit.php",
        data: "blank",
        cache: false,
        success: function(result){
            $("#scottsDiv").html(result);
        },
        error: function (xhr, ajaxOptions, thrownError) {
           alert(xhr.status);
           alert(thrownError);
        }
      });
    return false;
  });
});
</script>
