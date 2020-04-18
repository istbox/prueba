<?php
/**
 * @var \Phalcon\Mvc\View\Engine\Php $this
 */
?>

<div class="row">
    <nav>
        <ul class="pager">
            <li class="previous"><?php echo $this->tag->linkTo(["users", "Volver"]) ?></li>
        </ul>
    </nav>
</div>

<div class="page-header">
    <h1>Crea Usuarios</h1>
</div>

<?php echo $this->getContent(); ?>

<form action="/base/users/create" class="form-horizontal" method="post">
    <div class="form-group">
    <label for="fieldNombre" class="col-sm-2 control-label">Nombre</label>
    <div class="col-sm-10">
        <?php echo Phalcon\Tag::textField(["nombre", "size" => 30, "class" => "form-control", "id" => "fieldNombre"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldApellidos" class="col-sm-2 control-label">Apellidos</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["apellidos", "size" => 30, "class" => "form-control", "id" => "fieldApellidos"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldEmail" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["email", "size" => 30, "class" => "form-control", "id" => "fieldEmail"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldPass" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["pass", "size" => 30, "class" => "form-control", "id" => "fieldPass"]) ?>
    </div>
</div>

<div class="form-group">
    <label for="fieldNivel" class="col-sm-2 control-label">Nivel</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["nivel", "size" => 30, "class" => "form-control", "id" => "fieldNivel"]) ?>
    </div>
</div>
<div class="form-group">
    <label for="fieldLang" class="col-sm-2 control-label">Lenguaje</label>
    <div class="col-sm-10">
        <?php echo $this->tag->textField(["lang", "size" => 30, "class" => "form-control", "id" => "fieldLang"]) ?>
    </div>
</div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo $this->tag->submitButton(["Crear", "class" => "btn btn-default"]) ?>
        </div>
    </div>
</form>
