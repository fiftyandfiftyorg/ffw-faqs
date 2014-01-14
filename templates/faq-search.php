<div class="ffw_faqs_search_wrapper">
    <form role="search" action="<?php echo home_url(); ?>" method="get" >
        <input type="text" name="s" placeholder="Search <?php echo ffw_faqs_get_label_plural(); ?>">
        <input type="submit" value="search">
        <input type="hidden" name="post_type" value="ffw_faqs">
    </form>
</div>