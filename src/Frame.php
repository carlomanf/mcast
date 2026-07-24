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
	private $assignments = array();

	/**
	 * Definitions in this frame.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $definitions = array();

	/**
	 * Parent frame, if provided through the constructor.
	 *
	 * @access private
	 *
	 * @since 0.1.1
	 * @var Frame|null
	 */
	private $parent = null;

	/**
	 * Returns an assignment from this frame given its symbol.
	 *
	 * @since 0.1.0
	 *
	 * @param string $symbol The symbol to look up.
	 *
	 * @return Assignment|null The assignment if this symbol exists in the frame, null if not.
	 */
	public function get_assignment( string $symbol )
	{
		if ( isset( $this->assignments[ $symbol ] ) )
		{
			return $this->assignments[ $symbol ];
		}
		else
		{
			return isset( $this->parent ) ? $this->parent->get_assignment( $symbol ) : null;
		}
	}

	/**
	 * Returns a definition from this frame given its symbol.
	 *
	 * @since 0.1.0
	 *
	 * @param string $symbol The symbol to look up.
	 *
	 * @return Definition|null The definition if this symbol exists in the frame, null if not.
	 */
	public function get_definition( string $symbol )
	{
		if ( isset( $this->definitions[ $symbol ] ) )
		{
			return $this->definitions[ $symbol ];
		}
		else
		{
			return isset( $this->parent ) ? $this->parent->get_definition( $symbol ) : null;
		}
	}

	/**
	 * Adds an assignment to this frame.
	 *
	 * @since 0.1.1
	 *
	 * @param string $symbol The symbol for this assignment.
	 * @param Assignment $assignment The assignment.
	 */
	public function add_assignment( string $symbol, Assignment $assignment )
	{
		if ( count( (array) $assignment->subnodes ) === 1 )
		{
			$this->assignments[ $symbol ] = $assignment;
		}
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
	 * @since 0.1.1 Removed $assignments and $definitions parameters.
	 *
	 * @param Frame|null $parent Optional parent frame.
	 */
	public function __construct( Frame $parent = null )
	{
		$this->parent = $parent;
	}
}
