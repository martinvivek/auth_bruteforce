<?php
defined ( 'MOODLE_INTERNAL' ) || die();

if ( !isset( $config->limit ) ) {
    $config->limit = '20';
}

global $CFG, $OUTPUT;

?>
<table cellspacing="0" cellpadding="5" border="0">
    <tr valign="top" class="required">
        <td align="right"><label for="limit"><?php print_string('auth_bruteforcelimit_key', 'auth_bruteforce') ?>: </label></td>
        <td>
            <input name="limit" id="limit" type="text" size="30" value="<?php echo $config->limit ?>" />
            <?php

            if ( isset( $err[ 'limit' ] ) ) {
                echo $OUTPUT->error_text ( $err[ 'limit' ] );
            }

            ?>
            <p><?php
                print_string ( 'auth_bruteforcelimit', 'auth_bruteforce' );
                ?></p>
        </td>
    </tr>
    <?php
    echo $toolsLogEnabled = get_config('tool_log', 'enabled_stores');
    echo $testToolsLogEnabled = strpos($toolsLogEnabled, 'logstore_standard');

    if($CFG->version >= 2014050800 && $testToolsLogEnabled === false ) {?>
        <tr>
            <td colspan="2">
                <?php
                echo $OUTPUT->error_text (
                    get_string ( 'auth_bruteforcetesterror', 'auth_bruteforce' )
                );
                ?>
            </td>
        </tr><?php
    }?>

</table>
