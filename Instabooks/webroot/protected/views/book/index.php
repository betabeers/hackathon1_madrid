<?php
$this->breadcrumbs=array(
	'Book',
);?>

<h1>Search books</h1>

<div class="form">
<? $form = $this->beginWidget('CActiveForm') ?>
<?= $form->errorSummary($model) ?>
<?= $form->textField($model, 'query') ?>
<?= CHtml::submitButton('Search') ?>
<? $this->endWidget() ?>
</div>

<div class="book list">
<? foreach ($books->toArray() as $book): ?>
<div>
<div style="float: left; margin: 10px">
<?= CHtml::image($book->image) ?>
</div>
<h2>
<?=CHtml::link($book->title, $book->google_link) ?> - 
<?= CHtml::link('+1', 
    array('book/vote','id'=>md5($book->google_link), 'vote'=>+1)); ?>
</h2>
<p><?= $book->author ?> <?= $book->category ?></p>
<p><?= nl2br($book->description) ?></p>
</div>
<? endforeach ?>
</div>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
