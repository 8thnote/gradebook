<?php
/*************************************************************************************************/
if (isset($_POST['user_enter'])) {
  $login = clear($_POST['login']);
  $password = clear($_POST['password']);
  $user_info = db_select("`users`", "*", "`login` = '$login'");
  if ($password == $user_info['password']) {
    $_SESSION['user'] = $user_info;
    alert('Enter success.');
  }
  else {
    alert('Enter filed. Wrong login or password.');
  }
}
/*************************************************************************************************/
if (isset($_POST['user_exit'])) {
  session_destroy();
  alert('Exit success.', 1, '/');
}
/*************************************************************************************************/
if (isset($_POST['user_register'])) {
  $login = clear($_POST['login']);
  $email = clear($_POST['email']);
  $pass_1 = clear($_POST['pass_1']);
  $pass_2 = clear($_POST['pass_2']);
  $date = date("Y-m-d H:i:s");
  if ($pass_1 == $pass_2) {
    if(db_select("`users`", "*", "`login` = '$login'")) {
      alert('This login is already use.');
    }
    elseif (db_select("`users`", "*", "`email` = '$email'")) {
      alert('This email is already use.');
    }
    else {
      if (db_insert("`users`", "login, password, email, date", "'$login', '$pass_1', '$email', '$date'")) {
        alert('Register success.');
      }
      else {
        alert('Register filed.');
      }
    }
  }
  else {
    alert('Passwords missmath.');
  }
}
/*************************************************************************************************/
if (isset($_POST['user_profile_edit'])) {
  $user = db_select("`users`", "*", "`id` = '{$_POST['user_profile_id']}'");
  print '
  <div id="popup">
    <form name="user_profile_edit" method="post">
      <table class="profile_page">
        <tr>
          <th colspan="2">Edit profile</th>
        </tr>
        <tr>
          <td>Status:</td>
          <td><input type="text" name="user_status"  value="' . $user['status'] . '" disabled></td>
        </tr>
        <tr>
          <td>Login:</td>
          <td><input type="text" name="user_login" value="' . $user['login'] . '" disabled></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input type="text" name="user_email" value="' . $user['email'] . '" disabled></td>
        </tr>
        <tr>
          <td>Name:</td>
          <td><input type="text" name="user_name" value="' . $user['name'] . '"></td>
        </tr>
        <tr>
          <td>Surname:</td>
          <td><input type="text" name="user_surname" value="' . $user['surname'] . '"></td>
        </tr>
        <tr>
          <td><input type="hidden" name="user_profile_id" value="' . $user['id'] . '"></td>
          <td><input type="submit" name="user_profile_save" value="Save"></td>
        </tr>
      </table>
    </form>
  </div>';
}
/*************************************************************************************************/
if (isset($_POST['user_profile_save'])) {
  if (db_update(
        "`users`",
        "`name` = '{$_POST['user_name']}', `surname` = '{$_POST['user_surname']}'",
        "`id` = '{$_POST['user_profile_id']}'")) {
    alert('Information saved.');
  }
  else {
    alert('Error. Information did not saved.');
  }
}
/*************************************************************************************************/
?>