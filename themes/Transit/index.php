<?php
/**
 * Transit theme for Typecho
 *
 * @package Typecho Transit Theme
 * @author Natsusora
 * @version 0.2
 * @link https://github.com/Natsusora-no-Perseus/Typecho-TransitTheme
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$this->need('ekifuncs.php');
?>


<div class="col-9" id="main" role="main">
    <?php while ($this->next()): ?>
        <article class="entry" itemscope itemtype="http://schema.org/BlogPosting">
            <div class="entry-left">
                <h2 class="entry-title" itemprop="name headline">
                    <a itemprop="url"
                       href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                </h2>
                <ul class="entry-meta">
                    <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <a itemprop="name" href="<?php $this->author->permalink(); ?>" rel="author">作: <?php $this->author(); ?>&#8594;</a></li>
                    <li>
                        <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
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

    <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>

