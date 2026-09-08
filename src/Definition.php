<?php

namespace MCAST;

/**
 * Node class to represent definitions.
 *
 * @since 0.1.0
 */
class Definition extends Node
{
	/**
	 * Adds this definition to the current frame.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised definition.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		$frame->add_definition( (string) $this->symbol, $this );
		return $this;
	}

	/**
	 * Compiles a definition.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled definition.
	 */
	public function compile( Compiler $compiler ): string
	{
		return '';
	}
}
