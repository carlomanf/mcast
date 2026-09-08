<?php

namespace MCAST;

/**
 * Node class to represent output blocks.
 *
 * @since 0.1.0
 */
class Output extends Node
{
	/**
	 * Optimises the output block.
	 *
	 * @since 0.1.2
	 *
	 * @param Compiler $compiler The compiler.
	 * @param Frame $frame The current frame.
	 *
	 * @return Node The optimised output block.
	 */
	public function optimise( Compiler $compiler, Frame $frame ): Node
	{
		$subnodes = array();

		foreach ( $this->subnodes as $subnode )
		{
			$subnodes[] = $subnode->optimise( $compiler, $frame );
		}

		if ( $subnodes === $this->subnodes )
		{
			$output = $this;
		}
		else
		{
			$output = new Output();
			$output->name = $this->name;
			$output->attrs = $this->attrs;
			$output->subnodes = $subnodes;
			$output->content = $this->content;
		}

		return $output;
	}

	/**
	 * Compiles the output block.
	 *
	 * @since 0.1.0
	 *
	 * @param Compiler $compiler The compiler.
	 *
	 * @return string The compiled output block.
	 */
	public function compile( Compiler $compiler ): string
	{
		$output = '';
		$subnode = 0;

		foreach ( $this->content as $content )
		{
			if ( isset( $content ) )
			{
				$output .= trim( $content );
			}
			else
			{
				$output .= $this->subnodes[ $subnode++ ]->compile( $compiler );
			}
		}

		return $output;
	}
}
