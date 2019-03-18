<?php
namespace CliHighlighter\Service\Highlighter;

use Highlight\Colors\Cli\Colors;
use Highlight\Decorator\StatefulCliDecorator;
use Highlight\Highlighter;

/**
 * Class YamlHighlighter
 * @package CliHighlighter\Service\Highlighter
 */
class YamlHighlighter implements HighlighterInterface
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
        return $this->highlighter->highlight('yaml', $input)->value;
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
            'separators' => 'blue',
            'keys'       => 'yellow',
            'values'     => 'light_white',
            'comments'   => 'gray',
        ];

        if ($separators = $options['separators']) {
            $colorScheme['meta'] = $separators;
        }

        if ($keys = $options['keys']) {
            $colorScheme['attr'] = $keys;
            $colorScheme['bullet'] = $keys;
        }

        if ($values = $options['values']) {
            $colorScheme['string'] = $values;
            $colorScheme['number'] = $values;
            $colorScheme['literal'] = $values;
        }

        if ($comments = $options['comments']) {
            $colorScheme['comment'] = $comments;
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
        return 'yaml';
    }
}
