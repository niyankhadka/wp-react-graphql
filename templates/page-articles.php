<?php

/**
 * The template for displaying all single posts and attachments for the article post type.
 */
get_header(); ?>

    <div id="main-article" class="content-area">
        <main id="main" class="site-main">

            <header class="page-header">
                <?php
                get_the_title( '<h1 class="page-title">', '</h1>' );
                ?>
            </header><!-- .page-header -->

            <div id="root-article" class="page-articles">
                
            </div>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>