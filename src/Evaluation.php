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
		$evaluation = $this;
		$definition = $frame->get_definition( (string) $this->symbol );

		if ( isset( $definition ) )
		{
			$subframe = new Frame( $definition->frame );
			$params = (array) $definition->params;

			$evaluation = new Evaluation();
			$evaluation->name = $this->name;
			$evaluation->attrs = $this->attrs;
			$subnodes = array();

			foreach ( $this->subnodes as $key => &$assignment )
			{
				if ( isset( $params[ $key ] ) && $params[ $key ] === (string) $assignment->symbol )
				{
					$subnodes[] = $assignment->optimise( $compiler, $subframe );
				}
			}

			$evaluation->subnodes = $subnodes;
			$evaluation->content = $this->content;

			foreach ( $definition->subnodes as $node )
			{
				$evaluation->body[] = $node->optimise( $compiler, $subframe );
			}
		}

		return $evaluation;
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
