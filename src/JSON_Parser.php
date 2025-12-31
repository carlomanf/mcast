<?php

namespace MCAST;

/**
 * Default JSON parser implementation.
 *
 * @since 0.1.0
 */
class JSON_Parser implements Parser
{
	/**
	 * Parses a JSON string into an array of AST nodes.
	 *
	 * @since 0.1.0
	 *
	 * @param string $serialised JSON string.
	 *
	 * @return Node[] The array of AST nodes.
	 */
	public function parse( string $serialised ): array
	{
		return $this->convert_to_nodes( json_decode( $serialised, true ) );
	}

	/**
	 * Private recursive helper that converts `json_decode` output into AST nodes.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 *
	 * @param array $arrays The array representation.
	 *
	 * @return Node[] The array of AST nodes.
	 */
	private function convert_to_nodes( array $arrays ): array
	{
		foreach ( $arrays as &$array )
		{
			$name = isset( $array['name'] ) ? (string) $array['name'] : '';
			$node = $this->get_instance( $name );
			$node->name = $name;
			$node->attrs = isset( $array['attrs'] ) && is_array( $array['attrs'] ) ? $array['attrs'] : array();
			$node->subnodes = isset( $array['subnodes'] ) && is_array( $array['subnodes'] ) ? $this->convert_to_nodes( $array['subnodes'] ) : array();
			$node->content = isset( $array['content'] ) && is_array( $array['content'] ) ? $array['content'] : array();
			$array = $node;
		}

		return $arrays;
	}

	/**
	 * Serialises an array of AST nodes back into a JSON string.
	 *
	 * @since 0.1.0
	 *
	 * @param Node[] $parsed The array of AST nodes.
	 *
	 * @return string JSON string.
	 */
	public function serialise( array $parsed ): string
	{
		return json_encode( $this->convert_to_arrays( $parsed ) );
	}

	/**
	 * Private recursive helper that converts AST nodes into arrays suitable for `json_encode`.
	 *
	 * @access private
	 *
	 * @since 0.1.0
	 *
	 * @param Node[] $nodes The array of AST nodes.
	 *
	 * @return array The array representation.
	 */
	private function convert_to_arrays( array $nodes ): array
	{
		foreach ( $nodes as &$node )
		{
			$array = array();
			$array['name'] = isset( $node->name ) ? (string) $node->name : '';
			$array['attrs'] = isset( $node->attrs ) && is_array( $node->attrs ) ? $node->attrs : array();
			$array['subnodes'] = isset( $node->subnodes ) && is_array( $node->subnodes ) ? $this->convert_to_arrays( $node->subnodes ) : array();
			$array['content'] = isset( $node->content ) && is_array( $node->content ) ? $node->content : array();
			$node = $array;
		}

		return $nodes;
	}

	/**
	 * Used by `convert_to_nodes` to instantiate nodes.
	 * Can be extended by subclasses.
	 *
	 * @access protected
	 *
	 * @since 0.1.0
	 *
	 * @param string $name The node name.
	 *
	 * @return Node The node instance.
	 */
	protected function get_instance( string $name ): Node
	{
		switch ( $name )
		{
			default: return new Output();
		}
	}
}
