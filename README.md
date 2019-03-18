# About

This is a syntax highlighter library used to colorize output of xml, json and yaml formats 
to be displayed in command-line utilities.

## Installation

`composer require geekdevs/cli-highlighter`

## Usage

### Use individual highlighters:

```
$highlighter = new JsonHighlighter($jsonOptions);
echo $highlighter->highlight($input);

$highlighter = new XmlHighlighter($xmlOptions);
echo $highlighter->highlight($input);

$highlighter = new YamlHighlighter($yamlOptions);
echo $highlighter->highlight($input);
```

### Use helper service for multiple formats

```
$options = [
    'json' => [
        'keys'   => 'magenta',
        'values' => 'green',
        'braces' => 'light_white',
    ],

    'xml' => [
        'elements'   => 'yellow',
        'attributes' => 'green',
        'values'     => 'green',
        'innerText'  => 'light_white',
        'comments'   => 'gray',
        'meta'       => 'yellow',
    ],

    'yaml' => [
        'separators' => 'blue',
        'keys'       => 'yellow',
        'values'     => 'light_white',
        'comments'   => 'gray',
    ],
];

$highlighter = new \CliHighlighter\Service\Highlighter($options);

echo $highlighter->highlight($input, 'json');
echo $highlighter->highlight($input, 'xml');
echo $highlighter->highlight($input, 'yaml');
```

### Use as console tool

You can use `bin/highlighter` script with preconfigured colors for json, xml, yaml. Like this 

```
bin/highlighter json < input.json
bin/highlighter xml < input.xml
bin/highlighter yaml < yaml.xml
```

Alternativelym you can pipe this command like so:

```
echo "<hello name=\"world\" />" | bin/highlighter xml
```
