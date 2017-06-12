<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'SisHora: Sistema de Horas Complementares';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="pt-br">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    
    <?php
        echo $this->Html->script('jquery.min');

        echo $this->Html->css('general');

        echo $this->Html->css('bootstrap');
        echo $this->Html->css('style');
        echo $this->Html->script('bootstrap');

        echo $this->Html->script('jquery.modal.min');
        echo $this->Html->css('jquery.modal.min');

        echo $this->Html->script('datatables.min.js');
        echo $this->Html->css('datatables.min.css');

        echo $this->Html->script('multiselect.min');
        echo $this->Html->css('style2');
        
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <style>
        body { padding-top: 70px; background: #dddddd; }
        table{ margin-top: 20px; }
        .container{ border-radius: 12px; background: #fff; }
        li .active { border-radius: 20px; }
        .dropdown-option {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: 400;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
        }
        h3 {border-bottom: 1px solid #e5e5e5;}

        #example_wrapper{ margin-top: 10px;}
    </style>
    
</head>
<body>

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>

    <footer>
    </footer>
</body>
</html>
