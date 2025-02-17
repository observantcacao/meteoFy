<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\IActiveRecord;
use PDO;

/**
 * Classe ARBlogs
 * Implémente le pattern Active Record pour gérer les entrées de la table "blogs".
 * 
 * @package Models
 */
class MusicPourMeteo
{
   public $weatherPlaylists = [
        "Ciel clair" => [
            "Morning Energy" => "https://open.spotify.com/playlist/37i9dQZF1DXdxcBWuJkbcy",
            "Happy Hits" => "https://open.spotify.com/playlist/37i9dQZF1DX3rxVfibe1L0",
            "Chill Vibes" => "https://open.spotify.com/playlist/37i9dQZF1DX889U0CL85jj"
        ],
        "Nuages épars" => [
            "Indie Chill" => "https://open.spotify.com/playlist/37i9dQZF1DX4E3UdUs7fUx",
            "Soft Pop" => "https://open.spotify.com/playlist/37i9dQZF1DX1s9knjP51Oa",
            "Relax & Unwind" => "https://open.spotify.com/playlist/37i9dQZF1DX4WYpdgoIcn6"
        ],
        "Nuages brisés" => [
            "Deep Focus" => "https://open.spotify.com/playlist/37i9dQZF1DX4sWSpwq3LiO",
            "Sad Songs" => "https://open.spotify.com/playlist/37i9dQZF1DX7qK8ma5wgG1",
            "Mellow Mood" => "https://open.spotify.com/playlist/37i9dQZF1DWYMfG0Phlxx8"
        ],
        "Pluie de douche" => [
            "Rainy Day" => "https://open.spotify.com/playlist/37i9dQZF1DXbvABJXBIyiY",
            "Lofi Beats" => "https://open.spotify.com/playlist/37i9dQZF1DXdxcBWuJkbcy",
            "Acoustic Chill" => "https://open.spotify.com/playlist/37i9dQZF1DX2TRYkJECvfC"
        ],
        "Pluie" => [
            "Sad Acoustic" => "https://open.spotify.com/playlist/37i9dQZF1DX7gIoKXt0gmx",
            "Chillout Lounge" => "https://open.spotify.com/playlist/37i9dQZF1DXaRycgyh6kXP",
            "Piano in the Rain" => "https://open.spotify.com/playlist/37i9dQZF1DWZtZ8vUCzche"
        ],
        "Orage" => [
            "Dark & Stormy" => "https://open.spotify.com/playlist/37i9dQZF1DX3YSRoSdA634",
            "Epic Soundtracks" => "https://open.spotify.com/playlist/37i9dQZF1DWXJyjYpHunCf",
            "Heavy Metal Thunder" => "https://open.spotify.com/playlist/37i9dQZF1DX9qNs32fujYe"
        ],
        "Neige" => [
            "Winter Vibes" => "https://open.spotify.com/playlist/37i9dQZF1DX2pSTOxoPbx9",
            "Christmas Jazz" => "https://open.spotify.com/playlist/37i9dQZF1DWV5b2OZpiX6r",
            "Cozy Acoustic" => "https://open.spotify.com/playlist/37i9dQZF1DX4E3UdUs7fUx"
        ],
        "Brume" => [
            "Mystical Soundscapes" => "https://open.spotify.com/playlist/37i9dQZF1DWZZbwlv3Vmtr",
            "Ambient Relaxation" => "https://open.spotify.com/playlist/37i9dQZF1DX4E3UdUs7fUx",
            "Dark Academia" => "https://open.spotify.com/playlist/37i9dQZF1DX1bqWvGzYUcU"
        ]
    ];
    public function __construct()
    {
      
    }
    public function getPlaylistType($type)  {
        return $this->weatherPlaylists[$type];
    }


   
}
