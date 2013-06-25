<?php include 'header.php'; ?>
<div id="Centered">
  <table align="center">
    <tr>
      <td>
        <a href="adminuser.php">
          <?php
            echo _('Add, delete and manage POP/IMAP accounts');
          ?>
        </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="adminalias.php">
          <?php
            echo _('Add, delete and manage aliases, forwards and a Catchall');
          ?>
        </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="admingroup.php">
          <?php echo _('Add, delete and manage groups'); ?>
        </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="adminfail.php">
          <?php echo _('Add, delete and manage :fail:\'s'); ?>
        </a>
      </td>
    </tr>
    <?php if ('' != $settings['mailmanroot']): ?>
    <tr>
        <td>
            <a href="adminlists.php"><?php echo _('Manage mailing lists'); ?></a>
        </td>
    </tr>
    <?php endif ?>
    <tr>
      <td style="padding-top:1em">
        <a href="logout.php"><?php echo _('Logout'); ?></a>
      </td>
    </tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
<?php
if (count($domain->getAliases()) > 0): ?>
    <tr>
        <td>Domain data:</td>
    </tr>
    <?php foreach ($domain->getAliases() as $alias): ?>
    <tr>
        <td>
            <?php echo $alias->getName() . ' is an alias of ' . $domain->getName(); ?>
        </td>
    </tr>
    <?php endforeach ?>
<?php endif ?>
  </table>
</div>
<?php include 'footer.php'; ?>

