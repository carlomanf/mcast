<?php

namespace MCAST;

/**
 * Core interface to be implemented by parsers.
 *
 * @since 0.1.0
 */
interface Parser
{
	/**
	 * Parses a string into an array of AST nodes.
	 *
	 * @since 0.1.0
	 *
	 * @param string $serialised The serialised representation.
	 *
	 * @return Node[] The array of AST nodes.
	 */
	public function parse( string $serialised ): array;

	/**
	 * Serialises an array of AST nodes back into a string.
	 *
	 * @since 0.1.0
	 *
	 * @param Node[] $parsed The array of AST nodes.
	 *
	 * @return string The serialised representation.
	 */
	public function serialise( array $parsed ): string;
}
