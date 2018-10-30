<?php

namespace App\Traits;

trait RocketChat
{
    /**
     * @param array $notification
     *
     * @return mixed
     */
    public function sendToRocketChat(array $notification)
    {
        $rocket = resolve('rocket');
        if (! empty($rocket)) {
            return $rocket->post('', [
                'form_params' => $notification,
            ]);
        }
    }
}
