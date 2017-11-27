    <?php if($users){header("Location:index.php");}?>
  <form action="" method="post">
  <h1>Sign up</h1><br/>

  <span class="input"></span>
  <input type="text" name="name" placeholder="Full name" title="Format: Xx[space]Xx (e.g. Alex Cican)" autofocus autocomplete="off" required pattern="^\w+\s\w+$" />
  <span class="input"></span>
  <input type="email" name="email" placeholder="Email address" required />
  <span id="passwordMeter"></span>
  <input type="password" name="password" id="password" placeholder="Password" title="Password min 8 characters. At least one UPPERCASE and one lowercase letter" required pattern="(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"/>

  <button type="submit" value="Sign Up" name="submit" title="Submit form" class="icon-arrow-right"><span>Sign up</span></button>
</form>
<?php 
    $auth_class->signup($_POST);
?>
  <h4 style="text-align:center;position:absolute;top:80%;left:45%;"><a href="?page=signin">Sign In</a></h4><br/>