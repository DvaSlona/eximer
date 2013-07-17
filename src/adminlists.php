<?php
include_once dirname(__FILE__) . '/config/authpostmaster.php';
  if (isset($_POST['listname'])) {
    header ("Location: {$settings['mailmanroot']}/admin/{$_POST['listname']}");
  }

$tmplVars['title'] = _('Mailing List Administration');
include 'templates/header.php';
?>
    <div id="menu">
      <?php print "<a href=\"{$settings['mailmanroot']}/create\">" . _('Add a list') . '</a><br>'; ?>
      <a href="admin.php"><?php echo _('Main Menu'); ?></a><br>
      <br><a href="logout.php"><?php echo _('Logout'); ?></a><br>
    </div>
    <div id="Forms">
      <form name="adminlists" method="post" action="adminlists.php">
	<table align="center">
	  <tr>
            <td>
              <?php echo _('Please enter the name of the list to admin'); ?>:
            </td>
          </tr>
	  <tr>
            <td>
              <input name="listname" type="text" class="textfield">
            </td>
          </tr>
	  <tr>
            <td class="button">
              <input name="submit" type="submit"
                value="<?php echo _('Submit'); ?>">
            </td>
          </tr>
	</table>
      </form>
    </div>
<?php
include 'templates/footer.php';
