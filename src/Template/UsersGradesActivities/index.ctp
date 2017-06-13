
<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="actions-sidebar">
    <div class="container" style="background: #f8f8f8;">
        <a class="navbar-brand" href="#">SisHora</a>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a  href="courses" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Cadastro
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link(__('Atividades Complementares'), ['action' => '#']) ?></li>
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
<?php //calculo das horas
    $x = 0; //comprovada
    $p = 0; //pendente
    //Não deixar o aluno fazer nada se ele não estiver vinculado a uma grade
    $porcentagem = 0; 
    foreach($usersGradesActivities as $usersGradesActivity):
        if($x <= $users['qntHours']) 
        {
            if($usersGradesActivity->validated == 1)
            {
                $x += $usersGradesActivity->carga_aproveitada;
            }
            else if($usersGradesActivity->validated == 2)
            {
                $p += $usersGradesActivity->carga_aproveitada;
            }
        }
        else
        {
            $x = $users['qntHours'];
        }
    endforeach;

    if($x != 0)
        $porcentagem = round($x * (100 / $users['qntHours']), 2);

    if($porcentagem >= 100)
    {
        $porcentagem = 100;
    }
?>
<div class="container">
    <div class="container" style="border-radius: 0px; background: transparent; margin-top: 15px;">
        <div class="row">
            <div class="col-md-8"><b>Nome:</b>
                <?= $users['name'] ?>
            </div>
            <div class="col-md-4"><b>Matrícula:</b>
                <?= $users['matricula'] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8"><b>Curso:</b>
                <?php if(isset($users['course_name'])) 
                    echo $users['course_name'] ?>
            </div>
            <div class="col-md-4"><b>Grade:</b>
                <?php if(isset($users['grade_name'])) 
                    echo $users['grade_name'] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12"><b>Nº de horas complementares:</b>
                <?= $users['qntHours'] ?>
            </div>
        </div>
    </div>
    <div style="margin-top: 15px;">
        <h3>Progresso:</h1>
        <div class="row">
            <div class="col-md-8"><b>Horas complementares comprovadas:</b>
                <?php 
                   echo $x
                ?>h
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><b>Horas complementares pendentes:</b>
                <?php 
                   echo floor($p)
                ?>h
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><b>Restante:</b>
                <?php
                    echo floor($users['qntHours'] - $x < $users['qntHours'] ? 0 : $users['qntHours'] - $x)
                ?>h
            </div>
        </div>
        <div class="progress">
            <div id="myDiv" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentagem ?>%">
            <?= $porcentagem ?>%
            </div>
        </div>
    </div>
    <h3><?= __('Atividades Complementares') ?></h3>
    <?= $this->Html->link(__('Adicionar Atividade'), ['action' => 'add'], ['class' => 'btn btn-primary', 'rel' => 'modal:open']) ?>
    <table id="example" class="table table-bordered table-striped display">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('description', ['label' => 'Descrição']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('grades_activity_id', ['label' => 'Tipo']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('carga_horaria') ?></th>
                <th scope="col"><?= $this->Paginator->sort('carga_aproveitada', ['label' => 'Carga Aproveitada']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('instituicao', ['label' => 'Instituição']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_name', ['label' => 'Nome do arquivo']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('validated', ['label' => 'Status']) ?></th>
                <th scope="col"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersGradesActivities as $usersGradesActivity): ?>
            <tr>
                <td><?= h($usersGradesActivity->description) ?></td>
                <td><?= $usersGradesActivity->has('grades_activity') ? $usersGradesActivity->grades_activity->activity->name : '' ?></td>
                <td><?php 
                    echo $this->Number->format($usersGradesActivity->carga_horaria); 
                    if($usersGradesActivity->grades_activity->unit == 0)
                    {
                        echo ' Hora(s)';
                    }
                    else if($usersGradesActivity->grades_activity->unit == 1)
                    {
                        echo ' Dia(s)';
                    }
                    else if($usersGradesActivity->grades_activity->unit == 2)
                    {
                        echo ' Quantidade';
                    } ?></td>
                <td><?= $this->Number->format(floor($usersGradesActivity->carga_aproveitada))." Hora(s)" ?></td>
                <td><?= h($usersGradesActivity->instituicao) ?></td>
                <td><?= $this->Html->link(h($usersGradesActivity->file_name), ['action' => 'download', $usersGradesActivity->user_id, base64_encode($usersGradesActivity->file_name)]) ?></td>
                <td><?php if($usersGradesActivity->validated == 1)
                    {
                        echo('Validado');
                    }
                    else if($usersGradesActivity->validated == 0)
                    {
                        echo('Rejeitado ');
                        echo($this->Html->link('', ['action' => 'obs', $usersGradesActivity->id], ['class' => 'glyphicon glyphicon-remove-sign', 'rel' => 'modal:open', 'style' => 'color: red;']));
                    }
                    else if($usersGradesActivity->validated == 2)
                    {
                        echo('Pendente');
                    }
                ?></td>
                <?php
                if($usersGradesActivity->validated != 2)
                {
                    ?>
                    <script>
                        $( document ).ready(function() {
                            document.getElementById("edit"+<?php echo  $usersGradesActivity->id; ?>).style.display = "none";
                            document.getElementById("delete"+<?php echo  $usersGradesActivity->id; ?>).style.display = "none";
                        });
                    </script>
                    <?php
                }
            ?>
                <td class="actions">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $usersGradesActivity->id], ['class' => 'btn-warning btn btn-xs', 'rel' => 'modal:open', 'id' => 'edit'. $usersGradesActivity->id]) ?>
                    <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $usersGradesActivity->id], ['class' => 'btn btn-danger btn-xs', 'rel' => 'modal:open', 'id' => 'delete' . $usersGradesActivity->id, 'confirm' => __('Tem certeza que deseja deletar essa atividade?')]) ?>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>