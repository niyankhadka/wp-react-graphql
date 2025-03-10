<?php

/**
 * The template for displaying all taxonomy for the article post type.
 */

get_header(); ?>

    <div id="main-article" class="content-area">
        <main id="main" class="site-main">

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="archive-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <div id="root-article" class="archive-article">

            </div>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>