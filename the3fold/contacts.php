<?php
  include('./include/cadre.php');
  top();

  if($_POST['captcha_ans'])
  {
      SqlConnect();
      mail("colin.pitrat@gmail.com", "Message de ".$_POST['mail']." sur the3fold", $_POST['message']);
      $res = SqlQuery('select * from captcha where id = '.$_POST['captcha_id'].' limit 0,1');
      $row = mysqli_fetch_object($res);
      if($row->answer == $_POST['captcha_ans'])
      {
          SqlQuery('insert into comments(subject, name, date, texte, captcha) values ("'.$_POST['subject'].'", "'.$_POST['name'].'", "'.date('Y-m-d H:i:s').'", "'.$_POST['comment'].'", '.$_POST['captcha_id'].')');
          print '<p>Votre mail a bien &eacute;t&eacute; envoy&eacute;.</p>';
      }
      else
      {
          print "La verification du captcha a &eacute;chou&eacute;. Seriez vous un robot ?! (".$row->answer.", ".$_POST['captcha_ans'].")";
      }
  }
?>

  <h1>Contacts</h1>
  <br />

  <h2>Colin Pitrat</h2>

  <table>
  <tr>
  <td>
  <?php
  SqlConnect();
  $res = SqlQuery('select max(id) from captcha;');
  $maxid = mysqli_fetch_row($res);
  $cid = rand(0, $maxid[0]);
  $res = SqlQuery('select * from captcha where id >= '.$cid.' limit 0,1');
  if($row = mysqli_fetch_object($res))
  {
  ?>
      <table>
      <form action="" method="post">
          <tr><td valign="top">Votre adresse mail:</td>                      <td><input type="text" name="mail"/></td> </tr>
          <tr><td valign="top">Anti-spam: <?php print $row->question ?></td> <td><input type="hidden" name="captcha_id" value="<?php print $row->id?>"/><input type="text" name="captcha_ans"/></td></tr>
          <tr><td valign="top">Votre message:</td>                           <td><textarea name="message" rows="10" cols="50"></textarea></td></tr>
          <tr><td></td>                                                      <td><input type="submit" value="Envoyer"/></td></tr>
      </form>
      </table>
  <?php
  }
  ?>
  </td>
  </tr>
  </table>
<?php
  bottom();
?>
