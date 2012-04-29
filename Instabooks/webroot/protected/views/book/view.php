<?php
$this->breadcrumbs=array(
	'Book'=>array('/book'),
	'View',
);?>
<div style="book view">
<div style="float: right; margin: 0 10px 10px 0">
<?= CHtml::image($book->image) ?>
</div>
<h1><?= $book->title ?> (<span style="color:green">+<?=$book->vote?></span> / <span style="color:red">-<?=$book->n_vote?></span>)
</h1>
<h2>By <?=$book->author ?>


<span style="color: green"><?= CHtml::link('+1',array('vote','id'=>$book->google_id,'vote'=>+1)) ?> </span> /
<span style="color: red">
<?= CHtml::link('-1',array('vote','id'=>$book->google_id,'vote'=>-1)) ?></a>
</span></h2>

<p style="margin-bottom: 20px;"><?= nl2br($book->description) ?></p>

<h3><?= CHtml::link('Leer', array('read','id'=>$book->google_id),  array('rel'=> 'shadowbox;width=910')); ?></h3>
<h3>Compralo en</h3>
<ul>
    <li><a href="http://www.amazon.es/s/ref=nb_sb_noss?field-keywords=<?= $book->isbn_10; ?>" target="_blank">Amazon.com</a></li>
    <li><a href="http://www.casadellibro.com/homeAfiliado?isbn=<?= $book->isbn_10; ?>" target="_blank">Casa del libro</a></li>
    <li><a href="http://www.elcorteingles.es/tienda/libros/producto/libro_descripcion.asp?CODIISBN=<?= $book->isbn_10; ?>" target="_blank">El corte inglés</a></li>
</ul>
</div>

    <div style="clear: both;"></div>

<div class="fb-comments" data-href="<?php echo Yii::app()->request->baseUrl.'/'.$book->google_id; ?>" data-num-posts="10" data-width="910"></div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=140209332712403";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>    
