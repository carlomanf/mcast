<?php

namespace MCAST;

/**
 * Node class to represent variable references.
 *
 * @since 0.1.1
 */
class Reference extends Node
{
	/**
	 * Stores the optimised value node from the assignment.
	 *
	 * @access private
	 *
	 * @since 0.1.1
	 * @var Node|null
	 */
	private $value;

	/**
	 * Looks up the assignment and populates the reference with the optimised value.
	 *
	 * @since 0.1.1
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised reference.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		$reference = $this;
		$assignment = $frame->get_assignment( (string) $this->symbol );

		if ( isset( $assignment ) )
		{
			$reference = new Reference();
			$reference->name = $this->name;
			$reference->attrs = $this->attrs;
			$reference->subnodes = $this->subnodes;
			$reference->content = $this->content;
			$reference->value = $assignment->subnodes[0]->optimise( $compiler, $frame );
		}

		return $reference;
	}

	/**
	 * Compiles the reference.
	 *
	 * @since 0.1.1
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled reference.
	 */
	public function compile( Compiler $compiler ): string
	{
		return isset( $this->value ) ? $this->value->compile( $compiler ) : '';
	}
}
