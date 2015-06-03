<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
  <!-- FavIco -->
    <link rel="shortcut icon" href="<?= Yii::$app->urlManager->baseUrl; ?>/Favicon.ico" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<DIV id="page">

  <!-- 1) Header -->
    <div id="header">
        <div id="logo">FrameWork Template</div>
    </div>

  <!-- 2) PanelMenu -->
    <nav class="navbar navbar-default" role="navigation">
    <?= Menu::widget([

            'options' => [
                'class' => 'nav navbar-nav',
                'id' => 'yw0', // не сильно нужно
            ],

            'itemOptions' => [
                // 'class' => 'navBoxUrl',
                // 'tag' => 'div',
            ],
            
            // 'linkTemplate' => '<a href="{url}" class="navUrl">{label}</a>',

            'items' => [
                ['label' => 'Home', 'url' => ['/primary/index']],
                ['label' => 'HomeTest', 'url' => ['/primary/test']],
                ['label' => 'TestCont', 'url' => ['/test/index']],

                ['label' => 'TestTest', 'url' => ['/test/test']],
            ],
        ]);
    ?>
    </nav>

  <!-- 3) Content -->
    <div id="content">
        <div id="ContentBox">
            <h3 id="ContentBoxTitle">Content</h3>
            <?= $content ?>
        </div>
    </div>

  <!-- 4) Footer -->
    <div id="footer">
        Footer
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>