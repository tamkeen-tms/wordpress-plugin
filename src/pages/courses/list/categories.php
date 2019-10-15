
	<ul>
		<?php foreach($categories as $category): ?>
			<li>
				<a href="<?=get_permalink() ?>?view=category&category=<?=$category->id ?>">
					<?= $category->name ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
