<?php

namespace MCAST;

/**
 * Core class to represent a single-use compiler.
 *
 * @since 0.1.0
 */
class Compiler
{
	/**
	 * Parser being used by this compiler.
	 * Set through the constructor.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var Parser
	 */
	private $parser;

	/**
	 * Source being compiled.
	 * Set through the constructor.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private $source;

	/**
	 * Array of context variables.
	 * Optionally set through the constructor.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $context;

	/**
	 * The root definition.
	 * Set by the `compile` method.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var Definition|null
	 */
	private $definition = null;

	/**
	 * The root evaluation.
	 * Set by the `compile` method.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var Evaluation|null
	 */
	private $evaluation = null;

	/**
	 * The compiled target.
	 * Set by the `compile` method.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var string|null
	 */
	private $target = null;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param Parser $parser The parser to use.
	 * @param string $source The source to compile.
	 * @param array $context Optional context variables.
	 */
	public function __construct( Parser $parser, string $source, array $context = array() )
	{
		$this->parser = $parser;
		$this->source = $source;
		$this->context = $context;
	}

	/**
	 * Compiles the source.
	 *
	 * @since 0.1.0
	 *
	 * @return string The compiled target.
	 */
	public function compile(): string
	{
		$frame = new Frame();

		$this->definition = new Definition();
		$this->definition->attrs = array( 'symbol' => 'main', 'params' => array_keys( $this->context ) );
		$this->definition->subnodes = $this->parser->parse( $this->source );
		$this->definition->content = array();

		$this->definition = $this->definition->optimise( $this, $frame );

		$this->evaluation = new Evaluation();
		$this->evaluation->attrs = array( 'symbol' => 'main' );
		$subnodes = array();

		foreach ( $this->context as $symbol => $value )
		{
			$assignment = new Assignment();
			$assignment->attrs = array( 'symbol' => $symbol, 'value' => $value );
			$assignment->subnodes = array();
			$assignment->content = array();
			$subnodes[] = $assignment;
		}

		$this->evaluation->subnodes = $subnodes;
		$this->evaluation->content = array();

		$this->evaluation = $this->evaluation->optimise( $this, $frame );

		$this->target = $this->evaluation->compile( $this );

		return $this->target;
	}

	/**
	 * Parses a string into an array of AST nodes using the compiler's parser.
	 *
	 * @since 0.1.0
	 *
	 * @param string $serialised The serialised representation.
	 *
	 * @return Node[] The array of AST nodes.
	 */
	public function parse( string $serialised ): array
	{
		return $this->parser->parse( $serialised );
	}

	/**
	 * Serialises an array of AST nodes back into a string using the compiler's parser.
	 *
	 * @since 0.1.0
	 *
	 * @param Node[] $parsed The array of AST nodes.
	 *
	 * @return string The serialised representation.
	 */
	public function serialise( array $parsed ): string
	{
		return $this->parser->serialise( $parsed );
	}
}
