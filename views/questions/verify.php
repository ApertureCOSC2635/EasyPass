<?php
   use Helpers\Questions;

   $questions = Questions::getQuestions($_SESSION['login']);
 ?>
<form method="post" action="helpers/postquestions.php">
   <div id="questions">
      <div class="form-group">
         <input type="text" class="form-control" id="qf1" name="qf1"/ disabled value="<?= $questions->q1 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 1" id="q1" name="q1"/>
      </div>
      <div class="form-group">
         <input type="text" class="form-control" id="qf2" name="qf2"/ disabled value="<?= $questions->q2 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 2" id="q2" name="q2"/>
      </div>
      <div class="form-group">
         <input type="text" class="form-control" id="qf3" name="qf3"/ disabled value="<?= $questions->q3 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 3" id="q3" name="q3"/>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12"><p><button class="btn btn-success" type="submit" role="button" id="button" >Access</button></p></div>
   </div>
</form>
