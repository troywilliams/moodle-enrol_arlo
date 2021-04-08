<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
define('CLI_SCRIPT', true);

require(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../lib.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot.'/enrol/arlo/lib.php');

// We may need a lot of memory here.
@set_time_limit(0);
raise_memory_limit(MEMORY_HUGE);

list($options, $unrecognized) = cli_get_params(
    [
        'non-interactive'   => false,
        'debug'             => false,
        'verbose'           => false,
        'help'              => false
    ],
    [
        'v' => 'verbose',
        'h' => 'help'
    ]
);

$help = "
?

Options:
--non-interactive           No interactive questions or confirmations
--debug                     Developer debugging switched on.
-v, --verbose               Print out verbose messages.
-h, --help                  Print out this help.

Example:
\$ sudo -u www-data /usr/bin/php enrol/arlo/?.php -h
";

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}
if ($options['help']) {
    echo $help;
    die;
}
if (!enrol_is_enabled('arlo')) {
    cli_error(get_string('pluginnotenabled', 'enrol_arlo'), 2);
}
if ($options['debug']) {
    set_debugging(DEBUG_DEVELOPER, true);
}
$trace = new null_progress_trace();
if ($options['verbose']) {
    $trace = new text_progress_trace();
}
$interactive = empty($options['non-interactive']);


$sql = "SELECT c.*
          FROM {enrol_arlo_contact} c
         WHERE c.userid IN (SELECT c.userid
                              FROM {enrol_arlo_contact} c
                          GROUP BY c.userid
                     HAVING COUNT(c.userid) = 2) 
      ORDER BY c.userid";
$records = $DB->get_records_sql($sql);
foreach ($records as $record) {
    $contactResource = enrol_arlo\local\external::get_contact_resource($record->sourceid);
    $courses = enrol_get_all_users_courses($record->userid);
    $message = sprintf('[%10d] %s %s ', $record->sourceid, $record->firstname, $record->lastname);
    if ($contactResource->ContactID != $record->sourceid) {
        $trace->output(sprintf($message . "NO MATCH, person enrolled in %d courses", count($courses)), 1);
    } else {
        $trace->output(sprintf($message . "MATCH, person enrolled in %d courses", count($courses)), 1);
    }
}
