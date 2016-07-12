<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} $pageid=get_the_ID();global $buzz_options;  ?>
</main>
<footer id="footer">
  <div class="footer-block">
    <div class="container-fluid">
      <div class="row">
        <?php if($buzz_options['footer_text']):?>
            <div class="col-sm-6"><p><?php echo wp_kses_post($buzz_options['footer_text']);?></p></div>
        <?php endif;?>
        <div class="col-sm-6 text-right">
            <?php
                wp_nav_menu( array(
                'theme_location'    => 'secondary',
                'container'         => '',
                'container_class'   => '',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'sub-nav',
                'fallback_cb'       => 'bl_bootstrap_navwalker::fallback',
                'walker'            => new bl_bootstrap_navwalker())
                );
            ?>
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<?php if(isset($buzz_options['meta_javascript']) && $buzz_options['meta_javascript']!='')
echo wp_kses_post($buzz_options['meta_javascript']); ?>
<?php wp_footer(); ?>
<script type="text/javascript">
jQuery('body').on('click','#loadmore a',function(){
    var paged = jQuery('#paged').val();
    var next_num =parseInt(paged)+1;
    jQuery('#paged').val(next_num);
    var max_paged =jQuery('#max_paged').val();
    console.log(max_paged);
    if(parseInt(paged)>parseInt(max_paged))
    {
      return false;
    }
      jQuery.ajax({
        url: '<?php echo esc_url( get_template_directory_uri() );?>/inc/ajax.php',
        type: 'POST',
        data: 'action_type=loadmore&paged='+paged,
        beforeSend:function(xhr){
          jQuery('#loadmore a').html('Loading..');
        }
      })
      .done(function(result) {
        console.log(result);
        jQuery("#latest_post").append(result);
        if (parseInt(paged) == parseInt(max_paged))
        {
          jQuery("#loadmore a").hide();
          jQuery("#loadmore a").html('Load More');
        }
        else
        {
          jQuery("#loadmore a").show();
          jQuery("#loadmore a").html('Load More');
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
});
// Trading
jQuery('body').on('click','#loadmore_tranding a',function(){
    var paged = jQuery('#paged_tranding').val();
    var next_num =parseInt(paged)+1;
    jQuery('#paged_tranding').val(next_num);
    var max_paged =jQuery('#max_paged_tranding').val();
    console.log(max_paged);
    if(parseInt(paged)>parseInt(max_paged))
    {
      return false;
    }
      jQuery.ajax({
        url: '<?php echo esc_url( get_template_directory_uri() );?>/inc/ajax.php',
        type: 'POST',
        data: 'action_type=loadmore_tranding&paged='+paged,
        beforeSend:function(xhr){
          jQuery('#loadmore_tranding a').html('Loading..');
        }
      })
      .done(function(result) {
        console.log(result);
        jQuery("#tranding").append(result);
        if (parseInt(paged) == parseInt(max_paged))
        {
          jQuery("#loadmore_tranding a").hide();
          jQuery("#loadmore_tranding a").html('Load More');
        }
        else
        {
          jQuery("#loadmore_tranding a").show();
          jQuery("#loadmore_tranding a").html('Load More');
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
});
// trading 2
jQuery('body').on('click','#loadmore_tranding2 a',function(){
    var paged = jQuery('#paged_tranding2').val();
    var next_num =parseInt(paged)+1;
    jQuery('#paged_tranding2').val(next_num);
    var max_paged =jQuery('#max_paged_tranding2').val();
    console.log(max_paged);
    if(parseInt(paged)>parseInt(max_paged))
    {
      return false;
    }
      jQuery.ajax({
        url: '<?php echo esc_url( get_template_directory_uri() );?>/inc/ajax.php',
        type: 'POST',
        data: 'action_type=loadmore_tranding2&paged='+paged,
        beforeSend:function(xhr){
          jQuery('#loadmore_tranding2 a').html('Loading..');
        }
      })
      .done(function(result) {
        console.log(result);
        jQuery("#tranding2").append(result);
        if (parseInt(paged) == parseInt(max_paged))
        {
          jQuery("#loadmore_tranding2 a").hide();
          jQuery("#loadmore_tranding2 a").html('Load More');
        }
        else
        {
          jQuery("#loadmore_tranding2 a").show();
          jQuery("#loadmore_tranding2 a").html('Load More');
        }
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
});
</script>
    </body>
</html>