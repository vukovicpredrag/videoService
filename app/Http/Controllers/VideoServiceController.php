<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoServiceController extends Controller
{

    /**
     * @var string Youtube service with wildcard (<VIDEO_ID>)
     */
    private $youTubeService = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=<VIDEO_ID>&format=json";


    /**
     * @var string Vimeo service with wildcard (<VIDEO_ID>)
     */
    private $vimeoService = "http://vimeo.com/api/oembed.json?url=http://vimeo.com/<VIDEO_ID>";


    /**
     * Get video information based on video url (Youtube | Vimeo)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInfo(Request $request): JsonResponse
    {
        $videoUrl = $request->video_url;

        //Verify that the URL parameter has been entered
        if(!$videoUrl){

            return response()->json("Video URL parameter missing. Please enter a video URL!");

        }

        //Detect service provider
        $provider = $this->detectProvider($videoUrl);

        //Get video ID form vide URL
        $videoId = $this->getVideoId($videoUrl, $provider);

        //Prepare a request URL based on the provider's
        switch($provider) {
            case('youtube'):
                $serviceUrl = $this->youTubeService;
                break;

            case('vimeo'):
                $serviceUrl = $this->vimeoService;
                break;

            default:
                $serviceUrl = '';
        }

        $requestUrl = str_replace ("<VIDEO_ID>", $videoId, $serviceUrl);

        $getVideoInfo = $this->getVideoInfo($requestUrl);

        return new JsonResponse([
            'success' => true,
            'message' => 'Video information.',
            'data'    => $getVideoInfo
        ], 200);
    }

    /**
     * Detecting provider based on the video URL
     *
     * @param Request $request
     * @return string
     */
    public function detectProvider($videoUrl)
    {
        $youTubeRx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $matchYouTube = preg_match($youTubeRx, $videoUrl);

        $vimeoRx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([Ã¢Â€ÂŒÃ¢Â€Â‹0-9]{6,11})[?]?.*/';
        $matchVimeo = preg_match($vimeoRx, $videoUrl);

        $type = 'none';

        if ($matchYouTube) {
            $type = 'youtube';
        }

        if($matchVimeo) {
            $type = 'vimeo';
        }

        return $type;
    }


    /**
     * Get video ID from video URL
     *
     * @param string $videoUrl
     * @param string $provider
     * @return mixed
     */
    public function getVideoId($videoUrl, $provider)
    {
        if($provider == 'youtube') {

            $parseVideoURL = parse_url($videoUrl);

            parse_str($parseVideoURL['query'], $results);

            $videoId =  $results['v'];

        }

        if($provider == 'vimeo') {

            $videoId = (int) substr(parse_url($videoUrl, PHP_URL_PATH), 1);

        }

        //return empty sting if video not found
        $videoId = $videoId ?: '';

        return $videoId;
    }

    /**
     * Get video info | curl request to the target service
     *
     * @param string $requestUrl
     * @return array
     */
    public function getVideoInfo($requestUrl)
    {
        $requestUrl = str_replace('http', 'https', $requestUrl);

        //Set URL request
        $ch = curl_init( $requestUrl);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $curlResponse = curl_exec( $ch );
        curl_close( $ch );

        $curlResponse = json_decode($curlResponse);

        //Prepare API response
        $resposnse = [
            'author' => $curlResponse->author_name,
            'title'  => $curlResponse->title,
            'thumbnail_url' => $curlResponse->thumbnail_url,
        ];

        return $resposnse;
    }


}
