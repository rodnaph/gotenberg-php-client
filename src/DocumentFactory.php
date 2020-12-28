<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;
use function assert;
use function fopen;
use function fwrite;
use function GuzzleHttp\Psr7\stream_for;
use function is_resource;

final class DocumentFactory
{
    public static function makeFromPath(string $fileName, string $filePath): Document
    {
        return new Document($fileName, new LazyOpenStream($filePath, 'r'));
    }

    public static function makeFromStream(string $fileName, StreamInterface $fileStream): Document
    {
        return new Document($fileName, $fileStream);
    }

    public static function makeFromString(string $fileName, string $string): Document
    {
        $fileStream = fopen('php://memory', 'rb+');
        assert(is_resource($fileStream));
        fwrite($fileStream, $string);

        return new Document($fileName, stream_for($fileStream));
    }
}
