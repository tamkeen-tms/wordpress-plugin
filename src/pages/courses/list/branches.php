
    <ul>
        <?php foreach($branches as $branch): ?>
            <li>
	            <a href="<?=get_permalink() ?>?view=branch&branch=<?=$branch->id ?>">
		            <?= $branch->name ?>
	            </a>
            </li>
        <?php endforeach; ?>
    </ul>
