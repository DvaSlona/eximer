<?php
include_once dirname(__FILE__) . '/config/authpostmaster.php';
$tmplVars['title'] = _('Add Group');
include 'templates/header.php';
?>
    <div id="menu">
      <a href="admingroup.php"><?php echo _('Manage Groups'); ?></a><br>
      <a href="admin.php"><?php echo _('Main Menu'); ?></a><br>
      <br><a href="logout.php"><?php echo _('Logout'); ?></a><br>
    </div>
    <div id="Forms">
    <form name="adminadd" method="post" action="admingroupaddsubmit.php">
      <table align="center">
        <tr>
          <td><?php echo _('Group Address'); ; ?>:</td>
          <td>
            <input name="localpart" type="text" class="textfield">@
            <?php echo $_SESSION['domain']; ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="button">
            <input name="submit" type="submit"
              value="<?php echo _('Submit'); ?>">
          </td>
        </tr>
      </table>
    </form>
    </div>
<?php
include 'templates/footer.php';
