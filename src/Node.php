<?php

namespace MCAST;

/**
 * Core abstract class extended by all AST nodes.
 *
 * @since 0.1.0
 */
abstract class Node
{
	/**
	 * Node name.
	 * Set through the `__set` method and can not be changed once set.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var string
	 */
	private $name;

	/**
	 * Node attributes.
	 * Set through the `__set` method and can not be changed once set.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $attrs;

	/**
	 * Subnodes of this node.
	 * Set through the `__set` method and can not be changed once set.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var Node[]
	 */
	private $subnodes;

	/**
	 * Used for preserving non-subnode content.
	 * Set through the `__set` method and can not be changed once set.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var array
	 */
	private $content;

	/**
	 * Setter.
	 * Properties can only be set once.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key.
	 * @param mixed $value Value.
	 */
	final public function __set( $key, $value )
	{
		switch ( $key )
		{
			case 'name': if ( !isset( $this->name ) ) return $this->name = $value;
			case 'attrs': if ( !isset( $this->attrs ) ) return $this->attrs = $value;
			case 'subnodes': if ( !isset( $this->subnodes ) ) return $this->subnodes = $value;
			case 'content': if ( !isset( $this->content ) ) return $this->content = $value;
		}
	}

	/**
	 * Getter.
	 * Values of the `$attrs` array can be accessed by passing the attribute key.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key.
	 *
	 * @return mixed Value.
	 */
	final public function __get( $key )
	{
		switch ( $key )
		{
			case 'name': return $this->name;
			case 'attrs': return $this->attrs;
			case 'subnodes': return $this->subnodes;
			case 'content': return $this->content;
			default: return isset( $this->attrs[ $key ] ) ? $this->attrs[ $key ] : null;
		}
	}

	/**
	 * Called during compiler optimisation phase.
	 * Can be over-ridden by subclasses.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised node.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		foreach ( $this->subnodes as &$subnode )
		{
			$subnode = $subnode->optimise( $compiler, $frame );
		}

		return $this;
	}

	/**
	 * Called during compilation phase.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled node.
	 */
	public abstract function compile( Compiler $compiler ): string;
}
