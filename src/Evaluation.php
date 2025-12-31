<?php

namespace MCAST;

/**
 * Node class to represent evaluations.
 *
 * @since 0.1.0
 */
class Evaluation extends Node
{
	/**
	 * Stores the optimised body nodes from the definition.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 * @var Node[]
	 */
	private $body = array();

	/**
	 * Looks up the definition and populates the body with optimised nodes.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised evaluation.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		$definition = $frame->get_definition( (string) $this->symbol );
		$subframe = new Frame( array_combine( (array) $definition->params, (array) $this->params ), array(), $definition->frame );

		foreach ( $definition->subnodes as $node )
		{
			$this->body[] = $node->optimise( $compiler, $subframe );
		}

		return $this;
	}

	/**
	 * Compiles the evaluation.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled evaluation.
	 */
	public function compile( Compiler $compiler ): string
	{
		$output = '';

		foreach ( $this->body as $node )
		{
			$output .= $node->compile( $compiler );
		}

		return $output;
	}
}
