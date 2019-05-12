<?php
// source: /home/ali/www/ospf/app/presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

class Templatecfc48ee8c5 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'js' => 'blockJs',
	];

	public $blockTypes = [
		'content' => 'html',
		'js' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
?>

<?php
		$this->renderBlock('js', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
?><div id="cy"></div>
	<div class="toolbar">
		Změnit topologii:
	<button id="randome">Náhodně</button>
	<button id="circle">Kruh</button>
		<button id="grid">Grid</button>
		<button id="topology">Rozumně</button>
		<a href="" id='redirHref' target="_blank"></a>
	</div>
<?php
	}


	function blockJs($_args)
	{
		
	}

}
