<aside class="col-12 col-lg-4 order-lg-1 sidebar-left">
  <div class="pr-1 pl-1">

    <?php 
      if ( 
        !function_exists('dynamic_sidebar') || !dynamic_sidebar( "Sidebar Left") ) : 
      endif; 
    ?>
    
  </div>
</aside>