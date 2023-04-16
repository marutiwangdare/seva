<?php
$this->db->from('services');
$services_count = $this->db->count_all_results();
$this->db->from('services');
$this->db->where('status', 1);
$this->db->order_by('total_views', 'DESC');
$this->db->limit(3);
$popular = $this->db->get()->result_array();

$limit = settingValue('new_services_count')?settingValue('new_services_count'):'10';
$this->db->from('services');
$services_count = $this->db->count_all_results();
$this->db->from('services');
$this->db->where('status', 1);
$this->db->order_by('id', 'DESC');
$this->db->limit($limit);
$newest = $this->db->get()->result_array();


$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
if (!empty($result)) {
    foreach ($result as $data) {
        if ($data['key'] == 'currency_option') {
            $currency_option = $data['value'];
        }
    }
}


$bgquery = $this->db->query("select * from bgimage WHERE bgimg_for = 'banner'");
$bgresult = $bgquery->result_array();
if(!empty($bgresult[0]['upload_image']))
{
	$bgimg=base_url().$bgresult[0]['upload_image'];
}
else
{
	$bgimg=base_url().'assets/img/banner.jpg';
}

if(!empty($bgresult[0]['banner_content']))
{
	$banner_content=$bgresult[0]['banner_content'];
}
else
{
	$banner_content="World's Largest Marketplace";
   
}

if(!empty($bgresult[0]['banner_sub_content']))
{
	$banner_sub_content=$bgresult[0]['banner_sub_content'];
}
else
{
	$banner_sub_content="Search From 0 Awesome Verified Ads!";
    $banner_sub_content="Your Everday Companion!";
}
$banner_content="SEVA";
$banner_sub_content="Your Everday Companion!";
$banner_showhide = $this->db->get_where('bgimage',array('bgimg_id'=> 1))->row();
$howit_showhide = $this->db->get_where('system_settings',array('key'=> 'how_showhide'))->row();


?>
<?php if($banner_showhide->banner_settings == 1)  { ?>
<section class="hero-section">
    <div class="layer"> 
        <div class="home-banner" style="background-image: url('<?php echo $bgimg;?>');"></div>	
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-search">
						<h1><?php echo $banner_content; ?></h1>
						<p><?php echo $banner_sub_content; ?></p>
                         <?php if($banner_showhide->main_search == 1)  { ?>						
                        <div class="search-box">
                            <form action="<?php echo base_url(); ?>search" id="search_service" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                               

                                <div class="search-input line">
                                    <i class="fas fa-tv bficon"></i>
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control common_search search" name="common_search" id="search-blk" placeholder="<?php echo (!empty($user_language[$user_selected]['lg_what_you_look'])) ? $user_language[$user_selected]['lg_what_you_look'] : $default_language['en']['lg_what_you_look']; ?>" >
                                    </div>
                                </div>
                                <div class="search-input">
                                    <i class="fas fa-location-arrow bficon"></i>
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('user_address');?>" name="user_address" id="user_address" placeholder="<?php echo (!empty($user_language[$user_selected]['lg_your_location'])) ? $user_language[$user_selected]['lg_your_location'] : $default_language['en']['lg_your_location']; ?>">
                                        <input type="hidden" value="" name="user_latitude" id="user_latitude">
                                        <input type="hidden" value="" name="user_longitude" id="user_longitude">
                                        <a class="current-loc-icon current_location" data-id="1" href="javascript:void(0);" onclick="change_location()"><i class="fas fa-crosshairs"></i></a>
                                    </div>
                                </div>
                                <div class="search-btn">
                                    <button class="btn search_service" name="search" value="search"  type="button"><?php echo (!empty($user_language[$user_selected]['lg_search'])) ? $user_language[$user_selected]['lg_search'] : $default_language['en']['lg_search']; ?></button>
                                </div>
                            <?php } ?>
                            </form>
                        </div>
                        <ul id="searchResult"></ul>
                         <?php if($banner_showhide->popular_search == 1)  { ?> 
                        <div class="search-cat">
                            <i class="fas fa-circle"></i>
                            <span><?php echo (!empty($banner_showhide->popular_label)) ? $banner_showhide->popular_label : $default_language['en']['lg_popular_search']; ?></span>
                            <?php foreach ($popular as $popular_services) { ?>
                                <a href="<?php echo base_url() . 'service-preview/' . $popular_services['id'] . '?sid=' . md5($popular_services['id']); ?>">
                                    <?php echo $popular_services['service_title'] ?>
                                </a>
                            <?php } ?>
                        </div>
                         <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php  if(settingValue('featured_showhide') == 1) { ?>
<section class="category-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2><?php echo (settingValue('featured_title'))?settingValue('featured_title'):'Featured Categories'; ?></h2>
                            <span><?php echo (settingValue('featured_content'))?settingValue('featured_content'):'Test'; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="viewall">
                            <h4><a href="<?php echo base_url(); ?>all-categories"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : $default_language['en']['lg_View_All']; ?> <i class="fas fa-angle-right"></i></a></h4>
                            <span><?php echo (!empty($user_language[$user_selected]['lg_Featured_Categories'])) ? $user_language[$user_selected]['lg_Featured_Categories'] : $default_language['en']['lg_Featured_Categories']; ?></span>
                        </div>
                    </div>
                </div>						
                <div class="catsec">
                    <div class="row">
                        <?php
                        if (!empty($featured_category)) {
                            foreach ($featured_category as $crows) {
                                ?>
                                <div class="col-lg-4 col-md-6">
                                    <a href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', strtolower($crows['category_name'])); ?>">
                                        <div class="cate-widget">
										<?php if ($crows['category_image'] != '' && (@getimagesize(base_url().$crows['category_image']))) { ?>
                                            <img src="<?php echo base_url() . $crows['category_image']; ?>" alt="">
										<?php } else { ?>
											 <img alt="Category Image" src="<?php echo ($placholder_img)? base_url().$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg'; ?>">
										<?php } ?>
                                            <div class="cate-title">
                                                <h3><span><i class="fas fa-circle"></i> <?php echo ucfirst($crows['category_name']); ?></span></h3>
                                            </div>
                                            <div class="cate-count">
                                                <i class="fas fa-clone"></i> <?php echo $crows['category_count']; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        } else { ?>

                        <div class="col-lg-12">
                        <div class="category">
                        <h5 class="text-center"><?php echo (!empty($user_language[$user_selected]['lg_no_categories_found'])) ? $user_language[$user_selected]['lg_no_categories_found'] : $default_language['en']['lg_no_categories_found'] ?></h5>
                        </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<?php  if(settingValue('newest_ser_showhide') == 1) { ?>
<section class="popular-services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2><?php echo (settingValue('new_title_services'))?settingValue('new_title_services'):'Newest Services'; ?></h2>
                            <span><?php echo (settingValue('new_content_services'))?settingValue('new_content_services'):'Newest Service Contents'; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="viewall">
                            <h4><a href="<?php echo base_url(); ?>all-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : $default_language['en']['lg_View_All']; ?> <i class="fas fa-angle-right"></i></a></h4>
                            <span><?php echo (!empty($user_language[$user_selected]['lg_newest_services'])) ? $user_language[$user_selected]['lg_newest_services'] : 'Newested Services'; ?></span>
                        </div>
                    </div>
                </div>
                <div class="service-carousel">
                    <div class="service-slider owl-carousel owl-theme">

                        <?php

                        if (!empty($newest)) {
                            foreach ($newest as $nrows) {



                                $this->db->select("service_image");
                                $this->db->from('services_image');
                                $this->db->where("service_id", $nrows['id']);
                                $this->db->where("status", 1);
                                $image = $this->db->get()->row_array();

                                $provider_details = $this->db->where('id', $nrows['user_id'])->get('providers')->row_array();


                                $this->db->select('AVG(rating)');
                                $this->db->where(array('service_id' => $nrows['id'], 'status' => 1));
                                $this->db->from('rating_review');
                                $rating = $this->db->get()->row_array();
                                $avg_rating = round($rating['AVG(rating)'], 1);

                                $user_currency_code = '';
                                $userId = $this->session->userdata('id');
                                If (!empty($userId)) {
                                    $service_amount = $nrows['service_amount'];

                                    $type = $this->session->userdata('usertype');
                                    if ($type == 'user') {
                                        $user_currency = get_user_currency();
                                    } else if ($type == 'provider') {
                                        $user_currency = get_provider_currency();
                                    } $user_currency_code = $user_currency['user_currency_code'];

                                    $service_amount = get_gigs_currency($nrows['service_amount'], $nrows['currency_code'], $user_currency_code);
                                } else {
                                    $user_currency_code = settings('currency');
                                    $service_currency_code = $nrows['currency_code'];
                                    $service_amount = get_gigs_currency($nrows['service_amount'], $nrows['currency_code'], $user_currency_code);
                                }
                                if (is_nan($service_amount) || is_infinite($service_amount)) {
                                    $service_amount = $nrows['service_amount'];
                                }                         
                                ?>
                                <div class="service-widget">
                                    <div class="service-img">
                                        <a href="<?php echo base_url() . 'service-preview/' . $nrows['id'] . '?sid=' . md5($nrows['id']); ?>">
                                        
                                        <?php if ($image['service_image'] != '' && (@getimagesize(base_url().$image['service_image']))) { ?>
                                            <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>" alt="">
                                        <?php } else { ?>
                                             <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)?$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';?>">
                                        <?php } ?>

                                        </a>
                                        <div class="item-info">
                                            <div class="service-user">
                                                <a href="#">
                                                    <?php  if ($provider_details['profile_img'] != '' && (@getimagesize(base_url().$provider_details['profile_img']))) { ?>
                                                        <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                        
        <?php } ?>
                                                </a>
                                                <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                            </div>
                                            <div class="cate-list">
                                                <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($nrows['category_name'])); ?>"><?php echo ucfirst($nrows['category_name']); ?></a></div>
                                        </div>
                                    </div>
                                    <div class="service-content">
                                        <h3 class="title">
                                            <a href="<?php echo base_url() . 'service-preview/' .$nrows['id'] . '?sid=' . md5($nrows['id']); ?>"><?php echo ucfirst($nrows['service_title']); ?></a>
                                        </h3>
                                        <div class="rating">
                                            <?php
                                            for ($x = 1; $x <= $avg_rating; $x++) {
                                                echo '<i class="fas fa-star filled"></i>';
                                            }
                                            if (strpos($avg_rating, '.')) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            while ($x <= 5) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            ?>
                                            <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                        </div>
                                        <div class="user-info">

                                            <div class="row">
                                                <?php if ($this->session->userdata('id') != '') {
                                                    ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                <?php } else { ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
        <?php } ?>
                                                <span class="col ser-location"><span><?php echo ucfirst($nrows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {

                            echo '<div> 
                                    <p class="mb-0">'. (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : $default_language["en"]["lg_no_service"];
                                    '</p>
                                </div>';
                        }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<?php  }  ?>

<?php  if(settingValue('popular_ser_showhide') == 1) { ?>
<section class="popular-services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2><?php echo (settingValue('title_services'))?settingValue('title_services'):'Popular Services'; ?></h2>
                            <span><?php echo (settingValue('content_services'))?settingValue('content_services'):'Popular Service Contents'; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="viewall">
                            <h4><a href="<?php echo base_url(); ?>all-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : $default_language['en']['lg_View_All']; ?> <i class="fas fa-angle-right"></i></a></h4>
                            <span><?php echo (!empty($user_language[$user_selected]['lg_Most_Popular'])) ? $user_language[$user_selected]['lg_Most_Popular'] : $default_language['en']['lg_Most_Popular']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="service-carousel">
                    <div class="service-slider owl-carousel owl-theme">

                        <?php
                        if (!empty($services)) {
                            foreach ($services as $srows) {


                                $this->db->select("service_image");
                                $this->db->from('services_image');
                                $this->db->where("service_id", $srows['id']);
                                $this->db->where("status", 1);
                                $image = $this->db->get()->row_array();

                                $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();


                                $this->db->select('AVG(rating)');
                                $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                $this->db->from('rating_review');
                                $rating = $this->db->get()->row_array();
                                $avg_rating = round($rating['AVG(rating)'], 1);

                                $user_currency_code = '';
                                $userId = $this->session->userdata('id');
                                If (!empty($userId)) {
                                    $service_amount = $srows['service_amount'];

                                    $type = $this->session->userdata('usertype');
                                    if ($type == 'user') {
                                        $user_currency = get_user_currency();
                                    } else if ($type == 'provider') {
                                        $user_currency = get_provider_currency();
                                    } $user_currency_code = $user_currency['user_currency_code'];

                                    $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                } else {
                                    $user_currency_code = settings('currency');
                                    $service_currency_code = $srows['currency_code'];
                                    $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                }
                                if (is_nan($service_amount) || is_infinite($service_amount)) {
                                    $service_amount = $srows['service_amount'];
                                }                         
                                ?>
                                <div class="service-widget">
                                    <div class="service-img">
                                        <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>">
										
										<?php if ($image['service_image'] != '' && (@getimagesize(base_url().$image['service_image']))) { ?>
                                            <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>" alt="">
										<?php } else { ?>
											 <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)?$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';?>">
										<?php } ?>

                                        </a>
                                        <div class="item-info">
                                            <div class="service-user">
                                                <a href="#">
                                                    <?php  if ($provider_details['profile_img'] != '' && (@getimagesize(base_url().$provider_details['profile_img']))) { ?>
                                                        <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                    <?php } else { ?>
														<img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                        
        <?php } ?>
                                                </a>
                                                <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                            </div>
                                            <div class="cate-list">
                                                <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>
                                        </div>
                                    </div>
                                    <div class="service-content">
                                        <h3 class="title">
                                            <a href="<?php echo base_url() . 'service-preview/' .$srows['id'] . '?sid=' . md5($srows['id']); ?>"><?php echo ucfirst($srows['service_title']); ?></a>
                                        </h3>
                                        <div class="rating">
                                            <?php
                                            for ($x = 1; $x <= $avg_rating; $x++) {
                                                echo '<i class="fas fa-star filled"></i>';
                                            }
                                            if (strpos($avg_rating, '.')) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            while ($x <= 5) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            ?>
                                            <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                        </div>
                                        <div class="user-info">

                                            <div class="row">
                                                <?php if ($this->session->userdata('id') != '') {
                                                    ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                <?php } else { ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
        <?php } ?>
                                                <span class="col ser-location"><span><?php echo ucfirst($srows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {

                            echo '<div>	
									<p class="mb-0">'. (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : $default_language["en"]["lg_no_service"];
									'</p>
								</div>';
                        }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<?php  }  ?>
<?php  if(settingValue('top_rating_showhide') == 1) { ?>
<section class="popular-services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2><?php echo (settingValue('rating_title_services'))?settingValue('rating_title_services'):'Featured Services'; ?></h2>
                            <span><?php echo (settingValue('rating_content_services'))?settingValue('rating_content_services'):'Featured Services Contents'; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="viewall">
                            <h4><a href="<?php echo base_url(); ?>featured-services"><?php echo (!empty($user_language[$user_selected]['lg_View_All'])) ? $user_language[$user_selected]['lg_View_All'] : $default_language['en']['lg_View_All']; ?> <i class="fas fa-angle-right"></i></a></h4>
                            <span><?php echo (!empty($user_language[$user_selected]['lg_features_services'])) ? $user_language[$user_selected]['lg_features_services'] : $default_language['en']['lg_features_services']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="service-carousel">
                    <div class="service-slider owl-carousel owl-theme">

                        <?php
                        if (!empty($top_rating_services)) {
                            foreach ($top_rating_services as $srows) {



                                $this->db->select("service_image");
                                $this->db->from('services_image');
                                $this->db->where("service_id", $srows['id']);
                                $this->db->where("status", 1);
                                $image = $this->db->get()->row_array();

                                $provider_details = $this->db->where('id', $srows['user_id'])->get('providers')->row_array();


                                $this->db->select('AVG(rating)');
                                $this->db->where(array('service_id' => $srows['id'], 'status' => 1));
                                $this->db->from('rating_review');
                                $rating = $this->db->get()->row_array();
                                $avg_rating = round($rating['AVG(rating)'], 1);

                                $user_currency_code = '';
                                $userId = $this->session->userdata('id');
                                If (!empty($userId)) {
                                    $service_amount = $srows['service_amount'];

                                    $type = $this->session->userdata('usertype');
                                    if ($type == 'user') {
                                        $user_currency = get_user_currency();
                                    } else if ($type == 'provider') {
                                        $user_currency = get_provider_currency();
                                    } $user_currency_code = $user_currency['user_currency_code'];

                                    $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                } else {
                                    $user_currency_code = settings('currency');
                                    $service_currency_code = $srows['currency_code'];
                                    $service_amount = get_gigs_currency($srows['service_amount'], $srows['currency_code'], $user_currency_code);
                                }
                                if (is_nan($service_amount) || is_infinite($service_amount)) {
                                    $service_amount = $srows['service_amount'];
                                }                         
                                ?>
                                <div class="service-widget">
                                    <div class="service-img">
                                        <a href="<?php echo base_url() . 'service-preview/' . $srows['id'] . '?sid=' . md5($srows['id']); ?>">
                                        
                                        <?php if ($image['service_image'] != '' && (@getimagesize(base_url().$image['service_image']))) { ?>
                                            <img class="img-fluid serv-img" alt="Service Image" src="<?php echo base_url() . $image['service_image']; ?>" alt="">
                                        <?php } else { ?>
                                             <img class="img-fluid serv-img" alt="Service Image" src="<?php echo ($placholder_img)?$placholder_img:base_url().'uploads/placeholder_img/1641376256_banner.jpg';?>">
                                        <?php } ?>

                                        </a>
                                        <div class="item-info">
                                            <div class="service-user">
                                                <a href="#">
                                                    <?php  if ($provider_details['profile_img'] != '' && (@getimagesize(base_url().$provider_details['profile_img']))) { ?>
                                                        <img src="<?php echo base_url() . $provider_details['profile_img'] ?>">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url(); ?>assets/img/user.jpg">
                                                        
        <?php } ?>
                                                </a>
                                                <span class="service-price"><?php echo currency_conversion($user_currency_code) . $service_amount; ?></span>
                                            </div>
                                            <div class="cate-list">
                                                <a class="bg-yellow" href="<?php echo base_url() . 'search/' . str_replace(' ', '-', strtolower($srows['category_name'])); ?>"><?php echo ucfirst($srows['category_name']); ?></a></div>
                                        </div>
                                    </div>
                                    <div class="service-content">
                                        <h3 class="title">
                                            <a href="<?php echo base_url() . 'service-preview/' .$srows['id'] . '?sid=' . md5($srows['id']); ?>"><?php echo ucfirst($srows['service_title']); ?></a>
                                        </h3>
                                        <div class="rating">
                                            <?php
                                            for ($x = 1; $x <= $avg_rating; $x++) {
                                                echo '<i class="fas fa-star filled"></i>';
                                            }
                                            if (strpos($avg_rating, '.')) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            while ($x <= 5) {
                                                echo '<i class="fas fa-star"></i>';
                                                $x++;
                                            }
                                            ?>
                                            <span class="d-inline-block average-rating">(<?php echo $avg_rating ?>)</span>
                                        </div>
                                        <div class="user-info">

                                            <div class="row">
                                                <?php if ($this->session->userdata('id') != '') {
                                                    ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
                                                <?php } else { ?>
                                                    <span class="col ser-contact"><i class="fas fa-phone mr-1"></i> <span>xxxxxxxx<?= rand(00, 99) ?></span></span>
        <?php } ?>
                                                <span class="col ser-location"><span><?php echo ucfirst($srows['service_location']); ?></span> <i class="fas fa-map-marker-alt ml-1"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {

                            echo '<div> 
                                    <p class="mb-0">'. (!empty($user_language[$user_selected]["lg_no_service"])) ? $user_language[$user_selected]["lg_no_service"] : $default_language["en"]["lg_no_service"];
                                    '</p>
                                </div>';
                        }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
<?php  }  ?>
<?php  //if(settingValue('how_showhide') == 1) { 
       if(false){?>
<section class="how-work">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading howitworks">
                    <h2><?php echo (settingValue('how_title'))?settingValue('how_title'):'How It Works'; ?></h2>
                    <span><?php echo (settingValue('how_content'))?settingValue('how_content'):'How It Works Content'; ?></span>
                </div>
                <div class="howworksec">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="howwork">
                                <div class="iconround">
                                    <div class="steps">01</div>
										<?php
										$bo1query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image1'");
										$bo1result = $bo1query->result_array();
										if(!empty(settingValue('how_title_img_1'))){											
											echo '<img src="'.base_url().settingValue('how_title_img_1').'">';
										}else{
											
											echo '<img src="'.base_url().'assets/img/icon-1.png">';
										}
										?>
                                    
                                </div>
                                <h3>
								<?php echo (settingValue('how_title_1'))?settingValue('how_title_1'):'Choose What To Do'; ?>
								</h3>
                                <p>
								<?php echo (settingValue('how_content_1'))?settingValue('how_content_1'):'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.'; ?>
								</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="howwork">
                                <div class="iconround">
                                    <div class="steps">02</div>
                                    <?php
										$bo2query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image2'");
										$bo2result = $bo2query->result_array();
										if(!empty(settingValue('how_title_img_2'))){											
											echo '<img src="'.base_url().settingValue('how_title_img_2').'">';
										}else{
											
											echo '<img src="'.base_url().'assets/img/icon-2.png">';
										}
										?>
                                </div>
                                <h3>
                                <?php echo (settingValue('how_title_2'))?settingValue('how_title_2'):'Find What You Want'; ?>
                                </h3>
                                <p>
                                <?php echo (settingValue('how_content_2'))?settingValue('how_content_2'):'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.'; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="howwork">
                                <div class="iconround">
                                    <div class="steps">03</div>
                                    <?php
										$bo3query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image3'");
										$bo3result = $bo3query->result_array();
										if(!empty(settingValue('how_title_img_3'))){											
											echo '<img src="'.base_url().settingValue('how_title_img_3').'">';
										}else{
											
											echo '<img src="'.base_url().'assets/img/icon-3.png">';
										}
										?>
                                </div>
                                <h3>
                                <?php echo (settingValue('how_title_3'))?settingValue('how_title_3'):'Amazing Places'; ?>
                                </h3>
                                <p>
                                <?php echo (settingValue('how_content_3'))?settingValue('how_content_3'):'Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<!-- App Section -->
<?php  if(settingValue('download_showhide') == 1) { ?>
    <section class="app-section" id="how-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading howitworks">
                        <h2><?php echo (settingValue('download_title'))?settingValue('download_title'):'Download Our App'; ?></h2>
                        <span><?php echo (settingValue('download_content'))?settingValue('download_content'):'Aliquam lorem ante, dapibus in, viverra quis'; ?></span>
                        <div class="mt-3">
                            <a href="<?=(settingValue('play_store_link')?settingValue('play_store_link'):'#')?>" target="_blank" rel="noopener noreferrer"><img class="thumbnail m-b-0" src="<?php echo base_url() . settingValue('app_store_img'); ?>"></a>
                            <a href="<?=(settingValue('app_store_link')?settingValue('app_store_link'):'#')?>" target="_blank" rel="noopener noreferrer"><img class="thumbnail m-b-0" src="<?php echo base_url() . settingValue('play_store_img'); ?>"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<!-- App Section -->