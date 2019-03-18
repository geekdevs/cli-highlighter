<?php
namespace CliHighlighter\Service\Highlighter;

/**
 * Interface HighlighterInterface
 * @package CliHighlighter\Service\Highlighter
 */
interface HighlighterInterface
{
    /**
     * @param string $input
     *
     * @return string
     */
    public function highlight(string $input): string;

    /**
     * @return string
     */
    public function getName(): string;
}
