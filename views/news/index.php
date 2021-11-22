<?php

use app\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var $data
 * @var $pages
 */
$this->title = 'Информационное агенство';
$post_size = ['full', 'one-third', 'one-third', 'one-third', 'two-third', 'one-third'];
?>
<?= Alert::widget() ?>


<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image:url(images/content/pag.jpg);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 text-left">
                <div class="display-t">
                    <div class="display-tc animate-box" data-animate-effect="fadeInUp">
                        <span class="date-post"><?=$this->title?></span>
                        <h1 class="mb30"><a href="#">Сергей Собянин — о ситуации с коронавирусом в Москве</a></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="gtco-main">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col-md-12">
                <?php if(empty($data)):?>
                    <h2>Ни одной статьи не было добавлено!</h2>
                <?php endif;?>
                <ul id="gtco-post-list">
                    <?php foreach($data as $key => $value):
                        $count_size = (int)count($post_size);
                        $i = $key - $count_size*floor($key/$count_size);
                    ?>
                        <li class="<?=$post_size[$i] ?> entry animate-box" data-animate-effect="fadeIn">
                            <a href="<?= Url::toRoute(['news/view', 'id' => $value['id']]) ?>">
                                <div class="entry-img" style="background-image: url(<?=($value['image'])? $value['image'] : '/images/default.jpg'; ?>)"></div>
                                <div class="entry-desc">
                                    <h3><?=$value['title'] ?></h3>
                                    <p><?=$value['description'] ?></p>
                                </div>
                            </a>
                            <a class="post-meta">
                                <i class="icon-user"></i>
                                <?=$value['user'] ?>
                                <span class="date-posted">
                                    <i class="icon-watch"></i>
                                    <?=$value['date'] ?>
                                </span>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <nav aria-label="Page navigation">
                    <?php echo LinkPager::widget(['pagination' => $pages, 'id' => 'main_pagination']); ?>
                </nav>
            </div>
        </div>
    </div>
</div>