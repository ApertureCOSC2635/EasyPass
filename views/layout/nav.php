<div class="header clearfix">
   <nav>
      <ul class="nav nav-pills pull-right">
         <li role="presentation" class="active"><a href="#">Home</a></li>
         <li role="presentation"><a href="#">About</a></li>
         <?php if(isset($_SESSION['login'])) {
            echo '
            <li role="presentation" class="dropdown">
               <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  '.$_SESSION['login'].' <span class="caret"></span>
               </a>
               <ul class="dropdown-menu">
                  <li><a href="helpers/Logout.php">Logout</a></li>
               </ul>
            </li>
            ';
            }
         ?>
      </ul>
   </nav>
   <h3 class="text-muted">EasyPass&copy; </h3>
</div>
