<?php
use yii\helpers\Url;

/**
 * @var $data
 */

?>
<header id="gtco-header" class="gtco-cover" role="banner" style="background-image:url(<?=$data['image']?>);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-7 text-left">
                <div class="display-t">
                    <div class="display-tc animate-box" data-animate-effect="fadeInUp">
                        <span class="date-post"><?=$data['date']?></span>
                        <h1 class="mb30"><a href="#"><?=$data['title']?></a></h1>
                        <p><a href="#" class="text-link"><?=$data['user']?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="gtco-maine">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col-md-12">
                <article class="mt-negative container">
                    <div class="text-left content-article">
                        <?=$data['body']?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>