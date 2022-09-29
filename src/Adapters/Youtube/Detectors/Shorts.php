<?php
declare(strict_types=1);

namespace Embed\Adapters\Youtube\Detectors;

use Embed\Detectors\Feeds as Detector;
use function Embed\getDirectory;
use function Embed\matchPath;
use Psr\Http\Message\UriInterface;

class Shorts extends Detector
{
    /**
     * @return UriInterface[]
     */
    public function detect(): array
    {
        return parent::detect()
            ?: $this->fallback();
    }

    private function fallback(): array
    {
        $uri = $this->extractor->getUri();

        if (!matchPath('/shorts/*', $uri->getPath())) {
            return [];
        }

        $id = getDirectory($uri->getPath(), 1);
        $short = $this->extractor->getCrawler()->createUri("https://www.youtube.com/watch?v={$id}");

        return [$short];
    }
}
