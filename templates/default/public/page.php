<?php if($records['page']<$records['pagesum'] && $records['pagesum']>1):?>
<div class="loadMore fr"><a href="<?php echo $records['nexturl']?>">下一页</a></div>
<?php endif;?>
<?php if ($records['page']!=1):?>
<div class="loadMore"><a href="<?php echo $records['prevurl']?>">上一页</a></div>
<?php endif;?>