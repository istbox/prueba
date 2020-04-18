<?php
/**
 * @var \Phalcon\Mvc\View\Engine\Php $this
 */
?>

<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous"><?php echo $this->tag->linkTo(["users/index", "Go Back"]); ?></li>
            <li class="next"><?php echo $this->tag->linkTo(["users/new", "Create "]); ?></li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>Search result</h1>
</div>

<?php echo $this->getContent(); ?>

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

                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($page->items as $user): ?>
            <tr>
            <td><?php echo $user->id ?></td>
            <td><?php echo $user->nombre ?></td>
            <td><?php echo $user->apellidos ?></td>
            <td><?php echo $user->email ?></td>
            <td><?php echo $user->password ?></td>
            <td><?php echo $user->nivel ?></td>

                <td><?php echo $this->tag->linkTo(["users/edit/" . $user->id(), "Edit"]); ?></td>
                <td><?php echo $this->tag->linkTo(["users/delete/" . $user->id(), "Delete"]); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-1">
        <p class="pagination" style="line-height: 1.42857;padding: 6px 12px;">
            <?php echo $page->current, "/", $page->total_pages ?>
        </p>
    </div>
    <div class="col-sm-11">
        <nav>
            <ul class="pagination">
                <li><?php echo $this->tag->linkTo(["users/search", "First", 'class' => 'page-link']) ?></li>
                <li><?php echo $this->tag->linkTo(["users/search?page=" . $page->before, "Previous", 'class' => 'page-link']) ?></li>
                <li><?php echo $this->tag->linkTo(["users/search?page=" . $page->next, "Next", 'class' => 'page-link']) ?></li>
                <li><?php echo $this->tag->linkTo(["users/search?page=" . $page->last, "Last", 'class' => 'page-link']) ?></li>
            </ul>
        </nav>
    </div>
</div>

<div class="row">
    {{ usuarios }}
    <?php echo "<br>"; echo "<pre>";print_r($users);echo "</pre>"; ?>
</div>