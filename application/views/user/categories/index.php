<div class="breadcrumb-bar">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="breadcrumb-title">
					<h2><?php echo (!empty($user_language[$user_selected]['lg_category_name'])) ? $user_language[$user_selected]['lg_category_name'] : $default_language['en']['lg_category_name']; ?></h2>
				</div>
			</div>
			<div class="col-auto float-right ml-auto breadcrumb-menu">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo (!empty($user_language[$user_selected]['lg_home'])) ? $user_language[$user_selected]['lg_home'] : $default_language['en']['lg_home']; ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo (!empty($user_language[$user_selected]['lg_category_name'])) ? $user_language[$user_selected]['lg_category_name'] : $default_language['en']['lg_category_name']; ?></li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container">
		<div class="">
			<?php 
			$pagination=explode('|',$this->ajax_pagination->create_links());
			?>
		</div>					
		<div class="catsec">
			<div class="row" id="dataList">

			<?php
			$placholder_img = $this->db->get_where('system_settings', array('key'=>'service_placeholder_image'))->row()->value;
			if(!empty($category)) {
				foreach ($category as $crows) {
					$category_name=strtolower($crows['category_name']);
					
					if(!empty($crows['category_image']) && (@getimagesize(base_url().$crows['category_image']))){
						$category_image = base_url().$crows['category_image'];
					}else{
						$category_image = ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';
					} 
				?>
			<div class="col-lg-4 col-md-6">
					<div class="cate-widget">
						<img src="<?php echo $category_image;?>" alt="">
						<div class="cate-title">
							<a href="<?php echo base_url();?>maincategories/<?php echo $crows['id'];?>"><h3><span><i class="fas fa-circle"></i> <?php echo ucfirst($crows['category_name']);?></span></h3></a>
						</div>
						<div class="cate-count">
							<a class="text-white" href="<?php echo base_url();?>search/<?php echo str_replace(' ', '-', $category_name)?>"><i class="fas fa-clone"></i> <?php echo $crows['category_count'];?></a>
						</div>
					</div>
			</div>
			<?php } }
			else { 

			echo '<div class="col-lg-12">
			<div class="category">
			No Categories Found
			</div>
			</div>';
			} 

			echo $this->ajax_pagination->create_links();
			?>
			</div>
		</div>
	</div>
</div>