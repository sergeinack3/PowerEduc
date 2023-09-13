<?php
// This file is part of PowerEduc - http://powereduc.org/
//
// PowerEduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// PowerEduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with PowerEduc.  If not, see <http://www.gnu.org/licenses/>.


/**
 * PowerEduc REST library
 *
 * @package    webservice_rest
 * @copyright  2009 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * PowerEduc REST client
 *
 * It has been implemented for unit testing purpose (all protocols have similar client)
 *
 * @package    webservice_rest
 * @copyright  2010 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class webservice_rest_client {

    /** @var powereduc_url the REST server url */
    private $serverurl;

    /** @var string token */
    private $token;

    /** @var string returned value format: xml or json */
    private $format;

    /**
     * Constructor
     *
     * @param string $serverurl a PowerEduc URL
     * @param string $token the token used to do the web service call
     * @param string $format returned value format: xml or json
     */
    public function __construct($serverurl, $token, $format = 'xml') {
        $this->serverurl = new powereduc_url($serverurl);
        $this->token = $token;
        $this->format = $format;
    }

    /**
     * Set the token used to do the REST call
     *
     * @param string $token the token used to do the web service call
     */
    public function set_token($token) {
        $this->token = $token;
    }

    /**
     * Execute client WS request with token authentication
     *
     * @param string $functionname the function name
     * @param array $params the parameters of the function
     * @return mixed
     */
    public function call($functionname, $params) {
        global $DB, $CFG;

         if ($this->format == 'json') {
             $formatparam = '&powereducwsrestformat=json';
             $this->serverurl->param('powereducwsrestformat','json');
         } else {
             $formatparam = ''; //to keep retro compability with old server that only support xml (they don't expect this param)
         }

        $this->serverurl->param('wstoken',$this->token);
        $this->serverurl->param('wsfunction',$functionname); //you could also use params().

        $result = download_file_content($this->serverurl->out(false), null, $params);

        //TODO MDL-22965 transform the XML result into PHP values
        if ($this->format == 'json') {
            $result = json_decode($result);
        }

        return $result;
    }

}