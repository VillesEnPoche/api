<?php

namespace App\Traits;

trait Facebook
{
    /**
     * Regarde si la configuration Facebook est correcte.
     *
     * @return bool
     */
    public function canUseFacebook()
    {
        /* @var \Facebook\Facebook $facebook */
        $facebook = resolve('facebook');

        try {
            $facebook->get('/me');

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param int    $album_id
     * @param string $message
     * @param string $file
     *
     * @throws \Facebook\Exceptions\FacebookSDKException
     *
     * @return int
     */
    private function _sendPhotoToFacebook(int $album_id, string $message, string $file)
    {
        /* @var \Facebook\Facebook $facebook */
        $facebook = resolve('facebook');

        $data = [
            'message' => $message,
            'source' => $facebook->fileToUpload($file),
        ];

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $facebook->post('/' . $album_id . '/photos', $data, env('FACEBOOK_LONG_LIFE_TOKEN'));
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->error('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->error('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }

        return $response->getGraphNode()['id'];
    }

    /**
     * Envoi un lien sur le mur Facebook.
     *
     * @param string      $link
     * @param string|null $message
     * @param string|null $name
     * @param string|null $caption
     *
     * @throws \Facebook\Exceptions\FacebookSDKException
     *
     * @return mixed
     */
    private function _sendLinkToFacebook(string $link, string $message = null, string $name = null, string $caption = null)
    {
        /* @var \Facebook\Facebook $facebook */
        $facebook = resolve('facebook');

        $send = [
            'link' => $link,
        ];

        if (! empty($message)) {
            $send['message'] = $message;
        }

        if (! empty($name)) {
            $send['name'] = $name;
        }

        if (! empty($caption)) {
            $send['caption'] = $caption;
        }

        try {
            $response = $facebook->post('/' . env('FACEBOOK_PAGE_ID') . '/feed', $send);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->error('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->error('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }

        return $response->getGraphNode()['id'];
    }
}
