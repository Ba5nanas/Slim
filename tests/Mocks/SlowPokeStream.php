<?php

/**
 * Slim Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Slim/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Slim\Tests\Mocks;

use Exception;
use Psr\Http\Message\StreamInterface;

use function min;
use function str_repeat;
use function usleep;

use const SEEK_SET;

class SlowPokeStream implements StreamInterface
{
    public const CHUNK_SIZE = 1;
    public const SIZE = 500;

    /**
     * @var int
     */
    private $amountToRead;

    public function __construct()
    {
        $this->amountToRead = self::SIZE;
    }

    public function __toString()
    {
        $content = '';
        while (!$this->eof()) {
            $content .= $this->read(self::CHUNK_SIZE);
        }
        return $content;
    }

    public function close()
    {
    }

    public function detach()
    {
        throw new Exception('not implemented');
    }

    public function eof()
    {
        return $this->amountToRead === 0;
    }

    public function getContents()
    {
        throw new Exception('not implemented');
    }

    public function getMetadata($key = null)
    {
        throw new Exception('not implemented');
    }

    public function getSize()
    {
        return null;
    }

    public function isReadable()
    {
        return true;
    }

    public function isSeekable()
    {
        return false;
    }

    public function isWritable()
    {
        return false;
    }

    public function read($length)
    {
        usleep(1);
        $size = min($this->amountToRead, self::CHUNK_SIZE, $length);
        $this->amountToRead -= $size;
        return str_repeat('.', $size);
    }

    public function rewind()
    {
        throw new Exception('not implemented');
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new Exception('not implemented');
    }

    public function tell()
    {
        throw new Exception('not implemented');
    }

    public function write($string)
    {
        return $string;
    }
}
