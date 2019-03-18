<?php
namespace CliHighlighter\Service\Highlighter;

use Highlight\Colors\Cli\Colors;
use Highlight\Decorator\StatefulCliDecorator;
use Highlight\Highlighter;

/**
 * Class XmlHighlighter
 * @package CliHighlighter\Service\Highlighter
 */
class XmlHighlighter implements HighlighterInterface
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
        return $this->highlighter->highlight('xml', $input)->value;
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
            'elements'   => 'yellow',
            'attributes' => 'green',
            'values'     => 'green',
            'innerText'  => 'light_white',
            'comments'   => 'gray',
            'meta'       => 'yellow',
        ];

        if ($elements = $options['elements']) {
            $colorScheme['name'] = $elements;
            $colorScheme['tag'] = $elements;
        }

        if ($attributes = $options['attributes']) {
            $colorScheme['attr'] = $attributes;
        }

        if ($values = $options['values']) {
            $colorScheme['string'] = $values;
            $colorScheme['number'] = $values;
            $colorScheme['literal'] = $values;
        }

        if ($comments = $options['comments']) {
            $colorScheme['comment'] = $comments;
        }

        if ($meta = $options['meta']) {
            $colorScheme['meta'] = $meta;
        }

        if ($innerText = $options['innerText']) {
            $colorScheme['eq'] = $innerText;
            $colorScheme['default'] = $innerText;
            $colorScheme['document'] = $innerText;
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
        return 'xml';
    }
}
