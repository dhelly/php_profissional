<h2>Users</h2>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?php echo $user->firstName; ?> | <a href="/user/<?php echo $user->id ?>">Detalhes</a></li>
    <?php endforeach; ?>
</ul>