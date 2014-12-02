<!-- File: /app/View/Posts/index.ctp -->

<h1>Blog posts</h1>
<table>
<tr>
<th>Id</th>
<th>Login</th>
<th>Mot de passe</th>
</tr>

<!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($user['User']['login'],
            array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
        </td>
        <td><?php echo $user['User']['pwd']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>