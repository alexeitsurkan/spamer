<?php

use app\assets\MyNewsBundle;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var $data
 * @var $pages
 */


MyNewsBundle::register($this);
$this->title = 'Мои статьи';
$post_size = ['full', 'one-third', 'one-third', 'one-third', 'two-third', 'one-third'];
?>

<header id="gtco-header" class="gtco-cover" role="banner" style="height: 300px">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-7 text-left">
                <div class="display-t" style="height: 350px">
                    <div class="display-tc animate-box" data-animate-effect="fadeInUp" style="height: 350px">
                        <h1 class="mb30"><a href="#"><?= $this->title ?></a></h1>
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
                <div class="row mb-4">
                    <?php if (empty($data)): ?>
                        <div class="col-xs-12">
                            <h2> Пока ни одной статьи не найдено!</h2>
                        </div>
                    <?php endif; ?>
                    <div class="col">
                        <a href="<?= Url::toRoute(['news/form']) ?>" class="btn btn-success">Написать статью</a>
                    </div>
                    <div class="spacing"></div>
                </div>
                <ul id="gtco-post-list">
                    <?php foreach ($data as $key => $value):
                        $count_size = (int)count($post_size);
                        $i = $key - $count_size * floor($key / $count_size);
                        ?>
                        <li class="<?= $post_size[$i] ?> entry animate-box" data-animate-effect="fadeIn">
                            <div class="c_panel">
                                <a href="<?= Url::toRoute(['news/form', 'id' => $value['id']]) ?>"
                                   class="btn btn-warning" title="Изменить"><i class="icon-pencil"></i></a>
                                <a href="<?= Url::toRoute(['news/delete', 'id' => $value['id']]) ?>"
                                   class="btn btn-danger" title="Удалить"><i class="icon-trash"></i></a>
                            </div>
                            <a href="<?= Url::toRoute(['news/view', 'id' => $value['id']]) ?>">
                                <div class="entry-img"
                                     style="background-image: url(<?=($value['image'])? $value['image'] : '/images/default.jpg'; ?>)"></div>
                                <div class="entry-desc">
                                    <h3><?= $value['title'] ?></h3>
                                    <p><?= $value['description'] ?></p>
                                </div>
                            </a>
                            <span class="post-meta"><?= $value['user'] ?><span
                                        class="date-posted"><?= $value['date'] ?></span></span>
                        </li>
                    <?php endforeach; ?>
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