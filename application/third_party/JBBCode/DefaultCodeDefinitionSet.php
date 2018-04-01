<?php

namespace JBBCode;

require_once 'CodeDefinition.php';
require_once 'CodeDefinitionBuilder.php';
require_once 'CodeDefinitionSet.php';
require_once 'validators/CssColorValidator.php';
require_once 'validators/UrlValidator.php';
require_once 'validators/SizeValidator.php';

/**
 * Provides a default set of common bbcode definitions.
 *
 * @author jbowens
 */
class DefaultCodeDefinitionSet implements CodeDefinitionSet {
    /* The default code definitions in this set. */

    protected $definitions = array();

    /**
     * Constructs the default code definitions.
     */
    public function __construct() {
        /* [b] bold tag */
        $builder = new CodeDefinitionBuilder('b', '<strong>{param}</strong>');
        array_push($this->definitions, $builder->build());

        /* [i] italics tag */
        $builder = new CodeDefinitionBuilder('i', '<em>{param}</em>');
        array_push($this->definitions, $builder->build());

        /* [u] underline tag */
        $builder = new CodeDefinitionBuilder('u', '<u>{param}</u>');
        array_push($this->definitions, $builder->build());

        /* [s] underline tag */
        $builder = new CodeDefinitionBuilder('s', '<s>{param}</s>');
        array_push($this->definitions, $builder->build());

        $urlValidator = new \JBBCode\validators\UrlValidator();

        /* [url] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a rel="nofollow" href="{param}">{param}</a>');
        $builder->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [url=http://example.com] link tag */
        $builder = new CodeDefinitionBuilder('url', '<a rel="nofollow" href="{option}">{param}</a>');
        $builder->setUseOption(true)->setParseContent(true)->setOptionValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [size=23] size tag */
        $builder = new CodeDefinitionBuilder('size', '<span style="font-size: {option}px">{param}</span>');
        $builder->setUseOption(true)->setParseContent(true)->setOptionValidator(new \JBBCode\validators\SizeValidator());
        array_push($this->definitions, $builder->build());

        /* [img] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" />');
        $builder->setUseOption(false)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [img=alt text] image tag */
        $builder = new CodeDefinitionBuilder('img', '<img src="{param}" alt="{option}" />');
        $builder->setUseOption(true)->setParseContent(false)->setBodyValidator($urlValidator);
        array_push($this->definitions, $builder->build());

        /* [color] color tag */
        $builder = new CodeDefinitionBuilder('color', '<span style="color: {option}">{param}</span>');
        $builder->setUseOption(true)->setOptionValidator(new \JBBCode\validators\CssColorValidator());
        array_push($this->definitions, $builder->build());



        /* [quote] tag */
        $builder = new CodeDefinitionBuilder('quote', '<div class="blockquote">{param}</div>');
        array_push($this->definitions, $builder->build());

        /* [quote=somethink] tag */
        $builder = new CodeDefinitionBuilder('quote', '<div class="blockquote"><p class="quote_author">Цитата: {option}</p>{param}</div>');
        $builder->setUseOption(true)->setParseContent(true);
        array_push($this->definitions, $builder->build());


        /* [spoiler] tag */
        $builder = new CodeDefinitionBuilder('spoiler', '<div class="spoiler folded">Скрытый текст\картинка</div><div id="spoiler-body">{param}</div>');
        array_push($this->definitions, $builder->build());

        /* [spoiler=somethink] tag */
        $builder = new CodeDefinitionBuilder('spoiler', '<div class="spoiler folded">{option}</div><div id="spoiler-body">{param}</div>');
        $builder->setUseOption(true)->setParseContent(true);
        array_push($this->definitions, $builder->build());
    }

    /**
     * Returns an array of the default code definitions.
     */
    public function getCodeDefinitions() {
        return $this->definitions;
    }

}
