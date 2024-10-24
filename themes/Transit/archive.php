<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<?php $this->need('ekifuncs.php'); ?>

<div class="col-9" id="main" role="main">
    <h3 class="archive-title"><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ''); ?></h3>
    <?php if ($this->have()): ?>
        <?php while ($this->next()): ?>
            <article class="entry" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="entry-left">
                <h2 class="entry-title" itemprop="name headline"><a itemprop="url"
                                                                   href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                </h2>
                <ul class="entry-meta">
                    <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author">作: <?php $this->author(); ?>&#8594;</a></li>
                    <li>
                        <time datetime="<?php $this->date('c'); ?>"
                              itemprop="datePublished"><?php $this->date(); ?></time>
                    </li>
                    <li itemprop="interactionCount">
                        <a itemprop="discussionUrl"
                           href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum(); ?> &#x1F5E8;</a>
                    </li>
                </ul>
                <div class="entry-content" itemprop="articleBody">
                    <?php
                        $content = $this->content;
                        // $content = $this->content('- 阅读剩余部分 -');
                        // echo getHeadingsOrExcerpt($content, 50);
                        echo strip_tags($content);
                    ?>
                </div>
            </div>
                <ul class="entry-category">
                    <?php drawColoredCategory($this->categories); ?>
                </ul>
            </article>
        <?php endwhile; ?>
    <?php else: ?>
        <article class="entry">
            <h2 class="entry-title"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
</div><!-- end #main -->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
