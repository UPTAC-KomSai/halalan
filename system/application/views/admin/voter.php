<script>
function copyToList(from,to)
{
  fromList = document.getElementById(from);
  toList = document.getElementById(to);
  var sel = false;
  for (i=0;i<fromList.options.length;i++)
  {
    var current = fromList.options[i];
    if (current.selected)
    {
      sel = true;
      txt = current.text;
      val = current.value;
      toList.options[toList.length] = new Option(txt,val);
      fromList.options[i] = null;
      i--;
    }
  }
  if (!sel) alert ('You haven\'t selected any options!');
}

function allSelect()
{
  List = document.getElementById('chosen');
  for (i=0;i<List.length;i++)
  {
     List.options[i].selected = true;
  }
}
</script>
<div class="admin_menu">
	<div id="left_menu">
		<ul>
			<li><?= anchor('admin', 'Home'); ?> | </li>
			<li><?= anchor('admin/voters', 'Voters'); ?> |  </li>
			<li><?= anchor('admin/parties', 'Parties'); ?> | </li>
			<li><?= anchor('admin/positions', 'Positions'); ?> | </li>
			<li><?= anchor('admin/candidates', 'Candidates'); ?></li>
		</ul>
	</div>
	<div id="right_menu">
		<p>LOGGED IN AS <?= strtoupper($username); ?> | <?= anchor('gate/logout', 'LOGOUT'); ?></p>
	</div>
	<div class="clear"></div>
</div>

<?php if (isset($messages) && !empty($messages)): ?>
<div class="message">
	<div class="message_header"><?= e('common_message_box'); ?></div>
	<div class="message_body">
		<ul>
			<?php foreach ($messages as $message): ?>
			<li><?= $message; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>
<?php if ($action == 'add'): ?>
<?= form_open('admin/do_add_voter', array('onsubmit'=>'allSelect();')); ?>
<?php elseif ($action == 'edit'): ?>
<?= form_open('admin/do_edit_voter/' . $voter['id'], array('onsubmit'=>'allSelect();')); ?>
<?php endif; ?>
<div class="body">
	<div class="center_body">
		<fieldset>
			<legend><span class="header"> <?= e('admin_' . $action . '_voter_label'); ?> </span></legend>
			<table>
				<tr>
					<td width="30%"><?= ($settings['password_pin_generation'] == 'email') ? e('admin_voter_email') : e('admin_voter_username'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'username', 'value'=>$voter['username'])); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_voter_first_name'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'first_name', 'value'=>$voter['first_name'])); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_voter_last_name'); ?></td>
					<td width="70%"><?= form_input(array('name'=>'last_name', 'value'=>$voter['last_name'])); ?></td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_voter_general_positions'); ?></td>
					<td width="70%">
					<?php if (empty($general)): ?>
					<em><?= e('admin_voter_no_general_positions'); ?></em>
					<?php else: ?>
					<?php foreach ($general as $g): ?>
					<?= $g['position']; ?><br />
					<?php endforeach; ?>
					<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td width="30%"><?= e('admin_voter_specific_positions'); ?></td>
					<td width="70%">
					<?php if (empty($specific)): ?>
					<em><?= e('admin_voter_no_specific_positions'); ?></em>
					<?php else: ?>
						<table>
							<tr>
								<td><?= form_dropdown('possible[]', $possible, '', 'id="possible" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_voter_possible_positions'); ?></td>
								<td><input type="button" onclick="copyToList('possible','chosen');" value="  &gt;&gt;  " /><br /><input type="button" onclick="copyToList('chosen','possible');" value="  &lt;&lt;  " /></td>
								<td><?= form_dropdown('chosen[]', $chosen, '', 'id="chosen" multiple="true" size="5" style="width : 150px;"'); ?><br /><?= e('admin_voter_chosen_positions'); ?></td>
							</tr>
						</table>
					<?php endif; ?>
					</td>
				</tr>
				<?php if ($action == 'edit'): ?>
				<tr>
					<td width="30%"><?= e('admin_voter_regenerate'); ?></td>
					<td width="70%">
					<?= form_checkbox(array('name'=>'password', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_password'); ?>
					<?php if ($settings['pin']): ?>
					<?= form_checkbox(array('name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?= e('admin_voter_pin'); ?>
					<?php endif; ?>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</fieldset>
	</div>
	<div class="clear"></div>
</div>
<div class="menu" id="menu_center">
	<div id="center_menu">
		<?= anchor('admin/voters', 'GO BACK'); ?>
		|
		<?= form_submit('submit', e('admin_' . $action . '_voter_submit')) ?>
	</div>
	<div class="clear"></div>
</div>
<?= form_close(); ?>