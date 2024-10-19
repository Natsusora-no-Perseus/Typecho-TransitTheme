<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="col-mb-12 col-8" id="main" role="main">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <h1 class="post-title" itemprop="name headline">
            <a itemprop="url"
               href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
        </h1>
        <ul class="post-meta">
            <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                <?php _e('作者: '); ?><a itemprop="name"
                                       href="<?php $this->author->permalink(); ?>"
                                       rel="author"><?php $this->author(); ?></a>
            </li>
            <li><?php _e('时间: '); ?>
                <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
            </li>
            <li><?php _e('分类: '); ?><?php $this->category(','); ?></li>
        </ul>
        <div class="post-content" itemprop="articleBody">
            <?php $this->content(); ?>
        </div>
        <p itemprop="keywords" class="tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></p>
    </article>

    <?php $this->need('comments.php'); ?>

    <div class="post-near">
            <img src=<?php $this->options->themeUrl('img/left-point.svg'); ?> alt="Prev" id="larrow">
            <div class="near-bar">
                <div id="ltext"><?php $this->thePrev('%s', '无更旧文章'); ?></div>
                <div id="rtext"><?php $this->theNext('%s', '无更新文章'); ?></div>
            </div>
            <img src=<?php $this->options->themeUrl('img/left-point.svg'); ?> alt="Next" id="rarrow">
    </div>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
