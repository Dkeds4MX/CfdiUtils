<?php
namespace CfdiUtils\Utils;

use DOMDocument;

class Xml
{
    public static function newDocument(): DOMDocument
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = true;
        $document->preserveWhiteSpace = false;
        return $document;
    }

    public static function newDocumentContent(string $content): DOMDocument
    {
        if ('' === $content) {
            throw new \UnexpectedValueException('Received xml string argument is empty');
        }
        $document = static::newDocument();
        // this error silenced call is intentional, no need to alter libxml_use_internal_errors
        if (false === @$document->loadXML($content)) {
            throw new \UnexpectedValueException('Cannot create a DOM Document from xml string');
        }
        return $document;
    }

    public static function isValidXmlName(string $name): bool
    {
        if ('' === $name) {
            return false;
        }
        $pattern = '/^[:_A-Za-z'
            . '\xC0-\xD6\xD8-\xF6\xF8-\x{2FF}\x{370}-\x{37D}\x{37F}-\x{1FFF}\x{200C}-\x{200D}\x{2070}-\x{218F}'
            . '\x{2C00}-\x{2FEF}\x{3001}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFFD}\x{10000}-\x{EFFFF}]{1}'
            . '[\-:_A-Za-z0-9'
            . '\xC0-\xD6\xD8-\xF6\xF8-\x{2FF}\x{370}-\x{37D}\x{37F}-\x{1FFF}\x{200C}-\x{200D}\x{2070}-\x{218F}'
            . '\x{2C00}-\x{2FEF}\x{3001}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFFD}\x{10000}-\x{EFFFF}'
            . '\xB7\x{0300}-\x{036F}\x{203F}-\x{2040}]*$/u';
        return 1 === preg_match($pattern, $name);
    }
}
