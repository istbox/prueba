<?php
/**
 * @var \Phalcon\Mvc\View\Engine\Php $this
 */
?>

<div class="page-header">
    <h1>Usuarios</h1>
    <p><?php echo $this->tag->linkTo(["users/new", "Crear Usuario"]) ?></p>
</div>

<?php echo $this->getContent() ?>

<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Password</th>
            <th>Nivel</th>
			<th>Idioma</th>
            <th></th>
            <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
            <td><?php echo $user->id ?></td>
            <td><?php echo $user->nombre ?></td>
            <td><?php echo $user->apellidos ?></td>
            <td><?php echo $user->email ?></td>
            <td><?php echo $user->pass ?></td>
            <td><?php echo $user->nivel ?></td>
            <td><?php echo $user->lang ?></td>

                <td><?php echo $this->tag->linkTo(["users/edit/" . $user->id, "Edit"]); ?></td>
                <td><?php echo $this->tag->linkTo(["users/delete/" . $user->id, "Delete"]); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
