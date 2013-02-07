<?php
/*************************************************************************************************/
if (isset($_SESSION['user'])) {
/*************************************************************************************************/
  print '
  <table class="message_page">
    <tr>
      <td>' . url('message/in', 'Inbox') . '</td>
      <td>' . url('message/out', 'Outbox') . '</td>
      <td>' . url('message/new', 'New', 'New message') . '</td>
    </tr>
  </table>';
/*************************************************************************************************/
  if ($page['arg'][1] == 'new') {
    print '
    <form name="message" method="post">
      <table class="message_page">
        <tr>
          <td>Receiver:</td>
          <td><input type="text" name="message_receiver" required></td>
        </tr>
        <tr>
          <td>Subject:</td>
          <td><input type="text" name="message_subject" required></td>
        </tr>
        <tr>
          <td>Text:</td>
          <td><textarea rows="10" cols="50" maxlength="255" name="message_text" required></textarea></td>
        </tr>
        <tr>
          <td>Actions:</td>
          <td><input type="submit" name="message_send" value="Send"><input type="reset" value="Clear"></td>
        </tr>
      </table>
    </form>';
  }
/*************************************************************************************************/
  elseif ($page['arg'][1] == 'out') {
    $message = get_message($_SESSION['user']['id'], 'out');
    print '
    <form name="message" method="post">
      <table class="message_page">
        <tr>
          <th></th>
          <th>Subject</th>
          <th>Receiver</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>';
    for ($i=1; $i<=$message[0]; $i++) {
      print '
        <tr>
          <td>' . $message[$i]['status'] . '</td>
          <td>' . $message[$i]['subject'] . '</td>
          <td>' . $message[$i]['receiver'] . '</td>
          <td>' . $message[$i]['date'] . '</td>
          <td><input type="submit" name="message_delete' . $message[$i]['id'] . '" value="Delete"></td>
        </tr>';
    }
    print '
      </table>
    </form>';
  }
/*************************************************************************************************/
  else {
    $message = get_message($_SESSION['user']['id'], 'in');
    print '
    <form name="message" method="post">
      <table class="message_page">
        <tr>
          <th></th>
          <th>Subject</th>
          <th>Sender</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>';
    for ($i=1; $i<=$message[0]; $i++) {
      print '
        <tr>
          <td>' . $message[$i]['status'] . '</td>
          <td>' . $message[$i]['subject'] . '</td>
          <td>' . $message[$i]['sender'] . '</td>
          <td>' . $message[$i]['date'] . '</td>
          <td><input type="submit" name="message_delete' . $message[$i]['id'] . '" value="Delete"></td>
        </tr>';
    }
    print '
      </table>
    </form>';
  }
/*************************************************************************************************/
}
/*************************************************************************************************/
else {
  alert('You are not logined!', '1', '/login');
}
/*************************************************************************************************/
?>