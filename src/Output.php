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
