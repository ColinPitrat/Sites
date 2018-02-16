<?php
	require('./include/cadre.php');
	if($_POST['captcha_ans'])
	{
		top($_POST['origin']);
		print 'Should redirect to '.$_POST['origin'];
		SqlConnect();
		$res = SqlQuery('select * from captcha where id = '.$_POST['captcha_id'].' limit 0,1');
		$row = mysql_fetch_object($res);
		if($row->answer == $_POST['captcha_ans'])
		{
			SqlQuery('insert into comments(subject, name, date, texte, captcha) values ("'.$_POST['subject'].'", "'.$_POST['name'].'", "'.date('Y-m-d H:i:s').'", "'.$_POST['comment'].'", '.$_POST['captcha_id'].')');
			print '<p>Votre commentaire a bien &eacute;t&eacute; post&eacute;.</p>';
		}
		else
		{
			print "La verification du captcha a &eacute;chou&eacute;. Seriez vous un robot ?! (".$row->answer.", ".$_POST['captcha_ans'].")";
		}
	}
	else if($_GET['subject'])
	{
		top();
		SqlConnect();
		$res = SqlQuery('select max(id) from captcha;');
		$maxid = mysql_fetch_row($res);
		$cid = rand(0, $maxid[0]);
		$res = SqlQuery('select * from captcha where id >= '.$cid.' limit 0,1');
		if($row = mysql_fetch_object($res))
		{
			print '<h1>Poster un commentaire</h1>';
			print '<center><form action="" method="post"><table cellspacing="10px" width="100%">';
			print '<tr><td align="right">Nickname : </td><td><input type="text" name="name"/></td></tr>';
			print '<tr><td align="right">Votre texte : </td><td><textarea name="comment" rows="10" cols="60" ></textarea><br/></td></tr>';
			print '<tr><td align="right">Anti-spam:<br/>'.$row->question.'</td><td><input type="hidden" name="captcha_id" value="'.$row->id.'"/><input type="hidden" name="subject" value="'.$_GET['subject'].'"/><input type="text" name="captcha_ans"/></td></tr>';
			print '</table><input type="submit" value="Poster"></form></center>';
		}
	}
	bottom();
?>
