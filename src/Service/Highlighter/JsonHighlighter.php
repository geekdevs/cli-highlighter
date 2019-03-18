<?php
namespace CliHighlighter\Service\Highlighter;

use Highlight\Colors\Cli\Colors;
use Highlight\Decorator\StatefulCliDecorator;
use Highlight\Highlighter;

/**
 * Class JsonHighlighter
 * @package CliHighlighter\Service\Highlighter
 */
class JsonHighlighter implements HighlighterInterface
{
    /**
     * @var Highlighter
     */
    private $highlighter;

    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $colorScheme = $this->getColorScheme($options);
        $this->highlighter = new Highlighter(
            new StatefulCliDecorator($colorScheme)
        );

        $this->options = $options;
    }

    /**
     * @param string $input
     *
     * @return string
     */
    public function highlight(string $input): string
    {
        return $this->highlighter->highlight('json', $input)->value;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function getColorScheme(array $options): array
    {
        $colorScheme = [];
        $options += [
            'keys'   => 'magenta',
            'values' => 'green',
            'braces' => 'light_white',
        ];

        if ($braces = $options['braces']) {
            $colorScheme['document'] = $braces;
        }

        if ($keys = $options['keys']) {
            $colorScheme['attr'] = $keys;
        }

        if ($values = $options['values']) {
            $colorScheme['string'] = $values;
            $colorScheme['number'] = $values;
            $colorScheme['literal'] = $values;
        }

        //Normalize colors
        foreach ($colorScheme as &$colorName) {
            $colorName = Colors::normalizeColor($colorName);
        }

        return $colorScheme;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'json';
    }
}
