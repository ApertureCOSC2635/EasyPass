<?php
   namespace Helpers;
   include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

   use Helpers\Questions;

   class PostQuestions {

      protected $q1;
      protected $q2;
      protected $q3;
      protected $a1;
      protected $a2;
      protected $a3;
      protected $sms_response;

      public function __construct() {
         // Collect the posted data and store it as variables in the class.
         $this->q1 = $_POST['qf1'];
         $this->q2 = $_POST['qf2'];
         $this->q3 = $_POST['qf3'];
         $this->a1 = $_POST['q1'];
         $this->a2 = $_POST['q2'];
         $this->a3 = $_POST['q3'];
         $this->sms_response = $_POST['smscode'];
      }

      public function checkQuestions() {
         session_start();
         $q = new Questions;
         $answers = array(hash("sha256", $this->a1),hash("sha256", $this->a2),hash("sha256", $this->a3));
         if(!$this->validateSMS()) {
           $_SESSION['error'] = "Error: SMS code is incorrect";
         }
         else if(isset($_SESSION['new'])) {
            $questions = array($this->q1,$this->q2,$this->q3);
            $q->create($questions, $answers, $_SESSION['new']);
            $_SESSION['login'] = $_SESSION['new'];
            $_SESSION['success'] = true;
            $_SESSION['password'] = $this->a1.$this->a2.$this->a3;
            unset($_SESSION['new']);
         }
         else if(isset($_SESSION['login'])) {
            $result = $q->verify($answers, $_SESSION['login']);
            if($result == true) {
               $_SESSION['success'] = true;
               $_SESSION['password'] = $this->a1.$this->a2.$this->a3;
            }
            else if($result == false) {
               $_SESSION['error'] == "Answers are incorrect";
            }
         }
         header('Location: /');
      }
      private function validateSMS() {
         if(isset($_SESSION['sms'])) {
            if($_SESSION['sms'] == $this->sms_response) {
              return true;
            }
            return false;
         }
         return false;
      }
   }


   $post = new PostQuestions;
   $post->checkQuestions();

?>
