<div class="modal fade" id="newPost" tabindex="-1" role="dialog" aria-labelledby="NewPost">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header svy-modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="NewPostModalLabel">New Blog Post</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="blog-title" class="control-label">Title</label>
            <input type="text" name="title" class="form-control" id="blog-title">
          </div>
          <div class="form-group" id="blog-date">
            <label for="blog-date" class="control-label">Date</label>
				      <?php echo e(date('F d, Y')); ?>

          </div>
          <div class="form-group" id="blog-post-content">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_new">Add New Post</button>
      </div>
      <script>
      	$("#blog-post-content").summernote({
      		minHeight: 250
      	});
        $(".add_new").on("click", function(){
            var data = {
                title: $('#blog-title').val(),
                content: $("#blog-post-content").summernote('code')
            };
            // console.log(data);
            svy.post.addNewPost(data);
            $("#newPost").modal('hide');
            $('.popover').remove();
            $("#blog-post-content").summernote('destroy')
        });
      </script>
    </div>
  </div>