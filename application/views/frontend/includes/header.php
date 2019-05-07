<?php include_once realpath(__DIR__) . '/top_header.php'; ?>
<div class="logo-holder">
    <div class="container-fluid mainWrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex responsive-logo-holder">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo UPLOADS_URL . '/settings/' . HEADER_LOGO; ?>" alt="Logo">
                        </a>
                    </div>
                    <div class="ml-auto adBtns">
                        <a href="<?php echo base_url('add-buying-lead'); ?>">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            submit buying leads </a>
                        <a href="<?php echo base_url('add-seller-lead'); ?>">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            submit selling leads </a>
                        <a href="<?php echo base_url('ad-post'); ?>">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            post free ad </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mainWrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="desktopHideOnMobile">
                <ul class="nav-holder">
                    <?php if (!isset($categories) || empty($categories)) : ?>
                        <?php $categories = volgo_get_header_cats(); ?>
                    <?php endif; ?>
                    <?php foreach ((array)$categories as $category): $category_parent = $category['parent'];
                        $category_childs = $category['childs'];

                        $cat_slug = empty($category_parent->slug) ? '#' : base_url('category/' . $category_parent->slug);
                        ?>
                        <li class="nav-item <?php echo (count($category_childs) > 12) ? ' megaMenu' : ''; ?>">
                            <a class="nav-link" href="<?php echo $cat_slug; ?> ">
                                <i class="<?php echo $category_parent->image_icon; ?>"
                                   aria-hidden="true">
                                </i>
                                <?php echo ucwords($category_parent->cat_name); ?>
                            </a>
                            
                            <div class="dropdownHolderMain">
                                <ul class="dropdownHolder">
                                    <?php foreach ($category_childs

                                    as $key => $child):
                                    ?>
                                    <?php  if ($key % 12 === 0 && $key !== 0): ?>
                                </ul> <!-- dropdownHolder closes-->
                                <ul class="dropdownHolder">
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo (empty($child->slug)) ? '#' : base_url('category/' . $child->slug); ?>"><?php echo ucwords($child->cat_name); ?>
                                            <span> - <?php echo $child->count; ?> </span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach; ?>

                    <?php /*if (!isset($buying_leads_categories) || empty($buying_leads_categories)) : */?><!--
                        <?php /*$buying_leads_categories = volgo_get_buying_leads();
                        $cat_slug = base_url('buying-leads'); */?>
                    --><?php /*endif; */?>
                    <li class="nav-item megaMenu">
                        <a class="nav-link" href="<?php echo base_url('buying-leads'); ?>">
                            <i class="fa fa-buysellads"
                               aria-hidden="true">
                            </i>
                            Buying Leads
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('seller-leads'); ?>">
                            <i class="fa fa-handshake-o"
                               aria-hidden="true">
                            </i>
                            Seller Leads
                        </a>
                    </li>
                </ul>
            </div>
            <div class="mobileHideOnDesktop">
                <ul class="nav-holder">
                    <li class="nav-item">
                        <a class="nav-link ico-auto" href="javascript:void(0)"> Autos </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ico-property" href="javascript:void(0)"> Property</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ico-jobs" href="javascript:void(0)"> Jobs </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ico-classified" href="javascript:void(0)"> Classified</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ico-services" href="javascript:void(0)"> Services </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ico-buying" href="javascript:void(0)"> Buying Leads </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</header>
