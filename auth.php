<?php
/**
 * bruteforce protect
 *
 * @package auth_bruteforce
 * @author Eduardo Kraus
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined ( 'MOODLE_INTERNAL' ) || die();

require_once ( $CFG->libdir . '/authlib.php' );

/**
 * bruteforce authentication plugin.
 */
class auth_plugin_bruteforce extends auth_plugin_base
{

    /**
     * Constructor.
     */
    function auth_plugin_bruteforce ()
    {
        Global $DB, $CFG;
        $this->authtype = 'bruteforce';
        $this->config = get_config ( 'auth/bruteforce' );

        // check moodle version
        if($CFG->version >= 2014050800)
        {
            $sql = "SELECT id
                    FROM {logstore_standard_log}
                    WHERE action = ?
                      AND ip = ?
                      AND eventname LIKE ?
                      AND timecreated > ? ";

            $tests = $DB->get_records_sql($sql,
                array(
                    'failed',
                    getremoteaddr(),
                    '_core_event_user_login_failed',
                    time() - 86400 // 86400 = 24 * 60 * 60
                )
            );
        }
        else
        {
            $sql = "SELECT id
                    FROM {log}
                    WHERE module = ?
                      AND ip = ?
                      AND action LIKE ?
                      AND time > ? ";
            $tests = $DB->get_records_sql($sql,
                array(
                    'login',
                    getremoteaddr(),
                    'error',
                    time() - 86400 // 86400 = 24 * 60 * 60
                )
            );
        }

        if ( !isset ( $this->config->limit ) ) {
            $this->config->limit = 20;
        }

        if ( count ( $tests ) >= $this->config->limit )
            die( get_string ( 'auth_bruteforcebloqued', 'auth_bruteforce' ) );
    }

    function user_login ($username, $password) {
        return false;
    }

    function prevent_local_passwords() {
        return true;
    }

    function is_internal() {
        return false;
    }

    function can_change_password() {
        return false;
    }

    function config_form($config, $err, $user_fields) {
        include 'config.php';
    }

    function process_config($config) {
        // set to defaults if undefined
        if (!isset ($config->limit)) {
            $config->limit = 20;
        }

        // save settings
        set_config('limit', $config->limit, 'auth/bruteforce');

        return true;
    }

}


