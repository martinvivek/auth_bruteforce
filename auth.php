<?php
/**
 * bruteforce protect
 *
 * @package auth_bruteforce
 * @author Eduardo Kraus
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

/**
 * bruteforce authentication plugin.
 */
class auth_plugin_bruteforce extends auth_plugin_base {

    /**
     * Constructor.
     */
    function auth_plugin_bruteforce() {
        Global $DB, $CFG;
        $this->authtype = 'bruteforce';
        $this->config = get_config('auth/bruteforce');

        if($CFG->version >= 2014050800)
        {
            $sql = "SELECT id
                    FROM {logstore_standard_log}
                    WHERE action = 'failed'
                      AND ip = '".$_SERVER['REMOTE_ADDR']."'
                      AND eventname LIKE '_core_event_user_login_failed'
                      AND timecreated > (UNIX_TIMESTAMP()-86400) ";
        }
        else
        {
            $sql = "SELECT id
                    FROM {log}
                    WHERE module = 'login'
                      AND ip = '".$_SERVER['REMOTE_ADDR']."'
                      AND action LIKE 'error'
                      AND time > (UNIX_TIMESTAMP()-86400) ";
        }
        $tests = $DB->get_records_sql($sql);

        if (!isset ($this->config->limit)) {
            $this->config->limit = 20;
        }

        if(count($tests) >= $this->config->limit )
            die(get_string("auth_bruteforcebloqued", "auth_bruteforce"));
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
        include "config.php";
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


