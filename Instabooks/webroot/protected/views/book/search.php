<?php
$this->breadcrumbs=array(
	'Book'=>array('/book'),
	'Search',
);?>

<div class="span-11 colborder">
<h1>Busca tu favorito</h1>
<div class="form">
<? $form = $this->beginWidget('CActiveForm', array('method'=>'GET')) ?>
<?= $form->errorSummary($model) ?>
<?= $form->textField($model, 'query') ?>
<?= CHtml::submitButton('Search') ?>
<? $this->endWidget() ?>
</div>
</div>
<div class="span-10" >
<h2>Recomendamos:</h2>
<div class="span-5 last">
    <h3>Libros</h3>
<ul>
<li><?= CHtml::link('Huckleberry Finn', array('view','id'=>'khkU4KZ5o-4C')) ?></li>
<li><?= CHtml::link('Cloud Atlas', array('view','id'=>'EoxXLiC0uAIC')) ?></li>
<li><?= CHtml::link('Excession', array('view','id'=>'OwFWHk4qn90C')) ?></li>
<li><?= CHtml::link('Valis', array('view','id'=>'1V9_sv_BudkC')) ?></li>
<li><?= CHtml::link('Sinuhe, The Egyptian', array('view','id'=>'FEvh724F20UC')) ?></li>
</ul>
</div>
<div class="span-5 last">
<h3>Autores</h3>
<ul>
<li><?= CHtml::link('J. R. R. Tolkien ', array('view','id'=>'khkU4KZ5o-4C')) ?></li>
<li><?= CHtml::link('Philip K. Dick', array('view','id'=>'EoxXLiC0uAIC')) ?></li>
<li><?= CHtml::link('H. P. Lovecraft', array('view','id'=>'OwFWHk4qn90C')) ?></li>
<li><?= CHtml::link('Mika Waltari', array('view','id'=>'1V9_sv_BudkC')) ?></li>
<li><?= CHtml::link('David Mitchell', array('view','id'=>'FEvh724F20UC')) ?></li>
</ul>
</div>
</div>


<? if (!empty($books)): ?>
<? if ($books->count() == 0): ?>
<div class="error">No hay resultados</div>
<? else: ?>
<div class="book list">
<? foreach ($books->toArray() as $book): ?>
<div class="book view">
<div style="float: left; margin: 10px">
<?= CHtml::image($book->image) ?>
</div>
<h2>
<?= CHtml::link($book->title, array('view', 'id'=>$book->google_id)) ?> 
(<span style="color:green">+<?= $book->vote ?> /
<span style="color:red">-<?= $book->n_vote ?></span>)</h2>
<p><?= $book->author ?> <?= $book->category ?></p>
<p><?= nl2br($book->description) ?></p>
</div>
<? endforeach ?>
</div>
<? endif; ?>
<? endif; ?>
