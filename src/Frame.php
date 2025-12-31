<?php

namespace MCAST;

/**
 * Core class to represent frames.
 *
 * @since 0.1.0
 */
final class Frame
{
	/**
	 * Assignments in this frame.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $assignments;

	/**
	 * Definitions in this frame.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $definitions;

	/**
	 * Returns an assignment from this frame given its symbol.
	 *
	 * @since 0.1.0
	 *
	 * @param string $symbol The symbol to look up.
	 */
	public function get_assignment( string $symbol )
	{
		return isset( $this->assignments[ $symbol ] ) ? $this->assignments[ $symbol ] : null;
	}

	/**
	 * Returns a definition from this frame given its symbol.
	 *
	 * @since 0.1.0
	 *
	 * @param string $symbol The symbol to look up.
	 */
	public function get_definition( string $symbol )
	{
		return isset( $this->definitions[ $symbol ] ) ? $this->definitions[ $symbol ] : null;
	}

	/**
	 * Adds a definition to this frame.
	 *
	 * @since 0.1.0
	 *
	 * @param string $symbol The symbol for this definition.
	 * @param Definition $definition The definition.
	 */
	public function add_definition( string $symbol, Definition $definition )
	{
		$this->definitions[ $symbol ] = $definition;
	}

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param array $assignments Assignments for this frame.
	 * @param array $definitions Definitions for this frame.
	 * @param Frame|null $parent Optional parent frame.
	 */
	public function __construct( array $assignments, array $definitions, Frame $parent = null )
	{
		$this->assignments = isset( $parent ) ? array_merge( $parent->assignments, $assignments ) : $assignments;
		$this->definitions = isset( $parent ) ? array_merge( $parent->definitions, $definitions ) : $definitions;
	}
}
