<nav class="container">
    <ul class="breadcrumb clearfix">
        <?php
        if (function_exists('breadcrumbs')) {
            echo breadcrumbs();
        }
        get_template_part('metadata');
        ?>
    </ul>
</nav>