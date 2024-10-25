<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('normalize.css'); ?>">
    <!--
    <link rel="stylesheet" href="<?php //$this->options->themeUrl('grid.css'); ?>">
    <link rel="stylesheet" href="<?php //$this->options> themeUrl('style.css'); ?>">
    -->
    <!-- 加载远程字体 -->
    <link rel="stylesheet" href="https://code.cdn.mozilla.net/fonts/fira.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100..900&display=swap" rel="stylesheet">

    <!-- 加载附加 CSS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('typo.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('transit.css'); ?>">
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body>

<header id="header" class="clearfix">
    <div class="container">
        <div class="row">
            <div class="site-name col-9">
                    <!---
                <?php if ($this->options->logoUrl): ?>
                    <a id="logo" href="<?php $this->options->siteUrl(); ?>">
                        <img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>"/>
                    </a>
                <?php else: ?>
                    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
                    <p class="description"><?php $this->options->description() ?></p>
                <?php endif; ?>
                    --->
            </div>
            <div class="site-search col-3 kit-hidden-tb">
                <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                    <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                    <input type="text" id="s" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>"/>
                    <button type="submit" class="submit"><?php _e('搜索'); ?></button>
                </form>
            </div>
            <div class="col-9">
                <nav id="nav-menu" class="clearfix" role="navigation">
                    <a<?php if ($this->is('index')): ?> class="current"<?php endif; ?>
                        href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                    <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <a<?php if ($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?>
                            href="<?php $pages->permalink(); ?>"
                            title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                    <?php endwhile; ?>
                </nav>
            </div>
            <div class="col-9">
                <nav id="nav-menu" class="clearfix" role="navigation">
                    <?php if ($this->is('index')): ?>
                    <div class="back-index">
                        <img src="<?php $this->options->logoUrl(); ?>" alt="网站图标">
                    </div>
                    <div class="site-desc">
                        <div id="site-title">
                            <?php $this->options->title(); ?>
                        </div>
                        <div id="description">
                            <?php $this->options->description(); ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <a class="back-index" href="<?php $this->options->siteUrl(); ?>">
                        <img src=<?php $this->options->themeUrl('img/exit-arrow.svg'); ?> alt="主页" id="backarrow">
                    </a>
                    <div class="back-desc">主页</div>
                    <?php endif; ?>

                    <div class="dropdown">
                        <input type="checkbox" id="category-menu" itemprop="menu-box">
                        <label for="category-menu" class="menu-label">分类</label>
                        <?php \Widget\Metas\Category\Rows::alloc()->listCategories('wrapClass=menu-items'); ?>
                       </ul>
                    </div>
                    <div class="dropdown">
                        <input type="checkbox" id="category-menu" itemprop="menu-box">
                        <label for="category-menu" class="menu-label">分类</label>
                        <?php \Widget\Metas\Category\Rows::alloc()->listCategories('wrapClass=menu-items'); ?>
                       </ul>
                    </div>

                    <div class="dropdown">
                        <input type="checkbox" id="others-menu" itemprop="menu-box">
                        <label for="others-menu" class="menu-label">其它</label>
                        <ul class="menu-items">
                            <?php // Custom pages ?>
                            <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
                            <?php while ($pages->next()): ?>
                            <li><a<?php if ($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?>
                            href="<?php $pages->permalink(); ?>"
                            title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
                            <?php endwhile; ?>

                            <?php if ($this->user->hasLogin()): ?>
                            <li class="last"><a href="<?php $this->options->adminUrl(); ?>"><?php _e('进入后台'); ?>(<?php $this->user->screenName(); ?>)</a></li>
                            <li><a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a></li>
                            <?php else: ?>
                            <li class="last"><a href="<?php $this->options->adminUrl('login.php'); ?>"><?php _e('登录'); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a></li>
                            <li><a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a></li>
                            <div class="dropdown">
                                <input type="checkbox" id="more-menu" itemprop="menu-box">
                                <label for="more-menu" class="menu-label">其它</label>
                                <ul class="menu-items">
                                    <li><a href='#'>选项</a></li>
                                    <li><a href='#'>选项</a></li>
                                    <li><a href='#'>选项</a></li>
                                </ul>
                            </div>
                       </ul>
                    </div>

        </div><!-- end .row -->
    </div>
</header><!-- end #header -->
<div id="body">
    <div class="container">
        <div class="row">

    
    
