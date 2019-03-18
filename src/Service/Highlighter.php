<?php
namespace CliHighlighter\Service;

use CliHighlighter\Exception\UnsupportedFormatException;
use CliHighlighter\Service\Highlighter\HighlighterInterface;
use CliHighlighter\Service\Highlighter\JsonHighlighter;
use CliHighlighter\Service\Highlighter\XmlHighlighter;
use CliHighlighter\Service\Highlighter\YamlHighlighter;

/**
 * Class Highlighter
 * @package CliHighlighter\Service
 */
class Highlighter
{
    /**
     * Formats
     * Some helper constants
     */
    public const FORMAT_XML  = 'xml';
    public const FORMAT_YML  = 'yaml';
    public const FORMAT_JSON = 'json';

    /**
     * @var array
     */
    private $highlighters = [];

    /**
     * Highlighter constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        //Register some default formats
        $this->register(new JsonHighlighter(
            $options[self::FORMAT_JSON] ?? []
        ));

        $this->register(new XmlHighlighter(
            $options[self::FORMAT_XML] ?? []
        ));

        $this->register(new YamlHighlighter(
            $options[self::FORMAT_YML] ?? []
        ));
    }

    /**
     * @param string $input
     * @param string $format
     *
     * @return string
     */
    public function highlight(string $input, string $format): string
    {
        return $this->get($format)->highlight($input);
    }

    /**
     * @param HighlighterInterface $highlighter
     */
    public function register(HighlighterInterface $highlighter): void
    {
        $this->highlighters[$highlighter->getName()] = $highlighter;
    }

    /**
     * @param string $format
     *
     * @return HighlighterInterface
     */
    private function get(string $format): HighlighterInterface
    {
        $highlighter = $this->highlighters[$format] ?? null;

        if (!$highlighter) {
            throw new UnsupportedFormatException(sprintf(
                'Format "%s" is not supported. Supported formats are: %s',
                $format,
                implode(', ', array_keys($this->highlighters))
            ));
        }

        return $highlighter;
    }
}
