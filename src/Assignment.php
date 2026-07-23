<?php

namespace MCAST;

/**
 * Node class to represent variable assignments.
 *
 * @since 0.1.1
 */
class Assignment extends Node
{
	/**
	 * Adds this assignment to the current frame.
	 *
	 * @since 0.1.1
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised assignment.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		$frame->add_assignment( (string) $this->symbol, $this );
		return $this;
	}

	/**
	 * Compiles the variable assignment.
	 *
	 * @since 0.1.1
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled variable assignment.
	 */
	public function compile( Compiler $compiler ): string
	{
		return '';
	}
}
