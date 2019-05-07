<h5> Share This Post</h5>
<?php
$ci = volgo_get_ci_object();

$path_info = $ci->input->server('PATH_INFO');
if (empty($path_info))
	$path_info = $ci->input->server('ORIG_PATH_INFO');
?>
<ul class="social">
	<li><a onClick="share_this('share_fb_item')" id="share_fb_item"
		   data-url="<?php echo base_url($path_info); ?>" href="#"
		   class="fb" data-title="asdfasdfasdfasdf" target="_blank" title="Facebook">
			<span class="icon fa fa-facebook"></span> </a></li>
	<li><a onClick="share_this('share_tw_item')" id="share_tw_item"
		   data-url="<?php echo base_url($path_info); ?>" class="twt" href="#"
		   target="_blank" title="Twitter"> <span
				class="icon fa fa-twitter"></span> </a></li>
	<!--    <li><a onClick="share_this('share_gp_item')" id="share_gp_item"-->
	<!--           data-url="--><?php //echo base_url($path_info); ?><!--" class="gplus" href="#"-->
	<!--           target="_blank" title="Plus.google"> <span-->
	<!--                    class="icon fa fa-google-plus"></span> </a></li>-->
	<li><a onClick="share_this('share_ln_item')" id="share_ln_item"
		   data-url="<?php echo base_url($path_info); ?>" href="#" class="lnk"
		   target="_blank" title="Linkedin"> <span
				class="icon fa fa-linkedin"></span> </a></li>
	<li><a onClick="share_this('share_pt_item')" id="share_pt_item"
		   data-url="<?php echo base_url($path_info); ?>" href="#" class="pin"
		   href="https://pinterest.com/" target="_blank" title="Pinterest"> <span
				class="icon fa fa-pinterest"></span> </a></li>
</ul>

