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

defined('MOODLE_INTERNAL') || die();

/**
 * Tests for field format validators.
 *
 * @package     enrol_plugin
 * @author      Troy Williams
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_arlo_field_formats_testcase extends core_privacy\tests\provider_testcase {

    /**
     *  @var enrol_arlo_generator $plugingenerator handle to plugin generator.
     */
    protected $plugingenerator;

    public function setUp() {
        global $CFG;

        require_once($CFG->dirroot . '/enrol/arlo/lib.php');
        /** @var enrol_arlo_generator $plugingenerator */
        $this->plugingenerator = $this->getDataGenerator()->get_plugin_generator('enrol_arlo');
        // Enable and setup plugin.
        $this->plugingenerator->enable_plugin();
        $this->plugingenerator->setup_plugin();
    }

}
