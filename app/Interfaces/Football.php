<?php

namespace App\Interfaces;

interface Football
{
    const FOOTBALL_API_URL = 'http://www.thefanclub.com/lfpexports/';

    const CALENDAR_URL = self::FOOTBALL_API_URL . 'get_calendar/';

    const RANKING_URL = self::FOOTBALL_API_URL . 'get_ranking/';
}
