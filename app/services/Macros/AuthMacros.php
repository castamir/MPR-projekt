<?php


namespace Services\Macros;

use Nette\Latte\CompileException;
use Nette\Latte\Compiler;
use Nette\Latte\MacroNode;
use Nette\Latte\Macros\MacroSet;
use Nette\Latte\PhpWriter;

class AuthMacros extends MacroSet
{


	/**
	 * @param \Nette\Latte\Compiler
	 * @return void|static
	 */
	public static function install(Compiler $compiler)
	{
		/** @var Compiler $me */
		$me = new static($compiler);

		$me->addMacro('auth', array($me, 'macroIfAuth'), array($me, 'macroEndIfAuth'));
	}


	public function macroIfAuth(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('if ($user->isAllowed(%node.word)) {');
	}


	public function macroEndIfAuth(MacroNode $node, PhpWriter $writer)
	{
		return '}';
	}
}
