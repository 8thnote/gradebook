<?php
print '
<form name="user_login" method="post">
  <table id="login_page">
    <tr><th colspan="2">Authorization</th></tr>
    <tr><td>Login:   </td><td><input type="text" name="login" maxlength="15" required>                               </td></tr>
    <tr><td>Password:</td><td><input type="password" name="password" maxlength="15" required>                        </td></tr>
    <tr><td>         </td><td><input type="submit" name="user_enter" value="Enter"><input type="reset" value="Clear"></td></tr>
    <tr><td>         </td><td><a href="?page=register">Registration</a>                                              </td></tr>
  </table>
</form>';
?>