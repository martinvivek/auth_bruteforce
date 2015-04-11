<?php
defined('MOODLE_INTERNAL') || die();

if (!isset($config->limit)) {
    $config->limit = "20";
}

?>
<table cellspacing="0" cellpadding="5" border="0">

<tr valign="top" class="required">
    <td align="right"><label for="limit"><?php print_string('auth_bruteforcelimit_key', 'auth_bruteforce') ?>: </label></td>
    <td>
        <input name="limit" id="limit" type="text" size="30" value="<?php echo $config->limit ?>" />
        <?php

        if (isset($err["limit"])) {
            echo $OUTPUT->error_text($err["limit"]);
        }

        ?>
    </td>
    <td>
        <?php
        print_string("auth_bruteforcelimit", "auth_bruteforce");
        ?>
    </td>
</tr>
</table>
