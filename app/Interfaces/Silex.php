<?php

namespace App\Interfaces;

interface Silex
{
    const WEEZEVENT_URL = 'https://www.weezevent.com/widget_multi.php?19012.1.9';

    const XPATH_EVENTS = '//body[@id=\'multiWidgetBody\']/div[@class="event "]';

    const PLACE_NAME = 'Le Silex';
}
