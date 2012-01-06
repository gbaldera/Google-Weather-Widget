<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         PyroCMS
 * @subpackage         Google Weather Widget
 * @author            Gustavo Rodriguez Baldera - http://twitter.com/gbaldera
 *
 * Show Weather in your site
 */

class Widget_Google_weather extends Widgets
{
    public $title = 'Google Weather';
    public $description = array(
        'en' => 'Show weather from Google Weather\'s API',
        'es' => 'Muestra el clima desde el API de Google Weather'
    );
    public $author = 'Gustavo Rodriguez Baldera';
    public $website = 'http://twitter.com/gbaldera';
    public $version = '1.0';

    public $fields = array(
        array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'required'
        ),
        array(
            'field' => 'lang',
            'label' => 'Language',
            'rules' => ''
        ),
    );

    public function run($options)
    {
        if (empty($options['lang']))
        {
            $options['lang'] = 'en';
        }

        //caching
        if (!$content = $this->pyrocache->get('weather-' . url_title($options['location'])))
        {
            $city = urlencode($options['location']);
            $content = utf8_encode(file_get_contents('http://www.google.com/ig/api?weather=' . $city . '&hl=' . $options['lang']));

            //write cache and expires in 12 hours
            $this->pyrocache->write($content, 'weather-' . url_title($options['location']), 43200);
        }

        $xml = simplexml_load_string($content);

        // Fail?
        if (!$xml)
        {
            echo 'Error trying to contact the Google Weather server.';
            return false;
        }

        $information = $xml->xpath("/xml_api_reply/weather/forecast_information");
        $current = $xml->xpath("/xml_api_reply/weather/current_conditions");
        $forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");

        return array(
            'information' => $information,
            'current' => $current,
            'forecast_list' => $forecast_list
        );
    }
}