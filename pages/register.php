<?php
print '
<form name="user_register" method="post">
  <table id="register_page">
    <tr><th colspan="2">Registration</th></tr>
    <tr><td>Login:   </td><td><input type="text" name="login" maxlength="15" placeholder="Enter your nickname" required>       </td></tr>
    <tr><td>Email:   </td><td><input type="email" name="email" maxlength="15" placeholder="Enter your email" required>         </td></tr>
    <tr><td>Password:</td><td><input type="password" name="pass_1" maxlength="15" placeholder="Enter your password" required>  </td></tr>
    <tr><td>         </td><td><input type="password" name="pass_2" maxlength="15" placeholder="Confirm your password" required></td></tr>
    <tr><td>         </td><td><input type="submit" name="user_register" value="Register">                                      </td></tr>
  </table>
</form>
';
?>