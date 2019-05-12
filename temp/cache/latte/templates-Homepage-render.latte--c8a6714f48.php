<?php
// source: /home/ali/www/ospf/app/presenters/templates/Homepage/render.latte

use Latte\Runtime as LR;

class Templatec8a6714f48 extends Latte\Runtime\Template
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
		if (isset($this->params['item'])) trigger_error('Variable $item overwritten in foreach on line 13');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		?>	<h1>Tabulka pro síť: <?php echo LR\Filters::escapeHtmlText($netwrok->name) /* line 2 */ ?></h1>
	<table class="datatable">
		<thead>
		<tr>
			<th>Síť</th>
			<th>Nejkratší metrika</th>
			<th>Cesta</th>
			<th>Předchozí síť</th>
		</tr>
		</thead>
		<tbody>
<?php
		$iterations = 0;
		foreach ($data as $item) {
?>		<tr>
			<th><?php echo LR\Filters::escapeHtmlText($item->name) /* line 14 */ ?></th>
			<th><?php echo LR\Filters::escapeHtmlText($item->metric) /* line 15 */ ?></th>
			<th><?php echo $item->path /* line 16 */ ?></th>
			<th><?php echo LR\Filters::escapeHtmlText($item->last_network) /* line 17 */ ?></th>
		</tr>
<?php
			$iterations++;
		}
?>
		</tbody>
	</table>
	<style>
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		thead tr th {
			background-color: #00b800;
			color: white;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}

		.signature {
			position: relative !important;
		}
	</style>
<?php
	}


	function blockJs($_args)
	{
		extract($_args);
?>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function () {
			$('.datatable').DataTable({
				paging: false,
				"columnDefs": [
					{"targets": [1, 2, 3], "searchable": false}
				]
			});
		});
	</script>
<?php
	}

}
