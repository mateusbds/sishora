<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container" style="background: #f8f8f8;">
        <ul class="nav navbar-nav">
            <!-- <li class="heading"><?= __('Ações') ?></li> -->
            <li class="dropdown">
                <a  href="courses" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Cadastro
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link('Usuários', ['controller' => 'Users', 'action' => 'index'],  ['class' => 'dropdown-option', 'style' => 'margin-top: 0px;']) ?></li>
                    <li><?= $this->Html->link('Perfis', ['controller' => 'Profiles', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('Cursos', ['controller' => 'Courses', 'action' => 'index']) ?></li>
                </ul>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?= $this->request->session()->read('Auth.User.username') ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu"><?= $this->Html->link('Logout', ['action' => 'logout'], ['class' => 'dropdown-option']) ?></ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="profiles index large-9 medium-8 columns content">
        <h3><?= __('Perfis') ?></h3>
       
        <table id="example" class="display table table-striped table-bordered" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('Nome') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($profiles as $profile): ?>
                <tr>
                    <td><?= h($profile->name) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
