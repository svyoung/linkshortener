<div class="modal fade" id="fullpost" tabindex="-1" role="dialog" aria-labelledby="fullpost">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content" id="post-content-<?php echo e($post[0]->id); ?>">
    <div class="modal-header svy-modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="FullPostLabel"><?php echo e($post[0]->title); ?></h4>
    </div>
    <div class="modal-body">
      <?php if(Route::has('login')): ?>
            <div class="top-right links">
                <?php if(Auth::check()): ?>
                  <a onclick="svy.post.postEdit(<?php echo e($post[0]->id); ?>)"><i class="fa fa-pencil edit-pencil"></i></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
      <span style="text-align: right"><strong><?php echo e($post[0]->created_at); ?></strong></span>
      <p></p>
      <div class="modal-post-content">
        <?php echo $post[0]->content; ?>

      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    <script>
    	
    </script>
  </div>
</div>