<?php
/*************************************************************************************************/
if (isset($_SESSION['user'])) {
  $user_id = empty($page['arg'][1]) ? $_SESSION['user']['id'] : $page['arg'][1];
  $user = db_select_row("`users`", "*", "`id` = '$user_id'");
/*************************************************************************************************/
  if ($_SESSION['user']['id'] == $user['id']) {
    print '
    <form name="user_profile" method="post">
      <table class="profile_page">
        <tr>
          <th colspan="2">My profile</th>
        </tr>
        <tr>
          <td>Status:</td>
          <td>' . $user['status'] . '</td>
        </tr>
        <tr>
          <td>Login:</td>
          <td>' . $user['login'] . '</td>
        </tr>
        <tr>
          <td>Email:</td>
          <td>' . $user['email'] . '</td>
        </tr>
        <tr>
          <td>Name:</td>
          <td>' . $user['name'] . '</td>
        </tr>
        <tr>
          <td>Surname:</td>
          <td>' . $user['surname'] . '</td>
        </tr>
        <tr>
          <td><input type="hidden" name="user_profile_id" value="' . $user['id'] . '"></td>
          <td><input type="submit" name="user_profile_edit" value="Edit"></td>
        </tr>
      </table>
    </form>';
  }
/*************************************************************************************************/
  else {
    print '
    <table class="profile_page">
      <tr>
        <th colspan="2">' . $user['login'] . '*s profile</th>
      </tr>
      <tr>
        <td>Status:</td>
        <td>' . $user['status'] . '</td>
      </tr>
      <tr>
        <td>Login:  </td>
        <td>' . $user['login'] . '</td>
      </tr>
      <tr>
        <td>Email:  </td>
        <td>' . $user['email'] . '</td>
      </tr>
      <tr>
        <td>Name:</td>
        <td>' . $user['name'] . '</td>
      </tr>
      <tr>
        <td>Surname:</td>
        <td>' . $user['surname'] . '</td>
      </tr>
    </table>';
  }
}
/*************************************************************************************************/
else {
  alert('You are not logined!', '1', '/login');
}
/*************************************************************************************************/
?>