<?php

namespace App\Traits;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Storage;

trait Twitter
{
    /**
     * Regarde si la configuration Facebook est correcte.
     *
     * @return bool
     */
    public function canUseTwitter()
    {
        /* @var TwitterOAuth $twitter */
        $twitter = resolve('twitter');

        try {
            $twitter->get('/me');

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Envoi un message ou une photo sur Twitter.
     *
     * @param string $file
     * @param string $status
     *
     * @return array|object
     */
    private function _sendToTwitter(string $status, string $file = null)
    {
        /* @var TwitterOAuth $twitter */
        $twitter = resolve('twitter');

        $send = [
            'status' => $status,
            'long' => env('LATITUDE'),
            'lat' => env('LONGITUDE'),
            'display_coordinates' => true,
        ];

        if (! empty($file)) {
            $media = $twitter->upload('media/upload', [
                'media' => Storage::disk('public')->path($file),
                'media_type' => 'image/jpeg',
            ], true);
            $send['media_ids'] = $media->media_id_string;

            $response = $twitter->post('statuses/update', $send);
        }

        return $response;
    }

    /**
     * Retourne les auteurs.
     *
     * @param array  $authors
     * @param string $content
     *
     * @return array
     */
    private function _searchAuthors(array $authors, string $content)
    {
        $users = [];

        foreach ($authors as $author) {
            if (strpos($content, $author['name']) !== false) {
                $users[] = '@' . $author['twitter'];
            }
        }

        return $users;
    }
}
