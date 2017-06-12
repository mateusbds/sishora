<div class="container" style="margin: auto;
    width: 50%;
    border: 3px solid transparent;
    padding: 1px;
    background: transparent;">
    <div id="loginbox" style="margin-top:15px;" class="mainbox col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Bem Vindo ao SisHora!</div>
                <div style="float:right; font-size: 80%; position: relative; top:-10px">
                    <?= $this->Html->link("Esqueceu a senha?", ['action' => 'forgotPassword']) ?>
                </div>
            </div>
            <div style="padding-top:30px" class="panel-body" >
                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <?= $this->Form->create(null, ['class' => 'form-horizontal']) ?>

                    <?= $this->Form->label('username', 'Usuário') ?>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <?= $this->Form->input('username', ['class' => 'form-control', 'label' => false]) ?>
                    </div>

                    <?= $this->Form->label('password', 'Senha') ?>
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false]) ?>
                    </div>

                    <div class="col-sm-12 controls">
                        <?= $this->Form->button('Login', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
