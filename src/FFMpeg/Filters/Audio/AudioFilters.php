<?php

/*
 * This file is part of PHP-FFmpeg.
 *
 * (c) Alchemy <info@alchemy.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FFMpeg\Filters\Audio;

use FFMpeg\Filters\Audio\AddMetadataFilter;
use FFMpeg\Media\Audio;
use FFMpeg\Coordinate\TimeCode;

class AudioFilters
{
    protected $media;

    public function __construct(Audio $media)
    {
        $this->media = $media;
    }

    /**
     * Resamples the audio file.
     *
     * @param Integer $rate
     *
     * @return AudioFilters
     */
    public function resample($rate)
    {
        $this->media->addFilter(new AudioResamplableFilter($rate));

        return $this;
    }

    /**
     * Add metadata to an audio file. If no arguments are given then filter
     * will remove all metadata from the audio file
     * @param Array|Null $data  If array must contain one of these key/value pairs:
     *    - "title": Title metadata
     *    - "artist": Artist metadata
     *    - "composer": Composer metadata
     *    - "album": Album metadata
     *    - "track": Track metadata
     *    - "artwork": Song artwork. String of file path
     *    - "year": Year metadata
     *    - "genre": Genre metadata
     *    - "description": Description metadata
     */
    public function addMetadata($data = null)
    {
        $this->media->addFilter(new AddMetadataFilter($data));

        return $this;
    }

    /**
     * Cuts the audio at `$start`, optionally define the end
     *
     * @param   TimeCode    $start      Where the clipping starts(seek to time)
     * @param   TimeCode    $duration   How long the clipped audio should be
     * @return AudioFilters
     */
    public function clip($start, $duration = null) {
        $this->media->addFilter(new AudioClipFilter($start, $duration));

        return $this;
    }

    /**
     * Adds the `$artwork` to the audio to convert it to video.
     *
     * @param string $artwork  The artwork image link to add to the video
     * @param string $preset Certain encoding speed to compression ration and the default preset type is 'veryslow'.
     * @param array $flags Some extra flags that could be passed to the conversion command.
     * @return AudioFilters
     */
    public function imageVideo($artwork, $preset = null, $flags = null) {
        $this->media->addFilter(new ImageVideoFilter($artwork, $preset, $flags));

        return $this;
    }
}
